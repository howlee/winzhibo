<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/14
 * Time: 11:34
 */

namespace App\Models\Local\Admin;


use Illuminate\Database\Eloquent\Model;

class AdRole extends Model
{
    public $connection = "qt";

    public function resources() {
        return $this->belongsToMany(AdResource::class, 'ad_role_resources', 'ro_id', 're_id');
    }
}