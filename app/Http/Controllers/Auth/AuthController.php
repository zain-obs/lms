<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\AuthService;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    private $authService;
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }
    public function show_login(Request $request)
    {
        return view('Pages.Auth.login');
    }
    public function attempt_login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $credentials['remember_me'] = $request->has('remember_me');
        $user = $this->authService->login($credentials);
        
        if ($user) {
            if ($this->authService->check_email_verified_at($user)) {
                return redirect()
                    ->route('show-dashboard')
                    ->with(['success' => true, 'message' => 'Login Successful']);
            } else {
                $this->authService->send_verification_code($user, 'email_verification');
                return redirect()
                    ->route('verify_code')
                    ->with(['success' => false, 'message' => 'Email not verified']);
            }
        } else {
            return redirect()
                ->back()
                ->with(['success' => false, 'message' => 'Invalid Credentials']);
        }
    }
    public function show_register(Request $request)
    {
        return view('Pages.Auth.register');
    }
    public function attempt_register(RegisterRequest $request)
    {
        $user = $this->authService->register($request->only('name', 'email', 'password'));
        if ($user){
            Auth::login($user);
            return view('Pages.Auth.verify_email')->with(['success' => false, 'message' => 'Registration Error', 'user' => $user]);
        } else {
            return redirect()
                ->back()
                ->with(['success' => false, 'message' => 'Registration Error']);
        }
    }
    public function logout()
    {
        $this->authService->logout();
        return redirect()->route('show-login');
    }

    public function show_verify_code()
    {
        return view('Pages.Auth.verify_email');
    }

    public function verify_code(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|size:6',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $user = auth()->user();
            $code_correct = $this->authService->verify_verification_code($user, $request->code);
            if ($code_correct) {
                $user->email_verified_at = Carbon::now();
                $user->save();
                return redirect()
                    ->route('show-dashboard')
                    ->with(['success' => true, 'message' => 'Email Verified Successfully']);
            } else {
                return redirect()
                    ->back()
                    ->with(['success' => false, 'message' => 'Invalid Code']);
            }
        }
    }
}
