<?php

namespace App\Models;

use App\Traits\Filterable;
use Request;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable , Filterable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'users';
    protected $fillable = [
        'name',
        'email',
        'password',
        'api_token',
        'phone_number',
        'address',
        "sex",
        "birthday",
        "job",
        "height",
        "pathology",
        "weight",
        "service_point",
        "other_info",
        "avatar"
    ];

    protected $filterable = [
        'name',
        'email',
        'phone_number',


    ];


    protected $searchable = [
        "id",
        'name',
        'phone_number',
        'email',

    ];

    static function userInfo()
    {
        $token  = Request::header('token') ?? null;
        if ($token) {
            $user = User::where('api_token',  $token)->first();
            if ($user) {
                return $user;
            } else {
                return null;
            }
        }
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'api_token'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
