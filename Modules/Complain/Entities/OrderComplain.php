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
        'complain_resolution',
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

    public function getComplainDescriptionAttribute($value): ?string
    {
        return ucfirst($value);
    }

    public function getComplainResolutionAttribute($value): ?string
    {
        return $value ? ucfirst($value) : 'Belum ada.';
    }

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'complain_status_desc',
    ];

    public function getComplainStatusDescAttribute(): string
    {
        $status = $this->complain_status;
        if ($status == 1) {
            return 'Open';
        } elseif ($status == 2) {
            return 'In Progress';
        } elseif ($status == 3) {
            return 'Closed';
        }

        return 'Undefined';
    }

    public function relatedOrder(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }
}
