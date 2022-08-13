<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Zone;

class Map extends Model
{
    use HasFactory;

    protected $table = 'ck_maptier';

    protected $casts = [
        'ranked' => 'boolean'
    ];

    protected $appends = [
        'bonuses',
        'stages'
    ];

    protected $hidden = [
        'announcerecord',
        'gravityfix'
    ];

    public function zones()
    {
        return $this->hasMany(Zone::class, 'mapname', 'mapname');
    }

    public function times($style = 0)
    {
        return $this->hasMany(PlayerTime::class, 'mapname', 'mapname')->where('style', $style);
    }

    public function getMapRecord($style = 0)
    {
        return $this->hasMany(PlayerTime::class, 'mapname', 'mapname')->where('style', $style)->orderBy('runtimepro', 'asc')->first();
    }

    public function getAllRecords()
    {
        $records = [];
        for($i = 0; $i < 10; $i++){
            $records[$i] = $this->getMapRecord($i);
        }

        return $records;
    }

    public function getBonusesAttribute()
    {
        $bonuses = $this->zones()->max('zonegroup');

        if($bonuses == null || $bonuses == 0){
            return 0;
        }

        return $bonuses;
    }

    public function getStagesAttribute()
    {
        $stages = $this->zones()->where('zonetype', '3')->max('zonetypeid');

        if ($stages == null || $stages == 0){
            return 0;
        }

        return $stages + 2;
    }

    public function getMapRecordAttribute()
    {
        $recordHolder = $this->getMapRecord();

        return [
            'name' => $recordHolder->name,
            'steamid' => $recordHolder->steamid,
            'time' => $recordHolder->runtimepro,
            'velStartXY' => $recordHolder->velStartXY,
            'velStartXYZ' => $recordHolder->velStartXYZ,
            'velStartZ' => $recordHolder->velStartZ,
            'velEndXY' => $recordHolder->velEndXY,
            'velEndXYZ' => $recordHolder->velEndXYZ,
            'velEndZ' => $recordHolder->velEndZ,
            'style' => $recordHolder->style
        ];
    }
}
