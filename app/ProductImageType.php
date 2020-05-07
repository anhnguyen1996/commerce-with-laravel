<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductImageType extends Model
{
    protected $table = 'product_image_types';

    protected $fillable = ['id', 'name'];

    public $timestamps = true;
}
