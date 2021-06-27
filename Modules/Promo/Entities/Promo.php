<?php

namespace Modules\Promo\Entities;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Promo extends Model
{
    use SoftDeletes;

    /**
     * The database primary key value.
     *
     * @var string
     */
    protected $primaryKey = 'promo_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'promo_name',
        'promo_banner',
        'promo_desc',
        'promo_terms',
        'promo_started_at',
        'promo_finished_at',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'promo_started_at',
        'promo_finished_at',
    ];

    /**
     * Prepare a date for array / JSON serialization.
     *
     * @param  DateTimeInterface  $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format('Y.m.d H:i');
    }

    public function relatedProducts(): BelongsToMany
    {
        return $this->belongsToMany(
            Product::class,
            'promo_product',
            'promo_id',
            'product_id',
            'promo_id',
            'product_id'
        )
            ->using(PromoProduct::class)
            ->withPivot([
                'promo_product_stock',
                'promo_price_supplier',
                'promo_price_selling',
                'created_at',
                'updated_at',
            ]);
    }
}
