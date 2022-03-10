<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Exetel Laravel Rest API Assingment  Documentation",
 *      description="Use this as x-api-key `GzK2!H4m@*Me%a-zPL4TYz#JBw26MsMMjJCSbr+=BVqp&3f8gyRk%TF2gaVkN8%$ydR$3rE#F*Eue*5Fj4GdD9he335?R+zpDvQR7m6v84YMBe6#38SDU8vvfvnWfxUx6+=jdhMtwfv4^7RbuhuF+B_$&M5ztsswcAMQ^%Fd4Wc*UD@#AtcxYF@Jey&H3M_JW23s4CYnk#?yrtZM_t!vdd2Z7L8pYat%Y2vMCPv#K&uQEZBbnCL3!6c579f%C%*Q` ",
 *
 *     @OA\Contact(
 *          email="dinethwa@gmail.com"
 *      ),
 *      @OA\License(
 *          name="Apache 2.0",
 *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *      )
 * )
 *
 *
 * @OA\Server(
 *      url=L5_SWAGGER_CONST_HOST,
 *      description="Local API Server"
 * )
 *
 *
 * @OA\SecurityScheme(
 *      securityScheme="bearerAuth",
 *      type="http",
 *      scheme="bearer"
 * )
 *
 */

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
