<?php

use Dcat\Admin\Admin;
use Dcat\Admin\Grid;
use Dcat\Admin\Form;
use Dcat\Admin\Grid\Filter;
use Dcat\Admin\Show;

/**
 * Dcat-admin - admin builder based on Laravel.
 * @author jqh <https://github.com/jqhph>
 *
 * Bootstraper for Admin.
 *
 * Here you can remove builtin form field:
 *
 * extend custom field:
 * Dcat\Admin\Form::extend('php', PHPEditor::class);
 * Dcat\Admin\Grid\Column::extend('php', PHPEditor::class);
 * Dcat\Admin\Grid\Filter::extend('php', PHPEditor::class);
 *
 * Or require js and css assets:
 * Admin::css('/packages/prettydocs/css/styles.css');
 * Admin::js('/packages/prettydocs/js/main.js');
 *
 */
Admin::style('
body.dark-mode a {
    color: #a8a9bb!important;
}
body.dark-mode .btn-primary.btn-outline {
    color: #a8a9bb!important;
    border-color: #a8a9bb!important;
}
body.dark-mode .popover {
    background-color: #223!important;
}
.select2-container--default .select2-search--inline .select2-search__field, .select2-container--default .select2-selection--single .select2-selection__rendered {
    font-size: 14px!important;
}
input, input::placeholder {
    font-size: 14px !important;
}');