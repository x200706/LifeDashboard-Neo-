<?php

namespace App\Admin\Actions\Grid;

use App\Admin\Forms\SetDailyCalorie;
use Dcat\Admin\Grid\Tools\AbstractTool;
use Dcat\Admin\Widgets\Modal;


class SetDailyCalorieTool extends AbstractTool
{

    public function render()
    {
        return Modal::make()
        ->lg()
        ->title('設定每日熱量')
        ->body(SetDailyCalorie::make())
        ->button('<button class="btn btn-primary">設定每日熱量</button>');
    }
}
