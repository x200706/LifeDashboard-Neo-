<?php

namespace App\Admin\Metrics;

use Dcat\Admin\Widgets\Metrics\Line;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App\Models\CalorieRecord;
use App\Models\CalorieTags;

use Carbon\Carbon;

class ExerciseFrequency extends Line
{
    /**
     * @var string
     */
    protected $label = '半年運動頻率圖表';

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
      $sixMonthsAgo = Carbon::now()->subMonths(6)->format('Y-m-d');
      $allCalorieRecord = CalorieRecord::where('date', '>=', $sixMonthsAgo)->get()->toArray();
      $arrForMonthSum = [];

      // 如果在循環內查詢非常耗能，先查回來存起來
      $allTags = CalorieTags::all()->pluck('type', 'name')->toArray();

      foreach ($allCalorieRecord as $record) {
        $recordTags = json_decode($record['tag']);
        $recordYM = Carbon::createFromFormat('Y-m-d', $record['date'])->format('Ym');
        foreach ($recordTags as $tag) { // 如果是空陣列也就不會進來這邊了
            if ($allTags[$tag] === 'exercise') {
                if (isset($arrForMonthSum[$recordYM])) {
                    $arrForMonthSum[$recordYM] += 1;
                } else {
                    $arrForMonthSum[$recordYM] = 1;
                }
            }
        }
      }
      // 图表数据
      $this->withChart(array_values($arrForMonthSum));
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
                    'name' => $this->label,
                    'data' => $data,
                ],
            ],
        ]);
    }

    /**
     * 设置卡片内容.
     *
     * @param string $content
     *
     * @return $this
     */
    public function withContent($content)
    {
        return $this->content(
            <<<HTML
<div class="d-flex justify-content-between align-items-center mt-1" style="margin-bottom: 2px">
    <span class="mb-0 mr-1 text-80">{$this->label}</span>
</div>
HTML
        );
    }
} 