<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $name               =   $request->input('name');
        $email              =   $request->input('email');
        $type_user          =   $request->input('type_user');
        $password           =   $request->input('password');

        $user               =   new User; 
        $user->name         =   $name;
        $user->email        =   $email;
        $user->type_user    =   $type_user;
        $user->password     =   bcrypt($password);

        if($user){
            $user->save();
            return response()->json([$user],200);
        }
    
        return response()->json([
            'message' => 'Não foi possível criar o usuário.'
        ], 404);

    }
    public function login(Request $request){
        
        request()->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
       
        if(!Auth::attempt($credentials))
            return response()->json([
                'message' => 'Credencial Inválida.'
            ], 401);

        $token = auth()->user()->createToken('auth_token');

        return response()->json([
            'data' => ['token' => $token->plainTextToken],
            'message' => 'Usuário logado com sucesso'
        ], 200);
    }
    public function logout(){
        //remove o token da requisição atual 
        if(Auth::user()->currentAccessToken()->delete())
            return response()->json([
                'message' => 'Usuário deslogado com sucesso'
            ],200);
        
        return reponse()->json([
            'message' => 'Não foi possível fazer logout.'
        ], 404);

    }
}
