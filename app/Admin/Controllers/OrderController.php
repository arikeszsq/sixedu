<?php

namespace App\Admin\Controllers;

use App\Models\ActivitySignUser;
use App\Models\ActivitySignUserCourse;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class OrderController extends ActivitySignUserController
{

    public $title='订单';
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(ActivitySignUser::with(['activity']), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->model()->orderBy('id', 'desc');
            $grid->column('activity.title', '活动名称');
            $grid->column('type')->display(function ($type) {
                return ActivitySignUser::type_支付[$type];
            });
            $grid->column('order_no', '订单号');
            $grid->column('sign_name', '报名人信息')->display(function ($sign_name) {
                $sex = '';
                if (isset($this->sign_sex) && $this->sign_sex) {
                    $sex .= ActivitySignUser::Sex_List[$this->sign_sex];
                }
                return $sign_name . '-' . $this->sign_mobile . '-' . $sex . $this->sign_age . '岁';
            });
//            $grid->column('sign_mobile');
//            $grid->column('sign_age');
//            $grid->column('sign_sex')->display(function ($sign_sex) {
//                return ActivitySignUser::Sex_List[$sign_sex];
//            });
            $grid->column('status', '状态')->display(function ($status) {
                return ActivitySignUser::Status_支付[$status];
            })->label([1 => 'danger', 2 => 'warning', 3 => 'success']);
            $grid->column('created_at');

            $grid->filter(function (Grid\Filter $filter) {
                $filter->expand();
                $filter->equal('id')->width(3);
                $filter->like('activity.title', '活动名称')->width(3);
                $filter->like('order_no', '订单号')->width(3);
                $filter->like('sign_name', '报名人姓名')->width(3);
                $filter->like('sign_mobile', '报名人手机号')->width(3);
                $filter->like('status', '状态')->select(ActivitySignUser::Status_支付)->width(3);
            });

            $grid->disableCreateButton();//禁用创建按钮
            $grid->disableEditButton();//禁用编辑
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
        return Show::make($id, ActivitySignUser::with(['activity','group','user']), function (Show $show) {
            $show->field('id');
            $show->field('activity.title','活动名称');
            $show->field('group.name','团名');
            $show->field('role');
            $show->role('身份')->using([1 => '团长', 2 => '团员']);
            $show->field('user.name','姓名');
            $show->divider();
            $show->type('购买方式')->using([1 => '团购', 2 => '单独购买']);
            $show->field('order_no','订单号');
            $show->field('money','订单金额');
            $show->has_pay('付款状态')->using([1 => '待支付', 2 => '支付取消',3=>'支付成功']);
            $show->field('pay_time','付款时间');
            $show->divider();
            $show->field('sign_name','报名人');
            $show->field('sign_mobile','报名手机号');
            $show->divider();
            $show->field('sign_age','报名人年龄');
            $show->sign_sex('报名人性别')->using([1 => '男', 2 => '女']);
            $show->field('info_one','信息一');
            $show->field('info_two','信息二');
            $show->relation('courses','课程信息', function ($model) {
                $grid = new Grid(ActivitySignUserCourse::with(['school','course']));
                $grid->model()->where('order_num', $model->order_no);
//                $grid->number();
//                $grid->id();
                $grid->column('school.name', '学校名称');
                $grid->column('course.name', '课程名称');
                $grid->filter(function ($filter) {
//                    $filter->like('')->width('300px');
                });
                $grid->disableCreateButton();//禁用创建按钮
                $grid->disableActions();//禁用所有操作
                return $grid;
            });
//            $show->field('is_agree');
            $show->field('created_at');
            $show->field('updated_at');

            $show->panel()
                ->tools(function ($tools) {
                    $tools->disableEdit();
//                    $tools->disableList();
                    $tools->disableDelete();
                    // 显示快捷编辑按钮
//                    $tools->showQuickEdit();
                });

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
