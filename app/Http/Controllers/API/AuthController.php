<?php

namespace App\Http\Controllers\API;
use App\models\User;
use Hash;
use Str;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    public function login(Request $request){
        $user = User::where('phone_number', $request->phone_number)->first();

        if (!$user) {
            return $this->errorResponse('Tên tài khoản không tồn tại', 401);
        }

        if (!Hash::check($request->password, $user->password)) {
            return $this->errorResponse('Số điện thoại hoặc mật khẩu không hợp lệ', 401);
        }    else {
            $token_user = User::where('phone_number', $request->phone_number)->first()->api_token;
            if($token_user)
            return $this->successResponse([
                "token" =>  $token_user,
                "user" => $user


            ], "Đăng nhập thành công", 201);
            $token = Str::random(80);
            $user->update([
                "api_token" => $token
            ]);

            return $this->successResponse([
                "token" =>  $token,
                "user" => $user


            ], "Đăng nhập thành công", 201);
        }
    }
    public function register(Request $request)
    {
        try {
            return $this->successResponse(User::create([
                'name' => $request->name,
                'phone_number' => $request->phone_number,
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
                // 'api_token' => Str::random(60),
            ]), 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function info()
    {
        $user = User::userInfo();
        if ($user)
            return $this->successResponse($user, 200);
        else
            return $this->errorResponse("Token không tồn tại", 401);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
