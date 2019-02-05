<?php

namespace App;

class Test extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tests';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'categorie_id', 'user_id', 'description', 'soft_delete'
    ];

    public function scopeWithoutCategorie($query)
    {
        return $query->where('categorie_id', null);
    }


    /**
     * Get the comments for the blog post.
     */
    public function category()
    {
        return $this->hasOne('App\TestCategorie', 'id', 'categorie_id');
    }
}
