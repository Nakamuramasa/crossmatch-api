<?php

namespace App\Repositories\Eloquent;

use App\Exceptions\ModelNotDefined;
use App\Repositories\Contracts\IBase;

abstract class BaseRepository implements IBase
{
    protected $model;

    public function __construct()
    {
        $this->model = $this->getModelClass();
    }

    protected function getModelClass()
    {
        if(!method_exists($this, 'model')){
            throw new ModelNotDefined();
        }
        return app()->make($this->model());
    }

    public function all()
    {
        return $this->model->all();
    }
}
