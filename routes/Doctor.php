<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\DoctorController;
use App\Http\Controllers\Doctor\UserController;
use App\Http\Controllers\Doctor\PostController;
use App\Http\Controllers\Doctor\ReactController;
use App\Http\Controllers\Doctor\CommentController;


//  Auth
Route::group([
    'prefix' => 'auth/doctor'
], function () {
    Route::post('/login', [DoctorController::class, 'login']);
    Route::post('/logout', [DoctorController::class, 'logout']);
    Route::get('/myProfile', [DoctorController::class, 'doctorProfile']);
});

//User Images
Route::group([
    'prefix' => 'doctor'
], function () {
    Route::get('/showUserImage', [UserController::class, 'showUserImage']);
});

//Post
Route::group([
    'prefix' => 'doctor'
], function () {
    Route::post('/addPost', [PostController::class, 'addPost']);
    Route::get('/showPosts', [PostController::class, 'showPosts']);
    Route::post('/updatePost/{id}', [PostController::class, 'updatePost']);
    Route::post('/destroyPost/{id}', [PostController::class, 'destroyPost']);
});

//React
Route::group([
    'prefix' => 'doctor'
], function () {
    Route::post('/addReact', [ReactController::class, 'addReact']);
    Route::get('/showReacts', [ReactController::class, 'showReacts']);
    Route::post('/updateReact/{id}', [ReactController::class, 'updateReact']);
    Route::post('/destroyReact/{id}', [ReactController::class, 'destroyReact']);
});

//Comment
Route::group([
    'prefix' => 'doctor'
], function () {
    Route::post('/addComment', [CommentController::class, 'addComment']);
    Route::get('/showComments', [CommentController::class, 'showComments']);
    Route::post('/updateComment/{id}', [CommentController::class, 'updateComment']);
    Route::post('/destroyComment/{id}', [CommentController::class, 'destroyComment']);
});
?>
