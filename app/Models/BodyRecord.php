<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class BodyRecord extends Model
{
	use HasDateTimeFormatter;
    protected $connection = 'pgsql';
    protected $table = 'body_record';
    protected $primaryKey = 'id';

    public $incrementing = true;
    public $timestamps = false;

    protected $guarded = [];  
}
