<?php

namespace App\Repositories;

class BaseRepository
{
    
    public $model;
    
    public function __construct($model){
        $this->model = $model;
    }

    /**
     * Get's all items.
     *
     * @return mixed
     */
    public function all(){
        return $this->model->all();
    }
    
    /**
     * Get's a item by it's ID
     *
     * @param int $id
     */
    public function get($id){
        return $this->model->findOrFail($id);
    }
    
    /**
     * Store item
     *
     * @param $model
     * @return $model
     */
    public function store($model){
        //$model->created_at = Carbon::now();
        return $model->save();
    }

    /**
     * Updates an item.
     *
     * @param $model
     */
    public function update($model)
    {
        //$model->updated_at = Carbon::now();
        return $model->save();
    }

    /**
     * Deletes item.
     *
     * @param $model
     */
    public function delete($model)
    {
        return $model->delete();
    }
    
}
