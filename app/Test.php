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
        'json', 'categorie_id', 'user_id','soft_delete'
    ];
}
