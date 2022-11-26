<?php

namespace App\Admin\Controllers;

use App\Models\UserActivityInvite;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class UserActivityInviteController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(UserActivityInvite::with(['activity', 'inviteUser', 'parentUser', 'aUser']), function (Grid $grid) {
            $grid->model()->orderBy('id','desc');
            $grid->column('id')->sortable();
            $grid->column('activity.title','活动名称');
            $grid->column('inviteUser.name', '被邀请人');
            $grid->column('parentUser.name', '直接邀请人');
            $grid->column('aUser.name', '一级邀请人');
            $grid->column('has_pay')->display(function ($has_pay) {
                return $has_pay == 1 ? '已支付' : '未支付';
            })->label([1 => 'danger', 2 => 'success']);
            $grid->column('created_at')->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->expand();
                $filter->equal('id')->width(3);
                $filter->like('inviteUser.name', '被邀请人')->width(3);
                $filter->like('parentUser.name', '直接邀请人')->width(3);
                $filter->like('aUser.name', '一级邀请人')->width(3);
                $filter->equal('has_pay')->select([1 => '已支付', 2 => '未支付'])->width(3);
            });

            $grid->disableCreateButton();//禁用创建按钮
            $grid->disableActions();//禁用所有操作
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
        return Show::make($id, new UserActivityInvite(), function (Show $show) {
            $show->field('id');
            $show->field('activity_id');
            $show->field('A_user_id');
            $show->field('parent_user_id');
            $show->field('invited_user_id');
            $show->field('has_pay');
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new UserActivityInvite(), function (Form $form) {
            $form->display('id');
            $form->text('activity_id');
            $form->text('A_user_id');
            $form->text('parent_user_id');
            $form->text('invited_user_id');
            $form->text('has_pay');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
