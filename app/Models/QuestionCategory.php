<?php

namespace App\Models;

use Illuminate\Database\Query\Builder;

class QuestionCategory extends ApplicationModel
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
    protected $table = "question_categories";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "description", "father_id", "user_id", "soft_delete",
    ];

    /**
     * Return HasMany if category has questions
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function itens()
    {
        return $this->hasMany("App\Question", "category_id");
    }

    /**
     * Return HasMany if category has categories
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany("App\QuestionCategory", "father_id");
    }

    /**
     * Return hasOne if category has a father category
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function father()
    {
        return $this->hasOne("App\QuestionCategory", "id", "father_id");
    }

    /**
     * Scope function to get categories without father category
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeWithoutFather(Builder $query)
    {
        return $query->where("father_id", null);
    }
}
