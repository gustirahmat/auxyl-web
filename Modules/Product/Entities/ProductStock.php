<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;

class ProductStock extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id',
        'stock_qty',
        'stock_status',
        'stock_notes',
    ];
}
