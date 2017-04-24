<?php


//Route::get('timezones/{timezone}', 'xot\themes\ThemesController@index');
//Route::group(['middleware' => ['web'],'namespace'=>'xot\lu'], function () {

//	Route::resource('/lu', 'LUController'); 
	//Route::get('/product/{id_grid}', 'xot\fpb\ProductController@preview')->name('product.preview');
	//Route::get('/product/{id_grid}/thanks', 'xot\fpb\ProductController@thanks')->name('product.thanks');
	//Route::get('/product/{id_grid}/pagamento', 'xot\fpb\ProductController@eseguiPagamento')->name('product.eseguiPagamento');
	//Route::resource('/upload', 'xot\fpb\UploadController');
//});




if(\Request::path() != ''){
	$tmp=explode('/',\Request::path());
    $tmp=array_slice($tmp,0,2);
    $tmp = implode('_', $tmp);
    //echo '<h3>tmp = '.$tmp.'</h3>';die();
    $filename='web_'.$tmp.'.php';
    $filename_dir=__DIR__.DIRECTORY_SEPARATOR.'routes'.DIRECTORY_SEPARATOR.$filename;
    //echo '<h3>tmp = '.$filename_dir.'</h3>';die();
    if(file_exists($filename_dir)){
    	require $filename_dir;
    }
}


