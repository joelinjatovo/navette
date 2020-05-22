<?php

namespace App\View\Components;

use App\Models\User as UserModel;
use Illuminate\View\Component;

class User extends Component
{
    /**
     * The status value.
     *
     * @var UserModel $model
     */
    public $model;
	
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(?UserModel $model = null)
    {
        $this->model = $model;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.user');
    }
}
