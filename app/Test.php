<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tests';
	
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'categorie_id', 'user_id', 'description', 'soft_delete'
    ];
}
