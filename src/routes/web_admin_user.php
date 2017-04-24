<?php
Route::group(['prefix' => 'admin','middleware' => ['web','auth'],'namespace'=>'admin'], function () {
$item0=[
	'name'=>'lu'
	,'prefix'=>'lu'
	,'as'=>'lu.'//'trasferte.' 
	,'namespace'=>'lu'
	//,'controller' => 'UserController'
	,'controller' =>  '\XRA\LU\LUController'
	//,'only'=>['index']
	
];

$areas_prgs=[
	$item0
];
\XRA\Extend\Library\XOT::dynamic_route($areas_prgs);


});
