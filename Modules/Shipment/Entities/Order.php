<?php

namespace Modules\Shipment\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
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
        'order_ongkir',
        'order_latest_status',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'order_latest_status' => 'integer',
        'order_no' => 'string',
        'order_total' => 'decimal:0',
        'order_ongkir' => 'decimal:0',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'order_date',
    ];

    public function getOrderPaymentProofAttribute($value): ?string
    {
        if ($value) {
            if (App::environment('production')) {
                return $value;
            }

            return asset($value);
        }

        return null;
    }

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'order_status',
    ];

    public function getOrderStatusAttribute(): string
    {
        $status = $this->order_latest_status;
        if ($status == 1) {
            return 'Pesanan menunggu pembayaran';
        } elseif ($status == 2) {
            return 'Pesanan dibayar';
        } elseif ($status == 3) {
            return 'Pesanan dikirim';
        } elseif ($status == 4) {
            return 'Pesanan diterima';
        } elseif ($status == 5) {
            return 'Pesanan selesai';
        } elseif ($status == 6) {
            return 'Pesanan dikomplain';
        } elseif ($status == 7) {
            return 'Pesanan dibatalkan';
        }

        return 'Pesanan diproses';
    }

    protected $with = ['relatedProducts.relatedProduct', 'relatedProducts.relatedPhotos'];

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
        return $this->hasMany(OrderStatus::class, 'order_id', 'order_id')->latest();
    }

    public function relatedDelivery(): HasOne
    {
        return $this->hasOne(OrderDelivery::class, 'order_id', 'order_id');
    }
}
