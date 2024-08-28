<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FiveDaysTags extends Model
{
    protected $connection = 'pgsql2';
    protected $table = 'five_days_tags';
    protected $primaryKey = 'id';

    public $incrementing = true; 
    public $timestamps = false; 

    protected $guarded = [];  
}