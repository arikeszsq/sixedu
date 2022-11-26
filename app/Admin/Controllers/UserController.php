<?php

namespace App\Admin\Controllers;

use App\Models\User;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class UserController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new User(), function (Grid $grid) {
            $grid->model()->orderBy('id', 'desc');
            $grid->column('id')->sortable();
            $grid->column('name','微信昵称');
            $grid->column('is_A','是否A用户')->select(\App\User::IsA_Option);
            $grid->column('avatar')->image('','100%','40');
//            $grid->column('gender','性别');
            $grid->column('address','家的地址');
            $grid->column('created_at')->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->expand();
                $filter->equal('id')->width(3);
                $filter->like('name')->width(3);
                $filter->like('is_A')->width(3);
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
        return Show::make($id, new User(), function (Show $show) {
            $show->field('id');
            $show->field('is_A');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new User(), function (Form $form) {
            $form->display('id');
            $form->select('is_A','是否A用户')->options(\App\User::IsA_Option);
        });
    }
}
