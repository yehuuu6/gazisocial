<?php

use App\Livewire\Components\Auth\LoginForm;
use Livewire\Livewire;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Create the user only once before each test
    User::factory()->create([
        'email' => 'test@example.com',
        'password' => Hash::make('password'),
    ]);
});

function prepareFieldsForLoginTest($overrides = [])
{
    return Livewire::test(LoginForm::class)
        ->set('email', $overrides['email'] ?? 'test@example.com')
        ->set('password', $overrides['password'] ?? 'password');
}

it('renders successfully', function () {
    Livewire::test(LoginForm::class)
        ->assertStatus(200);
});

it('can login a user', function () {
    prepareFieldsForLoginTest()
        ->call('login');

    $this->assertAuthenticatedAs(User::first());
});

it('requires a valid email', function () {
    prepareFieldsForLoginTest(['email' => 'invalid-email'])
        ->call('login')
        ->assertDispatched('alert', function ($event, $params) {
            return $params['type'] === 'error' && str_contains($params['message'], 'Geçerli bir email adresi giriniz.');
        });
});

it('requires a password', function () {
    prepareFieldsForLoginTest(['password' => ''])
        ->call('login')
        ->assertDispatched('alert', function ($event, $params) {
            return $params['type'] === 'error' && str_contains($params['message'], 'Şifre alanı boş bırakılamaz.');
        });
});

it('does not allow to login with invalid credentials', function () {
    prepareFieldsForLoginTest(['password' => 'invalid-password'])
        ->call('login')
        ->assertDispatched('alert', function ($event, $params) {
            return $params['type'] === 'error' && str_contains($params['message'], 'Üzgünüz, bu bilgilerle hesap bulunamadı.');
        });
});

it('does not allow to login too many times', function () {
    for ($i = 0; $i < 10; $i++) {
        prepareFieldsForLoginTest(['password' => 'invalid-password'])
            ->call('login');
    }

    prepareFieldsForLoginTest(['password' => 'invalid-password'])
        ->call('login')
        ->assertDispatched('alert', function ($event, $params) {
            return $params['type'] === 'error' && str_contains($params['message'], 'Çok fazla istek gönderdiniz. Lütfen');
        });
});

it('can logout a user', function () {
    $user = User::first();

    $this->actingAs($user);

    Livewire::test(LoginForm::class)
        ->call('logout');

    $this->assertGuest();
});

it('redirects to login page after logout', function () {
    $user = User::first();

    $this->actingAs($user);

    Livewire::test(LoginForm::class)
        ->call('logout')
        ->assertRedirect(route('login'));
});
