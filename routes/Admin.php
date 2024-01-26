<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminController;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\ReactController;
use App\Http\Controllers\Admin\CommentController;


//  Auth
Route::group([
    'prefix' => 'auth/admin'
], function () {
    Route::post('/login', [AdminController::class, 'login']);
    Route::post('/logout', [AdminController::class, 'logout']);
    Route::get('/adminProfile', [AdminController::class, 'adminProfile']);
});

//CRUD User
Route::group([
    'prefix' => 'admin'
], function () {
    Route::get('/showUsers', [UserController::class, 'showUsers']);
    Route::post('/destroyUser/{id}', [UserController::class, 'destroyUser']);
});

//CRUD Doctor
Route::group([
    'prefix' => 'admin'
], function () {
    Route::post('/addDoctors', [DoctorController::class, 'addDoctors']);
    Route::get('/showDoctors', [DoctorController::class, 'showDoctors']);
    Route::post('/updateDoctors/{id}', [DoctorController::class, 'updateDoctors']);
    Route::post('/destroyDoctor/{id}', [DoctorController::class, 'destroyDoctor']);
});

//Posts
Route::group([
    'prefix' => 'admin'
], function () {
    Route::get('/showPosts', [PostController::class, 'showPosts']);
    Route::post('/destroyPost/{id}', [PostController::class, 'destroyPost']);
});

//Reacts
Route::group([
    'prefix' => 'admin'
], function () {
    Route::get('/showReacts', [ReactController::class, 'showReacts']);
    Route::post('/destroyReact/{id}', [ReactController::class, 'destroyReact']);
});

//Comments
Route::group([
    'prefix' => 'admin'
], function () {
    Route::get('/showComments', [CommentController::class, 'showComments']);
    Route::post('/destroyComment/{id}', [CommentController::class, 'destroyComment']);
});
?>
