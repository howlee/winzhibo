<?php
/**
 * Created by PhpStorm.
 * User: 11247
 * Date: 2019/7/15
 * Time: 12:33
 */

namespace App\Http\Middleware;

use App\Http\Controllers\Admin\UploadTrait;
use Closure;

class ImageMiddleware
{
    use UploadTrait;

    public function handle($request, Closure $next) {
        $m =  $next($request);
        $jsonList = explode("\n", $m);
        $json = json_decode($jsonList[count($jsonList) - 1], true);
        if (isset($json["state"]) && $json["state"] == "SUCCESS") {
            //上传图片成功，图片打水印
            if (!empty($json["url"])) {
                $url = $json["url"];
                $array = explode("/uploads/", $url);
                $url = "app/public/uploads/" . $array[1];
                $imgSrc = storage_path($url);
                $markImg = public_path('img/water.png');
                $this->setWater($imgSrc, $markImg, "", "", 9, "", "img");
            } else if (isset($json["list"])) {
                $list = $json["list"];
                $markImg = public_path('img/water.png');
                foreach ($list as $item) {
                    $url = $item["filename"];
                    $url = "app/public/uploads" . $url;
                    $imgSrc = storage_path($url);
                    $this->setWater($imgSrc, $markImg, "", "", 9, "", "img");
                }
            }
        }
        return $m;
    }

}