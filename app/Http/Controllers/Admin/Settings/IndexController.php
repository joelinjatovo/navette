<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Models\Setting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'app_name' => 'required|string|max:255',
			'app_slogan' => 'required|string|max:255',
		];
	}
    
    /**
     * @return Response
     */
    public function edit(Request $request)
    {
        return view('admin.settings.general');
    }
    
    /**
     * @return Response
     */
    public function update(Request $request)
    {
		$request->validate($this->rules());
		
		foreach($this->rules() as $key => $rule){
			Setting::updateOrCreate(
				['key' => $key],
				['value' => $request->input($key)]
			);
			
			\Config::set('settings.'.$key, $request->input($key));
		}
		
        return view('admin.settings.general');
    }
}
