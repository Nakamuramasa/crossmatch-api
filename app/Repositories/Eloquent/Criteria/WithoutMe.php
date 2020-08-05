<?php

namespace App\Repositories\Eloquent\Criteria;

use App\Repositories\Criteria\ICriterion;

class WithoutMe implements ICriterion
{
    public function apply($model)
    {
        return $model->where('id', '<>', auth()->id());
    }
}
