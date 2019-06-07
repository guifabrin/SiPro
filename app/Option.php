<?php

namespace App;

class Option extends ApplicationModel {
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

    /**
     * Return HasOne if image isset.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function image() {
        return $this->hasOne("App\Image", "id", "image_id");
    }

    /**
     * @return string|null
     */
    public function thumbImage() {
        try {
            return $this->image()->first()->imageb64_thumb;
        } catch (\Exception $e) {
            return null;
        }

    }
}
