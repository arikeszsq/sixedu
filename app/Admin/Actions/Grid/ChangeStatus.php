<?php

namespace App\Admin\Actions\Grid;

use App\Models\Activity;
use Dcat\Admin\Actions\Response;
use Dcat\Admin\Grid\RowAction;
use Dcat\Admin\Traits\HasPermissions;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ChangeStatus extends RowAction
{
    /**
     * @return string
     */
    protected $title = '上架';

    public function __construct($title = null)
    {
        if ($title) {
            $this->title = $title;
        }
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
        $activity_id = $this->getKey();
        $activity = Activity::getActivityById($activity_id);
        $status = $activity->status;
        if ($status == Activity::Status_已上架) {
            Activity::query()->where('id', $activity_id)->update(['status' => Activity::Status_已下架]);
        } else {
            Activity::query()->where('id', $activity_id)->update(['status' => Activity::Status_已上架]);
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
        $status = $this->row->status;
        if($status == 1){
            $title = '下架';
        }else{
            $title = '上架';

        }

        return [
            "活动：".$this->row->title,
            // 确认弹窗 title
            "您确定要".$title."吗？",
            // 确认弹窗 content
        ];
//		 return ['Confirm?', 'contents'];
    }

    /**
     * @param Model|Authenticatable|HasPermissions|null $user
     *
     * @return bool
     */
    protected function authorize($user): bool
    {
        return true;
    }

    /**
     * @return array
     */
    protected function parameters()
    {
        return [];
    }
}
