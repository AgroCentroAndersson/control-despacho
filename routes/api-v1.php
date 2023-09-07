<?php

use App\Http\Controllers\Api\ApiBatchController;
use App\Http\Controllers\Api\ApiDocumentDetailController;
use App\Http\Controllers\Api\ApiDocumentsController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\ApiGrocerController;


Route::post('register', [GrocerController::class, 'store'])->name('register.api.v1');

Route::get('login-user', [ApiGrocerController::class, 'loginResp'])->name('login.api.v1');
// Route::get('login', [GrocerController::class, 'validateLogin'])->name('login.api.v1');

Route::post('grocer/register', [ApiGrocerController::class, 'store'])->name('register.api.v1');

Route::get('documents', [ApiDocumentsController::class, 'listDocuments'])->name('documents.api.v1');

Route::get('detail-document', [ApiDocumentDetailController::class, 'getDetailDocument'])->name('document_document.api.v1');

Route::get('validate-product-document', [ApiDocumentDetailController::class, 'validateProduct'])->name('document_document.api.v1');

Route::get('quantity-batch', [ApiBatchController::class, 'getQuantityBatch'])->name('quantity_batch.api.v1');

Route::post('insert-document-details', [ApiDocumentDetailController::class, 'insertDetailDocuemts'])->name('insert_document_details.api.v1');


//[{"DocEntry":168272,"DocNum":3010536,"Type":"Pedido","ItemCode":"ZPT101110GT","ItemName":"","Quantity":1.0,"Lote":"125.15.2.52"}]
