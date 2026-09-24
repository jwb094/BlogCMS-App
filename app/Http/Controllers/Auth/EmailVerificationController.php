<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ResendVerificationEmailRequest;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmailVerificationController extends Controller
{
    /**
     * Display the email verification notice.
     */
    public function notice(): View
    {
        return view('auth.verify-email');
    }

    /**
     * Verify the user's email address.
     */
    public function verify(
        EmailVerificationRequest $request
    ): RedirectResponse {
        $request->fulfill();

        return redirect()
            ->route('admin.dashboard')
            ->with('status', true)
            ->with(
                'message',
                'Email address verified successfully.'
            );
    }

    /**
     * Resend the verification email.
     */
    public function resend(
        ResendVerificationEmailRequest $request
    ): RedirectResponse {
        $request->user()->sendEmailVerificationNotification();

        return back()
            ->with('status', true)
            ->with(
                'message',
                'A new verification link has been sent to your email address.'
            );
    }
}