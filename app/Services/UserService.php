<?php
namespace App\Services;

use App\DTOs\UserDTO;
use App\Repositories\UserRepo;
use Illuminate\Support\Facades\Auth;

class UserService {

    protected UserRepo $userRepo;

    public function __construct(UserRepo $userRepo) {
        $this->userRepo = $userRepo;
    }

    public function getAllUsers(): array {
        return $this->userRepo->getAllUser();
    }

    public function getLoggedInUser()
    {
        $user = $this->userRepo->getLoggedInUser();
        if (!$user) {
            return null;
        }
        return new UserDTO($user->id, $user->name, $user->email, $user->userRole);
    }
}
