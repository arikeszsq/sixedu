<?php

namespace App\Admin\Controllers;

use App\Models\ActivityViewLog;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class ActivityViewLogController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(ActivityViewLog::with(['user','activity']), function (Grid $grid) {

            $grid->model()->orderBy('id', 'desc');

            $grid->column('id')->sortable();
            $grid->column('activity.title','活动名称');
            $grid->column('user.name','微信昵称');
            $grid->column('created_at','浏览时间');
            $grid->column('updated_at')->sortable();

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
        return Show::make($id, new ActivityViewLog(), function (Show $show) {
            $show->field('id');
            $show->field('activity_id');
            $show->field('user_id');
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
        return Form::make(new ActivityViewLog(), function (Form $form) {
            $form->display('id');
            $form->text('activity_id');
            $form->text('user_id');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
