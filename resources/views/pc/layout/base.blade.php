<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>win直播-{{empty($title) ? '足球直播_NBA直播_世界杯直播_西甲直播_英超直播_免费直播' : $title}}</title>
    <meta name="keywords" content="{{empty($keywords) ? '足球直播,世界杯直播,NBA直播,五星体育,CCTV5在线直播' : $keywords}}">
    <meta name="description" content="{{empty($description) ? '免费的体育直播网站。高清直播足球、NBA篮球、世界杯等比赛。' : $description}}">
    <link href="/css/pc/style.css" type="text/css" rel="stylesheet" />
    @yield('css')
</head>

<body>
    <div id="zc_head">
        <div class="head">
            <div class="logo l">
                <a href="http://www.qqzhibo.net/"><img src="http://www.qqzhibo.net/logo.gif" alt="win直播"></a>
            </div>
        </div>
        <div class="nav">
            <div class="left"></div>
            <ul>
                <li><a href="/" @if(isset($check) && $check == 'index') class="f" @endif >直播首页</a></li>
                <li><a href="/live/football.html"@if(isset($check) && $check == 'football') class="f" @endif >足球直播</a></li>
                <li><a href="/live/basketball.html"@if(isset($check) && $check == 'basketball') class="f" @endif >篮球直播</a></li>
                <li><a href="http://www.qqzhibo.net/video/zuqiu/">足球视频</a></li>
                <li><a href="http://www.qqzhibo.net/video/lanqiu/">篮球视频</a></li>
                <li><a href="http://www.qqzhibo.net/video/tiyu/">综合视频</a></li>
                <li id="ad_text_nav"><a href="http://www.qqzhibo.net/live/shijiebei/">世界杯直播</a></li>
            </ul>
        </div>
        <div class="link">
            <b>足球直播：</b>
            <a href="http://www.qqzhibo.net/live/ouguan/" target="_blank">欧冠直播</a>
            <a href="http://www.qqzhibo.net/live/zhongchao/" target="_blank">中超直播</a>
            <a href="http://yingchao.qqzhibo.net/" target="_blank">英超直播</a>
            <a href="http://www.qqzhibo.net/live/xijia/" target="_blank">西甲直播</a>
            <a href="http://www.qqzhibo.net/live/dejia/" target="_blank">德甲直播</a>
            <a href="http://www.qqzhibo.net/live/yijia/" target="_blank">意甲直播</a>
            <a href="http://www.qqzhibo.net/live/fajia/" target="_blank">法甲直播</a>
            <a href="http://www.qqzhibo.net/live/yaguan/" target="_blank">亚冠直播</a>
            <b>篮球直播：</b>
            <a href="http://www.qqzhibo.net/live/nba/" target="_blank">NBA直播</a>
            <a href="http://www.qqzhibo.net/live/cba/" target="_blank">CBA直播</a>
        </div>
    </div>

    @yield('main')

    <div id="zc_link">
        <h3>友情链接</h3>
        <div class="show"><a href="http://www.qqzhibo.net/" target="_blank">QQ直播网</a><a href="http://sinuoke.qqzhibo.net/" target="_blank">HD斯诺克</a><a href="http://f1.qqzhibo.net/" target="_blank">F1赛车</a><a href="http://www.102tv.cn/" target="_blank">NBA录像</a><a href="http://www.tiantian.tv/" target="_blank">天天直播</a><a href="http://www.jrszhibo.net/" target="_blank">jrs直播</a><a href="http://www.qqzq.tv/" target="_blank">足球直播</a><a href="http://www.leisu.com/" target="_blank">雷速体育</a><a href="http://www.jisutiyu.com/" target="_blank">极速体育</a><a href="http://www.66tiyu.com/" target="_blank">牛牛体育</a><a href="http://www.lszhibo.com/" target="_blank">足球直播</a><a href="http://www.zhibowu.com/" target="_blank">足球直播</a><a href="http://www.4300.tv/" target="_blank">世界杯直播</a><a href="http://www.bisai8.com/" target="_blank">比赛吧</a><a href="http://www.0dian8.org/" target="_blank">CCTV5直播</a><a href="http://www.yingchaozhibo.com/" target="_blank">英超直播</a><a href="http://www.wa5.com/" target="_blank">五星体育直播</a><a href="http://www.ccav5.com" target="_blank">世界杯直播</a><a href="http://www.52waha.com" target="_blank">哇哈体育</a><a href="http://www.didiaokan.cc" target="_blank">低调看直播</a><a href="http://www.huanhuba.com" target="_blank">比分预测</a><a href="http://www.sportsln.cn/" target="_blank">辽宁体育网</a><a href="http://www.zhizhu.tv" target="_blank">足球比分</a><a href="http://www.lanqiu.tv/" target="_blank">篮球直播</a><a href="http://ozb.cc/" target="_blank">世界杯直播</a></div>
    </div>

    <div id="zc_foot">
        <p>win直播 <a href="http://www.qqzhibo.net/sitemap.xml" target="_blank">sitemap</a></p>
        <p>视频信号整理自互联网，如有侵权请告知我们 我们会在第一时间删除</p>
    </div>
</body>
<script type="text/javascript" src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
@yield('js')
</html>