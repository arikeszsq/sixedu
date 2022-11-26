<?php

namespace App\Admin\Controllers;

use App\Http\Traits\WeChatTrait;
use App\Models\Activity;
use App\Models\UserAInvitePic;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class UserAInvitePicController extends AdminController
{
    use WeChatTrait;
    /**
     * 设置用户为A用户的二维码图片
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(UserAInvitePic::with(['activity']), function (Grid $grid) {
            $grid->model()->orderBy('id', 'desc');
            $grid->column('id')->sortable();
//            $grid->column('activity.title','活动名称');
            $grid->column('invite_pic');
            $grid->column('start_time');
            $grid->column('end_time');
            $grid->column('created_at');

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');

            });
        });
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id)
    {
        return Show::make($id, UserAInvitePic::with(['activity']), function (Show $show) {
            $show->field('id');
//            $show->field('activity.title','活动名称');
            $show->field('invite_pic');
            $show->field('start_time');
            $show->field('end_time');
            $show->field('created_at');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new UserAInvitePic(), function (Form $form) {
            $form->display('id');
//            $options = Activity::getActivityListOptions();
//            $form->select('activity_id','活动')->options($options)->required();
            $form->datetime('start_time');
            $form->datetime('end_time');

            $form->hidden('invite_pic');

            //activity_id 设置为999999
            $form->saving(function (Form $form) {
                $form->invite_pic = $this->getShareQCode(999999);
            });

        });
    }
}
