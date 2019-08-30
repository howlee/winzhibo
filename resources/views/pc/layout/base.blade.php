<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    @yield("meta")
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{empty($title) ? '红单体育直播_足球篮球免费赛事直播,竞彩推荐' : $title}}-红单直播</title>
    <meta name="keywords" content="{{empty($keywords) ? '足球直播,英超直播,NBA直播,欧冠直播' : $keywords}}">
    <meta name="description" content="{{empty($description) ? '免费的体育直播网站。高清足球直播、NBA直播、英超直播等全部免费看。' : $description}}">
    <meta name="mobile-agent" content="format=[wml|xhtml|html5]; url={{env("M_HOST", "http://m.hongdanzhibo.com").request()->getRequestUri()}}"/>
    @yield("first_js")
    <script>
        if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
            var url = window.location.href;
            var path = location.pathname;
            if (window.pathReg && window.pathReg.test(path) ) {
              url = url.replace(path, "");
            } else if (path == "/live/" || path == "/live") {
              url = url.replace("/live/", "").replace("/live", "");
            } else if (/^\/(\w+\/)team\d+(_\w+_\d+).html/.test(path) ) {
              url = url.replace(/_\w+_\d+/, "");
            }
            url = url.replace(/(https?:\/\/)(www\.)?/, "$1m.");
            window.location.href = url;
        }
    </script>
    <link rel="Shortcut Icon" data-ng-href="{{env('CDN_URL')}}/img/ico.ico" href="{{env('CDN_URL')}}/img/ico.ico">
    <link href="{{env('CDN_URL')}}/css/pc/style.css" type="text/css" rel="stylesheet" />
    @yield('css')
</head>
<body>
    <div id="zc_head">
        <div class="head">
            <div><a href="/"><img class="logo l" src="/img/pc/pc_logo.png" alt="红单直播"></a></div>
        </div>
        <div class="nav">
            <div class="left"></div>
            <ul>
                <li><a href="/" @if(isset($check) && $check == 'index') class="f" @endif >直播首页</a></li>
                <li><a href="/zuqiu/"@if(isset($check) && $check == 'football') class="f" @endif >足球直播</a></li>
                <li><a href="/nba/"@if(isset($check) && $check == 'basketball') class="f" @endif >篮球直播</a></li>
                <li><a href="/news/" @if(isset($check) && $check == 'news') class="f" @endif>热点资讯</a></li>
                <li><a href="/tuijian/" @if(isset($check) && $check == 'tuijian') class="f" @endif>红单推荐</a></li>
                <li><a href="/video/" @if(isset($check) && $check == 'video') class="f" @endif>综合视频</a></li>
                {{--<li id="ad_text_nav"><a href="http://www.qqzhibo.net/live/shijiebei/">世界杯直播</a></li>--}}
            </ul>
        </div>
    </div>
    @yield('crumbs')
    @yield('main')
    {{--<div id="zc_link">--}}
        {{--<h3>友情链接</h3>--}}
        {{--<div class="show">--}}
            {{--<a href="http://www.quanqiutiyu.cc" target="_blank">BOSS直播</a>--}}
            {{--<a href="http://www.xijiazhibo.cc" target="_blank">JRS直播</a>--}}
            {{--<a href="https://www.baidu.com/s?wd=site%3A{{env('HOST', 'www.hongdanzhibo.com')}}" target="_blank">百度</a>--}}
        {{--</div>--}}
    {{--</div>--}}
    <div id="zc_foot">
        {{--<p>红单直播 <a href="http://www.qqzhibo.net/sitemap.xml" target="_blank">sitemap</a></p>--}}
        <p>视频信号整理自互联网，如有侵权请告知我们 我们会在第一时间删除</p>
    </div>
</body>
<script type="text/javascript" src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
@yield('js')
<script>
    var _hmt = _hmt || [];
    (function() {
        var hm = document.createElement("script");
        hm.src = "https://hm.baidu.com/hm.js?f83759b4187ea14a212918961719d3e4";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(hm, s);
    })();
</script>
</html>