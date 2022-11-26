<?php

namespace App\Admin\Controllers;

use App\Models\Award;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class AwardController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Award(), function (Grid $grid) {
            $grid->model()->orderBy('id','desc');
            $grid->column('id')->sortable();
            $grid->column('name');
            $grid->column('logo')->image(env('IMG_SERVE'),'100%','40');
            $grid->column('invite_num');
            $grid->column('status')->select(Award::Status_list);
            $grid->column('is_commander')->select(Award::Yes_1_No_2_list);
            $grid->column('group_ok')->select(Award::Yes_1_No_2_list);

            $grid->quickSearch('name')->placeholder('搜索标题');
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
        return Show::make($id, new Award(), function (Show $show) {
            $show->field('id');
            $show->field('name');
            $show->field('short_name');
            $show->field('logo')->image();
            $show->field('description');
            $show->field('invite_num');
            $show->field('status')->using(Award::Status_list);
            $show->field('price');
            $show->field('is_commander')->using(Award::Yes_1_No_2_list);
            $show->field('group_ok')->using(Award::Yes_1_No_2_list);
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
        return Form::make(new Award(), function (Form $form) {
            $form->display('id');
            $form->text('name');
            $form->text('short_name');
            $form->image('logo')->autoUpload();
            $form->text('description');
            $form->number('invite_num');
            $form->decimal('price');
            $form->select('status')->options(Award::Status_list);
            $form->select('is_commander')->options(Award::Yes_1_No_2_list);
            $form->select('group_ok')->options(Award::Yes_1_No_2_list);
        });
    }
}
