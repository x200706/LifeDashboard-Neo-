<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Dcat\Admin\Admin;

Admin::routes();

Route::group([
    'prefix'     => config('admin.route.prefix'),
    'namespace'  => config('admin.route.namespace'),
    'middleware' => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');
    // 記帳
    $router->resource('account', AccountController::class);
    $router->resource('account-record', AccountRecordController::class);
    $router->resource('account-record-tags', AccountRecordTagsController::class);

});
