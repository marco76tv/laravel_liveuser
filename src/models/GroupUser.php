<?php

namespace XRA\LU\models;

use Illuminate\Database\Eloquent\Model;
use XRA\Extend\Traits\Updater;


class GroupUser extends Model
{
	use Updater;
    protected $connection = 'liveuser_general'; // this will use the specified database conneciton
    protected $table = 'liveuser_groupusers';
   /* protected $primaryKey = ['perm_user_id','group_id'];*/ //questo da errore al toArray
//--------------------------------------------------
public function group(){
	return $this->hasOne(Group::class,'group_id','group_id');

}

//----------------------------------------
//----------------------------------------
}//end class GroupUser
