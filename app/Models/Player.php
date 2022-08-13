<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;

    protected $table = 'ck_playerrank';
    protected $casts = [
        'lastseen' => 'datetime',
        'joined' => 'datetime',
    ];
    protected $hidden = [
        'readchangelog',
        'id',
        'finishedmapspro'
    ];
}
