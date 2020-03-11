<?php 

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class UserRepository extends Repository
{

    public function __construct(Model $model = null)
    {
        $this->model = new \App\Models\User();
    }
    
    /**
     * Verify code
     *
     * @params string $code
     * @return boolean
     */
    public function verifyCode($code)
    {
        return true;
    }
}