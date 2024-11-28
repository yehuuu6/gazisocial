<?php

use App\Livewire\Components\Auth\RegisterForm;
use Livewire\Livewire;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function prepareFieldsForRegisterTest($overrides = [])
{
    return Livewire::test(RegisterForm::class)
        ->set('name', $overrides['name'] ?? 'John Doe')
        ->set('email', $overrides['email'] ?? 'test@example.com')
        ->set('username', $overrides['username'] ?? 'defaultusername')
        ->set('password', $overrides['password'] ?? 'password')
        ->set('password_confirmation', $overrides['password_confirmation'] ?? 'password')
        ->set('accept_terms', $overrides['accept_terms'] ?? true);
}

it('renders successfully', function () {
    Livewire::test(RegisterForm::class)
        ->assertStatus(200);
});

it('can register a user', function () {
    prepareFieldsForRegisterTest()
        ->call('register');

    $this->assertDatabaseHas('users', [
        'name' => 'John Doe',
        'username' => 'defaultusername',
        'email' => 'test@example.com',
    ]);

    $this->assertAuthenticated();

    $this->assertDatabaseCount('users', 1);
});

it('does not allow to register if terms are not accepted', function () {
    prepareFieldsForRegisterTest(['accept_terms' => false])
        ->call('register')
        ->assertDispatched('alert', function ($event, $params) {
            return $params['type'] === 'error' && str_contains($params['message'], 'Kullanıcı sözleşmesini kabul etmelisiniz.');
        });
});

it('does not allow choosing "anonymous" as username', function () {
    prepareFieldsForRegisterTest([
        'username' => 'anonymous',
    ])
        ->call('register')
        ->assertDispatched('alert', function ($event, $params) {
            return $params['type'] === 'error' && str_contains($params['message'], 'Bu kullanıcı adı kullanılamaz.');
        });
});

it('does not allow choosing a username that is already taken', function () {
    User::factory()->create(['username' => 'johndoe']);

    prepareFieldsForRegisterTest(['username' => 'johndoe'])
        ->call('register')
        ->assertDispatched('alert', function ($event, $params) {
            return $params['type'] === 'error' && str_contains($params['message'], 'Bu kullanıcı adı zaten alınmış.');
        });
});

it('does not allow choosing an email that is already taken', function () {
    User::factory()->create(['email' => 'test@example.com']);

    prepareFieldsForRegisterTest(['email' => 'test@example.com'])
        ->call('register')
        ->assertDispatched('alert', function ($event, $params) {
            return $params['type'] === 'error' && str_contains($params['message'], 'Bu email adresi zaten alınmış.');
        });
});

it('requires a valid email', function () {
    prepareFieldsForRegisterTest(['email' => 'invalid-email'])
        ->call('register')
        ->assertDispatched('alert', function ($event, $params) {
            return $params['type'] === 'error' && str_contains($params['message'], 'Geçerli bir email adresi giriniz.');
        });
});

it('does not allow choosing a password with less than 8 characters', function () {
    prepareFieldsForRegisterTest(['password' => '1234567'])
        ->call('register')
        ->assertDispatched('alert', function ($event, $params) {
            return $params['type'] === 'error' && str_contains($params['message'], 'Şifre alanı en az 8 karakter olabilir.');
        });
});

it('does not allow choosing a password that does not match confirmation', function () {
    prepareFieldsForRegisterTest(['password_confirmation' => 'password2'])
        ->call('register')
        ->assertDispatched('alert', function ($event, $params) {
            return $params['type'] === 'error' && str_contains($params['message'], 'Şifreler uyuşmuyor.');
        });
});

it('does not allow choosing a name with more than 30 characters', function () {
    prepareFieldsForRegisterTest(['name' => str_repeat('a', 31)])
        ->call('register')
        ->assertDispatched('alert', function ($event, $params) {
            return $params['type'] === 'error' && str_contains($params['message'], 'Ad alanı en fazla 30 karakter olabilir.');
        });
});

it('does not allow choosing a username with more than 30 characters', function () {
    prepareFieldsForRegisterTest(['username' => str_repeat('a', 31)])
        ->call('register')
        ->assertDispatched('alert', function ($event, $params) {
            return $params['type'] === 'error' && str_contains($params['message'], 'Kullanıcı adı alanı en fazla 30 karakter olabilir.');
        });
});

it('does not allow choosing an email with more than 255 characters', function () {
    prepareFieldsForRegisterTest(['email' => str_repeat('a', 256) . '@example.com'])
        ->call('register')
        ->assertDispatched('alert', function ($event, $params) {
            return $params['type'] === 'error' && str_contains($params['message'], 'Email alanı en fazla 255 karakter olabilir.');
        });
});

it('does not allow registering if user is already authenticated', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    prepareFieldsForRegisterTest()
        ->call('register')
        ->assertRedirect(route('verification.notice'));
});

it('gives error if too many requests sent', function () {
    for ($i = 0; $i < 10; $i++) {
        prepareFieldsForRegisterTest(['email' => 'invalid-email'])
            ->call('register');
    }

    prepareFieldsForRegisterTest()
        ->call('register')
        ->assertDispatched('alert', function ($event, $params) {
            return $params['type'] === 'error' && str_contains($params['message'], 'Çok fazla istek gönderdiniz.');
        });
});
