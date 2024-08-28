<?php

namespace App\Admin\Controllers;

use \Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;

use App\Models\StockTagList;

class StockTagListController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '股票標籤管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new StockTagList);

        $grid->disableCreateButton(); // 禁用新增按鈕
        $grid->disableActions(); // 禁用單行異動按鈕
        $grid->disableFilter(); // 禁用漏斗
        $grid->disableRowSelector(); // 禁用選取
        $grid->disableColumnSelector(); // 禁用像格子圖案的按鈕

        $grid->quickCreate(function (Grid\Tools\QuickCreate $create) {
            $create->text('tag', '標籤系統代號');
            $create->text('name', '標籤名稱');
            $create->text('desc', '標籤敘述');
        });

        $grid->column('tag', '標籤系統代號')->editable();
        $grid->column('name', '標籤名稱')->editable();
        $grid->column('desc', '標籤敘述')->editable();

        return $grid;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new StockTagList);

        $form->text('tag', '標籤系統代號');
        $form->text('name', '標籤名稱');
        $form->text('desc', '標籤敘述');

        return $form;
    }
}
