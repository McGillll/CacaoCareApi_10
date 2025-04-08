<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Traits\UsesUuId;


class User extends Model
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, HasApiTokens, UsesUuId, Notifiable;

    protected $fillable = [
        'id',
        'uuid',
        'email',
        'password',
        'profile',
        'region',
        'province',
        'city',
        'barangay',
        'role'
    ];
}
