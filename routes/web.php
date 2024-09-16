<?php

use App\Http\Controllers\Article;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');



Route::middleware("auth")->group(function () {

    // permissions---------
    Route::get("/permissions", [PermissionController::class, "index"])->name("permission.index");
    Route::get("/permissions/create", [PermissionController::class, "create"])->name("permission-create");
    Route::post("/permissions", [PermissionController::class, "store"])->name("permission-store");
    Route::get("/permissions/edit/{id}", [PermissionController::class, "edit"])->name("permission-edit");
    Route::post("/permissions/{id}", [PermissionController::class, "update"])->name("permission-update");
    Route::delete("/permissions", [PermissionController::class, "destroy"])->name("permission-destroy");
    // permissions---------




    // permissions---------
    Route::get("/role", [RoleController::class, "index"])->name("role.index");
    Route::get("/role/create", [RoleController::class, "create"])->name("role-create");
    Route::post("/role", [RoleController::class, "store"])->name("role-store");
    Route::get("/role/edit/{id}", [RoleController::class, "edit"])->name("role-edit");
    Route::post("/role/{id}", [RoleController::class, "update"])->name("role-update");
    Route::delete("/role", [RoleController::class, "destroy"])->name("role-destroy");
    // permissions---------



    // permissions---------
    Route::get("/article", [ArticleController::class, "index"])->name("article.index");
    Route::get("/article/create", [ArticleController::class, "create"])->name("article-create");
    Route::post("/article", [ArticleController::class, "store"])->name("article-store");
    Route::get("/article/edit/{id}", [ArticleController::class, "edit"])->name("article-edit");
    Route::post("/article/{id}", [ArticleController::class, "update"])->name("article-update");
    Route::delete("/article", [ArticleController::class, "destroy"])->name("article-destroy");
    // permissions---------




     // users---------
     Route::get("/user", [UserController::class, "index"])->name("user.index");
     Route::get("/user/create", [UserController::class, "create"])->name("user-create");
     Route::post("/user", [UserController::class, "store"])->name("user-store");
     Route::get("/user/edit/{id}", [UserController::class, "edit"])->name("user-edit");
     Route::post("/user/{id}", [UserController::class, "update"])->name("user-update");
     Route::delete("/user", [UserController::class, "destroy"])->name("user-destroy");
     // users---------

});



require __DIR__ . '/auth.php';
