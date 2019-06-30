<!doctype html>
<html>
<head>
    <meta charset=utf8>
    <title>英超直播_NBA直播吧_Jrs直播_低调看直播_高清免费</title>
    <meta name="keywords" content="足球直播,NBA直播,NBA直播吧,英超直播,西甲直播,jrs直播,低调看直播">
    <meta name="description" content="是一个免费高清体育赛事Jrs直播网站。在这里能看高清NBA直播、英超直播和西甲直播，低调看直播来就够了！">
    <meta charset="utf-8" >
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no">
    <link href="{{env('CDN_URL')}}/css/pc/style.css" type="text/css" rel="stylesheet" />
    <meta name="applicable-device" content="mobile" >
    <link href="/css/mobile/style.css" rel="stylesheet" >
    <link href="/css/mobile/font-awesome.min.css" rel="stylesheet">
    <script type="text/javascript" src="//apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
    <meta HTTP-EQUIV="Pragma" CONTENT="no-cache">
    <meta HTTP-EQUIV="Cache-Control" CONTENT="no-cache">
    <meta HTTP-EQUIV="Expires" CONTENT="0">
</head>
<body>
<div class="container">
    <div class="wrap" style="background-color: #ffffff;">
        <div class="header">
            <a href="/m/index.html"><img src="/img/mobile/wap_logo.png"/></a>
        </div>
        <div class="game-list" style="display:block;">
            <div class="game-item cPbtn" style="text-align: center;">
                <div class="team-left">
                    <img src="{{$hicon}}">
                    <p style="font-weight:bold;">{{$match["hname"]}}</p>
                </div>
                <div class="game-info">
                    <div class="team-score">
                        <bifen class="id126275">
                            <p class="score-num gray"><span class="score score126275"> VS </span></p>
                        </bifen>
                        <p class="live" style="">{{$match["league_name"]}}</p>
                        <p class="time" style=""><span>{{substr($match["time"], 0, 16)}}</span></p>
                    </div>
                </div>
                <div class="team-right">
                    <img src="{{$aicon}}">
                    <p style="font-weight:bold;">{{$match["aname"]}}</p>
                </div>
                <div class="clear"></div>
            </div>
            <div style="height: 350px">
                <iframe style="border: 0;" src="{{env("PLAYER_URL")}}/player/{{$match["sport"].$match["mid"]}}.html" width="100%" height="100%" scrolling="no"></iframe>
            </div>
        </div>
        <div class="footer-bar">
            <a href="/m/" style="width: 50%;"><i class="live"></i><p>直播</p></a>
            <a href="/m/videos.html" style="width: 50%;"><i class="luxiang"></i><p>录像</p></a>
        </div>
    </div>
</div>
</body>
<script type="text/javascript">

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