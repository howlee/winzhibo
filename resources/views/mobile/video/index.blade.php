<!doctype html>
<html>
<head>
    <meta charset=utf8>
    <title>英超直播_NBA直播吧_Jrs直播_低调看直播_高清免费</title>
    <meta name="keywords" content="足球直播,NBA直播,NBA直播吧,英超直播,西甲直播,jrs直播,低调看直播">
    <meta name="description" content="是一个免费高清体育赛事Jrs直播网站。在这里能看高清NBA直播、英超直播和西甲直播，低调看直播来就够了！">
    <meta charset="utf-8" >
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no">
    <meta name="applicable-device" content="mobile" >
    <link href="{{env('CDN_URL')}}/css/pc/style.css" type="text/css" rel="stylesheet" />
    <link href="/css/mobile/style.css" rel="stylesheet" >
    <link href="/css/mobile/font-awesome.min.css" rel="stylesheet">
    <script type="text/javascript" src="//apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
    <meta HTTP-EQUIV="Pragma" CONTENT="no-cache">
    <meta HTTP-EQUIV="Cache-Control" CONTENT="no-cache">
    <meta HTTP-EQUIV="Expires" CONTENT="0">
</head>
<body onscroll="scrollBottom(loadVideos);" >
<div class="container">
    <div class="wrap">
        <div class="header">
            <a href="/m/index.html"><img src="/img/mobile/wap_logo.png"/></a>
        </div>
        <div class="game-list" style="display:block;">
            @foreach($matches as $time=>$array)
                <h2 class="today">{{$time}}</h2>
                <div>
                @foreach($array as $match)
                    <?php
                        $mid = $match['id'];
                        if (strlen($mid) < 4) {
                            $path = "";
                        } else {
                            $path = 'https://www.aikq.cc/m/live/subject/video/' . substr($mid, 0, 2) . '/' . substr($mid, 2, 4) . '/' . $mid .'.html';
                        }
                        $hicon = !empty($match['hicon']) ? ($match['hicon']) : '//static.liaogou168.com/img/icon_team_default.png';
                        $aicon = !empty($match['aicon']) ? $match['aicon'] : '//static.liaogou168.com/img/icon_team_default.png';

                        $hicon = str_replace('static.cdn.dlfyb.com', 'static.liaogou168.com', $hicon);
                        $aicon = str_replace('static.cdn.dlfyb.com', 'static.liaogou168.com', $aicon);
                    ?>
                    @continue(empty($path))
                    <a href="{{$path}}" class="game-item cPbtn" style="text-align: center;">
                        <div class="team-left">
                            <img src="{{$hicon}}" >
                            <p style="font-weight:bold;">  {{$match['hname']}}</p>
                        </div>
                        <div class="game-info">
                            <div class="team-score">
                                <bifen class="id126275">
                                    <p class="score-num gray"><span class="score score126275"> VS </span></p>
                                </bifen>
                                <p class="live" style="">{{$match['lname']}} </p>
                                <p class="time" style=""><span>{{date('H:i', $match['time'])}}</span></p>
                            </div>
                        </div>
                        <div class="team-right">
                            <img src="{{$aicon}}" >
                            <p style="font-weight:bold;">{{$match['aname']}}</p>
                        </div>
                        <div class="clear"></div>
                    </a>
                @endforeach
                </div>
            @endforeach
        </div>

        <div class="footer-bar">
            <a href="/m/index.html" style="width: 50%;"><i class="live"></i><p>直播</p></a>
            <a class="active" style="width: 50%;"><i class="luxiang-on"></i><p>录像</p></a>
        </div>
    </div>
</div>
</body>
<script type="text/javascript" src="/js/m/videos.js"></script>
<script type="text/javascript">
    $(function () {
        $("div.module span").click(function () {
            var val = $(this).attr("value");

            $("div.module span").removeClass("current");
            $(this).addClass("current");

            $("div.game-list").hide();
            if (val == 'all') {
                $("div.game-list:first").show();
            } else if (val == 'shijiebei') {
                $("div.game-list:eq(1)").show();
            } else if (val == 'football') {
                $("div.game-list:eq(2)").show();
            } else if (val == 'basketball') {
                $("div.game-list:last").show();
            }
        });
    });
</script>
<script>
    var _hmt = _hmt || [];
    (function() {
        var hm = document.createElement("script");
        hm.src = "https://hm.baidu.com/hm.js?bea178e04cbf7ca1b6e231665baf94cf";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(hm, s);
    })();
</script>
</html>