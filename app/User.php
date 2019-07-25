<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Check if user has confirmed email
     *
     * @return boolean
     */
    public function isConfirmed()
    {
        return !! $this->is_confirmed;
    }

    /**
     * Get email confirmation token
     *
     * @return string
     */
    public function getEmailConfirmationToken()
    {
        $this->update([
            'confirmation-token' => $token = Str::random(),
        ]);

        return $token;
    }

    /**
     * Confirm user's email address
     *
     * @return User
     */
    public function confirm()
    {
        $this->update([
            'is_confirmed' => true,
            'confirmation-token' => null,
        ]);
        return $this;
    }
}
