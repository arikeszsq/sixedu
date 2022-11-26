<?php

namespace App\Admin\Controllers;

use App\Models\UserAward;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class UserAwardController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(UserAward::with(['activity','award','user']), function (Grid $grid) {

            $grid->disableCreateButton();//禁用创建按钮
            $grid->disableActions();//禁用所有操作

            $grid->model()->orderBy('id','desc');
            $grid->column('id')->sortable();
            $grid->column('activity.title','活动名称');
            $grid->column('user.name','用户名');
            $grid->column('award.name','奖品名称');
            $grid->column('created_at','领取时间');
            $grid->filter(function (Grid\Filter $filter) {
                $filter->expand();
                $filter->equal('id')->width(6);
                $filter->like('activity.title', '活动名称')->width(6);
                $filter->like('user.name', '用户名')->width(6);
                $filter->like('award.name', '奖品名称')->width(6);
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
        return Show::make($id, new UserAward(), function (Show $show) {
            $show->field('id');
            $show->field('activity_id');
            $show->field('user_id');
            $show->field('award_id');
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
        return Form::make(new UserAward(), function (Form $form) {
            $form->display('id');
            $form->text('activity_id');
            $form->text('user_id');
            $form->text('award_id');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
