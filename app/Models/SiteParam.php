<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteParam extends Model
{
    protected $connection = 'pgsql';
    protected $table = 'site_param';
    protected $primaryKey = 'key';

    public $incrementing = false;
    public $timestamps = false; 

    protected $guarded = [];  
}