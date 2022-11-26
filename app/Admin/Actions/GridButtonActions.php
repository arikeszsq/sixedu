<?php


namespace App\Admin\Actions;


use Dcat\Admin\Grid\Displayers\Actions;

class GridButtonActions extends Actions
{
    /**
     * @return string
     */
    protected function getViewLabel()
    {
//        $label = trans('admin.show') . '👁';
        $label = trans('admin.show');
        return '<span class="btn btn-sm btn-success">' . $label . '</span> &nbsp;';
    }

    /**
     * @return string
     */
    protected function getEditLabel()
    {
//        $label = trans('admin.edit') . '🖊';
        $label = trans('admin.edit');

        return '<span class="btn btn-sm btn-primary">' . $label . '</span> &nbsp;';
    }

    /**
     * @return string
     */
    protected function getQuickEditLabel()
    {
//        $label = trans('admin.edit') . '⚡';
        $label = trans('admin.edit') ;
        $label2 = trans('admin.quick_edit');

        return '<span class="text-blue-darker" title="' . $label2 . '">' . $label . '</span> &nbsp;';
    }

    /**
     * @return string
     */
    protected function getDeleteLabel()
    {
//        $label = trans('admin.delete') . '♻';
        $label = trans('admin.delete');

        return '<span class="btn btn-sm btn-danger">' . $label . '</span> &nbsp;';
    }

}
