<?php

namespace App\Admin\Actions\Grid;

use App\Admin\Forms\ActivityBatchSign;
use App\Models\ActivitySignCom;
use Dcat\Admin\Actions\Response;
use Dcat\Admin\Grid\BatchAction;
use Dcat\Admin\Traits\HasPermissions;
use Dcat\Admin\Widgets\Modal;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class BatchSignNew extends BatchAction
{
    protected $action;

    // 注意action的构造方法参数一定要给默认值
    public function __construct($title = null, $action = 1)
    {
        $this->title = $title;
        $this->action = $action;
    }

    // 确认弹窗信息
    public function confirm()
    {
        return '您确定吗？';
    }

    // 处理请求
    public function handle(Request $request)
    {
        // 获取选中的文章ID数组
        $keys = $this->getKey();

        // 获取请求参数
        $action = $request->get('action');

        $activity_id = $request->get('activity_id');

        if ($action) {
            //报名
            $data = [];
            foreach ($keys as $company_id) {
                $data[] = [
                    'company_id' => $company_id,
                    'activity_id' => $activity_id,
                    'created_at' => date('Y-m-d H:i:s', time())
                ];
            }
            ActivitySignCom::query()->insert($data);
        } else {
            //取消报名
            ActivitySignCom::query()->where('activity_id', $activity_id)
                ->whereIn('company_id', $keys)->delete();
        }
        $message = $action ? '报名成功' : '取消报名成功';

        return $this->response()->success($message)->refresh()->redirect('/activity-sign-com?activity_id='.$activity_id);
    }

    // 设置请求参数
    public function parameters()
    {
        return [
            'action' => $this->action,
            'activity_id' => request()->get('activity_id')
        ];
    }
}
