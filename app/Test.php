<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;

class Test extends ApplicationModel {
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "tests";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "category_id", "user_id", "description", "soft_delete"
    ];

    /**
     * Return hasOne if test has a category
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function category() {
        return $this->hasOne("App\TestCategory", "id", "category_id");
    }

    /**
     * Scope function to get tests in category.
     *
     * @param Builder $query
     * @param TestCategory $testCategory
     * @return Builder
     */
    public function scopeFromCategory(Builder $query, TestCategory $testCategory) {
        return $query->where("category_id", $testCategory->id);
    }

    /**
     * Scope function to get tests without category
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeWithoutCategory(Builder $query) {
        return $query->where("category_id", null);
    }
}
