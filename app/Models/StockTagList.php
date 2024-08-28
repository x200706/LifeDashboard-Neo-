<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockTagList extends Model
{
    protected $connection = 'pgsql2';
    protected $table = 'stock_tag_list';
    protected $primaryKey = 'tag';

    public $incrementing = false; 
    public $timestamps = false; 

    protected $guarded = [];  
}