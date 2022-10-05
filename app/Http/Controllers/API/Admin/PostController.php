<?php

namespace App\Http\Controllers\API\Admin;
use App\Repositories\Post\PostRepositoryInterface;
use App\Models\Post;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PostController extends Controller
{
    protected $PostRepo;

    public function __construct(PostRepositoryInterface $PostRepo)
    {
        $this->PostRepo = $PostRepo;

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $PostRepo = $this->PostRepo->getPost();
             return $this->successResponse(
            $PostRepo,
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
        try {
            $result = $this->PostRepo->create([
                'image_URL' => $request->image_URL,
                'name' => $request->name,
                'status' => $request->status,
                'description' => $request->description,
                'detail' => $request->detail,
                'category_id' => $request->category_id

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
        $PostRepo = $this->PostRepo->find($id);
        if (!$PostRepo)
            return $this->errorResponse(
                "Bài viết không tồn tại",
                403
            );
        return $this->successResponse(
            $PostRepo,
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
        try {
            $PostRepo = $this->PostRepo->find($id);
            if (!$PostRepo)
                return $this->errorResponse(
                    "Bài viết không tồn tại",
                    403
                );
            $result = $this->PostRepo->update($id, [
                'image_URL' => $request->image_URL,
                'name' => $request->name,
                'status' => $request->status,
                'description' => $request->description,
                'detail' => $request->detail,
                'category_id' => $request->category_id
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
            $PostRepo = $this->PostRepo->find($id);
            if (!$PostRepo)
                return $this->errorResponse(
                    "Bài viết không tồn tại",
                    403
                );
            $this->PostRepo->delete($id);
            return $this->successResponse();
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
