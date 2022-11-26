<?php

namespace App\Admin\Controllers;

use App\Models\BasicSetting;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class BasicSettingController extends AdminController
{

    public function index(Content $content)
    {
        $basic_setting = BasicSetting::query()->find(1);
        if ($basic_setting) {
            return admin_redirect('/setting/1/edit');
        } else {
            return admin_redirect('/setting/create');
        }
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new BasicSetting(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('buy_protocal');
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
        return Show::make($id, new BasicSetting(), function (Show $show) {
            $show->field('id');
            $show->field('kf_name');
            $show->field('mobile');
            $show->field('pic');
            $show->field('buy_protocal');
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
        return Form::make(new BasicSetting(), function (Form $form) {
//            $form->display('id');

            $form->editor('buy_protocal');
            $form->image('my_activity_pic','我要做活动联系二维码')->required()->autoUpload();
            $form->mobile('my_activity_mobile','我要做活动联系电话');


            $form->display('created_at');
            $form->display('updated_at');


            $form->tools(function (Form\Tools $tools) {
                $tools->disableDelete();
                $tools->disableView();
                $tools->disableList();
            });

        });
    }
}
