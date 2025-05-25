<?php

namespace App\Services;

use App\Repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{

    public function __construct(private UserRepositoryInterface $userRepository)
    {
        //
    }

    public function login(string $email, string $password): string {
        $user = $this->userRepository->findByEmail($email);

        if (!$user || !Hash::check($password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['認証に失敗しました'],
            ]);
        }

        return $user->createToken('auth_token')->plainTextToken;
    }
}
