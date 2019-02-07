<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "options";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "correct",
        "description",
        "image_id",
        "question_id",
    ];
}
