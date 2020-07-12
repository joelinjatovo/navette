<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Image as ImageResource;
use App\Services\ImageUploader;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    
    private $uploader;
    
    public function __construct(ImageUploader $uploader)
    {
        $this->uploader = $uploader;
    }

    /**
     * Upload license photo
     *
     * @return Response
     */
    public function license(Request $request, $type)
    {
        $request->validate([
            'image' => 'file|mimes:jpeg,png,jpg'
        ]);
        
        $image = $this->uploader->uploadLicense('image', $type);
        
        return (new ImageResource($image));
    }

    /**
     * Upload license photo
     *
     * @return Response
     */
    public function vtc(Request $request, $type)
    {
        $request->validate([
            'image' => 'file|mimes:jpeg,png,jpg'
        ]);
        
        $image = $this->uploader->uploadVTC('image', $type);
        
        return (new ImageResource($image));
    }
}
