<?php

namespace App\Admin\Controllers;

use App\Models\ActivityGroup;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class ActivityGroupController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(ActivityGroup::with(['activity','openuser','user']), function (Grid $grid) {
            $grid->model()->orderBy('id', 'desc');
            $grid->column('id')->sortable();
            $grid->column('activity.title','活动名称');
            $grid->column('name');
            $grid->column('user.name','团长');
            $grid->column('openuser.name','开团人');
            $grid->column('success_time');
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
                $filter->like('activity.title','活动名称');
                $filter->like('user.name','团长');
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
        return Show::make($id, new ActivityGroup(), function (Show $show) {
            $show->field('id');
            $show->field('activity_id');
            $show->field('name');
            $show->field('leader_id');
            $show->field('creater_id');
            $show->field('success_time');
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
        return Form::make(new ActivityGroup(), function (Form $form) {
            $form->display('id');
            $form->text('activity_id');
            $form->text('name');
            $form->text('leader_id');
            $form->text('creater_id');
            $form->text('success_time');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
