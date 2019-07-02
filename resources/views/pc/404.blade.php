<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>404错误页</title>
    <meta name="keywords" content="足球直播,世界杯直播,NBA直播,五星体育,CCTV5在线直播">
    <meta name="description" content="免费的体育直播网站。高清直播足球、NBA篮球、世界杯等比赛。">
    <link rel="Shortcut Icon" data-ng-href="/img/ico.ico" href="/img/ico.ico">
    <link href="/css/pc/style.css" type="text/css" rel="stylesheet" />
    <style type="text/css>">
    </style>
</head>
<body>
<div id="zc_head">
    <div class="head">
        <div class="logo l">
            <a href="/"><img src="/img/pc/pc_logo.png" alt="红单直播"></a>
        </div>
    </div>
    <div class="nav">
        <div class="left"></div>
        <ul>
            <li><a href="/">直播首页</a></li>
            <li><a href="/live/football.html" >足球直播</a></li>
            <li><a href="/live/basketball.html" >篮球直播</a></li>
            <li><a href="/live/videos" >综合视频</a></li>
        </ul>
    </div>
</div>
<div id="zc_main" >
    <div class="left l" style="width: 960px;height: 400px;background: url(/img/404.png) no-repeat center 100px RGB(255, 255, 255); background-size: 320px;text-align: center;">
        <div id="Content" style="position:relative;text-align: center;height: 300px;margin-left: 350px;">
            <p id="ps" style="color: rgb(185, 86, 93);font-size: 26px;position: absolute;bottom: 0; margin: 0;padding: 0;">找不到您想要的页面</p>
        </div>
    </div>
</div>
</body>
<script type="text/javascript" src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
<script>
    $("h2.cp").click(function () {
        var $this = $(this);
        var $next = $this.next();
        var display = $next.css('display');
        if (display == 'none') {
            $this.find('img').attr('src', '/img/pc/show_yes.gif');
            $next.show();
        } else {
            $this.find('img').attr('src', '/img/pc/show_no.gif');
            $next.hide();
        }
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