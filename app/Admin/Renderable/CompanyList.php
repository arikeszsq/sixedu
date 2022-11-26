<?php


namespace App\Admin\Renderable;

use Dcat\Admin\Grid;
use Dcat\Admin\Grid\LazyRenderable;
use App\Admin\Actions\Grid\BatchSign;
use App\Admin\Actions\Grid\RowSign;
use App\Models\Company;
class CompanyList extends LazyRenderable
{
    public function grid() : Grid
    {
        return Grid::make(new Company(), function (Grid $grid) {
            $grid->model()->orderBy('id', 'desc');
            $grid->column('id')->sortable();
            $grid->column('name');
            $grid->batchActions([new BatchSign()]);
        });
    }
}
