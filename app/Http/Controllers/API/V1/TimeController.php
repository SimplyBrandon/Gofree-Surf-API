<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Map;

class TimeController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/times/{mapname}",
     *     tags={"Times"},
     *     summary="Get all times for a map",
     *     description="Returns a paginated response of player times, in the given style.",
     *     operationId="indexTimes",
     *     @OA\Parameter(
     *       name="mapname",
     *       description="The name of the map to view player times of. Default: 0 [Normal]",
     *       in="path",
     *       required=true,
     *       @OA\Schema(
     *         type="string",
     *         example="surf_utopia_v3",
     *       )   
     *     ),
     *     @OA\Parameter(
     *       name="style",
     *       description="The style of the times to return. Default: 0 [Normal]",
     *       in="query",
     *       @OA\Schema(
     *         type="integer",
     *         minimum=0,
     *         maximum=10,
     *         example=0
     *       )   
     *     ),
     *     @OA\Parameter(
     *       name="page",
     *       description="The page of times to return. Varies giving the amount of maps per page. Default: 1",
     *       in="query",
     *       @OA\Schema(
     *         type="integer",
     *         minimum=1
     *       )   
     *     ),
     *     @OA\Parameter(
     *       name="per_page",
     *       description="The amount of times to return per page. Default/Min: 30. Max: 10000.",
     *       in="query",
     *       @OA\Schema(
     *         type="integer",
     *         minimum=30,
     *         maximum=10000,
     *         example=30
     *       )   
     *     ),
     *     @OA\Parameter(
     *       name="order",
     *       description="The attribute in which to order the players by. Default: runtimepro",
     *       in="query",
     *       @OA\Schema(
     *         type="string",
     *         example="runtimepro_asc"
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
     *                         @OA\Items(ref="#/components/schemas/Time")
     *                     ),
     *                     @OA\Property(
     *                       property="first_page_url",
     *                       type="string",
     *                       example="/api/v1/players?page=1"
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
     *                       example="/api/v1/players?page=100"
     *                     ),
     *                     @OA\Property(
     *                       property="next_page_url",
     *                       type="string",
     *                       example="/api/v1/players?page=2"
     *                     ),
     *                     @OA\Property(
     *                       property="path",
     *                       type="string",
     *                       example="/api/v1/players"
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
     *         description="Out of Range"
     *     )
     * )
     */
    public function index($mapname, Request $request)
    {
        if($request->has('style') && $request->style > 10 || $request->has('style') && $request->style < 0) {
            return response()->json([
                'message' => 'Style is out of range [0-10]'
            ], 400);
        }

        if($request->has('per_page') && $request->per_page > 10000 || $request->has('per_page') && $request->per_page < 1) {
            return response()->json([
                'message' => 'Per Page is out of range [1-10000]'
            ], 400);
        }

        $map = Map::where('mapname', $mapname)->first();

        if(!$map)
        {
            return response()->json([
                'message' => 'Map not found',
            ], 404);
        }

        if($request->has('order')){
            $order = explode('_', $request->order);
        } else {
            $order = ['runtimepro', 'asc'];
        }


        $times = $map->times($request->style ?? 0)->orderBy($order[0], $order[1])->paginate($request->per_page ?? 30);

        return $times;
    }
}
