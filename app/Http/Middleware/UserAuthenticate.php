<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use Hash;
class UserAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        error_reporting(0);
        $resposeFail = [
            'msg_code' => 'ERROR',
            'msg' => "Token không hợp lệ",
            'data' => [],
            "success" => false,
            "code" => 401
        ];
        $token  = $request->header('token') ?? null;
        if ($token) {
            $user = User::where('api_token',  $token)->first();
            if ($user) {
                return $next($request);
            } else
                return response()->json($resposeFail, 401);
        } else {
            return response()->json($resposeFail, 401);
        }
    }
}
