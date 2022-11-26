<?php

namespace App\Admin\Actions\Grid;

use App\Models\Activity;
use App\Models\UserApplyCashOut;
use Dcat\Admin\Actions\Response;
use Dcat\Admin\Grid\RowAction;
use Dcat\Admin\Traits\HasPermissions;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class AuditUserCashOut extends RowAction
{
    public $status;
    public $title;

    public function __construct($title = null, $status = null)
    {
        $this->status = $status;
        $this->title = $title;
        parent::__construct($title);
    }

    /**
     * Handle the action request.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function handle(Request $request)
    {
        $id = $this->getKey();
        $status = $request->get('status');
        UserApplyCashOut::query()->where('id', $id)->update(['status' => $status]);
        if($status==2){
            UserApplyCashOut::PayToUser($id);
        }

        return $this->response()
            ->success('Processed successfully: ' . $this->getKey())
            ->refresh();
    }

    /**
     * @return string|array|void
     */
    public function confirm()
    {

        return [
            "确定：",
            "您确定要" . $this->title . "吗？",
        ];

    }

    public function parameters()
    {
        return [
            // 发送当前行 status 字段数据到接口
            'status' => $this->status
        ];
    }

}
