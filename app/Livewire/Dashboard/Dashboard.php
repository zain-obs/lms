<?php

namespace App\Livewire\Dashboard;

use App\Models\User;
use Livewire\Component;
use App\Models\Classroom;
use Illuminate\Support\Facades\Http;

class Dashboard extends Component
{
    public $email;
    public $password;
    public $name;
    // API Responses
    public $loginResponse;
    public $registerResponse;
    public $fetchResponse;
    public $token;
    // API Errors
    public $loginError;
    public $registerError;
    public $fetchError;
    protected $apiBaseUrl = 'http://127.0.0.1:8001/api';
    protected $apiEndpoints = [
        'login' => '/login',
        'register' => '/register',
        'users' => '/users',
    ];
    public function loginApi()
    {
        $response = Http::post($this->apiBaseUrl . $this->apiEndpoints['login'], [
            'email' => $this->email,
            'password' => $this->password,
        ]);

        if ($response->successful()) {
            $this->loginResponse = json_encode($response->json(), JSON_PRETTY_PRINT);
        } else {
            $this->loginError = $response->json()['message'] ?? 'Login failed';
        }
    }

    public function registerApi()
    {
        $response = Http::post($this->apiBaseUrl . $this->apiEndpoints['register'], [
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
        ]);

        if ($response->successful()) {
            $this->registerResponse = json_encode($response->json(), JSON_PRETTY_PRINT);
        } else {
            $this->registerError = $response->json()['message'] ?? 'Registration failed';
        }
    }

    public function fetchUsers()
    {
        $response = Http::withToken($this->token)->get($this->apiBaseUrl . $this->apiEndpoints['users']);
        if ($response->successful()) {
            $this->fetchResponse = json_encode($response->json(), JSON_PRETTY_PRINT);
        } else {
            $this->fetchError = $response->json()['message'] ?? 'Failed to fetch users';
        }
    }
    public function render()
    {
        $roleCounts = [];
        $roles = ['student', 'teacher', 'parent'];
        foreach ($roles as $role) {
            $roleCounts[$role] = User::role($role)->count();
        }
        $roleCounts['member'] = User::doesntHave('roles')->count();

        $classCount = Classroom::count();
        return view('livewire.dashboard.dashboard', compact(['roleCounts', 'classCount']));
    }
}
