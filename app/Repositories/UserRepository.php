<?php 

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class UserRepository extends Repository
{

    public function __construct(Model $model = null)
    {
        $this->model = new \App\Models\User();
    }
}