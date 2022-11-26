<?php

namespace App\Admin\Actions\Grid;

use App\Admin\Forms\ActivityBatchSign;
use Dcat\Admin\Actions\Response;
use Dcat\Admin\Grid\BatchAction;
use Dcat\Admin\Traits\HasPermissions;
use Dcat\Admin\Widgets\Modal;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class BatchSign extends BatchAction
{
    protected $title = '活动报名';

    public function render()
    {
        // 实例化表单类
        $form = ActivityBatchSign::make();

        return Modal::make()
            ->lg()
            ->title($this->title)
            ->body($form)
            // 因为此处使用了表单异步加载功能，所以一定要用 onLoad 方法
            // 如果是非异步方式加载表单，则需要改成 onShow 方法
            ->onLoad($this->getModalScript())
            ->button($this->title);
    }

    protected function getModalScript()
    {
        // 弹窗显示后往隐藏的id表单中写入批量选中的行ID
        return <<<JS
// 获取选中的ID数组
var key = {$this->getSelectedKeysScript()}

$('#select-ids').val(key);
JS;
    }
}
