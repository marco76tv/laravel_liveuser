<?php

namespace XRA\LU\models;

use Illuminate\Database\Eloquent\Model;
use XRA\Extend\Traits\Updater;


class PermUser extends Model
{
	use Updater;
    //
    protected $connection = 'liveuser_general'; // this will use the specified database conneciton
    protected $table = 'liveuser_perm_users';
    protected $primaryKey = 'perm_user_id';
//--------------------------------
public function areaAdminAreas(){
	//return $this->hasMany('App\Comment', 'foreign_key', 'local_key');
	return $this->hasMany('AreaAdminArea','perm_user_id','perm_user_id');
}    
//----------------
public function groupUsers(){
	//die('['.__LINE__.']['.__FILE__.']');
	return $this->hasMany('GroupUser','perm_user_id','perm_user_id');
}

//--------------------------------
}//end class PermUsers
