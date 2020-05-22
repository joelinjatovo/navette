<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Status extends Component
{

    /**
     * The status value.
     *
     * @var string
     */
    public $status;
	
    /**
     * The status theme.
     *
     * @var string
     */
    public $theme;
	
    /**
     * The status type.
     *
     * @var string
     */
    public $type;

    /**
     * The status text.
     *
     * @var string
     */
    public $text;

    /**
     * Create the component instance.
     *
     * @param  string  $status
     * @return void
     */
    public function __construct($status, $theme = 'light')
    {
        $this->status = $status;
        $this->theme = $theme;
		switch($this->status){
			case 'active': 
				$this->type = 'danger';
				$this->text = trans('messages.status.active');
			break;
			case 'arrived': 
				$this->type = 'success';
				$this->text = trans('messages.status.arrived');
			break;
			case 'cancelable': 
				$this->type = 'danger';
				$this->text = trans('messages.status.cancelable');
			break;
			case 'canceled': 
				$this->type = 'danger';
				$this->text = trans('messages.status.canceled');
			break;
			case 'completable': 
				$this->type = 'default';
				$this->text = trans('messages.status.completable');
			break;
			case 'completed': 
				$this->type = 'default';
				$this->text = trans('messages.status.completed');
			break;
			case 'next': 
				$this->type = 'success';
				$this->text = trans('messages.status.next');
			break;
			case 'ok': 
				$this->type = 'success';
				$this->text = trans('messages.status.ok');
			break;
			case 'on-hold': 
				$this->type = 'black';
				$this->text = trans('messages.status.on-hold');
			break;
			case 'ping': 
				$this->type = 'primary';
				$this->text = trans('messages.status.ping');
			break;
			case 'processing': 
				$this->type = 'danger';
				$this->text = trans('messages.status.processing');
			break;
			case 'online': 
				$this->type = 'success';
				$this->text = trans('messages.status.online');
			break;
			default:
				$this->type = 'info';
				$this->text = trans('messages.status.unknown');
			break;
		}
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.status');
    }
}
