<?php

namespace App\Http\Controllers\API\Admin;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ListCategoryController extends Controller
{
    protected $CategoryRepo;

    public function __construct(CategoryRepositoryInterface $CategoryRepo)
    {
        $this->CategoryRepo = $CategoryRepo;

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $CategoryRepo = $this->CategoryRepo->getCategory();
             return $this->successResponse(
            $CategoryRepo,
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

            $result = $this->CategoryRepo->create([

                'title' => $request->title,
                'content' => $request->content,
                'image_url' => $request->image_url
            ]);
            return $this->successResponse(
                $result,
                null,
                201
            );
        } catch (\throwable $err) {
            return $$err;
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
        $CategoryRepo = $this->CategoryRepo->find($id);
        if (!$CategoryRepo)
            return $this->errorResponse(
                "Danh mục không tồn tại",
                403
            );
        return $this->successResponse(
            $CategoryRepo,
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
            $CategoryRepo = $this->CategoryRepo->find($id);
            if (!$CategoryRepo)
                return $this->errorResponse(
                    "Danh mục không tồn tại",
                    403
                );
            $result = $this->CategoryRepo->update($id, [
                'title' => $request->title,
                'content' => $request->content,
                'image_url' => $request->image_url

            ]);
            return $this->successResponse(
                $result,
                201
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
            $CategoryRepo = $this->CategoryRepo->find($id);
            if (!$CategoryRepo)
                return $this->errorResponse(
                    "Danh mục không tồn tại",
                    403
                );
            $this->CategoryRepo->delete($id);
            return $this->successResponse();
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
