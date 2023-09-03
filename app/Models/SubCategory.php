<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'product_sub_categories';

    protected $fillable = ['created_by_id', 'updated_by_id', 'name', 'status', 'slug', 'product_category_id'];

    public function category()
    {
        return $this->hasMany(ProductCategory::class, 'product_category_id');
    }

}
