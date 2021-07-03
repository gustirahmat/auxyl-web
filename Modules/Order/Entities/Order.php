<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Supplier\Entities\Supplier;

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
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'supplier_id',
        'customer_id',
        'order_latest_status',
        'order_no',
        'order_date',
        'order_total',
        'order_notes',
        'order_payment_proof',
    ];

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

    public function relatedSupplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'supplier_id');
    }

    public function relatedCustomer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
    }

    public function relatedProducts(): HasMany
    {
        return $this->hasMany(OrderProduct::class, 'order_id', 'order_id');
    }

    public function relatedStatuses(): HasMany
    {
        return $this->hasMany(OrderStatus::class, 'order_id', 'order_id');
    }

    public function relatedDelivery(): HasOne
    {
        return $this->hasOne(OrderDelivery::class, 'order_id', 'order_id');
    }

    public function relatedComplain(): HasOne
    {
        return $this->hasOne(OrderComplain::class, 'order_id', 'order_id');
    }
}
