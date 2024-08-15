<?php

namespace App\Admin\Controllers;

use \Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;

use Illuminate\Support\Facades\Log;

use App\Models\CalorieRecord;
use App\Models\CalorieTags;

class CalorieRecordController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '卡路里紀錄';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new CalorieRecord);

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
            $create->text('name', '名稱');
            $create->integer('amount', '卡路里');
            $create->select('tag', '卡路里分類')->options(CalorieTags::all()->sortByDesc('type')->pluck('desc','name')->toArray());
            $create->select('is_prototype', '原型食物')->options([0 => '否或運動', 1 => '是'])->default(0); // 連動表單有點麻煩，而且無論快速新增跟行內編輯應該都不支援，不如data維持一致性
            $create->hidden('user_id', '紀錄者')->value(Admin::user()->id);
        });

        $grid->column('date', '日期')->editable();
        $grid->column('name', '名稱')->editable();
        $grid->column('amount', '卡路里')->editable();
        $grid->column('tag', '卡路里分類')->select(CalorieTags::all()->sortByDesc('type')->pluck('desc','name')->toArray());
        $grid->column('is_prototype', '原型食物')->select([0 => '否或運動', 1 => '是']);

        return $grid;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $call = $this;
        
        $form = new Form(new CalorieRecord);

        $form->date('date', '日期');
        $form->text('name', '名稱');
        $form->number('amount', '卡路里');
        $form->select('tag', '卡路里分類')->options(CalorieTags::all()->sortByDesc('type')->pluck('desc','name')->toArray());
        $form->select('is_prototype', '原型食物')->options([0 => '否或運動', 1 => '是'])->default(0);
        $form->hidden('user_id', '紀錄者')->value(Admin::user()->id);

        return $form;
    }

}
