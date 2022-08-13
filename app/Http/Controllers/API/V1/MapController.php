<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Map;

use OpenApi\Annotations as OA;


class MapController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/maps",
     *     tags={"Maps"},
     *     summary="Get all maps",
     *     description="Returns a paginated response of maps, in the given style.",
     *     operationId="indexMaps",
     *     @OA\Parameter(
     *       name="page",
     *       description="The page of maps to return. Varies giving the amount of maps per page. Default: 1",
     *       in="query",
     *       @OA\Schema(
     *         type="integer",
     *         minimum=1
     *       )   
     *     ),
     *     @OA\Parameter(
     *       name="per_page",
     *       description="The amount of maps to return per page. Default/Min: 30. Max: 10000.",
     *       in="query",
     *       @OA\Schema(
     *         type="integer",
     *         minimum=30,
     *         maximum=10000
     *       )   
     *     ),
     *     @OA\Parameter(
     *       name="mapname",
     *       description="Queries the maps names for likeliness to the search term.",
     *       in="query",
     *       @OA\Schema(
     *         type="string"
     *       )   
     *     ),
     *     @OA\Parameter(
     *       name="tier",
     *       description="Filters the maps by tier.",
     *       in="query",
     *       @OA\Schema(
     *         type="integer",
     *         minimum=1,
     *         maximum=8
     *       )   
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         content={
     *              @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     @OA\Property(
     *                       property="current_page",
     *                       type="integer",
     *                       example=1
     *                     ),
     *                     @OA\Property(
     *                         property="data",
     *                         type="array",
     *                         @OA\Items(ref="#/components/schemas/Map")
     *                     ),
     *                     @OA\Property(
     *                       property="first_page_url",
     *                       type="string",
     *                       example="/api/v1/maps?page=1"
     *                     ),
     *                     @OA\Property(
     *                       property="from",
     *                       type="integer",
     *                       example=1
     *                     ),
     *                     @OA\Property(
     *                       property="last_page",
     *                       type="integer",
     *                       example=10000
     *                     ),
     *                     @OA\Property(
     *                       property="last_page_url",
     *                       type="integer",
     *                       example="/api/v1/maps?page=100"
     *                     ),
     *                     @OA\Property(
     *                       property="next_page_url",
     *                       type="string",
     *                       example="/api/v1/maps?page=2"
     *                     ),
     *                     @OA\Property(
     *                       property="path",
     *                       type="string",
     *                       example="/api/v1/maps"
     *                     ),
     *                     @OA\Property(
     *                       property="per_page",
     *                       type="integer",
     *                       example=30
     *                     ),
     *                     @OA\Property(
     *                       property="prev_page_url",
     *                       type="integer",
     *                       example=null
     *                     ),
     *                     @OA\Property(
     *                       property="to",
     *                       type="integer",
     *                       example=10
     *                     ),
     *                     @OA\Property(
     *                       property="total",
     *                       type="integer",
     *                       example=1
     *                     ),
     *                 ),
     *              )
     *         }
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Maps not found",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Out of Bounds"
     *     )
     * )
     */
    public function index(Request $request)
    {
        $maps = Map::query();

        if($request->has('mapname') && $request->mapname != null) {
            $maps->where('mapname', 'like', '%' . $request->mapname . '%');
        }

        if($request->has('tier') && $request->tier != null) {
            if($request->tier > 8 || $request->tier < 1) {
                return response()->json([
                    'message' => 'Map tier is out of range [1-8]'
                ], 400);
            }

            $maps->where('tier', $request->tier);
        }

        $maps = $maps->paginate($request->perPage ?? 30);

        $maps->getCollection()->transform(function($map) {
            $map['record'] = $map->map_record;

            return $map;
        });

        return $maps;
    }

    /**
     * @OA\Get(
     *     path="/api/v1/maps/{mapname}",
     *     tags={"Maps"},
     *     summary="Get a map by mapname",
     *     description="Returns a record of a map, if found.",
     *     operationId="showMap",
     *     @OA\Parameter(
     *       name="mapname",
     *       description="The name of the map to return.",
     *       in="path",
     *       required=true,
     *       @OA\Schema(
     *         type="string",
     *         example="surf_utopia_v3"
     *       )   
     *     ),
     *     @OA\Parameter(
     *       name="style",
     *       description="The style of the record to return. Default: 0",
     *       in="query",
     *       @OA\Schema(
     *         type="integer",
     *         example=0,
     *         minimum=0,
     *         maximum=10
     *       )   
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         content={
     *              @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(ref="#/components/schemas/Map"),
     *              )
     *         }
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Map not found",
     *     )
     * )
     */
    public function show($mapname, Request $request)
    {
        if($request->has('style') && $request->style < 0 || $request->has('style') && $request->style > 10) {
            return response()->json([
                'message' => 'Style is out of range [1-10]'
            ], 400);
        }

        $map = Map::where('mapname', $mapname)->first();

        if($map == null) {
            return response()->json([
                'message' => 'Map not found'
            ], 404);
        }

        $map['record'] = $map->getMapRecord($request->style ?? 0);

        return $map;
    }
}
