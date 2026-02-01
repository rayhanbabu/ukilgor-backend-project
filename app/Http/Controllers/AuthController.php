<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\User_role;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordResetMail;
use App\Models\Employeepermission;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = validator($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }
    
        $key = 'login_attempts:' . $request->ip();
    
        if (RateLimiter::tooManyAttempts($key, 5)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Too many login attempts. Please try again later.'
            ], 429);
        }
    
        if (!Auth::attempt($request->only('email', 'password'))) {
            RateLimiter::hit($key, 60);
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid credentials',
                'errors' => [
                    'email' => ['Invalid credentials']
                ]
            ], 422);
        }
    
        RateLimiter::clear($key);
        
            $user = Auth::user();
           if ( $user->status == 0) {
                            Auth::logout();
                            return response()->json([
                                'status' => 'error',
                                'message' => 'Account is inactive. Please contact support.'
                            ], 422);
             }
        $token = $user->createToken('auth-token')->plainTextToken;
    
        return response()->json([
             'message' => 'Login successful',
             'token' => $token,
             'data' =>user(),
          ], 200);
      }


      public function login_v1(Request $request)
        {
            $validator = validator($request->all(), [
                'phone' => 'required|string',
                'login_type' => 'required|in:Student,All',
                'student_id' => 'required_if:login_type,Student',
                'password' => 'required_if:login_type,All',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $key = 'login_attempts:' . $request->ip();

            if (RateLimiter::tooManyAttempts($key, 5)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Too many login attempts. Please try again later.'
                ], 429);
            }

          if( $request->login_type == 'Student') {
                        $student = User::join('students', 'users.id', '=', 'students.user_id')
                        ->where('users.phone', $request->phone)
                        ->where('students.id', $request->student_id)
                        ->where('users.status', 1)
                        ->select('users.id')
                        ->first();

                        if (!$student) {
                            RateLimiter::hit($key, 60);
                            return response()->json([
                                'status' => 'error',
                                'message' => 'Invalid credentials',
                                'errors' => [
                                    'login' => ['Student not found']
                                ]
                            ], 422);
                        }

                        // Now fetch the full User model instance
                        $user = User::find($student->id);

                        Auth::login($user);
                        RateLimiter::clear($key);

                        $token = $user->createToken('auth-token')->plainTextToken;

                        return response()->json([
                            'message' => 'Login successful',
                            'token' => $token,
                            'data' => user(),
                        ], 200);
                
            } else {
            
                        // Use custom Auth::attempt since default uses 'email' by default
                        if (!Auth::attempt(['phone' => $request->phone, 'password' => $request->password])) {
                            RateLimiter::hit($key, 60);
                            return response()->json([
                                'status' => 'error',
                                'message' => 'Invalid credentials',
                                'errors' => [
                                    'phone' => ['Invalid credentials']
                                ]
                            ], 422);
                        }

                        RateLimiter::clear($key);

                        $user = Auth::user();

                        if ( $user->status == 0) {
                            Auth::logout();
                            return response()->json([
                                'status' => 'error',
                                'message' => 'Account is inactive. Please contact support.'
                            ], 422);
                        }

                        $token = $user->createToken('auth-token')->plainTextToken;

                        return response()->json([
                            'message' => 'Login successful',
                            'token' => $token,
                            'data' => user(),
                        ], 200);
               }

           }


            public function user(Request $request)
            {
                return response()->json([
                    'status' => 'success',
                    'data' =>user(),
                    'fuction' =>rayhan()
                ],200);
            }



   


           public function logout(Request $request)
            {
                $userId = Auth::id();

                if ($userId) {
                    // Clear cached user info
                    Cache::forget("user_info_{$userId}");
                }

                // Delete all tokens (for API authentication via Sanctum/Passport)
                $request->user()->tokens()->delete();

                

                return response()->json([
                    'message' => 'Logged out successfully'
                ], 200);
            }



         public function forget_password(Request $request)
            {
                $validator = validator($request->all(), [
                    'email' => 'required|email',
                ]);

                if ($validator->fails()) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Validation failed',
                        'errors' => $validator->errors()
                    ], 422);
                }

                $email = $request->input('email');
                $user  = User::where('email', $email)->first();

                if (!$user) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'User not found'
                    ], 400);
                }

                $resetToken = Str::random(60);

                DB::table('users')
                    ->where('email', $email)
                    ->update([
                        'forget_reset_code' => $resetToken,
                        'forget_reset_time' => now()
                    ]);

                // Send the reset email
                Mail::to($email)->send(new PasswordResetMail($user, $resetToken));

                return response()->json([
                    'status' => 'success',
                    'message' => 'Password reset link sent to your email'
                ], 200);
            }


    public function reset_password(Request $request)
      {
         $validator = validator($request->all(), [          
             'password' => 'required|min:6|confirmed',
             'password_confirmation' => 'required|min:6'
         ]);

          if ($validator->fails()) {
             return response()->json([
                 'status' => 'error',
                 'message' => 'Validation failed',
                 'errors' => $validator->errors()
             ], 422);
          }

        $user = User::where('forget_reset_code', $request->forget_reset_code)->first();

         if (!$user && $request->forget_reset_code!=NULL) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid token'
            ], 400);
          }

                // Check if token is expired (5 minutes)
            $resetTime = $user->forget_reset_time;
            if (now()->diffInMinutes($resetTime) > 10) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Reset token expired'
                ], 400);
            }

            // Update the user's password
            $user->password = bcrypt($request->input('password'));
            $user->forget_reset_code = null; // Clear the reset code
            $user->forget_reset_time = null; // Clear reset time
            $user->save();
                return response()->json([
                    'status' => 'success',
                    'message' => 'Password reset successfully',
                    'forget_reset_code' => $user,
                ], 200);
            }



    public function password_change(Request $request)
   {
    $validator = validator($request->all(), [     
        'old_password' => 'required|min:6',
        'password' => 'required|min:6|confirmed',
        'password_confirmation' => 'required|min:6'
    ]);

      $userauth = user(); 
      if ($validator->fails()) {
         return response()->json([
             'status' => 'error',
             'message' => 'Validation failed',
             'errors' => $validator->errors()
          ], 422);
      }

    $user = DB::table('users')->where('id', $userauth->id)->first();
    if (Hash::check($request->input('old_password'), $user->password)) {

        DB::table('users')
            ->where('id', $user->id)
            ->update([
                'password' => Hash::make($request->input('password'))
            ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Password changed successfully'
        ], 200);
    }

      return response()->json([
          'status' => 'error',
          'message' => 'Old password does not match'
      ], 400);
  }


}
