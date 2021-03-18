<?php

namespace App\Models;

use Illuminate\Database\Query\Builder;

class TestCategory extends ApplicationModel
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
    protected $table = "test_categories";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "description", "father_id", "user_id", "soft_delete",
    ];

    /**
     * Return HasMany if categories has tests
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function itens()
    {
        return $this->hasMany("App\Test", "category_id");
    }

    /**
     * Return hasMany if category has categories
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function children()
    {
        return $this->hasMany("App\TestCategory", "father_id");
    }

    /**
     * Return hasOne if category has a father category
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function father()
    {
        return $this->hasOne("App\TestCategory", "id", "father_id");
    }

    /**
     * Scope function to get tests without father category
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeWithoutFather(Builder $query)
    {
        return $query->where("father_id", null);
    }
}
