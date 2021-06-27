<?php

namespace Modules\Promo\Entities;

use Illuminate\Database\Eloquent\Relations\Pivot;

class PromoProduct extends Pivot
{
    /**
     * The database primary key value.
     *
     * @var string
     */
    protected $primaryKey = 'promo_product_id';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;
}
