<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class BaseModel extends Model
{

    /**
     * Scope function to return a builder where there isn't soft-deleted itens
     * @param Builder $query
     * @return Builder
     */
    public function scopeNotRemoved(Builder $query)
    {
        return $query->where("soft_delete", false);
    }
}
