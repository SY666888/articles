<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Dcat\Admin\Admin;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');
    //网站配置
    Route::get('/settings', 'SettingsController@index')->name('settings.index');
    $router->resource('admin_users','AdminUserController');// 修改用户管理/auth/users
    $router->resource('category', 'ArctypeController');
    $router->resource('article',  'ArticlecreateController');
    $router->resource('link',  'LinkController');
    $router->resource('phone',  'PhoneController');
    $router->resource('phone_feipei',  'XiansuoFeipeiController');
    $router->resource('phone_genzong',  'XiansuoGenzongController');
    Route::get('makesitemap','SiteMapController@Index');
    Route::get('makemsitemap','SiteMapController@MobileSitemap');

});
