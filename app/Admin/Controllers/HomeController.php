<?php

namespace App\Admin\Controllers;

use App\Admin\Metrics\Examples;
use App\Http\Controllers\Controller;
use Dcat\Admin\Http\Controllers\Dashboard;
use Dcat\Admin\Layout\Column;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;

class HomeController extends Controller
{
    public function index(Content $content)
    {
        return $content
            ->header('生活後台')
            ->description('可以做很多事情')
            ->body(function (Row $row) {
                $row->column(6, function (Column $column) {
                    $column->row('首頁內容募集中');
                });

                $row->column(6, function (Column $column) {
                    // 暫時沒東西
                });
            });
    }
}
