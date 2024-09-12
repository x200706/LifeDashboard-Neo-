<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
	use HasDateTimeFormatter;
    protected $connection = 'pgsql';
    protected $table = 'restaurant';
    protected $primaryKey = 'id';

    public $incrementing = true;
    public $timestamps = false;

    protected $guarded = [];  
}
