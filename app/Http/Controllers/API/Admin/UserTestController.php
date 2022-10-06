<?php

namespace App\Http\Controllers\API\Admin;
use App\Repositories\UserTest\UserTestRepositoryInterface;
use App\Http\Requests\User\UserTest\UpdateUserTestRequest;
use App\Http\Requests\User\UserTest\InsertUserTestRequest;
use App\Models\UserTest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserTestController extends Controller
{
    protected $userTestRepo;

    public function __construct( UserTestRepositoryInterface $userTestRepo)
    {

        $this->userTestRepo = $userTestRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userTestRepo = $this->userTestRepo->getUserTest();
        return $this->successResponse(
            $userTestRepo,
            null,
            200
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InsertUserTestRequest $request)
    {
        try {
            $result = $this->userTestRepo->create([
                'user_id' => $request->user_id,
                'result_0' => $request->result_0,
                'result_1' => $request->result_1,
                'result_2' => $request->result_2,


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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $userTestRepo = $this->userTestRepo->find($id);
        if (!$userTestRepo)
            return $this->errorResponse(
                "Người dùng không tồn tại",
                403
            );
        return $this->successResponse(
            $userTestRepo,
            201
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserTestRequest $request, $id)
    {
        try {
            $userTestRepo = $this->userTestRepo->find($id);
            if (!$userTestRepo)
                return $this->errorResponse(
                    "Người dùng không tồn tại",
                    403
                );
            $result = $this->userTestRepo->update($id, [
                'user_id' => $request->user_id,
                'result_0' => $request->result_0,
                'result_1' => $request->result_1,
                'result_2' => $request->result_2,
            ]);
            return $this->successResponse(
                $result
            );
        } catch (\Throwable $th) {
            throw $th;
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
        try {
            $userTestRepo = $this->userTestRepo->find($id);
            if (!$userTestRepo)
                return $this->errorResponse(
                    "Người dùng không tồn tại",
                    403
                );
            $this->userTestRepo->delete($id);
            return $this->successResponse();
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
