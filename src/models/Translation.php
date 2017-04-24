<?php

namespace XRA\LU\models;

use Illuminate\Database\Eloquent\Model;

use XRA\Extend\Traits\Updater;


class Translation extends Model
{
	use Updater;
    // 
    protected $connection = 'liveuser_general'; // this will use the specified database conneciton
    protected $table = 'liveuser_translations';
    protected $primaryKey = ['section_id','section_type','language_id'];

}
