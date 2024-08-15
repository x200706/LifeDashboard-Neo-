<?php

namespace App\Admin\Controllers;

use \Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;

use App\Models\CalorieTags;

class CalorieTagsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '卡路里類別管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new CalorieTags);
        $grid->model()->orderBy('type', 'desc');

        $grid->disableCreateButton(); // 禁用新增按鈕
        $grid->disableActions(); // 禁用單行異動按鈕
        $grid->disableFilter(); // 禁用漏斗
        // $grid->disableExport(); // 禁用匯出
        $grid->disableRowSelector(); // 禁用選取
        $grid->disableColumnSelector(); // 禁用像格子圖案的按鈕

        $grid->quickCreate(function (Grid\Tools\QuickCreate $create) {
            $create->text('name', '類別代號');
            $create->text('desc', '顯示名稱');
            $create->select('type', '類型')->options(['food' => '食物','exercise' => '運動',])->default('food'); 
        });

        $grid->column('name', '類別代號')->editable();
        $grid->column('desc', '顯示名稱')->editable();
        $grid->column('type', '類型')->select(['food' => '食物','exercise' => '運動',]); 

        return $grid;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new CalorieTags);

        $form->text('name', '類別代號');
        $form->text('desc', '顯示名稱');
        $form->select('type', '類型')->options(['food' => '食物','exercise' => '運動',])->default('food'); 

        return $form;
    }
}
