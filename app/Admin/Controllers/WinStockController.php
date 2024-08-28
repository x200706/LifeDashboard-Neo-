<?php

namespace App\Admin\Controllers;

use \Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;

use App\Models\WinStock;
use App\Models\FiveDaysTags;
use App\Models\TenDaysTags;

use App\Admin\Actions\Grid\SetStockTagsTool;
use App\Models\StockTagList;

class WinStockController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '隔日上漲股票清單';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new WinStock);
        $grid->model()->orderBy('id', 'desc');

        $grid->disableCreateButton(); // 禁用新增按鈕
        // $grid->disableActions(); // 禁用單行異動按鈕
        $grid->disableRowSelector(); // 禁用選取
        $grid->disableColumnSelector(); // 禁用像格子圖案的按鈕

        $grid->actions(function (Grid\Displayers\Actions $actions) {
            $actions->disableDelete();
            $actions->disableEdit();
            $actions->disableQuickEdit();
            $actions->disableView();
        });
        // $grid->setActionClass(Grid\Displayers\Actions::class);
        $grid->actions([new SetStockTagsTool()]);

        $grid->filter(function($filter){
            $filter->expand();
            $filter->panel();
        
            $filter->equal('stock_code', '股票代號')->width(3);
            $filter->equal('stock_name', '股票名稱')->width(3);
            $filter->date('today', '當天日期')->width(3);           
        });

        $grid->column('id', 'id')->sortable();
        $grid->column('stock_code', '股票代號');
        $grid->column('stock_name', '股票名稱');
        $grid->column('lastday', '前一天日期'); // 因為開盤日的前一天不一定是昨天啊~
        $grid->column('today', '當天日期'); // 其實當天的英文是that day
        $grid->column('lastday_close', '前一天收盤價');
        $grid->column('today_close', '當天收盤價')->sortable();
        $grid->column('increase', '漲幅')->display(function () {
            $increase = number_format(($this->today_close - $this->lastday_close) / $this->lastday_close * 100, 2);
            return $increase > 0 ? "<span style='color:#e771ad'>$increase%</span>" : "<span style='color:#a1d174'>$increase%</span>";
        });
        $grid->column('five_days_tag', '五日標籤')->display(function () {
            $swh_id = $this->id;
            $tags = FiveDaysTags::where('swh_id', '=', $swh_id)->pluck('tag')->toArray();
            $html = '';
            foreach ($tags as $tag) {
                $tag_name = StockTagList::where('tag', '=', $tag)->first()->name;
                $html .= "<span class='label' style='background:#6b794a'>$tag_name</span><br>";
            }
            return $html;
        });
        $grid->column('ten_days_tag', '十日標籤')->display(function () {
            $swh_id = $this->id;
            $tags = TenDaysTags::where('swh_id', '=', $swh_id)->pluck('tag')->toArray();
            $html = '';
            foreach ($tags as $tag) {
                $tag_name = StockTagList::where('tag', '=', $tag)->first()->name;
                $html .= "<span class='label' style='background:#6b794a'>$tag_name</span><br>";
            }
            return $html;
        });

        return $grid;
    }
}
