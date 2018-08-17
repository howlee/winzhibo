<?php
/**
 * Created by PhpStorm.
 * User: 11247
 * Date: 2018/8/16
 * Time: 18:10
 */

namespace App\Models\Aikq;


use Illuminate\Database\Eloquent\Model;

/**
 * 直播管理员打卡表
 * Class LiveAccountSign
 * @package App\Models\Admin
 */
class LiveAccountSign extends Model
{
    const kStatusOn = 1, kStatusOff = 2;//1：上班，2：下班

    public function getStatusCn() {
        if ($this->status == self::kStatusOn) {
            return "上班";
        } else {
            return "下班";
        }
    }

    /**
     * 获取值班人员的openid数组
     * @return array
     */
    public static function getOnOpenidArray() {
        $query = self::query();
        $query->join('accounts', 'accounts.id', '=', 'live_account_signs.account_id');
        $query->where('live_account_signs.status', '=', self::kStatusOn);
        $query->select('accounts.openid', 'accounts.id');
        $ons = $query->get();//获取当前值班人员
        $openidArray = [];
        foreach ($ons as $on) {
            $openidArray[] = $on->openid;
        }

        if (count($openidArray) == 0) {//如果当前无值班人员，则发给上一个值班人员
            $query = self::query();
            $query->join('accounts', 'accounts.id', '=', 'live_account_signs.account_id');
            $query->select('accounts.openid', 'accounts.id');
            $query->orderByDesc('live_account_signs.off_time');//获取最后下班的人
            $last = $query->first();
            if (isset($last)) {
                $openidArray[] = $last->openid;
            }
        }
        return $openidArray;
    }

}