<?php
namespace App\Repositories\UserTest;
use App\Models\User;
use App\Repositories\BaseRepository;

class UserTestRepository extends BaseRepository implements UserTestRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\UserTest::class;
    }

    public function getUserTest()
    {
        return $this->model->filter(request()->all())->get();
    }
    public function getUserTestDetail(){
        return $this->model->where('user_id', User::userInfo()->id)->get();

    }
}
