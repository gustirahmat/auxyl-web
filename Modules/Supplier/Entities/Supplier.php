<?php

namespace Modules\Supplier\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use SoftDeletes;

    /**
     * The database primary key value.
     *
     * @var string
     */
    protected $primaryKey = 'supplier_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'supplier_name',
        'supplier_phone',
        'supplier_address',
    ];
}
