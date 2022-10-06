<?php
namespace App\Repositories\UserTest;

use App\Repositories\RepositoryInterface;

interface UserTestRepositoryInterface extends RepositoryInterface
{
    //ví dụ: lấy 5 sản phầm đầu tiên
    public function getUserTest();
}
