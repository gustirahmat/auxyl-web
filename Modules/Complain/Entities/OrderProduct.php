<?php

namespace Modules\Complain\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Category\Entities\Category;
use Modules\Complain\Entities\Order;
use Modules\Product\Entities\ProductPhoto;
use Modules\Product\Entities\Product;

class OrderProduct extends Model
{
    /**
     * The database primary key value.
     *
     * @var string
     */
    protected $primaryKey = 'order_product_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'promo_id',
        'product_id',
        'category_id',
        'order_product_qty',
        'order_product_price',
        'order_product_subtotal',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'order_product_qty' => 'integer',
        'order_product_price' => 'decimal:0',
        'order_product_subtotal' => 'decimal:0'
    ];

    public function relatedOrder(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }

    public function relatedProduct(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }

    public function relatedPhotos(): HasMany
    {
        return $this->hasMany(ProductPhoto::class, 'product_id', 'product_id');
    }

    public function relatedCategory(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'order_id', 'order_id');
    }
}
