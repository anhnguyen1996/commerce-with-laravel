<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserStatus extends Model
{
    protected $table = 'user_statuses';

    protected $fillable = ['id', 'user_id', 'permission_id'];

    public $timestamps = true;
}
