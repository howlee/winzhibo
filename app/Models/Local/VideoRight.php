<?php
/**
 * Created by PhpStorm.
 * User: 11247
 * Date: 2019/7/2
 * Time: 0:07
 */

namespace App\Models\Local;


use Illuminate\Database\Eloquent\Model;

class VideoRight extends Model
{

    public $connection = "qt";

    public static function rights() {
        $query = self::query();
        $query->orderBy("od");
        return $query->take(5)->get();
    }

}