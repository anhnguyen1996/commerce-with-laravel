<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPermission extends Model
{
    protected $table = 'user_permissions';

    protected $fillable = ['id', 'user_id', 'permission_id'];

    public $timestamps = true;
}
