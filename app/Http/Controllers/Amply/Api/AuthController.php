<?php

namespace App\Http\Controllers\Amply\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|max:191|unique:users,email',
            'password' => 'required|min:8',
            'permissions' => 'required'
        ]);
        if ($validator -> fails())
        {
            return response()->json([
            'validation_erros'=>$validator->messages(),
            ]);
        }

        else
        {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'permissions' => $request->permissions,
            ]);
            $token = $user->createToken($user->email.'_Token', ['server:update'])->plainTextToken;
            return response()->json([
                'status' => 200, 
                'username' => $user->name, 
                'token' => $token,
                'permissions' => $user->permissions,
                'message' =>'Registrado Com Sucesso',
            ]);
        }
    }



public function login(Request $request)
    {

       
        $remember_me = $request ->input('remember_me');
               
        $validator = Validator::make($request->all(), [
            'email' => 'required:max:191',
            'password' => 'required',
       
        ]);

        if($validator->fails())
        {
            return response()->json([
                'validation_erros' =>$validator->messages(),
            ]);
        }
        else
        {
            $user = User::where('email', $request->email)->first();
 
            if(!$user || !Hash::check($request->password, $user->password)){
                return response()->json([
                    'status' =>401,
                    'message'=>'Email ou senha Incorretos.',
                ]);
            }
            
            else{
                $permissions = json_decode($user->permissions);
                $permissionsArray = (array) $permissions;
                $token = $user->createToken($user->email.'_Token', [$permissionsArray])->plainTextToken;
                


                return response()->json([
                    'status'=>200,
                    'username'=>$user->name,
                    'token' => $token,
                    'permissions' => $permissions,
                    'message' => 'Bem-vindo.',
                ]);

            }
        }
    }


    public function logout(){
        auth()->user()->tokens()->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Até Logo !',
        ]);
    }
}
