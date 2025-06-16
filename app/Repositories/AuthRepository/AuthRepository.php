<?php

namespace App\Repositories\AuthRepository;

use App\Jobs\EmailJob;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Repositories\AuthRepository\AuthRepositoryInterface;
use Str;

class AuthRepository implements AuthRepositoryInterface
{
    public function login(array $credentials): ?User
    {
        return Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']], $credentials['remember_me']) ? auth()->user() : null;
    }
    public function register(array $credentials): ?User
    {
        $user = User::create($credentials);
        $this->send_verification_code($user, 'email_verification');
        return $user;
    }
    public function logout(): bool
    {
        Auth::logout();
        Session()->invalidate();
        Session()->regenerateToken();
        return true;
    }
    public function check_email_verified_at(User $user): bool
    {
        return $user->email_verified_at != null;
    }
    public function send_verification_code(User $user, string $purpose): bool
    {
        $user->verification_code = Str::random(6);
        $user->save();
        EmailJob::dispatch($user, $purpose);
        return true;
    }
    public function verify_verification_code(User $user, string $verification_code): bool
    {
        return $user->verification_code === $verification_code;
    }
}
