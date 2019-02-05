<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{

    public function scopeNotRemoved($query)
    {
        return $query->where('soft_delete', false);
    }
}
