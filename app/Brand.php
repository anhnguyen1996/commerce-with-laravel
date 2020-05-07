<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $table = 'brands';
    
    protected $fillable = ['id', 'name'];

    public $timestamps = true;
}
