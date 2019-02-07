<?php

namespace App;

class TestCategory extends BaseModel
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
     * Get the comments for the blog post.
     */
    public function itens()
    {
        return $this->hasMany("App\Test", "category_id");
    }

    /**
     * Get the comments for the blog post.
     */
    public function children()
    {
        return $this->hasMany("App\TestCategory", "father_id");
    }

    /**
     * Get the comments for the blog post.
     */
    public function father()
    {
        return $this->hasOne("App\TestCategory", "id", "father_id");
    }

    public function scopeWithoutFather($query)
    {
        return $query->where("father_id", null);
    }
}
