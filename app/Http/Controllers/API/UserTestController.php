<?php

namespace App\Http\Controllers\API;
use App\Repositories\UserTest\UserTestRepositoryInterface;
use App\Models\UserTest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserTestController extends Controller
{
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
    public function userDetail(){
        $userTestRepo = $this->userTestRepo->getUserTestDetail();
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
