<?php
Route::group(['prefix' => 'admin','middleware' => ['web','auth'],'namespace'=>'admin'], function () {
$item0=[
	'name'=>'lu'
	,'prefix'=>'lu'
	,'as'=>'lu.'//'trasferte.' 
	,'namespace'=>'lu'
	//,'controller' => 'UserController'
	,'controller' =>  '\XRA\LU\Controllers\admin\LUController'
	,'only'=>['index']
	,'subs'=>[
		[
			'name'=>'user',
			'prefix'=>'user',
			'as'=>'user',
			'namespace'=>'user',
			'controller'=>'\XRA\LU\Controllers\admin\UserController',
			'acts'=>[
				[
					'name'=>'search',
					'method'=>'any',
					'act'=>'search',
					'as'=>'.search',
				],//end act_n
			],//end acts
			'subs'=>[
				[
				'name'=>null,
				'namespace'=>null,
				'as'=>null,
				'prefix'=>'{id_user}',
				'controller' => 'SearchController',
				'subs' =>[
					[
						'name'=>'group',
						'prefix'=>'group',
						'as'=>'.group',
						'namespace'=>'group',
						'controller'=>'\XRA\LU\Controllers\admin\user\GroupController',
					],//end sub_n
					[
						'name'=>'area',
						'prefix'=>'area',
						'as'=>'.area',
						'namespace'=>'area',
						'controller'=>'\XRA\LU\Controllers\admin\user\AreaController',
					],//end sub_n
				],//end subs
				],//end sub_n
			],//end subs
		],//end sub_n
	],//end subs
	
];

$areas_prgs=[
	$item0
];
\XRA\Extend\Library\XOT::dynamic_route($areas_prgs);


});
