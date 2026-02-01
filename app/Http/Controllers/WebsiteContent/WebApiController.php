<?php

namespace App\Http\Controllers\SchoolPanel\WebsiteContent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Models\Page;
use App\Models\School;
use App\Models\Gpacategory;
use App\Models\Gpalist;
use App\Models\Pagecategory;
use App\Models\Employee;
use App\Models\Designation;
use App\Models\Enroll;





class WebApiController extends Controller
{

          public function school_info(Request $request, $school_username)
          {
          $school = School::with(['user:id,name,email,phone,profile_picture,alternative_phone,secondary_email']) // eager load user fields only
               ->where('school_username', $school_username)
               ->select('school_username', 'bangla_name', 'english_name', 'full_address', 
                'short_address','user_id','eiin','bangla_address','office_time','map_link','counter_name1','counter_name2'
                ,'counter_name3','counter_name4','counter1','counter2','counter3','counter4')->first();

          return response()->json([
               'data' => $school,
          ], 200);
          }


     public function gpa_category(Request $request,$school_username)
     {

        $query = Gpacategory::query();
        $query->where('school_username', $school_username);

         if ($request->has('status')) {
              $query->where('status', $request->status);
         }

        $sortField = $request->get('sortField', 'id');
        $sortDirection = $request->get('sortDirection', 'asc');
        $query->orderBy($sortField, $sortDirection);

        $perPage = (int) $request->input('perPage', 20);
        $page = (int) $request->input('page', 1);
       
        $result = $query->paginate($perPage, ['*'], 'page', $page);

        return response()->json([
             'data' => $result->items(),
             'total' => $result->total(),
             'per_page' => $result->perPage(),
             'current_page' => $result->currentPage(),
             'last_page' => $result->lastPage(),
        ]);

     }



     public function gpa(Request $request,$school_username)
     {

        $query = Gpalist::query();
        $query->with('gpaCategory'); 
        $query->where('school_username', $school_username);

    $filters = [
        'viewById' => 'id',
        'session_year' => 'session_year',
        'gpa_category_id' => 'gpa_category_id',
    ];

      foreach ($filters as $requestKey => $dbColumn) {
         if (is_int($requestKey)) $requestKey = $dbColumn;
         if ($request->filled($requestKey)) {
             $query->where($dbColumn, $request->$requestKey);
          }
       }
   
      if ($request->has('search')) {
          $search = $request->search;
          $query->where(function ($q) use ($search) {
               $q->where('session_year', 'like', "%$search%")
                 ->orWhere('status', 'like', "%$search%");
              });
         }

       if ($request->has('status')) {
           $query->where('status', $request->status);
         }

        $sortField = $request->get('sortField', 'id');
        $sortDirection = $request->get('sortDirection', 'asc');
        $query->orderBy($sortField, $sortDirection);

        $perPage = (int) $request->input('perPage', 10);
        $page = (int) $request->input('page', 1);
       
        $result = $query->paginate($perPage, ['*'], 'page', $page);

        return response()->json([
             'data' => $result->items(),
             'total' => $result->total(),
             'per_page' => $result->perPage(),
             'current_page' => $result->currentPage(),
             'last_page' => $result->lastPage(),
        ]);
        
     }



       public function page_category(Request $request,$school_username)
       {

         if ($request->filled('ShowByCategorygroup') && $request->ShowByCategorygroup == 1) {
             $query = Pagecategory::with('children')->with('pages')
             ->where('school_username', $school_username)
              ->whereNull('parent_id');  // fetch root categories only
       }else{
            $query = Pagecategory::with('parent')
            ->where('school_username', $school_username); // fetch child categories only
       }

               

               // Apply filters
               $filters = [
                    'viewById' => 'id',
                    'personal_status' => 'personal_status',
               ];

               foreach ($filters as $requestKey => $dbColumn) {
                    if (is_int($requestKey)) $requestKey = $dbColumn;
                    if ($request->filled($requestKey)) {
                         $query->where($dbColumn, $request->$requestKey);
                    }
               }

               // Search filter
               if ($request->filled('search')) {
                    $search = $request->search;
                    $query->where(function ($q) use ($search) {
                         $q->where('page_category_name', 'like', "%$search%")
                         ->orWhere('status', 'like', "%$search%");
                    });
               }

               // Status filter
               if ($request->filled('status')) {
                    $query->where('status', $request->status);
               }

               // Sorting
               $sortField = $request->get('sortField', 'id');
               $sortDirection = $request->get('sortDirection', 'asc');
               $query->orderBy($sortField, $sortDirection);

               // Pagination
               $perPage = (int) $request->input('perPage', 10);
               $page = (int) $request->input('page', 1);

               $result = $query->paginate($perPage, ['*'], 'page', $page);

               return response()->json([
                    'data' => $result->items(),
                    'total' => $result->total(),
                    'per_page' => $result->perPage(),
                    'current_page' => $result->currentPage(),
                    'last_page' => $result->lastPage(),
               ]);

       }


