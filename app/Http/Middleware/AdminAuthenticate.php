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

        $resposeFail = [
            'msg_code' => 'ERROR',
            'msg' => "Invalid Token",
            'data' => [],
            "success" => false,
            "code" => 401
        ];
        $token  = $request->header('admin_token') ?? null;

        if ($token) {
            $user = Admin::where('api_token',  $token)->first();
            if ($user) {
                return $next($request);
            } else
                return response()->json($user, 401);
        } else {
            return response()->json($resposeFail . "v1", 401);
        }
    }
}
