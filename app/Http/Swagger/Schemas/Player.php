<?php

namespace App\Http\Swagger\Schemas;

use OpenApi\Annotations as OA;
use OpenApi\Annotations\Property;
use OpenApi\Annotations\Schema;

/**
 * @OA\Schema(
 *     schema="Player",
 *     type="object",
 *     title="Player",
 *     description="This is the record of a player, from a specific style. Note that each style a player plays in, is a separate record.",
 * )
 */

 class Player {

    /**
     * The players community SteamID,
     * @var string
     * @OA\Property(example="STEAM_1:0:12345678")
     */

    public $steamid;

    /**
     * The players SteamID64,
     * @var string
     * @OA\Property(example="12345678910121314")
     */
    public $steamid64;

    /**
     * The players name,
     * @var string
     * @OA\Property(example="Surfer")
     */
    public $name;

    /**
     * The players country,
     * @var string
     * @OA\Property(example="The United Kingdom")
     */
    public $country;

    /**
     * The players points in this style,
     * @var int
     * @OA\Property(example=100000)
     */
    public $points;

    /**
     * The amount of points this player has gained from acquiring world records on maps,
     * @var int
     * @OA\Property(example=16666)
     */
    public $wrpoints;

    /**
     * The amount of points this player has gained from acquiring world records on bonuses,
     * @var int
     * @OA\Property(example=16666)
     */
    public $wrbpoints;
    
    /**
     * The amount of points this player has gained from placing in the top 10 on maps,
     * @var int
     * @OA\Property(example=16666)
     */
    public $top10points;

    /**
     * The amount of points this player has gained from completing a map within a group placing,
     * @var int
     * @OA\Property(example=16666)
     */
    public $groupspoints;

    /**
     * The amount of points this player has gained from completing maps,
     * @var int
     * @OA\Property(example=16666)
     */
    public $mappoints;

    /**
     * The amount of points this player has gained from completing bonuses,
     * @var int
     * @OA\Property(example=16666)
     */
    public $bonuspoints;

    /**
     * The amount of maps this player has completed
     * @var int
     * @OA\Property(example=100)
     */
    public $finishedmaps;

    /**
     * The amount of bonuses this player has completed
     * @var int
     * @OA\Property(example=80)
     */
    public $finishedbonuses;

    /**
     * The amount of stages this player has completed
     * @var int
     * @OA\Property(example=230)
     */
    public $finishedstages;

    /**
     * The amount of map world records this player currently holds
     * @var int
     * @OA\Property(example=10)
     */
    public $wrs;

    /**
     * The amount of bonus world records this player currently holds
     * @var int
     * @OA\Property(example=31)
     */
    public $wrbs;

    /**
     * The amount of stage world records this player currently holds
     * @var int
     * @OA\Property(example=71)
     */
    public $wrcps;

    /**
     * The amount of top 10 placements this player currently holds
     * @var int
     * @OA\Property(example=11)
     */
    public $top10s;

    /**
     * The amount of groups this player has placed in
     * @var int
     * @OA\Property(example=66)
     */
    public $groups;

    /**
     * A timestamp containing the last time this player has been seen on any GoFree server
     * @var string
     * @OA\Property(example="2021-01-02T20:12:34.000000Z")
     */
    public $lastseen;

    /**
     * A timestamp containing the date this player first completed a map on GoFree
     * @var string
     * @OA\Property(example="2021-01-02T20:12:34.000000Z")
     */
    public $joined;
    
    /**
     * The amount of seconds this player has spent alive on a GoFree server
     * @var int
     * @OA\Property(example=371307)
     */
    public $timealive;

    /**
     * The amount of seconds this player has spent spectating on a GoFree server
     * @var int
     * @OA\Property(example=37123)
     */
    public $timespec;

    /**
     * The amount of times this player has connected to any GoFree server
     * @var int
     * @OA\Property(example=1030)
     */
    public $connections;

    /**
     * The style of surfing that this players record is currently comprised of<br/>[0 = Normal, 1 = Sideways, 2 = Half-Sideways, 3 = Backwards, 4  = Low-Gravity, 5 = Slow Motion, 6 = Fast Forward, 7 = Freestyle, 8 = Golden Knife, 9 = Velocity Multiplier]
     * @var int
     * @OA\Property(example=0, minimum=0, maximum=10)
     */
    public $style;    
 }