<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TenDaysTags extends Model
{
    protected $connection = 'pgsql2';
    protected $table = 'ten_days_tags';
    protected $primaryKey = 'id';

    public $incrementing = true; 
    public $timestamps = false; 

    protected $guarded = [];  
}