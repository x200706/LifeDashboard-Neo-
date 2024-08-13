<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\WinStock;

class WinStockLabel extends Model
{
    protected $connection = 'pgsql2';
    protected $table = 'stock_win_label';
    protected $primaryKey = 'id';

    public $incrementing = true; 
    public $timestamps = false; 

    protected $guarded = [];  

    public function history()
    {
        return $this->belongsTo(WinStock::class, 'swh_id', 'id');
    }
}