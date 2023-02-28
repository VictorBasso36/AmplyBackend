<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Amply\Api\AuthController;
use App\Http\Controllers\NewPasswordController;
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



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::post('forgotPassword', [NewPasswordController::class, 'forgotPassword']);
Route::post('reset-password', [NewPasswordController::class, 'reset']);


Route::middleware(['auth:sanctum'], 'apiAdmin')->group(function () {
   
 
    Route::get('/checkingAuthenticated', function(){
        $user = auth()->user();
        $permissions = json_decode($user->permissions);  
        return response()->json(['messageAuth'=>'You are in','permissions' => $permissions, 'status' =>200], 200); 
    });
    Route::post('logout', [AuthController::class, 'logout']);
});

// Route::post('/login', function(Request $request){
//     if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){

//         $user = Auth::user();
//         $token = $user -> createToken('AmplyToken');
//         return response()->json($token,200);
//     }   
//     return response()->json('Usuario Invalido', 401);
// });