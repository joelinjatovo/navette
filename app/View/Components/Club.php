<?php

namespace App\View\Components;

use App\Models\Club as ClubModel;
use Illuminate\View\Component;

class Club extends Component
{
    /**
     * The status value.
     *
     * @var ClubModel $model
     */
    public $model;
	
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(?ClubModel $model = null)
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
        return view('components.club');
    }
}
