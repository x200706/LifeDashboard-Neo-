<?php

namespace App\Admin\Metrics;

use Dcat\Admin\Widgets\Metrics\Line;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App\Models\CalorieRecord;
use App\Models\CalorieTags;

use Carbon\Carbon;

class CalorieTrend extends Line
{
    /**
     * @var string
     */
    protected $label = '兩個月內每日熱量趨勢';

    /**
     * 初始化卡片内容
     *
     * @return void
     */
    protected function init()
    {
        parent::init();

        $this->title($this->label);
    }

    /**
     * 处理请求
     *
     * @param Request $request
     *
     * @return mixed|void
     */
    public function handle(Request $request)
    {
      $sixtyDaysAgo = Carbon::now()->subDays(60)->format('Y-m-d');
      $allCalorieRecord = CalorieRecord::where('date', '>=', $sixtyDaysAgo)->get()->toArray();
      $arrForDaySum = [];

      foreach ($allCalorieRecord as $record) {
        $recordYMd = Carbon::createFromFormat('Y-m-d', $record['date'])->format('Ymd');
        if (isset($arrForDaySum[$recordYMd])) {
            $arrForDaySum[$recordYMd] += $record['amount'];
        } else {
            $arrForDaySum[$recordYMd] = $record['amount'];
        }
      }
      Log::info($arrForDaySum);
      // 图表数据
      $this->withContent();
      $this->withChart($arrForDaySum);
    }

    /**
     * 设置图表数据.
     *
     * @param array $data
     *
     * @return $this
     */
    public function withChart(array $data)
    {
        return $this->chart([
            'series' => [
                [
                    'name' => '熱量',
                    'data' => array_values($data),
                ],
            ],
            'tooltip' => [
                'x' => [
                    'show' => true,
                ],
            ],
            'xaxis' => [
                'categories' => array_keys($data),
            ]
        ]);
    }

    /**
     * 设置卡片内容.
     *
     * @param string $content
     *
     * @return $this
     */
    public function withContent()
    {
        return $this->content(
            <<<HTML
<div class="d-flex justify-content-between align-items-center mt-1" style="margin-bottom: 2px">
    <h2 class="ml-1 font-lg-1">　</h2>
    <span class="mb-0 mr-1 text-80">　</span>
</div>
HTML
        );
    }
} 