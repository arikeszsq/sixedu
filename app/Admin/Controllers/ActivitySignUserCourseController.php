<?php

namespace App\Admin\Controllers;

use App\Models\ActivitySignUserCourse;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class ActivitySignUserCourseController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new ActivitySignUserCourse(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('activity_id');
            $grid->column('school_id');
            $grid->column('course_id');
            $grid->column('user_id');
            $grid->column('sign_user_id');
            $grid->column('created_at');
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
        return Show::make($id, new ActivitySignUserCourse(), function (Show $show) {
            $show->field('id');
            $show->field('activity_id');
            $show->field('school_id');
            $show->field('course_id');
            $show->field('user_id');
            $show->field('sign_user_id');
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
        return Form::make(new ActivitySignUserCourse(), function (Form $form) {
            $form->display('id');
            $form->text('activity_id');
            $form->text('school_id');
            $form->text('course_id');
            $form->text('user_id');
            $form->text('sign_user_id');
        
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
