<?php

namespace App\Helpers;

class BaseQuery
{

    public function __construct()
    {
    }

    public function getById($model, $id)
    {
        return $model::find($id);
    }

    public function getAll($model)
    {
        return $model::all();
    }

    public function deleteById($model, $id)
    { 
        return $model::destroy($id);
    }
     
    public function create($model, $data)
    {
        return $model::create($data);
    }

    public function update($model, $id, $data)
    {
        return $model::find($id)->update($data);
    }
   
}
