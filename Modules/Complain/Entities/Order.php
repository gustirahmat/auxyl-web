<?php

namespace Modules\Complain\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    /**
     * The database primary key value.
     *
     * @var string
     */
    protected $primaryKey = 'order_id';

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'order_latest_status' => 'integer',
        'order_no' => 'string',
        'order_date' => 'date',
        'order_total' => 'decimal:0',
    ];

    public function relatedComplain(): HasOne
    {
        return $this->hasOne(OrderComplain::class, 'order_id', 'order_id');
    }
}
