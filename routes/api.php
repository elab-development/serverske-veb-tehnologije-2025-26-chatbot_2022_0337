<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ChatbotController;
use App\Http\Controllers\Api\ExportController;
use App\Http\Controllers\Api\KnowledgeItemController;
use App\Http\Controllers\Api\ProfileController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'me']);
    Route::post('/profile/image', [ProfileController::class, 'uploadImage']);
    Route::delete('/profile/image', [ProfileController::class, 'deleteImage']);

    Route::middleware('role:admin')->get('/admin/check', function (Request $request) {
        return response()->json([
            'message' => 'Korisnik ima admin pristup.',
            'user' => $request->user(),
        ]);
    });
});

Route::apiResource('categories', CategoryController::class)
    ->only(['index', 'show']);
Route::apiResource('knowledge-items', KnowledgeItemController::class)
    ->only(['index', 'show']);

Route::middleware(['auth:sanctum', 'role:admin,moderator'])->group(function () {
    Route::get('/export/knowledge-items', [ExportController::class, 'knowledgeItems']);

    Route::apiResource('categories', CategoryController::class)
        ->only(['store', 'update', 'destroy']);
    Route::apiResource('knowledge-items', KnowledgeItemController::class)
        ->only(['store', 'update', 'destroy']);
});

Route::post('chatbot/ask', [ChatbotController::class, 'ask']);
