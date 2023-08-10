<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'product_sub_categories';

    protected $dates = ['deleted_at'];

    protected $fillable = ['created_by_id', 'updated_by_id', 'code', 'name', 'status', 'slug', 'product_category_id'];

    public function category()
    {
        return $this->hasMany(ProductCategory::class, 'product_category_id');
    }

}
