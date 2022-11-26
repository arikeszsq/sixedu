<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Grid\BackToActivityList;
use App\Admin\Actions\Grid\BatchSign;
use App\Admin\Actions\Grid\BatchSignNew;
use App\Admin\Actions\Grid\RowSign;
use App\Models\Company;
use App\Models\CompanyCourse;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class CompanyController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Company(), function (Grid $grid){

            $grid->model()->orderBy('id', 'desc');

            $grid->column('id')->sortable();
            $grid->column('name');
            $grid->column('short_name');
            $grid->column('intruduction');
            $grid->column('video_url');
            $grid->column('creater_id');
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');

            });

            $grid->batchActions([
                new BatchSignNew('报名', 1),
                new BatchSignNew('取消报名', 0)
            ]);


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
        return Show::make($id, new Company(), function (Show $show) {
            $show->field('id');
            $show->field('name');
            $show->field('short_name');
            $show->field('intruduction');
            $show->field('video_url');
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
        return Form::make(Company::with(['children', 'courses']), function (Form $form) {
            $form->display('id');
            $form->text('name');
            $form->text('short_name');
            $form->text('intruduction');
            $form->image('logo')->width(6);
            $form->file('video_url')->width(6);

//            因为要添加经纬度，所有不想在这里加了，因为是别人写的地图插件，这里加的，只能定位一个
//            $form->hasMany('children', function (Form\NestedForm $form) {
//                $form->width(2)->text('name');
//                $form->width(2)->text('map_area','校区地址');
//            })->useTable()->label('校区')->required();

            $form->hasMany('courses', function (Form\NestedForm $form) {
                $form->select('type')->options(CompanyCourse::Type_类型列表)->width(3);
                $form->image('logo')->width(3);
                $form->text('name')->width(3);
                $form->decimal('price', '价格')->width(3);
                $form->number('total_num', '名额数')->width(3);
            })->label('课程')->required();


            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
