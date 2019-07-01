<?php
/**
 * Created by PhpStorm.
 * User: 11247
 * Date: 2019/7/1
 * Time: 19:13
 */

namespace App\Models\Local;


use Illuminate\Database\Eloquent\Model;

class Match extends Model
{

    public $connection = "qt";

    public static function findBy($sport, $mid) {
        return self::query()->where("sport", $sport)->where('mid', $mid)->first();
    }

    public static function saveMatch(array $match) {
        if (empty($match)) return null;
        $mid = $match["mid"];
        $sport = $match["sport"];
        $newMatch = self::findBy($sport, $mid);
        if (!isset($newMatch)) {
            $newMatch = new Match();
            $newMatch->sport = $sport;
            $newMatch->mid = $mid;
        }

        if (!empty($match['league_name'])) {
            $league_name = $match['league_name'];
        } else if (!empty($match["lname"])) {
            $league_name = $match['lname'];
        } else if (!empty($match["project"])) {
            $league_name = $match['project'];
        } else {
            $league_name = null;
        }

        $newMatch->league_name = $league_name;
        $newMatch->lid = $match["lid"];
        $newMatch->hname = $match["hname"];
        $newMatch->aname = $match["aname"];
        $newMatch->hid = $match["hid"];
        $newMatch->aid = $match["aid"];
        $newMatch->hscore = $match["hscore"];
        $newMatch->ascore = $match["ascore"];
        $newMatch->status = $match["status"];
        $newMatch->time = $match["time"];

        $newMatch->save();
    }

}