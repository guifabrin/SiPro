<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Header extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'headers';
	
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
	
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'json', 'soft_delete'
    ];
}
