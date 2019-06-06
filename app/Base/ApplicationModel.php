<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ApplicationModel extends Model
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
