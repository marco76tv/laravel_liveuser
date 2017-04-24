<?php

namespace XRA\LU\Controllers\admin\user;

use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use App\Http\Controllers\Controller;
use XRA\Extend\Traits\CrudSimpleTrait as CrudTrait;
use XRA\LU\models\Group;

//use blueimp\jquery-file-upload\UploadHandler;

class GroupController extends Controller{
use CrudTrait;
//-------------------------
public function getModel(){
    return new Group;
}//end getModel

public function getPrimaryKey(){
    return 'id_group';
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
public function filter(Request $request){
	$data=$request->all();
	//echo '<pre>';print_r($data);echo '</pre>';
	if($request->_method!=''){
		return $this->do_search($data);

	}
	return view('lu::user.search');
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
	return view('lu::user.do_search')->with('rows',$rows);

}
//-------------------------------------------------------------------------
////-------------------------------------------------------------------------
 public function index(Request $request){
        if($request->routelist==1){
           return app(\App\Http\Controllers\admin\ArtisanController::class)->exe('route:list');
        }
        $params = \Route::current()->parameters();
        $model=$this->getModel();
        //$rows = $model->all(); 
        $rows=$model->search($params);
        return view('lu::admin.user.group.index')->with('rows',$rows)->with('params',$params);
}//end index
//---------------------------------------------------
public function store(Request $request){
	$data=$request->all();
	//echo '<pre>';print_r($data);echo '</pre>';
	$params = \Route::current()->parameters();
	extract($params);
	$user=\XRA\LU\models\User::find($id_user);
	$perm_user_id=$user->permUsers['perm_user_id'];
	//echo '<h3>'.$perm_user_id;
	$res=\XRA\LU\models\GroupUser::where('perm_user_id','=',$perm_user_id)->delete();
	extract($data);
	reset($group_id);
	while(list($k,$v)=each($group_id)){
		$row=new \XRA\LU\models\GroupUser;
		$row->group_id=$v;
		$row->perm_user_id=$perm_user_id;
		$row->save();
	}
	\Session::flash('status','gruppi aggiornati ');
	return back()->withInput();
}//end update
}
