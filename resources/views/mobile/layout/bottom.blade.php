<?php
    $liveHref = $m. "/";
    $luxiangHref = $m."/video/";
    $zixunHref = $m."/news/";
    $tuijian = $m."/tuijian/";
    $classArray = [
        'live'=>['class'=>'live', 'attr'=>'href="'.$liveHref.'"'],
        'luxiang'=>['class'=>'luxiang', 'attr'=>'href="'.$luxiangHref.'"'],
        'zixun'=>['class'=>'zixun', 'attr'=>'href="'.$zixunHref.'"'],
        'tuijian'=>['class'=>'tuijian', 'attr'=>'href="'.$tuijian.'"'],
    ];
    if (isset($bar)) {
        foreach ($classArray as $key=>$item) {
            if ($key == $bar) {
                $classArray[$key]['class'] = $key.'-on';
                $classArray[$key]['attr'] = 'class="active"';
            }
        }
    }
?>
<div class="footer-bar">
    <a {!! $classArray['live']['attr'] !!} style="width: 25%;"><i class="{{$classArray['live']['class']}}"></i><p>直播</p></a>
    <a {!! $classArray['luxiang']['attr'] !!} style="width: 25%;"><i class="{{$classArray['luxiang']['class']}}"></i><p>录像</p></a>
    <a {!! $classArray['zixun']['attr'] !!} style="width: 25%;"><i class="{{$classArray['zixun']['class']}}"></i><p>资讯</p></a>
    <a {!! $classArray['tuijian']['attr'] !!} style="width: 25%;"><i class="{{$classArray['tuijian']['class']}}"></i><p>推荐</p></a>
</div>