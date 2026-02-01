<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\PaymentPdfController;
use App\Http\Controllers\StudentPanel\StudentInvoiceController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

      Route::get('/', function () {
            return response()->json([
                'message' => 'API is working fine. Healthy check success',
            ], 200);
      });

    Route::get('/generate-pdf', [PdfController::class, 'generatePDF']);
    Route::get('{school_username}/marksheet-pdf', [PdfController::class, 'generateMarksheetPDF']);
    Route::get('{school_username}/tabulation-pdf', [PdfController::class, 'generateTabulationPDF']);
 
    

       // Payment Pdf Routes
       Route::get('{school_username}/pdf-payment-report-by-group', [PaymentPdfController::class, 'generatePaymentReportByGroupPDF']);
       Route::get('{school_username}/pdf-institution-account-report', [PaymentPdfController::class, 'generateInstitutionAccountReportPDF']);


      Route::get('/{school_username}/{student_id}/payment', [StudentInvoiceController::class, 'student_payment']);

      //You need declear your success & fail route in "app\Middleware\VerifyCsrfToken.php"
      Route::post('amarpay_success',[StudentInvoiceController::class,'amarpay_success'])->name('amarpay_success');
      Route::post('amarpay_fail',[StudentInvoiceController::class,'amarpay_fail'])->name('amarpay_fail');
      Route::get('amarpay_cancel',[StudentInvoiceController::class,'amarpay_cancel'])->name('amarpay_cancel');


