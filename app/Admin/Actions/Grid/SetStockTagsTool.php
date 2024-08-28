<?php

namespace App\Admin\Actions\Grid;

use App\Admin\Forms\SetStockTags;
use Dcat\Admin\Grid\RowAction;
use Dcat\Admin\Widgets\Modal;


class SetStockTagsTool extends RowAction
{

    public function render()
    {
        $form = SetStockTags::make()->payload(['swh_id' => $this->getKey()]);
        
        return Modal::make()
        ->lg()
        ->title('設置股票標籤')
        ->body($form)
        ->button('設置股票標籤');
    }
}
