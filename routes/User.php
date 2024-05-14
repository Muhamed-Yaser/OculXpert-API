<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\User\PostController;
use App\Http\Controllers\User\ReactController;
use App\Http\Controllers\User\CommentController;
use App\Http\Controllers\User\ImageController;


//  Auth
Route::group([
    'prefix' => 'auth/user'
], function () {
    Route::post('/register', [UserController::class, 'register']);
    Route::post('/login', [UserController::class, 'login']);
    Route::post('/logout', [UserController::class, 'logout']);
    Route::get('/myProfile', [UserController::class, 'userProfile']);
    Route::post('/uploadProfileImage', [UserController::class, 'uploadProfileImage']);
});

//user Image
Route::group([
    'prefix' => 'user'
], function () {
    Route::post('uploadUserImages', [ImageController::class, 'uploadUserImages']);
});
//Post
Route::group([
    'prefix' => 'user'
], function () {
    Route::post('/addPost', [PostController::class, 'addPost']);
    Route::get('/showPosts', [PostController::class, 'showPosts']);
    Route::post('/updatePost/{id}', [PostController::class, 'updatePost']);
    Route::post('/destroyPost/{id}', [PostController::class, 'destroyPost']);
});

//React
Route::group([
    'prefix' => 'user'
], function () {
    Route::post('/addReact', [ReactController::class, 'addReact']);
    Route::get('/showReacts', [ReactController::class, 'showReacts']);
    Route::post('/updateReact/{id}', [ReactController::class, 'updateReact']);
    Route::post('/destroyReact/{id}', [ReactController::class, 'destroyReact']);
});

//Comment
Route::group([
    'prefix' => 'user'
], function () {
    Route::post('/addComment', [CommentController::class, 'addComment']);
    Route::get('/showComments', [CommentController::class, 'showComments']);
    Route::post('/updateComment/{id}', [CommentController::class, 'updateComment']);
    Route::post('/destroyComment/{id}', [CommentController::class, 'destroyComment']);
});
?>