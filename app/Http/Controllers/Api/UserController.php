<?php

namespace App\Http\Controllers\Api;

use App\DTOs\UserDTO;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $users = $this->userService->getAllUsers();
        return response()->json($users);
    }

    public function show(User $user)
    {
//        $u = User::query()->where('id', '=', $user->id)->first();
//        return response()->json($u);
        return response()->json($user);
    }


    public function showLoggedInUser()
    {
        $userDTO = $this->userService->getLoggedInUser();
        if (!$userDTO) {
            return response()->json(['message' => 'کاربر وارد نشده است.'], 401);
        }

        return response()->json($userDTO);
    }




}
