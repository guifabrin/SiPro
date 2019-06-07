<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;

class Question extends ApplicationModel
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
    protected $table = "questions";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "category_id",
        "description",
        "image_id",
        "lines",
        "soft_delete",
        "type",
        "user_id",
    ];

    /**
     * Scope function to get questions in category.
     *
     * @param Builder $query
     * @param QuestionCategory $questionCategory
     * @return Builder
     */
    public function scopeFromCategory(Builder $query, QuestionCategory $questionCategory)
    {
        return $query->where("category_id", $questionCategory->id);
    }

    /**
     * Scope function to get questions without category
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeWithoutCategory(Builder $query)
    {
        return $query->where("category_id", null);
    }

    /**
     * Function to return image in base64 if valid image.
     *
     * @return string|null
     */
    public function thumbImage()
    {
        try {
            return $this->image()->first()->imageb64_thumb;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Return HasOne if image isset.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function image()
    {
        return $this->hasOne("App\Image", "id", "image_id");
    }


    /**
     * Return HasMany if questions has options
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function options()
    {
        return $this->hasMany("App\Option");
    }


    /**
     * Return HasOne if category isset.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function category()
    {
        return $this->hasOne("App\QuestionCategory", "id", "category_id");
    }

    /**
     * Function to verify if question in test
     * @param Test $test
     * @return bool
     */
    public function inTest(Test $test)
    {
        return QuestionsInTests::where("question_id", $this->id)->where("test_id", $test->id)->first() != null;
    }

}
