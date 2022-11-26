<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Grid\AuditUserCashOut;
use App\Models\UserApplyCashOut;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class UserApplyCashOutController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(UserApplyCashOut::with(['user']), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->model()->orderBy('id', 'desc');
            $grid->column('user.name', '申请人姓名');
            $grid->column('apply_money');
            $grid->column('history_total_money');
            $grid->column('current_stay_money');
            $grid->column('created_at','申请时间');

            $grid->column('status')->display(function ($status) {
                return UserApplyCashOut::Status_审核状态[$status];
            })->label([1 => 'danger', 2 => 'success', 3 => 'warning']);


            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
                $filter->like('user.name', '申请人姓名');
            });

            $grid->actions(function (Grid\Displayers\Actions $actions) {
                $status = $actions->row->status;
                if ($status == 1) {//待审核
                    $actions->append(new AuditUserCashOut('<span class="btn btn-sm btn-primary">同意</span>',2));
                    $actions->append(new AuditUserCashOut('<span class="btn btn-sm btn-warning">拒绝</span>',3));
                }
            });

            $grid->disableCreateButton();//禁用创建按钮
            $grid->disableEditButton();
            $grid->disableDeleteButton();

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
        return Show::make($id, new UserApplyCashOut(), function (Show $show) {
            $show->field('id');
            $show->field('user_id');
            $show->field('apply_money');
            $show->field('history_total_money');
            $show->field('current_stay_money');
            $show->field('pay_order');
            $show->field('pay_time');
            $show->field('pay_status');
            $show->field('status');
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
        return Form::make(new UserApplyCashOut(), function (Form $form) {
            $form->display('id');
            $form->text('user_id');
            $form->text('apply_money');
            $form->text('history_total_money');
            $form->text('current_stay_money');
            $form->text('pay_order');
            $form->text('pay_time');
            $form->text('pay_status');
            $form->text('status');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
