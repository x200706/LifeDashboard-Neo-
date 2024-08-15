<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CalorieTags extends Model
{
    protected $connection = 'pgsql';
    protected $table = 'calorie_tags';
    protected $primaryKey = 'name';

    public $incrementing = false;
    public $timestamps = false; 

    protected $guarded = [];  
}