        public function page(Request $request,$school_username)
       {

                $query = Page::query();
                $query->with('pageCategory');
                $query->where('school_username', $school_username);

               $filters = [
                    'viewById' => 'id',
                    'page_category_id',
               ];

                    foreach ($filters as $requestKey => $dbColumn) {
                    if (is_int($requestKey)) $requestKey = $dbColumn;
                    if ($request->filled($requestKey)) {
                         $query->where($dbColumn, $request->$requestKey);
                         }
                    }
               
                    if ($request->has('search')) {
                         $search = $request->search;
                         $query->where(function ($q) use ($search) {
                              $q->where('title', 'like', "%$search%")
                              ->orWhere('status', 'like', "%$search%")
                              ->orWhere('phone', 'like', "%$search%")
                              ->orWhere('name', 'like', "%$search%");

                         });
                    }

                    if ($request->has('status')) {
                         $query->where('status', $request->status);
                    }

                    $sortField = $request->get('sortField', 'id');
                    $sortDirection = $request->get('sortDirection', 'asc');
                    $query->orderBy($sortField, $sortDirection);

                    $perPage = (int) $request->input('perPage', 30);
                    $page = (int) $request->input('page', 1);
                    
                    $result = $query->paginate($perPage, ['*'], 'page', $page);

                    return response()->json([
                         'data' => $result->items(),
                         'total' => $result->total(),
                         'per_page' => $result->perPage(),
                         'current_page' => $result->currentPage(),
                         'last_page' => $result->lastPage(),
                    ]);

       }



      public function employee(Request $request,$school_username)
          {

                    $query = Employee::with([
                         'user:id,name,email,phone,username,profile_picture,status',
                         'religion:id,religion_name',
                         'level:id,level_name',
                         'faculty:id,faculty_name',
                         'department:id,department_name',
                         'designation:id,designation_name,designation_bangla_name,designation_status',
                    ])->where('school_username', $school_username);
                         
                    $query->where('school_username', $school_username);

                    $filters = [
                         'designation_id',
                         'religion_id',
                         'level_id',
                         'faculty_id',
                         'department_id',
                         'sectionyear_id',
                         'viewById' => 'id'
                    ];

                    foreach ($filters as $requestKey => $dbColumn) {
                    if (is_int($requestKey)) $requestKey = $dbColumn;
                    if ($request->filled($requestKey)) {
                         $query->where($dbColumn, $request->$requestKey);
                         }
                    }
               
                    if ($request->has('search')) {
                         $search = $request->search;
                         $query->where(function ($q) use ($search) {
                              $q->where('bangla_name', 'like', "%$search%")
                              ->orWhere('english_name', 'like', "%$search%")
                              ->orWhere('index_number', 'like', "%$search%")
                              ->orWhere('tin_number', 'like', "%$search%")
                              ->orWhere('father_name', 'like', "%$search%")
                              ->orWhere('mother_name', 'like', "%$search%")
                              ->orWhere('spouse_name', 'like', "%$search%")
                              ->orWhere('present_address', 'like', "%$search%")
                              ->orWhereHas('user', function ($q) use ($search) {
                                   $q->where('name', 'like', "%$search%")
                                   ->orWhere('email', 'like', "%$search%")
                                   ->orWhere('phone', 'like', "%$search%")
                                   ->orWhere('username', 'like', "%$search%");
                              });
                         
                         });
                    }

                    if ($request->has('status')) {
                         $query->whereHas('user', function ($q) use ($request) {
                         $q->where('status', $request->status);
                         });
                    }

                    $sortField = $request->get('sortField', 'serial');
                    $sortDirection = $request->get('sortDirection', 'asc');
                    $query->orderBy($sortField, $sortDirection);

                    $perPage = (int) $request->input('perPage', 10);
                    $page = (int) $request->input('page', 1);
                    
                    $result = $query->paginate($perPage, ['*'], 'page', $page);

                    return response()->json([
                         'data' => $result->items(),
                         'total' => $result->total(),
                         'per_page' => $result->perPage(),
                         'current_page' => $result->currentPage(),
                         'last_page' => $result->lastPage(),
                    ]);

       }


