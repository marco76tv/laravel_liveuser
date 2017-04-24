<?php

namespace XRA\LU\Controllers\admin;

use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use App\Http\Controllers\Controller;
use XRA\Extend\Traits\CrudSimpleTrait as CrudTrait;

//-------- models ----------------
use XRA\LU\Models\User;


//use blueimp\jquery-file-upload\UploadHandler;

class UserController extends Controller{
use CrudTrait;
//-------------------------
public function getModel(){
    return new User;
}//end getModel

public function getPrimaryKey(){
    return 'id_user';
}//end getPrimaryKey
/*
public function index(Request $request){
	if($request->routelist==1){
        return app(\App\Http\Controllers\admin\ArtisanController::class)->exe('route:list');
    }
    return view('lu::index');
}
*/
//---------------------------------
public function search(Request $request){
	$data=$request->all();
	//echo '<pre>';print_r($data);echo '</pre>';
	if($request->_method!=''){
		return $this->do_search($data);

	}
	return view('lu::admin.user.search');
}//end search
//------------------------------------------------------------------------  
public function do_search($data){
	//echo '<h3>do_search</h3>';
	$rows=$this->getModel();
	extract($data);
	if(isset($handle) && $handle!=''){
		$rows=$rows->where('handle',$handle);
	}
	if(isset($cognome) && $cognome!=''){	
		$rows=$rows->where('cognome',$cognome);
	}
	if(isset($nome) && $nome!=''){	
		$rows=$rows->where('nome',$nome);
	}
	$rows=$rows->get();
	//echo '<h3>'.$rows->count().'</h3>';
	return view('lu::admin.user.do_search')->with('rows',$rows);

}
//-------------------------------------------------------------------------
}
