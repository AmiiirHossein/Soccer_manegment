<?php

namespace Tests\Feature\Api;

use App\Enums\UserRole;
use App\Models\User;
use App\Models\League;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    protected User $adminUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->adminUser = User::factory()->create([
            'role' => UserRole::ADMIN->value,
        ]);

        Sanctum::actingAs($this->adminUser);
    }

    /** @test */
    public function it_returns_all_admin_users()
    {
        User::factory()->count(3)->create(['role' => UserRole::ADMIN->value]);

        $response = $this->getJson('/api/v1/admin/allUser/');

        $response->assertJsonCount(4, 'data');
    }

    /** @test */
    public function it_creates_a_new_user()
    {
        $data = [
            'name' => 'New User',
            'email' => 'newuser@example.com',
            'role' => UserRole::ORGANIZER->value,
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->postJson('/api/v1/admin/createUser', $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('users', ['email' => 'newuser@example.com']);
    }

    /** @test */
    public function it_updates_an_existing_user()
    {
        $user = User::factory()->create();

        $data = [
            'name' => 'Updated Name',
            'email' => $user->email,
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
            'role' => 'admin'
        ];

        $response = $this->patchJson("/api/v1/admin/updateUser/{$user->id}", $data);
        $response->assertStatus(200);
        $this->assertDatabaseHas('users', ['id' => $user->id, 'name' => 'Updated Name']);
        $this->assertTrue(Hash::check('newpassword123', $user->fresh()->password));
    }

    /** @test */
    public function it_deletes_a_user()
    {
        $user = User::factory()->create();

        $response = $this->deleteJson("/api/v1/admin/deleteUser/{$user->id}");

        $response->assertStatus(200);
        $this->assertModelMissing($user);
    }

    public function test_it_returns_all_leagues()
    {
        $organizer = User::factory()->create();
        League::factory()->count(5)->create([
            'organizer_id' => $organizer->id,
        ]);
//        League::factory()->count(5)->create();

        $response = $this->getJson('/api/v1/admin/allLeague');

        $response->assertStatus(200);
        $response->assertJsonCount(5, 'data');
    }

    /** @test */
    public function it_approves_a_league()
    {
        $league = League::factory()->create(['status' => 'pending']);

        $response = $this->postJson("/api/v1/admin/leagues/{$league->id}/approve");

        $response->assertStatus(200);
        $this->assertDatabaseHas('leagues', ['id' => $league->id, 'status' => 'approved']);
    }

    /** @test */
    public function it_rejects_a_league()
    {
        $league = League::factory()->create(['status' => 'pending']);

        $response = $this->postJson("/api/v1/admin/leagues/{$league->id}/reject");

        $response->assertStatus(200);
        $this->assertDatabaseHas('leagues', ['id' => $league->id, 'status' => 'rejected']);
    }
}
