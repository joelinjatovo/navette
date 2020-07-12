<?php

namespace App\Services;

use App\Models\Car;
use App\Models\Club;
use App\Models\User;
use App\Models\Image;
use Illuminate\Http\Request;

class ImageUploader
{
    private $request;
    
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    
    public function upload($field, $model)
    {
        $request = $this->request;
        if ($request->hasFile($field)) {
            $file = $request->file($field);
            if ($file->isValid()) {
                $name = md5(time()).'.'.$file->extension();
                switch(true){
                    case $model instanceof Car:
                        $path = $file->storeAs('uploads',  'cars/' . $model->getKey() . '/' . $name);
                    break;
                    case $model instanceof Club:
                        $path = $file->storeAs('uploads',  'clubs/' . $model->getKey() . '/' . $name);
                    break;
                    case $model instanceof User:
                        $path = $file->storeAs('uploads',  'users/' . $model->getKey() . '/' . $name);
                    break;
                    default:
                        $path = $file->storeAs('uploads',  $model->getKey() . '/' . $name);
                    break;
                }
                
                $image = new Image([
                    'url' => $path, 
                    'mime' => $file->getClientMimeType(), 
                    'name' => $file->getClientOriginalName()
                ]);
                
                $model->image()->save($image);
            }
        }
    }
    
    public function uploadLicense($field, $type)
    {
        $request = $this->request;
        if ($request->hasFile($field)) {
            $file = $request->file($field);
            if ($file->isValid()) {
                $name = md5(time()).'.'.$file->extension();
                $path = $file->storeAs('uploads',  'users/license-' . $type . '/' . $name);
                $image = new Image([
                    'url' => $path, 
                    'mime' => $file->getClientMimeType(), 
                    'type' => 'license-' . $type, 
                    'name' => $file->getClientOriginalName()
                ]);
                $image->save();
                return $image;
            }
        }
    }
    
    public function uploadVTC($field, $type)
    {
        $request = $this->request;
        if ($request->hasFile($field)) {
            $file = $request->file($field);
            if ($file->isValid()) {
                $name = md5(time()).'.'.$file->extension();
                $path = $file->storeAs('uploads',  'users/vtc-' . $type . '/' . $name);
                $image = new Image([
                    'url' => $path, 
                    'mime' => $file->getClientMimeType(), 
                    'type' => 'vtc-' . $type, 
                    'name' => $file->getClientOriginalName()
                ]);
                $image->save();
                return $image;
            }
        }
    }
}
