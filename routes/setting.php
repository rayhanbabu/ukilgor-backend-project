<?php 
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Setting\DistrictController;
use App\Http\Controllers\Setting\ProfessionController;
use App\Http\Controllers\Setting\PracticeAreaController;



         
      Route::middleware('auth:sanctum')->group(function () {
          
                 // District Routes
                  Route::get('/district', [DistrictController::class, 'district']);
                  Route::post('/district-add', [DistrictController::class, 'district_add']);
                  Route::post('/district-update/{id}', [DistrictController::class, 'district_update']);
                  Route::delete('/district-delete/{id}', [DistrictController::class, 'district_delete']);

                   // Profession Routes
                  Route::get('/profession', [ProfessionController::class, 'profession']);
                  Route::post('/profession-add', [ProfessionController::class, 'profession_add']);
                  Route::post('/profession-update/{id}', [ProfessionController::class, 'profession_update']);
                  Route::delete('/profession-delete/{id}', [ProfessionController::class, 'profession_delete']);

                   // PracticeArea Routes
                  Route::get('/practicearea', [PracticeAreaController::class, 'practicearea']);
                  Route::post('/practicearea-add', [PracticeAreaController::class, 'practicearea_add']);
                  Route::post('/practicearea-update/{id}', [PracticeAreaController::class, 'practicearea_update']);
                  Route::delete('/practicearea-delete/{id}', [PracticeAreaController::class, 'practicearea_delete']);


            
      
     });

?>