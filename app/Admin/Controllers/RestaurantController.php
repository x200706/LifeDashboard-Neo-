<?php

namespace App\Admin\Controllers;

use App\Models\Restaurant;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

use Illuminate\Support\Facades\Log;

class RestaurantController extends AdminController
{

    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '餐廳決定器';
    
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Restaurant(), function (Grid $grid) {

            // $grid->disableCreateButton(); // 禁用新增按鈕
            $grid->disableFilter(); // 禁用漏斗
            // $grid->disableExport(); // 禁用匯出
            $grid->disableRowSelector(); // 禁用選取
            $grid->disableColumnSelector(); // 禁用像格子圖案的按鈕

            // 禁用個別單行異動按鈕
            $grid->actions(function ($actions) {        
                // 去掉查看
                $actions->disableView();
            });

            $grid->selector(function (Grid\Tools\Selector $selector) {
                $selector->select('zone', '地區', Restaurant::all()->pluck('zone', 'zone')->toArray());

                $price_level = Restaurant::all()->pluck('price_level', 'price_level')->map(function($level) {
                    return str_repeat('★', $level);
                })->toArray();
                $selector->select('price_level', '價位', $price_level);

                $selector->select('style', '風格', Restaurant::all()->pluck('style', 'style')->toArray());

                $element_result = Restaurant::all()->pluck('element')->toArray();
                $elements = [];
                foreach ($element_result as $element) {
                    $elements = array_merge($elements, json_decode($element, true));
                }
                $uniqueElements = array_values(array_unique($elements));
                $selector->select('element', '主食類型', $uniqueElements); 
            });

            $grid->column('name', '名稱');
            $grid->column('zone', '地區');

            $grid->column('price_level', '價位')
            ->using([1 =>'★', 2 => '★★', 3 => '★★★', 4 => '★★★★', 5 => '★★★★★'])->badge([
                'default' => '#c2638b',  
                1 => '#c2638b',
                2 => '#c48d58',
                3 => '#81b058',
                4 => '#5488b0',
                5 => '#7357ab',
            ])->sortable();

            $grid->column('style', '風格');

            $grid->column('element', '主食類型')->display(function ($element) {
                return json_decode($element, true); // 字串型別的json還原回php array
            })->label();
            
            $grid->column('memo', '備註');
        });
    }

    // /**
    //  * Make a show builder.
    //  *
    //  * @param mixed $id
    //  *
    //  * @return Show
    //  */
    // protected function detail($id)
    // {
    //     return Show::make($id, new Restaurant(), function (Show $show) {
    //         $show->field('id');
    //         $show->field('name');
    //         $show->field('zone');
    //         $show->field('price_level');
    //         $show->field('style');
    //         $show->field('element');
    //         $show->field('memo');
    //     });
    // }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Restaurant(), function (Form $form) {
            $form->text('name', '名稱');
            $form->text('zone', '地區');
            $form->select('price_level', '價位')->options([1 =>'★', 2 => '★★', 3 => '★★★', 4 => '★★★★', 5 => '★★★★★']);
            $form->text('style', '風格');
            $form->tags('element', '主食類型')->placeholder('請用逗號分隔')->saving(function ($value) {
                return json_encode($value, JSON_UNESCAPED_UNICODE);
            });
            $form->textarea('memo', '備註');
        });
    }
}
