<?php

namespace App\Http\Controllers;

use App\User;
use App\Mail\EmailConfirmation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UsersEmailConfirmationController extends Controller
{
    public function request(User $user)
    {
        if ($user->isConfirmed()) {
            return redirect()->home();
        }

        return view('confirm_email.request-email-confirmation', compact('user'));
    }

    public function sendEmail(User $user, Request $request)
    {
        $token = $user->getEmailConfirmationToken();

        Mail::to($user->email)->send(new EmailConfirmation($user, $token));

        return view('confirm_email.sending-email');
    }

    public function confirm(User $user, $token)
    {
        $userToConfirm = User::where('email', $user->email)->where('confirmation-token', $token)->first();

        if (! $userToConfirm)
        {
            return redirect()->route('request-confirm-email', $user);
        }

        $userToConfirm->confirm();

        return redirect()->home();
    }
}
