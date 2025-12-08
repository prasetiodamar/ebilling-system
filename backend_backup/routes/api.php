<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\InvoiceController;
use App\Http\Controllers\Api\PaymentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Health check
Route::get('/health', function () {
    return response()->json(['status' => 'ok', 'timestamp' => now()]);
});

// Public routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Protected routes (require authentication)
Route::middleware('auth:sanctum')->group(function () {
    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    // Customers
    Route::apiResource('customers', CustomerController::class);
    Route::get('customers/{customer}/invoices', [CustomerController::class, 'invoices']);
    Route::get('customers/{customer}/payments', [CustomerController::class, 'payments']);
    Route::post('customers/{customer}/suspend', [CustomerController::class, 'suspend']);
    Route::post('customers/{customer}/activate', [CustomerController::class, 'activate']);

    // Invoices
    Route::apiResource('invoices', InvoiceController::class);
    Route::post('invoices/{invoice}/send', [InvoiceController::class, 'send']);
    Route::post('invoices/{invoice}/mark-as-paid', [InvoiceController::class, 'markAsPaid']);
    Route::post('invoices/{invoice}/cancel', [InvoiceController::class, 'cancel']);
    Route::get('invoices/customer/{customer}', [InvoiceController::class, 'byCustomer']);

    // Payments
    Route::apiResource('payments', PaymentController::class);
    Route::post('payments/{payment}/complete', [PaymentController::class, 'complete']);
    Route::post('payments/{payment}/refund', [PaymentController::class, 'refund']);
    Route::get('payments/gateway/{gateway}', [PaymentController::class, 'byGateway']);
    Route::post('payments/webhook/xendit', [PaymentController::class, 'webhookXendit']);
    Route::post('payments/webhook/tripay', [PaymentController::class, 'webhookTripay']);
});
