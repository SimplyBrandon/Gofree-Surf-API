<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Player;

use OpenApi\Annotations as OA;

class PlayerController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/players",
     *     tags={"Players"},
     *     summary="Get all players",
     *     description="Returns a paginated response of players, in the given style.",
     *     operationId="indexPlayers",
     *     @OA\Parameter(
     *       name="style",
     *       description="The style of the players to return. Default: 0 [Normal]",
     *       in="query",
     *       @OA\Schema(
     *         type="integer"
     *       )   
     *     ),
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
     *       description="The amount of players to return per page. Default/Min: 30. Max: 10000.",
     *       in="query",
     *       @OA\Schema(
     *         type="integer",
     *         minimum=30,
     *         maximum=10000
     *       )   
     *     ),
     *     @OA\Parameter(
     *       name="search",
     *       description="Queries the players names for likeliness to the search term.",
     *       in="query",
     *       @OA\Schema(
     *         type="string"
     *       )   
     *     ),
     *     @OA\Parameter(
     *       name="order",
     *       description="The attribute in which to order the players by. Default: points",
     *       in="query",
     *       @OA\Schema(
     *         type="integer"
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
     *                         x=3,
     *                         @OA\Items(ref="#/components/schemas/Player")
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
     *         description="Players not found",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Out of Range"
     *     )
     * )
     */
    public function index(Request $request)
    {
        $players = Player::query();

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

        $players->where('style', $request->style ?? 0);
        
        if ($request->has('search')) {
            $players->where('name', 'like', '%' . $request->input('search') . '%');
        }

       if($request->has('order')){
            $order = explode('_', $request->order);
        } else {
            $order = ['points', 'desc'];
        }

        $players->orderBy($order[0], $order[1]);

        return $players->paginate($request->per_page ?? 30);
    }

    /**
     * @OA\Get(
     *   path="/api/v1/players/{steamid}",
     *   tags={"Players"},
     *   summary="Get a player by their steamid, in a given style",
     *   description="Returns a single player record, in the given style, if it exists.",
     *   operationId="showPlayer",
     *   @OA\Parameter(
     *     name="steamid",
     *     description="The Community SteamID of the player to return. *Not* their SteamID 64.",
     *     in="path",
     *     required=true,
     *     @OA\Schema(
     *       type="string"
     *     )
     *   ),
     *   @OA\Parameter(
     *     name="style",
     *     description="The style of the player record to return. Default: 0 [Normal]",
     *     in="query",
     *     @OA\Schema(
     *       type="string"
     *     )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="successful operation",
     *     content={
     *     @OA\MediaType(
     *       mediaType="application/json",
     *       @OA\Schema(ref="#/components/schemas/Player")
     *     )
     *     }
     *   ),
     *   @OA\Response(
     *     response=404,
     *     description="Player not found",
     *     content={
     *     @OA\MediaType(
     *       mediaType="application/json",
     *       @OA\Schema(
     *         @OA\Property(
     *           property="message",
     *           type="string",
     *           example="Player not found"
     *         )
     *       )
     *     )
     *     }
     *   ),
     *   @OA\Response(
     *     response=400,
     *     description="Style is out of range [0-10]",
     *     content={
     *     @OA\MediaType(
     *       mediaType="application/json",
     *       @OA\Schema(
     *         @OA\Property(
     *           property="message",
     *           type="string",
     *           example="Style is out of range [0-10]"
     *         )
     *       )
     *     )
     *     }
     *   )
     *           
     * )
     *             
     */

    public function show($id, Request $request)
    {
        if($request->has('style') && $request->style > 10 || $request->style < 0) {
            return response()->json([
                'message' => 'Style is out of range [0-10]'
            ], 400);
        }

        $player = Player::where('style', $request->style ?? 0)->where('steamid', $id)->first();

        if(!$player) {
            return response()->json([
                'message' => 'Player not found'
            ], 404);
        }

        return $player;
    }
}
