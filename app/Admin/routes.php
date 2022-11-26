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

    $router->resource('all-user', 'UserController');
    $router->resource('activity', 'ActivityController');
    $router->resource('activity-one', 'OneController');
    $router->resource('activity-many', 'ManyController');


    $router->resource('activity-sign-com', 'ActivitySignComController');
    $router->resource('activity-sign-user', 'ActivitySignUserController');
    $router->resource('activity-group', 'ActivityGroupController');
    $router->resource('activity-view-log', 'ActivityViewLogController');
    $router->resource('activity-web-create', 'ActivityWebCreateController');


    $router->resource('company', 'CompanyController');
    $router->resource('company-child', 'CompanyChildController');
    $router->resource('award', 'AwardController');
    $router->resource('user-award', 'UserAwardController');
    $router->resource('invite-log', 'UserActivityInviteController');
    $router->resource('setting', 'BasicSettingController');

    //A用户邀请码，小程序收到活动id为9999的活动，直接设置用户为A用户
    $router->resource('user-a-invite-pic', 'UserAInvitePicController');

    //提现
    $router->resource('user-apply-cash-out', 'UserApplyCashOutController');

    //订单管理
    $router->resource('order', 'OrderController');


    $router->get('custom/map', 'CompanyChildController@customMap'); // 自定义地图视图

});
