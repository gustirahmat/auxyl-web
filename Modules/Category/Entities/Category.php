<?php

namespace Modules\Category\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Product\Entities\Product;

class Category extends Model
{
    use SoftDeletes;

    /**
     * The database primary key value.
     *
     * @var string
     */
    protected $primaryKey = 'category_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_name',
        'category_icon',
        'category_gender',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'category_gender' => 'integer'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['category_gender_text'];

    public function getCategoryGenderTextAttribute(): string
    {
        if ($this->attributes['category_gender'] == 0) {
            return 'Wanita';
        } elseif ($this->attributes['category_gender'] == 1) {
            return 'Pria';
        }

        return 'Unisex';
    }

    public function relatedProducts(): HasMany
    {
        return $this->hasMany(Product::class, 'category_id', 'category_id');
    }
}
