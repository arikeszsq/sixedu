<?php

namespace App\Admin\Controllers;

use App\Models\CompanyCourse;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class CompanyCourseController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new CompanyCourse(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('type');
            $grid->column('company_Id');
            $grid->column('logo');
            $grid->column('name');
            $grid->column('price');
            $grid->column('total_num');
            $grid->column('sale_num');
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
        return Show::make($id, new CompanyCourse(), function (Show $show) {
            $show->field('id');
            $show->field('type');
            $show->field('company_Id');
            $show->field('logo');
            $show->field('name');
            $show->field('price');
            $show->field('total_num');
            $show->field('sale_num');
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
        return Form::make(new CompanyCourse(), function (Form $form) {
            $form->display('id');
            $form->text('type');
            $form->text('company_Id');
            $form->text('logo');
            $form->text('name');
            $form->text('price');
            $form->text('total_num');
            $form->text('sale_num');
        
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
