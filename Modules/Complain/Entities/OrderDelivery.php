<?php

namespace Modules\Complain\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Complain\Entities\Order;

class OrderDelivery extends Model
{
    /**
     * The database primary key value.
     *
     * @var string
     */
    protected $primaryKey = 'delivery_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'delivery_order_number',
        'delivery_contact_name',
        'delivery_contact_phone',
        'delivery_max_date',
        'delivery_act_date',
        'delivery_est_date',
        'delivery_rcv_date',
        'delivery_address',
        'delivery_zipcode',
        'delivery_kelurahan',
        'delivery_kecamatan',
        'delivery_kabkot',
        'delivery_provinsi',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'delivery_order_number' => 'string'
    ];

    public function relatedOrder(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }
}
