<?php 
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebsiteContent\PageCategoryController;
use App\Http\Controllers\WebsiteContent\PageController;
use App\Http\Controllers\WebsiteContent\WebApiController;


    //Public Routes
    Route::middleware('ApiKeyMiddleware')->group(function () {
    
          Route::get('/web/page-category', [WebApiController::class,'page_category']);
          Route::get('/web/page', [WebApiController::class,'page']);
          Route::get('/web/employee', [WebApiController::class,'employee']);
        
    });


        Route::middleware('auth:sanctum')->group(function () {

            // Page Category Routes
            Route::get('/pagecategory', [PageCategoryController::class, 'pageCategory']);
             Route::post('/pagecategory-add', [PageCategoryController::class, 'pageCategory_add']);
             Route::post('/pagecategory-update/{id}', [PageCategoryController::class, 'pageCategory_update']);
             Route::delete('/pagecategory-delete/{id}', [PageCategoryController::class, 'pageCategory_delete']);

   
            // Page Routes
            Route::get('/page', [PageController::class, 'page']);
            Route::post('/page-add', [PageController::class, 'page_add']);
            Route::post('/page-update/{id}', [PageController::class, 'page_update']);
            Route::delete('/page-delete/{id}', [PageController::class, 'page_delete']);

   

  });

?>