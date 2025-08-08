<?php

declare(strict_types = 1);

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    /**
     * Handle a user registration request.
     */
    public function register(array $data): User
    {
        return User::query()->create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    /**
     * Handle a user login request.
     *
     * @throws ValidationException
     */
    public function login(array $credentials): User
    {
        if (! Auth::attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => [__('auth.failed')],
            ]);
        }

        $user = Auth::user();

        // This should not happen after a successful attempt, but it ensures type safety.
        if (! $user instanceof User) {
            throw ValidationException::withMessages(['email' => [__('auth.failed')]]);
        }

        return $user;
    }

    /**
     * Handle a user logout request.
     */
    public function logout(User $user): void
    {
        $user->currentAccessToken()->delete();
    }
}
