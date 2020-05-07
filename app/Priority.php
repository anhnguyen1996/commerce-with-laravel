<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Priority extends Model
{
    protected $table = 'priorities';

    protected $fillable = ['id', 'name', 'describes', 'sort'];

    public $timestamps = true;
}
