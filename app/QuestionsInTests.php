<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionsInTests extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'questions_in_tests';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'question_id', 'test_id'
    ];
}
