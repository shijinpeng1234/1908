<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//闭包路由
// Route::get('/', function () {
//     return view('welcome');
// });

//首页
Route::get('/','Index\IndexController@index');
//登陆页面
Route::view('/login','index/login');
Route::post('/logindo','Index\IndexController@logindo');
//注册
Route::view('/reg','index/reg');
Route::post('/regdo','Index\IndexController@regdo');
//商品列表
Route::view('/prolist','index/prolist');


//商品详情页
Route::get('/proinfo/{id}','Index\IndexController@proinfo');


//短信发送
Route::get('/send','LoginController@ajaxsend');







//路由命名
// Route::view('/category','user/type');
// Route::post('/cdd','UserController@cdd')->name('dd');


//正则约束
// Route::get('/goods/{id}',function($goods_id){
//     echo "商品ID";
//     echo $goods_id;
// });
// Route::get('/good/{id}',function($goods_id){
//     echo "ID";
//     echo $goods_id;
// });
// Route::get('/goods/{id}/{name}',function($goods_id,$name){
//     echo "商品ID";
//     echo $goods_id;
//     echo "商品名称";
//     echo $name;
// })->where('name','\w+');


//外来务工人员统计       //中间件 ->middleware('peoplelogin')
Route::prefix('people')->group(function(){
    Route::get('/create','PeopleController@create');
    Route::post('/store','PeopleController@store');
    Route::get('/','PeopleController@index');
    Route::get('/edit/{id}','PeopleController@edit');
    Route::post('/update/{id}','PeopleController@update');
    Route::get('/destroy/{id}','PeopleController@destroy');
});
//登录界面
// Route::view('/login','login/login');
//执行登录
// Route::post('/logindo','LoginController@logindo');


//学生表
Route::get('/student/create','StudentController@create');
Route::post('/student/store','StudentController@store');
Route::get('/student','StudentController@index');
Route::get('/student/edit/{id}','StudentController@edit');
Route::post('/student/update/{id}','StudentController@update');
Route::get('student/destroy/{id}','StudentController@destroy');


//品牌表
Route::get('/brand/create','BrandController@create');
Route::post('/brand/store','BrandController@store');
Route::get('brand','BrandController@index');
Route::get('/brand/edit/{id}','BrandController@edit');
Route::post('/brand/update/{id}','BrandController@update');
Route::get('/brand/destroy/{id}','BrandController@destroy');


//文章          中间件->middleware('articlelogin')
Route::prefix('article')->group(function(){
    Route::get('/create','ArticleController@create');
    Route::post('/store','ArticleController@store');
    Route::get('/','ArticleController@index');
    Route::get('/edit/{id}','ArticleController@edit');
    Route::post('/update/{id}','ArticleController@update');
    Route::get('/destroy/{id}','ArticleController@destroy');
    Route::post('/checkOnly','ArticleController@checkOnly');
});

//分类表 category
Route::prefix('category')->group(function(){
    Route::get('/create','CategoryController@create');
    Route::post('/store','CategoryController@store');
    Route::get('/','CategoryController@index');
    Route::get('/edit/{id}','CategoryController@edit');
    Route::post('/update/{id}','CategoryController@update');
    Route::get('/destroy/{id}','CategoryController@destroy');
});


//商品
Route::prefix('goods')->group(function(){
    Route::get('/create','GoodsController@create');
    Route::post('/store','GoodsController@store');
    Route::get('/','GoodsController@index');
    Route::get('/edit/{id}','GoodsController@edit');
    Route::post('/update/{id}','GoodsController@update');
    Route::get('/destroy/{id}','GoodsController@destroy');
    Route::post('/checkOnly','GoodsController@checkOnly');
});

//管理员
Route::prefix('admin')->group(function(){
    Route::get('/create','AdminController@create');
    Route::post('/store','AdminController@store');
    Route::get('/','AdminController@index');
    Route::get('/edit/{id}','AdminController@edit');
    Route::post('/update/{id}','AdminController@update');
    Route::get('/destroy/{id}','AdminController@destroy');
    Route::post('/checkOnly','AdminController@checkOnly');
});
Route::prefix('user')->middleware('userlogin')->group(function(){
    Route::get('/create','UserController@create');
    Route::post('/store','UserController@store');
    Route::get('','UserController@index');
    Route::get('/edit/{id}','UserController@edit');
    Route::post('/update/{id}','UserController@update');
    Route::get('/destroy/{id}','UserController@destroy');
});
    Route::view('user/login','user/login');
    Route::post('user/logindo','UserController@logindo');
