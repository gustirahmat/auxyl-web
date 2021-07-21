<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Order\Entities\Order;

class Customer extends Model
{
    use SoftDeletes;

    /**
     * The database primary key value.
     *
     * @var string
     */
    protected $primaryKey = 'customer_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'customer_name',
        'customer_phone',
        'customer_address',
        'customer_zipcode',
        'customer_kelurahan',
        'customer_kecamatan',
        'customer_kabkot',
        'customer_provinsi',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'customer_phone' => 'string',
        'customer_zipcode' => 'string'
    ];

    public function relatedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }

    public function relatedOrders(): HasMany
    {
        return $this->hasMany(Order::class, 'customer_id', 'customer_id');
    }
}
