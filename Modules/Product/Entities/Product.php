<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    /**
     * The database primary key value.
     *
     * @var string
     */
    protected $primaryKey = 'product_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'supplier_id',
        'category_id',
        'product_sku',
        'product_name',
        'product_description',
        'product_guarantee',
        'product_stock',
        'price_supplier',
        'price_selling',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'product_stock' => 'integer',
        'price_selling' => 'decimal:0',
        'price_supplier' => 'decimal:0',
    ];

    public function relatedPhotos(): HasMany
    {
        return $this->hasMany(ProductPhoto::class, 'product_id', 'product_id');
    }

    public function relatedStocks(): HasMany
    {
        return $this->hasMany(ProductStock::class, 'product_id', 'product_id')->latest();
    }
}
