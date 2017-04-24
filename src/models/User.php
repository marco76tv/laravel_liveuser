<?php
//http://stackoverflow.com/questions/33562285/how-can-i-use-md5-hashing-for-passwords-in-laravel

namespace XRA\LU\Models;


use Illuminate\Notifications\Notifiable;
/*
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable;
//use Illuminate\Auth\Authenticable as AuthenticableTrait;
use Illuminate\Auth\Authenticable;


//https://laracasts.com/index.php/discuss/channels/eloquent/eloquent-help-generating-attribute-values-before-creating-record

//use Illuminate\Auth\Authenticatable;
//use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
//use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
*/


use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;


//class User extends Model
class User extends \Eloquent implements AuthenticatableContract,
                                        CanResetPasswordContract {
/*
class User extends \Eloquent implements  AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract {
*/
    //
   // use /*Authenticable,*/ Authorizable, CanResetPassword;
     use Authenticatable, CanResetPassword;                                 
     use Notifiable;                                        

    protected $connection = 'liveuser_general'; // this will use the specified database conneciton
    protected $table = 'liveuser_users';
    protected $primaryKey = 'auth_user_id';
    protected $fillable = [
        'ente', 'matr','handle', 'passwd','email'
    ];
    public $timestamps = true;
    public static $rules = array();  

    /**
 * Get the unique identifier for the user.
 *
 * @return mixed
 */
    public function getAuthIdentifier() 
    {
        return $this->getKey();
    }
    
public function getAuthIdentifierName(){
    return 'auth_user_id';
}
//-----------------------------------------------------------
function permUsers(){
    return $this->hasOne(PermUser::class,'auth_user_id','auth_user_id');
}

///----------------------------------------------------------------------
public function perm_type(){
    $permUsers=$this->permUsers();
    return $permUsers;
}


function groups1(){
    $permUsers=$this->permUsers()->first();
    $groupUsers=$permUsers->groupUsers()->get();
    //echo '<pre>[';print_r($groupUsers->first()->toArray());echo '</pre>';
    //$groupUsers=$this->permUsers()->first()->groupUsers()->get();
    //echo '<pre>['; print_r($groupUsers->toArray()); echo ']</pre>';
    $groups=[];
    foreach($groupUsers as $k => $v){
       // $v1=$v->group();
        //echo '<pre>['; print_r($v->toArray()); echo ']</pre>';
        $v1=$v->group()->first();
        //echo '<pre>['; print_r($v1->toArray()); echo ']</pre>';
        if($v1!=null){
            $groups[]=$v1->toArray();
        }
    }
    $collection = collect($groups);
    //$collection->prepend(['a'=>'b']);
    $keyed = $collection->keyBy('group_id');
    $keyed ->prepend('--- SELEZIONA ---');
    //echo '<pre>';print_r($keyed->all()); 
    return $keyed->all();
    //return $groups;
}

function groups_opts(){

    $groups=$this->groups()->get()->toArray();
    $collection = collect($groups);
    $plucked = $collection->pluck('group_define_name', 'group_id');
    $plucked->prepend('','');
    return $plucked->all();
}

function areas(){
    //$areas=[];
    if($this->permUsers()->first()==null) return [];
    $perm_user_id=$this->permUsers['perm_user_id'];
    //echo '<h3>'.$perm_user_id;
    $areas=Area::whereHas('AreaAdminArea',function ($query) use ($perm_user_id){
        $query->where('perm_user_id','=',$perm_user_id);
    });
    return $areas;
}

function groups(){
    //$areas=[];
    if($this->permUsers()->first()==null) return [];
    $perm_user_id=$this->permUsers['perm_user_id'];
    //echo '<h3>'.$perm_user_id;
    $groups=Group::whereHas('GroupUser',function ($query) use ($perm_user_id){
        $query->where('perm_user_id','=',$perm_user_id);
    });
    return $groups;
}



/*
function areas(){
    $areas=[];
    //$tmp=\Auth::user()->permUsers()->first()->areaAdminAreas()->get();
    if($this->permUsers()->first()==null) return $areas;
    $tmp=$this->permUsers()->first()->areaAdminAreas()->get();
    foreach($tmp as $v){
      $v1=$v->area()->get()->toArray();
      if(isset($v1[0])){
        $tmp=array_merge($v->toArray(),$v1[0]);
        $tmp['routename']=str_replace('-','_',str_slug($tmp['area_define_name'])).'.index';
        if(\Route::has( $tmp['routename'])){
          $tmp['url']=route($tmp['routename']);
        }else{
          $tmp['url']='#4-'.$tmp['routename'];
        }
        $areas[]=$tmp;
      }
    }
    return $areas;
}
*/

//-----------------------------------------------------------
public function areaAdminAreas(){

    //$perm_user_id=$this->perm_user_id();
    $areaAdminAreas=$this->permUsers()->first()->areaAdminAreas()->get();
   
    //*
    //while(list($k,$v)=each($areaAdminAreas) ){
        //echo '<pre>';print_r($v->area()->first()); echo '</pre>';
    //    die();
    //}
    //*/
    foreach($areaAdminAreas as $tmp){
        echo '<br/>'.$tmp->areas()->first()->area_id;
    }

    return ['area1','area2','area_3'];
}

    /**
 * Get the password for the user.
 *
 * @return string
 */
public function getAuthPassword(){
     //your passwor field name
    return $this->passwd;
}	
    

    public function metadata()
    {
        return $this->hasOne('Metadata');
    }

/**
 * Get the e-mail address where password reminders are sent.
 *
 * @return string
 */

public function getReminderEmail()
{
    return $this->email;
}


   

    /**
     * Get the token value for the "remember me" session.
     *
     * @return string
     */
    
    public function getRememberToken(){
        // die('['.__LINE__.']['.__FILE__.']');
        return $this->remember_token;
    }
    
    /**
     * Set the token value for the "remember me" session.
     *
     * @param  string  $value
     * @return void
     */
    public function setRememberToken($value){
      //   die('['.__LINE__.']['.__FILE__.']');
         $this->remember_token = $value;
    }

    /**
     * Get the column name for the "remember me" token.
     *
     * @return string
     */
    
    public function getRememberTokenName(){
         //die('['.__LINE__.']['.__FILE__.']');
           return 'remember_token';
    }
    
     protected function authenticated($request, $user){
        die('['.__LINE__.']['.__FILE__.']');
         if($user->role === 'admin') {
            return redirect()->intended('/admin_path_here');
        }

        return redirect()->intended('/path_for_normal_user');
    }



    public function password(){
        //die('['.__LINE__.']['.__FILE__.']');
        return 'passwd';
    }

    public function username(){

        $user_table=$this->table;
        //echo '<h3>'.$user_table.'</h3>';die();
         
        if(!\Schema::connection($this->connection)->hasColumn($user_table, 'remember_token')){
            \Schema::connection($this->connection)->table($user_table, function($table){$table->string('remember_token');});
        }
        if(!\Schema::connection($this->connection)->hasColumn($user_table, 'updated_at')){
            \Schema::connection($this->connection)->table($user_table, function($table){$table->datetime('updated_at');});
        }
        //die('['.__LINE__.']['.__FILE__.']');
        return 'handle';
    }
    //--------------------
    //--------------------
    /*
    public function setPasswordAttribute($value) {
        //die('['.__LINE__.']['.__FILE__.']');
        $this->attributes['password'] = bcrypt($value);
    }
    */
     //--------------------
    public function setPasswdAttribute($value) {
       // die('['.__LINE__.']['.__FILE__.']');
        $this->attributes['passwd'] = md5($value);
    }

    public function setUsernameAttribute($value){
        //die('['.__LINE__.']['.__FILE__.']');
        $this->attributes['username'] = strtolower($value);
    }
//-------------------------------    
public function name(){
  return $this->handle;
}

//---------------------------------------------------------------------------
static public function filter($params){
  
  extract($params);
  //echo '<pre>';print_r($params);echo '</pre>';
  $rows=new self;
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
//---------------------------------------------------
}//end class
