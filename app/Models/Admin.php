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
    protected $hidden = [
        'password',
        'remember_token',
        'api_token'
    ];
    static function adminInfo()
    {
        $token  = Request::header('admin_token') ?? null;
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
