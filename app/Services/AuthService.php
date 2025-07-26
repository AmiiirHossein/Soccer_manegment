<?php

namespace App\Services;

use App\Repositories\AuthRepo;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class AuthService
{
    protected AuthRepo $authRepository;

    public function __construct(AuthRepo $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function register(array $data): array
    {
        $user = $this->authRepository->createUser([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'role'     => 'player',
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'message' => 'User registered successfully',
            'token'   => $token,
        ];
    }

    public function login(string $email, string $password): array
    {
        $user = $this->authRepository->findByEmail($email);

        if (! $user || ! Hash::check($password, $user->password)) {
            throw ValidationException::withMessages([
                'message' => ['Email or password is incorrect.'],
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'message' => 'Login successful',
            'token'   => $token,
        ];
    }

    public function logout(User $user): array
    {
        $user->currentAccessToken()->delete();

        return [
            'message' => 'Logged out successfully',
        ];
    }

    public function updateProfile(User $user, array $data): array
    {
        $this->authRepository->updateUser($user, $data);

        return [
            'message' => 'Profile updated successfully',
            'user'    => $user,
        ];
    }

    public function changePassword(User $user, string $currentPassword, string $newPassword): array
    {
        if (! Hash::check($currentPassword, $user->password)) {
            throw ValidationException::withMessages([
                'message' => ['Current password is incorrect.'],
            ]);
        }

        $hashedPassword = Hash::make($newPassword);
        $this->authRepository->updatePassword($user, $hashedPassword);

        return [
            'message' => 'Password changed successfully',
        ];
    }
}
