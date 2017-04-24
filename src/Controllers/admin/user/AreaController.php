<?php

namespace XRA\LU\Controllers\admin\user;

use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use App\Http\Controllers\Controller;
use XRA\Extend\Traits\CrudSimpleTrait as CrudTrait;



//use blueimp\jquery-file-upload\UploadHandler;

class AreaController extends Controller{
use CrudTrait;
//-------------------------
public function getModel(){
    return new \XRA\LU\models\Area;
}//end getModel

public function getPrimaryKey(){
    return 'id_area';
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
 public function index(Request $request){
        if($request->routelist==1){
           return app(\App\Http\Controllers\admin\ArtisanController::class)->exe('route:list');
        }
        $params = \Route::current()->parameters();
        $model=$this->getModel();
        //$rows = $model->all();
        $rows=$model->filter($params);
        return view('lu::admin.user.area.index')->with('rows',$rows)->with('params',$params);
}//end index

//---------------------------------------------------------------------------
public function update(Request $request){
	die('['.__LINE__.']['.__FILE__.']');
}//end update
public function store(Request $request){
	$data=$request->all();
	//echo '<pre>';print_r($data);echo '</pre>';
	$params = \Route::current()->parameters();
	extract($params);
	$user=\XRA\LU\models\User::find($id_user);
	$perm_user_id=$user->permUsers['perm_user_id'];
	//echo '<h3>'.$perm_user_id;
	$res=\XRA\LU\models\AreaAdminArea::where('perm_user_id','=',$perm_user_id)->delete();
	extract($data);
	reset($area_id);
	while(list($k,$v)=each($area_id)){
		$row=new \XRA\LU\models\AreaAdminArea;
		$row->area_id=$v;
		$row->perm_user_id=$perm_user_id;
		$row->save();
	}
	\Session::flash('status','aree aggiornate ');
	return back()->withInput();
}//end update

}//end class
