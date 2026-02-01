<?php 
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SchoolPanel\Employee\EmployeeController;
use App\Http\Controllers\SchoolPanel\Employee\PayroleInfoController;
use App\Http\Controllers\SchoolPanel\Employee\PayroleController;

  Route::middleware('auth:sanctum')->group(function () {



      Route::middleware('PayrollMiddleware:{school_username}')->group(function () {

           
            Route::post('/{school_username}/employee-add', [EmployeeController::class, 'employee_add']);
            Route::post('/{school_username}/employee-update/{id}', [EmployeeController::class, 'employee_update']);
            Route::delete('/{school_username}/employee-delete/{id}', [EmployeeController::class, 'employee_delete']);

            //PayroleInfo
            
            Route::post('/{school_username}/payroleinfo-add', [PayroleInfoController::class, 'payroleinfo_add']);
            Route::post('/{school_username}/payroleinfo-update/{id}', [PayroleInfoController::class, 'payroleinfo_update']);
            Route::delete('/{school_username}/payroleinfo-delete/{id}', [PayroleInfoController::class, 'payroleinfo_delete']);

            //Payrole
          
            Route::post('/{school_username}/payrole-add', [PayroleController::class, 'payrole_add']);
            Route::post('/{school_username}/payrole-single-add', [PayroleController::class, 'payrole_single_add']);
            Route::delete('/{school_username}/payrole-delete/{id}', [PayroleController::class, 'payrole_delete']);
         
     });

      Route::middleware('PayrolReadlMiddleware:{school_username}')->group(function () {

             //Payrole
             Route::get('/{school_username}/employee', [EmployeeController::class, 'employee']);
             Route::get('/{school_username}/payroleinfo', [PayroleInfoController::class, 'payroleinfo']);
             Route::get('/{school_username}/payrole', [PayroleController::class, 'payrole']);
         
      });

  });

?>