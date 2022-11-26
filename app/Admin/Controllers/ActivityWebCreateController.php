<?php

namespace App\Admin\Controllers;

use App\Models\ActivityWebCreate;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class ActivityWebCreateController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new ActivityWebCreate(), function (Grid $grid) {

            $grid->model()->orderBy('id','desc');
            $grid->column('id')->sortable();
            $grid->column('shop_name');
            $grid->column('contacter');
            $grid->column('mobile');
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');

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
        return Show::make($id, new ActivityWebCreate(), function (Show $show) {
            $show->field('id');
            $show->field('shop_name');
            $show->field('contacter');
            $show->field('mobile');
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
        return Form::make(new ActivityWebCreate(), function (Form $form) {
            $form->display('id');
            $form->text('shop_name');
            $form->text('contacter');
            $form->text('mobile');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
