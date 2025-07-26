<?php
namespace App\Repositories;

use App\DTOs\UserDTO;
use App\Enums\UserRole;
use App\Interfaces\UserInterface;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserRepo implements UserInterface
{
    public function findById($id)
    {
        return User::find($id);
    }

    public function getLoggedInUser()
    {
        return Auth::user();
    }

    public function getAllUser()
    {
        return User::all()->map(function ($user) {
            return new UserDTO(
                $user->id,
                $user->name,
                $user->email,
                UserRole::from($user->role),
                $user->password,

            );
        })->toArray();
    }

    public function getAdmins()
    {
        return User::query()
            ->where('role', 'admin')
            ->get();
    }

    public function create(array $data): User
    {
        return User::create($data);
    }

    public function update(User $user, array $data): User
    {
        $user->update($data);
        return $user;
    }

    public function delete(User $user): bool
    {
        return $user->delete();
    }

}
