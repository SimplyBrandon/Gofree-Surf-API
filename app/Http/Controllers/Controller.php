<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *    title="GoFree Surfers API",
 *    version="1.0.0",
 *    description="The GoFree Surfers API is a RESTful API that provides access to data that's collected from the GoFree Surfers database. <br>In Version 1.0.0 this API currently only provides endpoints for maps and players. <br>For more information, please visit the Discord server.<br/><br/>Created by <a href='https://stats.go-free.info/player/STEAM_1:0:50362476'>Simply Brandon</a>",
 *    @OA\Contact(
 *      url="https://discord.gg/aTf8J7xT9n",
 *      name="GoFree Community Discord Server"
 *    )
 * )
 */

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
