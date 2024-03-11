<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function log()
    {
        return view('user.login');
    }

    public function login(Request $request)
    {
        $creds = $request->only('email', 'password');

        $validator = Validator::make($creds, [
            'email' => 'required|email',
            'password' => 'required|min:5'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->messages()], 401);
        }

        if (!Auth::attempt($creds)){
            return response()->json(['success' => false, 'message' => 'E-mail ou senha invalidos'], 404);
        }
        $user = Auth::user();


        $randonTime = time().rand(0, 9999);
        $token = $user->createToken($randonTime)->plainTextToken;

        return redirect(route('vehicles.index'));

        return response()->json(['success' => true, 'token' => $token,
         'message' => 'Usuario ' .$user->name. ' Logado com sucesso'], 200);
    }

    public function logout()
    {
        $user = Auth::user();
        $user->tokens()->delete();

        return redirect(route('log'));
        
        return response()->json(['success' => true, 'message' => 'Usuario ' .$user->name. ' Deslogado']);
    }
}
