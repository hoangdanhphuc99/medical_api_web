<?php

namespace App\Http\Controllers\API\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\User\UserRepositoryInterface;
use App\Models\User;

use Hash;



class UserController extends Controller
{

    protected $userRepo;

    public function __construct( UserRepositoryInterface $userRepo)
    {

        $this->userRepo = $userRepo;
    }

    /**
     * Danh sách nhân viên
     *
     * @header Content-Type application/json
     * @header Accept application/json
     */

    public function index(Request $request)
    {
        $userRepo = $this->userRepo->getUser();
        return $this->successResponse(
            $userRepo,
            null,
            200
        );
    }






    public function create()
    {
    }

    /**
     * Thêm nhân viên
     *
     * @header Content-Type application/json
     * @header Accept application/json
     * @bodyParam name string required Tên người dùng. Example: Nguyễn A
     * @bodyParam user_name string required Tên người dùng. Example: abcc
     * @bodyParam email string required Email. Example: ada@dad.com
     * @bodyParam password string required Mật khẩu tài khoản. Example: 123456
     * @bodyParam phone_number string required Số điện thoại. Example: 0132456782
     * @bodyParam sex string  Giới tính. Example: 0 là không xác định, 1 là nam , 2 là nữ
     * @bodyParam position string   Chức vụ/ vị trí. Example: kế toán
     */
    public function store(Request $request)
    {
        try {
            $result = $this->userRepo->create($request->all());
            $result->update([
                "password" => Hash::make($request['password'])
            ]);
            return $this->successResponse(
                $result,
                null,
                201
            );
        } catch (\throwable $err) {
            return $err;
        }
    }

    /**
     * Hiển thị 1 nhân viên
     * @urlParam  id int required id nhân viên. Example: 1

     * @header Content-Type application/json
     * @header Accept application/json
     */
    public function show($id)
    {
        $userRepo = $this->userRepo->find($id);
        if (!$userRepo)
            return $this->errorResponse(
                "Người dùng không tồn tại",
                403
            );
        return $this->successResponse(
            $userRepo,
            201
        );
    }





    public function edit($id)
    {
        //
    }

    /**
     * Cập nhật nhân viên
     *
     * @header Content-Type application/json
     * @header Accept application/json
     * @urlParam  id int required id nhân viên. Example: 1

     * @bodyParam name string required Tên người dùng. Example: Nguyễn A
     * @bodyParam user_name string required Tên người dùng. Example: abcc
     * @bodyParam email string required Email. Example: ada@dad.com
     * @bodyParam password string required Mật khẩu tài khoản. Example: 123456
     * @bodyParam phone_number string required Số điện thoại. Example: 0132456782
     * @bodyParam sex string  Giới tính. Example: 0 là không xác định, 1 là nam , 2 là nữ
     * @bodyParam position string   Chức vụ/ vị trí. Example: kế toán
     */
    public function update(Request $request, $id)
    {
        try {
            $userRepo = $this->userRepo->find($id);
            if (!$userRepo)
                return $this->errorResponse(
                    "Người dùng không tồn tại",
                    403
                );
            $result = $this->userRepo->update($id,$request->all());

            if($request->has("password") and isset($request->password))
            {
                $result->update([
                    "password" => Hash::make($request['password'])
                ]);
            }
            return $this->successResponse(
                $result
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    /**
     * Xóa nhân viên
     * @urlParam  id int required id nhân viên. Example: 1

     * @header Content-Type application/json
     * @header Accept application/json
     */
    public function destroy($id)
    {
        try {
            $result = $this->userRepo->delete($id);
            return $this->successResponse($result, null, 201);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
