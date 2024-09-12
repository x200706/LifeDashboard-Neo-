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
    // 投資
    $router->resource('win-stock', WinStockController::class);
    $router->resource('stock-tag-manager', StockTagListController::class);
    // 卡路里
    $router->resource('calorie-record', CalorieRecordController::class);
    $router->resource('calorie-tags', CalorieTagsController::class);
    // 身體素質
    $router->resource('body-record', BodyRecordController::class);
    // 餐廳收集
    $router->resource('restaurant', RestaurantController::class);
});
