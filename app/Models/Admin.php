<?php

namespace App\Models;
use Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'password',
        'api_token',
        'phone_number',
        'address',
        "sex"

    ];
    static function adminInfo()
    {
        $token  = Request::header('token') ?? null;
        if ($token) {
            $user = Admin::where('api_token',  $token)->first();
            if ($user) {
                return $user;
            } else {
                return null;
            }
        }
    }
}
