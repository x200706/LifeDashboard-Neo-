<?php

namespace App\Admin\Controllers;

use \Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;

use App\Admin\Metrics\TodayCalorie;

use Illuminate\Support\Facades\Log;

use App\Models\CalorieRecord;
use App\Models\CalorieTags;

use Illuminate\Routing\Controller;

class CalorieRecordController extends AdminController
{
    // /**
    //  * Title for current resource.
    //  *
    //  * @var string
    //  */
    // protected $title = '卡路里紀錄';

    
    public function index(Content $content)
    {
        return $content
            ->header('卡路里紀錄')
            // ->description('表格功能展示')
            ->body(function (Row $row) {
                $row->column(3, new TodayCalorie());
            })
            ->body($this->grid());
    }

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
            $create->multipleSelect('tag', '卡路里標籤')->options(CalorieTags::all()->sortByDesc('type')->pluck('desc','name')->toArray());
            $create->hidden('user_id', '紀錄者')->value(Admin::user()->id);
        });

        $grid->column('date', '日期')->editable();
        $grid->column('name', '名稱')->editable();
        $grid->column('amount', '卡路里')->editable(); 
        $grid->column('tag', '卡路里標籤')->checkbox(CalorieTags::all()->sortByDesc('type')->pluck('desc','name')->toArray(), true);

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
        $form->checkbox('tag', '卡路里標籤')->options(CalorieTags::all()->sortByDesc('type')->pluck('desc','name')->toArray())->saving(function ($value) {
            return json_encode($value);
        });
        
        $form->hidden('user_id', '紀錄者')->value(Admin::user()->id);

        return $form;
    }

}
