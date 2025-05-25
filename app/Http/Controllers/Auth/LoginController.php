<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function __construct(private AuthService $authService)
    {
        //
    }

    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $token = $this->authService->login($credentials['email'], $credentials['password']);
        
        return response()->json([
            'token' => $token,
        ]);
    }
    
}
