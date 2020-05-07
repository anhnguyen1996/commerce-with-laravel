<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = ['id', 'name', 'alias', 'price', 'sale_price', 'inventory_quantity', 'description', 'content', 'product_image_id', 'brand_id', 'product_status_id', 'user_id', 'category_id', 'priority_id'];

    public $timestamps = true;
}
