<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TestCategorie extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'test_categories';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'description', 'father_id', 'user_id', 'soft_delete'
    ];
}