<?php

namespace App\Admin\Forms;

use Dcat\Admin\Widgets\Form;
use Dcat\Admin\Contracts\LazyRenderable;
use Dcat\Admin\Traits\LazyWidget;

use Illuminate\Support\Facades\Log;

use App\Models\StockTagList;
use App\Models\FiveDaysTags;
use App\Models\TenDaysTags;

class SetStockTags extends Form implements LazyRenderable
{
    use LazyWidget;

    /**
     * Handle the form request.
     *
     * @param array $input
     *
     * @return mixed
     */
    public function handle(array $input)
    {
        $swh_id = $this->payload['swh_id'] ?? null;
        $table = $input['table'];

        $tags = $input['tags'];
        $tags_arr = json_decode($tags);

        if ($table === 'five') {
            if (sizeof($tags_arr) === 0) {
                FiveDaysTags::where('swh_id', '=', $swh_id)->delete();
            } else {
                foreach ($tags_arr as $tag) {
                    FiveDaysTags::where('swh_id', '=', $swh_id)->delete();
                    FiveDaysTags::insert(['swh_id' => $swh_id, 'tag' => $tag]);
                }
            }
        } elseif ($table === 'ten') {
            if (sizeof($tags_arr) === 0) {
                TenDaysTags::where('swh_id', '=', $swh_id)->delete();
            } else {
                foreach ($tags_arr as $tag) {
                    TenDaysTags::where('swh_id', '=', $swh_id)->delete();
                    TenDaysTags::insert(['swh_id' => $swh_id, 'tag' => $tag]);
                }
            }
        }
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
        $swh_id = $this->payload['swh_id'] ?? null;

        $this->select('table', '區間')->options(['five' => '五日','ten' => '十日',])
        ->when('five', function (Form $form) use ($swh_id) { // 以例外的觀點：連動還沒被選擇時仍會預先載入
            $form->checkbox('tags', '五日打標')
            ->options(StockTagList::all()->pluck('name','tag'))->default(FiveDaysTags::select('tag')->where('swh_id', '=',  $swh_id)->pluck('tag')->toArray())
            ->saving(function ($value) {
                return json_encode($value);
            });
        })->when('ten', function (Form $form) use ($swh_id) { 
            $form->checkbox('tags', '十日打標')
            ->options(StockTagList::all()->pluck('name','tag'))->default(TenDaysTags::select('tag')->where('swh_id', '=',  $swh_id)->pluck('tag')->toArray())
            ->saving(function ($value) {
                return json_encode($value);
            });
        });


    }
}
