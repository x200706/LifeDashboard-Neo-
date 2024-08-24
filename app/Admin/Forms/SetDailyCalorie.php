<?php

namespace App\Admin\Forms;

use App\Models\SiteParam;
use Dcat\Admin\Widgets\Form;

use Illuminate\Support\Facades\Log;

class SetDailyCalorie extends Form
{
    /**
     * Handle the form request.
     *
     * @param array $input
     *
     * @return mixed
     */
    public function handle(array $input)
    {
        /*
        Log::info($input);
        [2024-08-24 13:43:51] local.INFO: array (
            'key' => 'daily_calorie_limit',
            'value' => '1600',
        )  
        */
        // return $this->response()->error('Your error message.');

        SiteParam::where('key', '=', $input['key'])->update(['value_array' => [$input['value']]]);;

        return $this
				->response()
				->success('設定成功！')
				->refresh();
    }

    /**
     * Build a form here.
     */
    public function form()
    {
        $this->hidden('key')->default('daily_calorie_limit');
        // 輸入熱量數字，然而這不是最後要新增的
        $currentSettingDailyCalorie = json_decode(SiteParam::where('key', '=', 'daily_calorie_limit')->first()->value_array)[0];
        $this->number('value', '設定每日熱量')->rules('regex:/^[1-9][0-9]*$/|min:1')->default($currentSettingDailyCalorie);
    }
}
