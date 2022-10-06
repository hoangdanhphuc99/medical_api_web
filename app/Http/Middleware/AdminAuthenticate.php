<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Admin;
use Hash;
class AdminAuthenticate
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
        $token  = $request->header('admin-token') ?? null;

        $resposeFail = [
            'msg_code' => 'ERROR',
            'msg' => "Token không hợp lệ",
            'data' => [],
            "success" => false,
            "code" => 401,

        ];

        if ($token) {
            $user = Admin::where('api_token',  $token)->first();
            if ($user) {
                return $next($request);
            } else
                return response()->json($user, 401);
        } else {
            return response()->json($resposeFail, 401);
        }
    }
}
