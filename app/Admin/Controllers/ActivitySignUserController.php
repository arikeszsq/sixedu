<?php

namespace App\Admin\Controllers;

use App\Models\ActivitySignUser;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class ActivitySignUserController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(ActivitySignUser::with(['activity']), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('activity.title', '活动名称');
            $grid->column('type')->display(function ($type) {
                return ActivitySignUser::type_支付[$type];
            });
            $grid->column('order_no');
            $grid->column('status')->display(function ($status) {
                return ActivitySignUser::Status_支付[$status];
            });
            $grid->column('sign_name','报名用户姓名');
            $grid->column('sign_mobile','报名用户手机号');
            $grid->column('sign_age','报名用户年龄');
            $grid->column('sign_sex')->display(function ($sign_sex) {
                return ActivitySignUser::Sex_List[$sign_sex];
            });
            $grid->column('created_at');

            $grid->filter(function (Grid\Filter $filter) {
                $filter->expand();
                $filter->equal('id')->width(3);
                $filter->like('activity.title', '活动名称')->width(3);
                $filter->like('order_no')->width(3);
                $filter->like('sign_name')->width(3);
                $filter->like('sign_mobile')->width(3);
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
        return Show::make($id, new ActivitySignUser(), function (Show $show) {
            $show->field('id');
            $show->field('activity_id');
            $show->field('group_id');
            $show->field('role');
            $show->field('user_id');
            $show->field('type');
            $show->field('creater_id');
            $show->field('share_q_code');
            $show->field('order_no');
            $show->field('money');
            $show->field('has_pay');
            $show->field('status');
            $show->field('pay_time');
            $show->field('pay_cancel_time');
            $show->field('sign_name');
            $show->field('sign_mobile');
            $show->field('sign_age');
            $show->field('sign_sex');
            $show->field('is_agree');
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
        return Form::make(new ActivitySignUser(), function (Form $form) {
            $form->display('id');
            $form->text('activity_id');
            $form->text('group_id');
            $form->text('role');
            $form->text('user_id');
            $form->text('type');
            $form->text('creater_id');
            $form->text('share_q_code');
            $form->text('order_no');
            $form->text('money');
            $form->text('has_pay');
            $form->text('status');
            $form->text('pay_time');
            $form->text('pay_cancel_time');
            $form->text('sign_name');
            $form->text('sign_mobile');
            $form->text('sign_age');
            $form->text('sign_sex');
            $form->text('is_agree');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
