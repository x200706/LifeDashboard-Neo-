<?php

namespace App\Admin\Controllers;

use App\Models\BodyRecord;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class BodyRecordController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '身體素質記錄';


    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new BodyRecord(), function (Grid $grid) {

            $grid->model()->where('user_id', '=', Admin::user()->id)->orderBy('date', 'desc');

            $grid->disableCreateButton(); // 禁用新增按鈕
            $grid->disableFilter(); // 禁用漏斗
            // $grid->disableExport(); // 禁用匯出
            $grid->disableRowSelector(); // 禁用選取
            $grid->disableColumnSelector(); // 禁用像格子圖案的按鈕

            // 禁用個別單行異動按鈕
            $grid->actions(function ($actions) {        
                // 去掉编辑
                $actions->disableEdit();
                // 去掉查看
                $actions->disableView();
            });

            $grid->quickCreate(function (Grid\Tools\QuickCreate $create) { // 注意到匿名函數裡面可以用最外面的use？！
                $create->date('date', '日期');
                $create->text('weight', '體重');
                $create->text('fat', '體脂肪');
                $create->select('is_sp_day', '特殊日（生理期或腸胃炎）')->options([0=>'否', 1=>'☑️是'])->default(0);
                $create->hidden('user_id', '紀錄者')->value(Admin::user()->id);
            });

            $grid->column('date', '日期')->editable();
            $grid->column('weight', '體重')->editable();
            $grid->column('fat', '體脂肪')->editable();
            $grid->column('is_sp_day', '特殊日（生理期或腸胃炎）')->select([0=>'否', 1=>'☑️是']);
        
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new BodyRecord(), function (Form $form) {
            $form->date('date', '日期');
            $form->number('weight', '體重');
            $form->number('fat', '體脂肪');
            $form->select('is_sp_day', '特殊日（生理期或腸胃炎）')->options([0=>'否', 1=>'☑️是'])->default(0);
            $form->hidden('user_id', '紀錄者')->value(Admin::user()->id);
        });
    }
}
