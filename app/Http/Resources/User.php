<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'code' => 200,
            'status' => "success",
            'data' => [
                'id' => $this->id,
                'name' => $this->name,
                'phone' => $this->phone,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,

                'secret' => $this->when(\Auth::check() && \Auth::user()->isAdmin(), 'secret-value'),
                $this->mergeWhen(\Auth::user()->isAdmin(), [
                    'first-secret' => 'value',
                    'second-secret' => 'value',
                ]),
                //'posts' => PostResource::collection($this->posts),
            ]
        ];
    }
}
