<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Map;

class Zone extends Model
{
    use HasFactory;
    protected $table = 'ck_zones';

    public function map()
    {
        return $this->belongsTo(Map::class, 'mapname', 'mapname');
    }
}
