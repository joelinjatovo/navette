<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class OrderCollection extends ResourceCollection
{
    protected $pagination;

    public function __construct($resource)
    {
        $this->pagination = [
            'total' => $resource->total(),
            'count' => $resource->count(),
            'per_page' => $resource->perPage(),
            'current_page' => $resource->currentPage(),
            'last_page' => $resource->lastPage()
        ];

        $resource = $resource->getCollection();

        parent::__construct($resource);
    }
    
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'code' => 200,
            'status' => "success",
            'message' => null,
            'errors' => [],
            'data' => $this->collection,
            'pagination' => $this->pagination,
        ];
    }
}
