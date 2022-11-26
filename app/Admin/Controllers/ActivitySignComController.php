<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Grid\BackToActivityList;
use App\Models\ActivitySignCom;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class ActivitySignComController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(ActivitySignCom::with(['activity','company']), function (Grid $grid) {
            $grid->model()->orderBy('id', 'desc');
            $activity_id = request()->get('activity_id');
            if($activity_id){
                $grid->model()->where('activity_id',$activity_id);
            }
            $grid->column('id')->sortable();
            $grid->column('activity.title','活动名称');
            $grid->column('company.name','公司名称');
//            $grid->column('created_at','报名时间')->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
                $filter->like('activity.title','活动名称');
                $filter->like('company.name','公司名称');

            });
            $grid->disableCreateButton();//禁用创建按钮
            $grid->disableRowSelector();//禁用行选择框

            $grid->disableActions();//禁用所有操作
            $grid->tools(function (Grid\Tools $tools) {
                $tools->append(new BackToActivityList());
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
        return Show::make($id, new ActivitySignCom(), function (Show $show) {
            $show->field('id');
            $show->field('activity_id');
            $show->field('company_id');
            $show->field('creater_id');
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
        return Form::make(new ActivitySignCom(), function (Form $form) {
            $form->display('id');
            $form->text('activity_id');
            $form->text('company_id');
            $form->text('creater_id');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
