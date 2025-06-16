<?php

namespace App\Jobs;

use App\Mail\CodeVerificationMail;
use App\Mail\RegistrationMail;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Mail;

class EmailJob implements ShouldQueue
{
    use Queueable, Dispatchable;

    protected User $user;
    protected string $purpose;
    public function __construct(User $user, string $purpose)
    {
        $this->user = $user;
        $this->purpose = $purpose;
    }

    public function handle(): void
    {
        if ($this->purpose == 'email_verification') {
            Mail::to($this->user->email)->send(new RegistrationMail($this->user));
        } elseif ($this->purpose == 'code_verification') {
            Mail::to($this->user->email)->send(new CodeVerificationMail($this->user));
        } else {
            return;
        }
    }
}
