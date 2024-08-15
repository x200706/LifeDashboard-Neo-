<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CalorieRecord extends Model
{
    protected $connection = 'pgsql';
    protected $table = 'calorie_record';
    protected $primaryKey = 'id';

    public $incrementing = true;
    public $timestamps = false; 

    protected $guarded = [];  
}