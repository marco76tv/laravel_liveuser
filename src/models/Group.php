<?php

namespace XRA\LU\models;

use Illuminate\Database\Eloquent\Model;
use XRA\Extend\Traits\Updater;


class Group extends Model
{
    use Updater;
    //
    protected $connection = 'liveuser_general'; // this will use the specified database conneciton
    protected $table = 'liveuser_groups';
   // protected $primaryKey = 'group_id';

public function GroupUser(){
	return $this->hasMany(GroupUser::class,'group_id','group_id');
}

function label(){
	return $this->group_id.'] '.$this->group_define_name;
}

function key(){
 return $this->group_id; 
}

function keyName(){
  return 'group_id';
}

/*
function AreaAdminAreas(){
	return $this->hasMany('AreaAdminAreas','area_id','area_id');
}
*/
static public function full(){
	$rows=new self;
	
	return $rows;
}

//---------------------------------------------------------------------------
static public function filter($params){
  
  extract($params);
  //echo '<pre>';print_r($params);echo '</pre>';
  if(isset($id_user)){
  	$user=User::find($id_user);
  	$rows=$user->groups();
	}else{
		$rows=new self;
	}
  //echo '<pre>';print_r($areas->toArray());echo '</pre>';
  //echo '<pre>';print_r($user);echo '</pre>';
  //$perm_user=$user->permUsers['perm_user_id'];
  //echo '<pre>-';print_r($perm_user);echo '-</pre>';

  //
    /*
  if(!isset($tipo)){ // e' il tipo che dice se e' admin o meno.. utente normale solo "competenza"
    $ente=\Auth::user()->ente;
    $matr=\Auth::user()->matr;
  }
    */

  if(isset($ente)){
        $rows=$rows->where('ente','=',$ente);
        //echo '<pre>';print_r($params);echo '</pre>';
    }
    if(isset($matr)){
        $rows=$rows->where('matr','=',$matr);
    }
    $datefield='data_start';
    if(isset($tipo)){
        switch($tipo){
            case 1: $datefield='data_start'; break;
            case 2: $datefield='datemod'; break;
        }
    }

    if(isset($mese)){
        $rows=$rows->whereMonth($datefield,$mese);
    }
    if(isset($anno)){
        //$rows=$rows->whereYear($datefield,$anno);
        $rows=$rows->where('anno',$anno);
    }
    if(isset($stabi)){
        $rows=$rows->where('stabi',$stabi);
    }
    if(isset($repar)){
        $rows=$rows->where('repar',$repar);
    }


    if(isset($stati)){
      $rows=$rows->whereRaw('find_in_set(last_stato,"'.$stati.'")');
    }
    //$rows=$rows->orderBy('data_start', 'desc');
    return $rows;
}//end search
//-----------------------------------------------------------------------------------

}
