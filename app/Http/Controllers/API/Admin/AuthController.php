<?php

namespace App\Http\Controllers\API\Admin;
use App\Models\Admin;
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
    public function login(Request $request){
        $user = Admin::where('phone_number', $request->phone_number)->first();

        if (!$user) {
            return $this->errorResponse('Tên tài khoản không tồn tại', 401);
        }

        if (!Hash::check($request->password, $user->password)) {
            return $this->errorResponse('Tài khoản hoặc mật khẩu không đúng', 401);
        }    else {
            $token_admin = Admin::where('phone_number', $request->phone_number)->first()->api_token;
            if($token_admin)
            return $this->successResponse([
                "token" =>  $token_admin,
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
            return $this->successResponse(Admin::create([
                'name' => $request->name,
                'phone_number' => $request->phone_number,
                'user_name' => $request['user_name'],
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
        $user = Admin::adminInfo();
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

    public function checkPhone(Request $request)
    {
        try {
            $admin = Admin::where("phone_number" , $request->phone_number)->first();
            if ($admin) {
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

            $user = Admin::where("phone_number", $request->phone_number)->first();
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
                Admin::where('id', $user->id)->update([
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
