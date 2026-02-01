<?php

namespace App\Services\Setting\PracticeAreaService;

use App\Models\Practicearea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Exception;

class PracticeAreaAdd
{
    public function handle(Request $request)
    {

        DB::beginTransaction();
        try {
            $validator = validator($request->all(), [
                'practicearea_name' => 'required|unique:practiceareas,practicearea_name',
                'status' => 'nullable|boolean',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation failed',
                    'errors' => $validator->errors(),
                ], 422);
            }

    
            $user_auth =user();
        
            $model = new Practicearea();
            $model->practicearea_name = $request->practicearea_name;
            $model->status = $request->status;
            $model->created_by = $user_auth->id; 
            $model->save();

            DB::commit();

            return response()->json([
                  'message' => 'Data added successfully',
              ], 200);

         } catch (\Exception $e) {
              DB::rollback();
           
              return response()->json([
                  'message' => 'Failed to Add ',
                  'error' => $e->getMessage(),
              ], 500);
        }
    }

 
}
