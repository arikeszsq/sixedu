<?php

use Dcat\Admin\Admin;
use Dcat\Admin\Grid;
use Dcat\Admin\Form;
use Dcat\Admin\Grid\Filter;
use Dcat\Admin\Show;

/**
 * Dcat-admin - admin builder based on Laravel.
 * @author jqh <https://github.com/jqhph>
 *
 * Bootstraper for Admin.
 *
 * Here you can remove builtin form field:
 *
 * extend custom field:
 * Dcat\Admin\Form::extend('php', PHPEditor::class);
 * Dcat\Admin\Grid\Column::extend('php', PHPEditor::class);
 * Dcat\Admin\Grid\Filter::extend('php', PHPEditor::class);
 *
 * Or require js and css assets:
 * Admin::css('/packages/prettydocs/css/styles.css');
 * Admin::js('/packages/prettydocs/js/main.js');
 *
 */

//地图控件
Form\Field\Map::requireAssets();

//把view目录从vendor中复制出来方便修改
app('view')->prependNamespace('admin', resource_path('views/admin'));



//Admin::disablePjax();

//初始化grid参数
Grid::resolving(function (Grid $grid) {
    $grid->filter(function (Grid\Filter $filter){
        $filter->panel();
    });
    $grid->toolsWithOutline(false);
    $grid->disableRefreshButton();
//    $grid->disableBatchActions();
//    $grid->disableQuickEditButton();
//    $grid->disableRowSelector();
//    $grid->disableDeleteButton();
});

//初始化form参数
Form::resolving(function (Form $form) {
    $form->tools(function (Form\Tools $tools) {
        $tools->disableDelete();
    });

    $form->footer(function (Form\Footer $footer) {
        $footer->disableReset();
        $footer->disableViewCheck();
        $footer->disableEditingCheck();
        $footer->disableCreatingCheck();
    });
});

//初始化show参数
Show::resolving(function (Show $show) {
    $show->panel()
        ->tools(function ($tools) {
            $tools->disableDelete();
        });
});
