<?php

namespace App\Repositories\AuthRepository;
use App\Models\User;

interface AuthRepositoryInterface{
    public function login(array $credentials): ?User;
    public function register(array $credentials): ?User;
    public function logout(): bool;
    public function check_email_verified_at(User $user): bool;
    public function send_verification_code(User $user, string $purpose): bool;
    public function verify_verification_code(User $user, string $verification_code): bool;
}