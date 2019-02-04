<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TestCategorie extends Model {
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
		'description', 'father_id', 'user_id', 'soft_delete',
	];

    /**
     * Get the comments for the blog post.
     */
    public function tests()
    {
        return $this->hasMany('App\Test', 'categorie_id');
    }

    /**
     * Get the comments for the blog post.
     */
    public function categories()
    {
        return $this->hasMany('App\TestCategorie', 'father_id')->get();
    }

    /**
     * Get the comments for the blog post.
     */
    public function father()
    {
        return $this->hasOne('App\TestCategorie', 'id', 'father_id')->first();
    }
}
