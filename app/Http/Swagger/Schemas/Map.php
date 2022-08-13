<?php

namespace App\Http\Swagger\Schemas;

use OpenApi\Annotations as OA;
use OpenApi\Annotations\Property;
use OpenApi\Annotations\Schema;

/**
 * @OA\Schema(
 *   schema="Map",
 *   type="object",
 *   title="Map",
 *   description="This is the record of a Map currently in the map listings of GoFree",
 *  )
 */

 class Map {
    /**
     * The name of the map,
     * @var string
     * @OA\Property(example="surf_utopia_v3")
     */
    public $mapname;

    /**
     * The tier of the map,
     * @var int
     * @OA\Property(example=1, minimum=1, maximum=8)
     */
    public $tier;

    /**
     * The limit of speed applied to this map,
     * @var int
     * @OA\Property(example=9999)
     */
    public $maxvelocity;

    /**
     * Whether this map is currently available in the map listings,
     * @var boolean
     * @OA\Property(example=true)
     */
    public $ranked;

    /**
     * The current record holder of this map, in the given style, or Normal [0] style if a style is not given,
     * @var object
     * @OA\Property(ref="#/components/schemas/Time")
     */
    public $record;

    /**
     * The amount of bonuses this map has,
     * @var int
     * @OA\Property(example=5)
     */
    public $bonuses;

    /**
     * The amount of stages this map has,
     * @var int
     * @OA\Property(example=3)
     */
    public $stages;
 }