     public function employee_designation(Request $request, $school_username){

           $query = Designation::query();
        $query->where('school_username', $school_username);
    
        // Search
        if ($request->has('search')) {
             $search = $request->search;
             $query->where(function ($q) use ($search) {
                $q->where('designation_name', 'like', "%$search%")
                    ->orWhere('designation_status', 'like', "%$search%")
                    ->orWhere('designation_bangla_name', 'like', "%$search%");
             });
         }

        // Filter by status
        if ($request->has('status')) {
                $query->where('designation_status', $request->status);
        }

        // View By Id
        if ($request->has('viewById')) {
            $query->where('id', $request->viewById);
        }

        // Sorting
        $sortField = $request->get('sortField', 'id');
        $sortDirection = $request->get('sortDirection', 'asc');
        $query->orderBy($sortField, $sortDirection);

        // Pagination
        $perPage = (int) $request->input('perPage', 20);
        $page = (int) $request->input('page', 1);
        $perPage = ($perPage > 100) ? 100 : $perPage; // Max 100 per page

        // Apply pagination
        $result = $query->paginate($perPage, ['*'], 'page', $page);

        return response()->json([
            'data' => $result->items(),
            'total' => $result->total(),
            'current_page' => $result->currentPage(),
            'last_page' => $result->lastPage(),
            'per_page' => $result->perPage(),
                  
         ]);
      
     }


   public function student_list(Request $request, $school_username){

       //Enrollment List 
               $query = Enroll::query();
               $query->join('students','enrolls.student_id','=','students.id');
               $query->where('enrolls.school_username', $school_username);
               $query->with([
                  'sessionyear:id,sessionyear_name',
                  'programyear:id,programyear_name',
                  'level:id,level_name,level_category',
                  'faculty:id,faculty_name',
                  'department:id,department_name',
                  'section:id,section_name',
               ]);
            
               $query->select(
                    'enrolls.enroll_group',
                    DB::raw('COUNT(enrolls.id) as total_student'),
                    DB::raw('MAX(enrolls.runing_enroll_status) as runing_enroll_status'),
                    DB::raw('SUM(CASE WHEN students.gender = "Male" THEN 1 ELSE 0 END) as total_male'),
                    DB::raw('SUM(CASE WHEN students.gender = "Female" THEN 1 ELSE 0 END) as total_female'),
                    DB::raw('MAX(enrolls.sessionyear_id) as sessionyear_id'),
                    DB::raw('MAX(enrolls.programyear_id) as programyear_id'),
                    DB::raw('MAX(enrolls.level_id) as level_id'),
                    DB::raw('MAX(enrolls.faculty_id) as faculty_id'),
                    DB::raw('MAX(enrolls.department_id) as department_id'),
                    DB::raw('MAX(enrolls.section_id) as section_id'),
                )->groupBy('enrolls.enroll_group'); // Important: include any selected non-aggregates here

                $sortField = $request->get('sortField', 'enrolls.enroll_group'); // sortField should match the alias or actual column name in select
                $sortDirection = $request->get('sortDirection', 'asc');
                $query->orderBy($sortField, $sortDirection);

                $enroll_list = $query->get();

               return response()->json([
                   'data' => $enroll_list,
               ]);
           }

}
