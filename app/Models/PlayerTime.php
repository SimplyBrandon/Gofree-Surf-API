<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Player;

class PlayerTime extends Model
{
    use HasFactory;

    protected $table = 'ck_playertimes';

    public function player()
    {
        return $this->belongsTo(Player::class, 'steamid', 'steamid');
    }
}
