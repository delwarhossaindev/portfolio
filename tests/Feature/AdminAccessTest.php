<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        app(PermissionRegistrar::class)->forgetCachedPermissions();
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'editor']);
    }

    private function userWithRole(?string $role = null): User
    {
        $user = User::factory()->create();
        if ($role) {
            $user->assignRole($role);
        }

        return $user;
    }

    public function test_guests_are_redirected_to_login(): void
    {
        $this->get('/admin/dashboard')->assertRedirect(route('admin.login'));
        $this->get('/admin/users')->assertRedirect(route('admin.login'));
    }

    public function test_login_page_renders(): void
    {
        $this->get('/admin/login')->assertOk()->assertSee('Sign in');
    }

    public function test_admin_can_reach_every_section(): void
    {
        $admin = $this->userWithRole('admin');

        foreach (['/admin/dashboard', '/admin/home', '/admin/projects', '/admin/contacts', '/admin/users', '/admin/roles', '/admin/permissions'] as $url) {
            $this->actingAs($admin)->get($url)->assertOk();
        }
    }

    public function test_editor_manages_content_but_not_access_control(): void
    {
        $editor = $this->userWithRole('editor');

        $this->actingAs($editor)->get('/admin/dashboard')->assertOk()->assertDontSee('User Management');
        $this->actingAs($editor)->get('/admin/projects')->assertOk();
        $this->actingAs($editor)->get('/admin/users')->assertForbidden();
        $this->actingAs($editor)->get('/admin/roles')->assertForbidden();
    }

    public function test_user_without_a_role_is_forbidden(): void
    {
        $this->actingAs($this->userWithRole())->get('/admin/dashboard')->assertForbidden();
    }

    public function test_delete_uses_styled_confirm_and_success_shows_a_toast(): void
    {
        $admin = $this->userWithRole('admin');
        $contact = \App\Models\Contact::create([
            'name' => 'Jane', 'email' => 'jane@example.com', 'subject' => 'Hello', 'message' => 'Hello there, testing.',
        ]);

        $this->actingAs($admin)->get('/admin/contacts')
            ->assertOk()
            ->assertSee('data-confirm="Delete this message?"', false)
            ->assertDontSee('return confirm(', false)
            ->assertSee('id="confirm-dialog"', false);

        $this->actingAs($admin)->from('/admin/contacts')
            ->delete("/admin/contacts/{$contact->id}")
            ->assertRedirect();

        $this->actingAs($admin)->get('/admin/contacts')
            ->assertSee('admin-toast-success', false)
            ->assertSee('Message deleted.');
    }

    public function test_admin_can_set_a_simple_password(): void
    {
        $admin = $this->userWithRole('admin');

        $this->actingAs($admin)->put("/admin/users/{$admin->id}", [
            'name' => $admin->name,
            'email' => $admin->email,
            'password' => '1234567890',
            'password_confirmation' => '1234567890',
            'roles' => ['admin'],
        ])->assertRedirect(route('admin.users.index'));
    }
}
