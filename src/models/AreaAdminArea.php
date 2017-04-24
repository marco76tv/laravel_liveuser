<?php

namespace XRA\LU\models;

use Illuminate\Database\Eloquent\Model;
use XRA\Extend\Traits\Updater;


class AreaAdminArea extends Model{
    //
    use Updater;
    protected $connection = 'liveuser_general'; // this will use the specified database conneciton
    protected $table = 'liveuser_area_admin_areas';
    //protected $primaryKey = 'auth_user_id'; ha 2 keys

function area(){
	//return $this->belongsTo('App\Post', 'foreign_key', 'other_key');
	return $this->belongsTo('Area','area_id');
}   

}//---end class
