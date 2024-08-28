<?php

namespace App\Admin\Actions\Grid;

use App\Admin\Forms\SetStockTags;
use Dcat\Admin\Grid\Tools\AbstractTool;
use Dcat\Admin\Widgets\Modal;


class SetStockTagsTool extends AbstractTool
{

    public function render()
    {
        $form = SetStockTags::make()->payload(['swh_id' => $this->getKey()]);
        
        return Modal::make()
        ->lg()
        ->title('設置股票標籤')
        ->body($form)
        ->button('<button class="btn btn-primary">設置股票標籤</button>');
    }
}
