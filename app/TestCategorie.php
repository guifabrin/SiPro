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
        'description', 'father_id', 'user_id'
    ];
}