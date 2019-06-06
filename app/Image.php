<?php

namespace App;

class Image extends ApplicationModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "images";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "imageb64",
        "imageb64_thumb",
    ];
}
