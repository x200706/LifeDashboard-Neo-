<?php

namespace App\Admin\Controllers;

use \Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;

use App\Models\AccountRecordTags;

class AccountRecordTagsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '記帳類別管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new AccountRecordTags);

        $grid->disableCreateButton(); // 禁用新增按鈕
        $grid->disableActions(); // 禁用單行異動按鈕
        $grid->disableFilter(); // 禁用漏斗
        // $grid->disableExport(); // 禁用匯出
        $grid->disableRowSelector(); // 禁用選取
        $grid->disableColumnSelector(); // 禁用像格子圖案的按鈕

        $grid->quickCreate(function (Grid\Tools\QuickCreate $create) {
            $create->text('name', '類別代號');
            $create->text('desc', '顯示名稱');
        });

        $grid->column('name', '類別代號')->editable();
        $grid->column('desc', '顯示名稱')->editable();
        // 只能多不能少；暫時沒有軟刪除功能
        // 或是說刪除分類同時，要把符合該類別的記帳順便還原為未分類

        return $grid;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new AccountRecordTags);

        $form->text('name', '類別代號');
        $form->text('desc', '顯示名稱');

        return $form;
    }
}
