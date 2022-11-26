<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\ShowUser;
use App\Admin\Metrics\Examples;
use App\Admin\Renderable\CompanyList;
use App\Admin\Renderable\UserTable;
use App\Http\Controllers\Controller;
use App\Http\Traits\WeChatTrait;
use Dcat\Admin\Http\Controllers\Dashboard;
use Dcat\Admin\Layout\Column;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;

use Dcat\Admin\Widgets\Modal;
use EasyWeChat\Factory;
use EasyWeChat\Kernel\Http\StreamResponse;
use Illuminate\Support\Facades\Log;


class HomeController extends Controller
{

    use WeChatTrait;

    /**
     * @param Content $content
     * @return mixed
     *
     *         解决方案
     * 路径问题
     * 传入的页面路径，pages前不可用加 " / "
     * 正确：‘pages/index/index’
     * 错误：‘/pages/index/index’
     *
     * 小程序参数问题
     * 小程序的参数不能超过32个字符
     *
     *          小程序是否发布
     * 传入page，生成指定页面的二维码的前提是，小程序必须审核并发布
     * 审核成功并发布的小程序才能正常调用二维码生成接口
     */
    public function index(Content $content)
    {


//        $access_token = $this->getShareQCode(3, 1);
//
//        var_dump($access_token);
//        exit;

//        return $content->body(UserTable::make());

        $modal = Modal::make()
            ->lg()
            ->title('异步加载 - 表格')
            ->body(CompanyList::make()) // Modal 组件支持直接传递 渲染类实例
            ->button('打开表格');

        return $content->body($modal);


    }




//    public function index(Content $content)
//    {
//        return $content
//            ->header('Dashboard')
//            ->description('Description...')
//            ->body(function (Row $row) {
//                $row->column(6, function (Column $column) {
//                    $column->row(Dashboard::title());
//                    $column->row(new Examples\Tickets());
//                });
//
//                $row->column(6, function (Column $column) {
//                    $column->row(function (Row $row) {
//                        $row->column(6, new Examples\NewUsers());
//                        $row->column(6, new Examples\NewDevices());
//                    });
//
//                    $column->row(new Examples\Sessions());
//                    $column->row(new Examples\ProductOrders());
//                });
//            });
//    }
}
