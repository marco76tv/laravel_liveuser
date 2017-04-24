<?php

namespace XRA\LU\models;

use Illuminate\Database\Eloquent\Model;
use XRA\Extend\Traits\Updater;


class Application extends Model
{
	use Updater;
    //
    protected $connection = 'liveuser_general'; // this will use the specified database conneciton
    protected $table = 'liveuser_applications';
    protected $primaryKey = 'application_id';

}
