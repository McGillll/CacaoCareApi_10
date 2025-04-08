<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Cacao extends Model
{
    /** @use HasFactory<\Database\Factories\CacaoFactory> */
    use HasFactory, HasApiTokens, Notifiable;

    protected $fillable = [
        'id',
        'label',
        'confidence',
        'photo',
        'uploaderId',
        'caption'
    ];
}
