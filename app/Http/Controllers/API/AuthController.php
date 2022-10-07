<?php

namespace App\Http\Controllers\API;
use App\Http\Requests\User\InsertLoginUserRequest;
use App\Models\User;
use Hash;
use Str;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kreait\Firebase\Factory;

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
    public function login(Request $request)
    {
        $user = User::where('phone_number', $request->phone_number)->first();

        if (!$user) {
            return $this->errorResponse('Số điện thoại hoặc mật khẩu không hợp lệ', 401);
        }

        if (!Hash::check($request->password, $user->password)) {
            return $this->errorResponse('Số điện thoại hoặc mật khẩu không hợp lệ', 401);
        } else {
            $token_user = User::where('phone_number', $request->phone_number)->first()->api_token;
            if ($token_user)
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


    public function checkPhone(Request $request)
    {
        try {
            $users = User::where("phone_number", $request->phone_number)->first();
            if ($users) {
                return $this->successResponse([], "Số điện thoại hợp lệ", 201);
            } else {
                return $this->errorResponse(
                    "Số điện thoại không tồn tại",
                    401
                );
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function resetPassword(Request $request)
    {


        $keyPath = storage_path("app/public/firebase/tcell-otp-firebase-adminsdk-dco6s-142601003c.json");
        $auth = (new Factory)->withServiceAccount($keyPath)->createAuth();

        try {

            $user = User::where("phone_number", $request->phone_number)->first();
            if ($user) {
                $ptn = "/^0/";  // Regex
                $str = $request->phone_number; //Your input, perhaps $_POST['textbox'] or whatever
                $rpltxt = "+84";  // Replacement string
                $phoneOtp = preg_replace($ptn, $rpltxt, $str);
                $userPhoneNumber = $phoneOtp;
                try {
                    $info = $auth->getUserByPhoneNumber($userPhoneNumber);
                } catch (\Throwable $th) {
                    return $this->errorResponse('Số điện thoại chưa được xác thực trên hệ thống!', 401);
                }
                User::where('id', $user->id)->update([
                    'password' => Hash::make($request['password']),
                    'api_token' => Str::random(60)
                ]);
                return $this->successResponse([], "Lấy lại mật khẩu thành công", 201);
            } else {
                return $this->errorResponse(
                    "Người dùng không tồn tại",
                    401
                );
            }
        } catch (Exception $e) {
            return $this->errorResponse('Số điện thoại chưa được xác thực trên hệ thống!', 401);
        }
    }

    public function updateInfo(Request $request)
    {
        try {
            $user = User::userInfo();
            if (!$user)
                return $this->errorResponse(
                    "Người dùng không tồn tại",
                    401
                );
            $user->name = $request->name;
            $user->phone_number =  $request->phone_number;
            $user->email =  $request->email;
            $user->sex =  $request->sex;
            $user->address =  $request->address;
            $user->avatar =  $request->avatar;

            if ($request->has("password") && !empty($request['password'])) {
                $user->password =  $request->password;
            }
            $user->save();
            return $this->successResponse(
                $user,
                null,
                201
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function changePassWord(Request $request)
    {
        try {
            $user = User::userInfo();
            if (!$user)
                return $this->errorResponse(
                    "Người dùng không tồn tại",
                    401
                );
            if (!Hash::check($request->password, $user->password))
                return $this->errorResponse(
                    "Mật khẩu không hợp lệ",
                    401
                );
            $user->password = Hash::make($request->new_password);
            $user->save();
            return $this->successResponse(
                $user,
                null,
                201
            );
        } catch (\Throwable $th) {
            throw $th;
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
