<?php

namespace App\Http\Swagger\Schemas;

use OpenApi\Annotations as OA;
use OpenApi\Annotations\Property;
use OpenApi\Annotations\Schema;

/**
 * @OA\Schema(
 *   schema="Time",
 *   type="object",
 *   title="Time",
 *   description="This is a time for a map, in a specific style.",
 *  )
 */

 class Time {

    /**
     * The SteamID of the player who holds this time,
     * @var string
     * @OA\Property(example="STEAM_1:0:12345678")
     */
    public $steamid;

    /**
     * The name of the map that this time was set on,
     * @var string
     * @OA\Property(example="surf_utopia_v3")
     */
    public $mapname;

    /**
     * The name of the player who holds this time,
     * @var string
     * @OA\Property(example="Surfer")
     */
    public $name;

    /**
     * The time, in seconds, it took the player to complete the map,
     * @var int
     * @OA\Property(example=32.6855)
     */
    public $runtimepro;

    /**
     * The starting speed of the player, using XY velocity, on this map,
     * @var int
     * @OA\Property(example=400)
     */
    public $velStartXY;

    /**
     * The starting speed of the player, using XYZ velocity, on this map,
     * @var int
     * @OA\Property(example=520)
     */
    public $velStartXYZ;
    
    /**
     * The starting speed of the player, using only Z velocity, on this map,
     * @var int
     * @OA\Property(example=-330)
     */
    public $velStartZ;

    /**
     * The speed of the player, using XY velocity, at the end of this map,
     * @var int
     * @OA\Property(example=2040)
     */
    public $velEndXY;

    /**
     * The speed of the player, using XYZ velocity, at the end of this map,
     * @var int
     * @OA\Property(example=2057)
     */
    public $velEndXYZ;
    
    /**
     * The speed of the player, using only Z velocity, at the end of this map,
     * @var int
     * @OA\Property(example=250)
     */
    public $velEndZ;

    /**
     * The style the player was surfing in when they set this time,
     * @var int
     * @OA\Property(example=250)
     */
    public $style;

    /**
     * The date the player set this time,
     * @var string
     * @OA\Property(example="2021-04-22 17:35:36")
     */
    public $time;
 }