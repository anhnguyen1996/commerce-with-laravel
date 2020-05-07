<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $table = 'product_images';

    protected $fillable = ['id', 'name', 'path', 'alt', 'product_image_type_id'];

    public $timestamps = true;
}