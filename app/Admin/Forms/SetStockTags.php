<?php

namespace App\Admin\Forms;

use Dcat\Admin\Widgets\Form;
use Dcat\Admin\Contracts\LazyRenderable;

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

        if ($table === 'five') {
            foreach ($tags as $tag) {
                FiveDaysTags::insert(['swh_id' => $swh_id, 'tag' => $tag]);
            }
        } elseif ($table === 'ten') {
            foreach ($tags as $tag) {
                TenDaysTags::insert(['swh_id' => $swh_id, 'tag' => $tag]);
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
        $this->select('table', '區間')->options(['five' => '五日','ten' => '十日',]);
        $this->checkbox('tags', '打標')
        ->options(StockTagList::all()->pluck('name','tag'))
        ->saving(function ($value) {
            return json_encode($value);
        });

    }
}
