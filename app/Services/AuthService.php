<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\AuthRepository\AuthRepositoryInterface;

class AuthService
{
    private $authRepository;
    public function __construct(AuthRepositoryInterface $authRepository)
    {
        $this->authRepository = $authRepository;
    }
    public function login(array $credentials)
    {
        return $this->authRepository->login($credentials);
    }
    public function register(array $credentials)
    {
        return $this->authRepository->register($credentials);
    }
    public function logout()
    {
        return $this->authRepository->logout();
    }
    public function check_email_verified_at(User $user)
    {
        return $this->authRepository->check_email_verified_at($user);
    }
    public function send_verification_code(User $user, string $purpose)
    {
        return $this->authRepository->send_verification_code($user, $purpose);
    }
    public function verify_verification_code(User $user, string $verification_code): bool
    {
        return $this->authRepository->verify_verification_code($user, $verification_code);
    }
}
