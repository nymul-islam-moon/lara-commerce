<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ChildCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'child_categories';

    protected $fillable = ['slug', 'name', 'updated_by_id', 'created_by_id', 'product_subcategory_id', 'status'];
}
