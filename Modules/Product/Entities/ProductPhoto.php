<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;

class ProductPhoto extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id',
        'image_alt_text',
        'image_url',
    ];
}
