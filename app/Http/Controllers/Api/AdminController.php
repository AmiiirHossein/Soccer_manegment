<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLeagueRequest;
use App\Http\Resources\Api\LeagueResource;
use App\Http\Resources\UserResource;
use App\Models\League;
use App\Models\User;
use App\Services\AdminService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rules\Password;

class AdminController extends Controller
{
    protected AdminService $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    public function all()
    {
        $admins = $this->adminService->listAdmins();
        return UserResource::collection($admins);
    }

    public function create(Request $request)
    {
        $validated = $request->validate([
            "name" => "required|string|max:255",
            "email" => "required|email|unique:users,email",
            'role' => ['required', new Enum(\App\Enums\UserRole::class)],
            "password" => ["required", "string", Password::min(8), "confirmed"]
        ]);

        $user = $this->adminService->createUser($validated);

        return response()->json(["message" => "User created", "user" => $user]);
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            "name" => "required|string|max:255",
            "email" => "required|email|unique:users,email," . $user->id,
            "password" => ["required", "string", Password::min(8), "confirmed"]
        ]);

        $user = $this->adminService->updateUser($user, $validated);

        return response()->json(["message" => "User updated", "user" => $user]);
    }

    public function delete(User $user)
    {
        $this->adminService->deleteUser($user);
        return response()->json(["message" => "User deleted"]);
    }

    public function league()
    {
        $leagues = $this->adminService->getAllLeagues();
        return LeagueResource::collection($leagues);
    }

    public function approve(League $league)
    {
        try {
            $this->adminService->approveLeague($league);
            return response()->json(['message' => 'League approved successfully!']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    public function reject(League $league)
    {
        try {
            $this->adminService->rejectLeague($league);
            return response()->json(['message' => 'League rejected successfully!']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }





}
