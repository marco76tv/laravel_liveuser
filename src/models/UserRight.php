<?php

namespace XRA\LU\models;

use Illuminate\Database\Eloquent\Model;

use XRA\Extend\Traits\Updater;

class UserRight extends Model
{
	use Updater;
    //
    protected $connection = 'liveuser_general'; // this will use the specified database conneciton
    protected $table = 'liveuser_userrights';
    protected $primaryKey = ['perm_user_id','right_id'];

}
