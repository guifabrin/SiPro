<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model {
	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'questions';

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
		'description', 'categorie_id', 'user_id', 'soft_delete', 'lines', 'image_id', 'type',
	];

    public function scopeWithoutCategorie($query)
    {
        return $query->where('categorie_id', null);
    }
}
