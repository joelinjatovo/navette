<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Http\Resources\SettingCollection as SettingCollectionResource;

use Illuminate\Http\Request;

class SettingsController extends Controller
{

    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		return new SettingCollectionResource(Setting::all());
    }
}
