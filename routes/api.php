<?php

use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Models\User;




// Version 1 API routes
Route::prefix('v1')->name('api.v1.')->group(function () {

    // Auth routes
    Route::prefix('auth')->controller(AuthController::class)->group(function () {
        Route::post('login', 'login');
        Route::post('register', 'register');
        Route::post('logout', 'logout')->middleware('auth:sanctum');
        Route::middleware('auth:sanctum')->group(function () {
            Route::post('/logout',         [AuthController::class, 'logout']);
            Route::put('/update-profile',  [AuthController::class, 'updateProfile']);
            Route::put('/change-password', [AuthController::class, 'changePassword']);
        });
    });

    // Protected routes (require authentication)
    Route::middleware('auth:sanctum')->group(function () {

        // Users
        Route::prefix('users')->name('users.')->controller(UserController::class)->group(function () {
            Route::get('/', 'index')->name('index');         // GET /api/v1/users
            Route::get('{user}', 'show')->name('show');      // GET /api/v1/users/{user}
//            Route::put('{user}', 'update')->name('update');  // PUT /api/v1/users/{user}
//            Route::delete('{user}', 'destroy')->name('destroy'); // DELETE /api/v1/users/{user}
        });

//        ->middleware(['role:admin|user|organizer'])

        Route::prefix('admin')->group(function () {
            Route::get('allUser',[\App\Http\Controllers\Api\AdminController::class,"all"]);
            Route::post('createUser',[\App\Http\Controllers\Api\AdminController::class,"create"]);
            Route::patch('updateUser/{user}', [\App\Http\Controllers\Api\AdminController::class, 'update']);
            Route::delete('deleteUser/{user}', [\App\Http\Controllers\Api\AdminController::class, 'delete']);
            Route::get('allLeague',[\App\Http\Controllers\Api\AdminController::class,"league"]);
            Route::get('/notifications', [\App\Http\Controllers\Api\Admin\NotificationController::class, 'index']);
            Route::post('{id}/read', [\App\Http\Controllers\Api\Admin\NotificationController::class, 'markAsRead']);
            Route::post('{id}/unread', [\App\Http\Controllers\Api\Admin\NotificationController::class, 'markAsUnread']);
            Route::delete('{id}', [\App\Http\Controllers\Api\Admin\NotificationController::class, 'destroy']);
            Route::post('read-all', [\App\Http\Controllers\Api\Admin\NotificationController::class, 'markAllAsRead']);
            Route::post('leagues/{league}/approve',[\App\Http\Controllers\Api\AdminController::class,"approve"]);
            Route::post('leagues/{league}/reject',[\App\Http\Controllers\Api\AdminController::class,"reject"]);
        });

          Route::prefix("teams")->middleware(['role:organizer|admin'])->group(function (){
            Route::get("index",[\App\Http\Controllers\Api\TeamController::class,"index"]);
            Route::post("create",[\App\Http\Controllers\Api\TeamController::class,"store"]);
            Route::patch("update/{team}",[\App\Http\Controllers\Api\TeamController::class,"update"]);
            Route::delete("delete/{team}",[\App\Http\Controllers\Api\TeamController::class,"delete"]);
            Route::post("team/{team}/league/{league}",[\App\Http\Controllers\Api\TeamController::class,'assignLeague']);
        });

        Route::prefix("leagues")->middleware(['role:organizer|admin'])->group(function () {
            Route::post("/{league}", [\App\Http\Controllers\Api\LeagueController::class, "index"]);
            Route::post("store", [\App\Http\Controllers\Api\LeagueController::class, "store"]);
            Route::patch("update/{league}", [\App\Http\Controllers\Api\LeagueController::class, "update"]);
            Route::delete("delete/{league}", [\App\Http\Controllers\Api\LeagueController::class, "delete"]);
        }
    );

        Route::prefix('fixture')->middleware('role:admin|organizer')->group(function (){
            Route::post('/{league}/generate-fixtures', [\App\Http\Controllers\Api\FixtureController::class, 'generate']);
            Route::get('/{league}/fixtures',[\App\Http\Controllers\Api\FixtureController::class,'index']);
            Route::patch('/{fixtures}/result', [\App\Http\Controllers\Api\FixtureController::class, 'submitResult']);

        });

        Route::prefix("organizer")->middleware("role:organizer")->group(function (){
            Route::get('notifications/', [\App\Http\Controllers\Organizer\NotificationController::class, 'index']);
            Route::post('notifications/{id}/read', [\App\Http\Controllers\Organizer\NotificationController::class, 'markAsRead']);
            Route::post('notifications/{id}/unread', [\App\Http\Controllers\Organizer\NotificationController::class, 'markAsUnread']);
            Route::delete('notifications/{id}', [\App\Http\Controllers\Organizer\NotificationController::class, 'destroy']);
            Route::post('notifications/read-all', [\App\Http\Controllers\Organizer\NotificationController::class, 'markAllAsRead']);

        });

        Route::prefix("standings")->middleware("role:organizer|admin")->group(function (){
//            Route::post('/{league}',[\App\Http\Controllers\Api\StandingController::class,'index']);
//            Route::get('/leagues/{league}/standings', [\App\Http\Controllers\Api\StandingController::class, 'index']);
              Route::get('{league}',[\App\Http\Controllers\Api\StandingController::class,'index']);
        });
    });

});






Route::post('assignRole',function (){
   $user = User::find(7);

   if(!$user){
       return 'user not found';
   }
    $user->assignRole('organizer');

});

Route::post('assignRoleAdmin',function (){
    $user = User::find(8);

    if(!$user){
        return 'user not found';
    }
    $user->assignRole('admin');

});

