<?php

namespace Modules\Employee\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use SoftDeletes;

    /**
     * The database primary key value.
     *
     * @var string
     */
    protected $primaryKey = 'employee_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'employee_name',
        'employee_phone',
        'employee_position',
        'employee_address',
    ];

    public function relatedProducts(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
