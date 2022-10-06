<?php
namespace App\Repositories\UserTest;

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
        return $this->model->paginate(20);
    }
}
