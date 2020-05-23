<?php

namespace App\View\Components;

use App\Models\Car as CarModel;
use Illuminate\View\Component;

class Car extends Component
{
    /**
     * The status value.
     *
     * @var CarModel $model
     */
    public $model;
	
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(?CarModel $model)
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
        return view('components.car');
    }
}
