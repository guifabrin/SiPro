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
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'school', 'title', 'subtitle', 'observation', 'teacher', 'date', 'value', 'imageb64', 'soft_delete'
    ];
}
