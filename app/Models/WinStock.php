<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\WinStockLabel;

class WinStock extends Model
{
    protected $connection = 'pgsql2';
    protected $table = 'stock_win_history';
    protected $primaryKey = 'id';

    public $incrementing = false; 
    public $timestamps = false; 

    protected $guarded = [];  

    public function label()
    {
        return $this->hasOne(WinStockLabel::class, 'id', 'swh_id');
    }
}