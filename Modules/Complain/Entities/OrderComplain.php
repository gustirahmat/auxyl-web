<?php

namespace Modules\Complain\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderComplain extends Model
{
    /**
     * The database primary key value.
     *
     * @var string
     */
    protected $primaryKey = 'complain_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'complain_status',
        'complain_category',
        'complain_description',
        'complain_attachment',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'complain_status' => 'integer'
    ];

    public function relatedOrder(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }
}
