@extends('pc.layout.base')
@section('main')
    <div id="zc_main">
        <div class="left l">
            <div class="live">
                <h2>{{substr($match['time'], 0, 10)}} {{$info}}</h2>
                <div class="tip">如果以下信号都无效，请进入<a href="/">win直播</a>主页查看最新直播信号 </div>
                <div class="channel">
                    <p>【站外直播】： <a href="http://www.aikq.cc/live/spPlayer/player-{{$match['mid']}}-{{$match['sport']}}.html" target="_blank">高清直播</a></p>
                    <p>【比赛导读】： <a href="http://www.qqzhibo.net/iframe.html?url=http://sports.sohu.com/20131121/n390548629.shtml" target="_blank">香港超级赛赛程</a> <a href="http://www.qqzhibo.net/iframe.html?url=http://sports.sohu.com/20130120/n364073562.shtml" target="_blank">2013羽联超级赛各站冠军榜</a> <a href="http://www.qqzhibo.net/iframe.html?url=http://sports.sohu.com/20121226/n361623496.shtml" target="_blank">2013羽毛球赛程</a> <a href="http://www.qqzhibo.net/iframe.html?url=http://others.sports.sina.com.cn/rank/bmf.php" target="_blank">羽毛球排名</a></p>
                </div>
            </div>
            <div class="box">
                <h3>{{substr($match['time'], 0, 16)}} {{$info}}</h3>
                <div class="info">
                    @if($match['sport'] != 3)
                    <p>对阵双方：主队：{{$match['hname']}}　客队：{{$match['aname']}}</p>
                    @endif
                    <p>开赛时间：{{substr($match['time'], 0, 16)}}</p>
                    <p>比赛时长：2小时</p>
                    <p>赛事类型：<a href="/live/yumaoqiu/">{{$league}}直播</a></p>
                    <p><b style="color:red;">我们为您找到以下相关视频↓</b></p><p><a class="v" href="http://www.qqzhibo.net/video/yumaoqiu/31528.html" title="8月30日 世界羽毛球锦标赛半决赛 全场录像回放" target="_blank">8月30日 世界羽毛球锦标赛半决赛 全场录像回放</a></p><p><a class="v" href="http://www.qqzhibo.net/video/yumaoqiu/29633.html" title="5月23日 汤尤杯羽毛球赛半决赛 中国VS日本 全场录像" target="_blank">5月23日 汤尤杯羽毛球赛半决赛 中国VS日本 全场录像</a></p><p><a class="v" href="http://www.qqzhibo.net/video/yumaoqiu/29631.html" title="5月23日 汤尤杯羽毛球赛半决赛 全场录像回放" target="_blank">5月23日 汤尤杯羽毛球赛半决赛 全场录像回放</a></p><p><a class="v" href="http://www.qqzhibo.net/video/yumaoqiu/29623.html" title="5月22日 汤尤杯羽毛球赛1/4决赛 全场录像回放" target="_blank">5月22日 汤尤杯羽毛球赛1/4决赛 全场录像回放</a></p><p><a class="v" href="http://www.qqzhibo.net/video/yumaoqiu/29608.html" title="5月21日 尤伯杯羽毛球赛 中国VS中华台北 全场录像" target="_blank">5月21日 尤伯杯羽毛球赛 中国VS中华台北 全场录像</a></p><p><a class="v" href="http://www.qqzhibo.net/video/yumaoqiu/29594.html" title="5月20日 汤姆斯杯羽毛球赛 中国VS中华台北 全场录像" target="_blank">5月20日 汤姆斯杯羽毛球赛 中国VS中华台北 全场录像</a></p><p><a class="v" href="http://www.qqzhibo.net/video/yumaoqiu/29592.html" title="5月20日 汤姆斯杯羽毛球赛 丹麦VS英格兰 全场录像" target="_blank">5月20日 汤姆斯杯羽毛球赛 丹麦VS英格兰 全场录像</a></p><p><a class="v" href="http://www.qqzhibo.net/video/yumaoqiu/29561.html" title="5月18日 尤伯杯羽毛球赛 泰国VS中国香港 全场录像" target="_blank">5月18日 尤伯杯羽毛球赛 泰国VS中国香港 全场录像</a></p><p><a class="v" href="http://www.qqzhibo.net/video/yumaoqiu/29560.html" title="5月18日 尤伯杯羽毛球赛 中国VS俄罗斯 全场录像" target="_blank">5月18日 尤伯杯羽毛球赛 中国VS俄罗斯 全场录像</a></p><p><a class="v" href="http://www.qqzhibo.net/video/yumaoqiu/29550.html" title="5月18日 汤姆斯杯羽毛球赛 丹麦VS中国香港 全场录像" target="_blank">5月18日 汤姆斯杯羽毛球赛 丹麦VS中国香港 全场录像</a></p>      </div>
            </div>
            <!--相关比赛-->
            <!--介绍内容-->
        </div>
        <div class="right r">
            <div id="ad_live_right_top"><div style="clear:both"></div></div>    <div class="box">
                <h2>羽毛球视频录像<a class="more" href="http://www.qqzhibo.net/video/yumaoqiu/">+更多</a></h2>
                <ul><li><a href="http://www.qqzhibo.net/video/yumaoqiu/31528.html" target="_blank">30日 世界羽毛球锦标赛半决赛 全场录像回放</a></li><li><a href="http://www.qqzhibo.net/video/yumaoqiu/29633.html" class="hei" target="_blank">23日 羽毛球 中国vs日本</a><a href="http://www.qqzhibo.net/video/yumaoqiu/29633.html" class="ml5" target="_blank">录像</a></li><li><a href="http://www.qqzhibo.net/video/yumaoqiu/29631.html" target="_blank">23日 汤尤杯羽毛球赛半决赛 全场录像回放</a></li><li><a href="http://www.qqzhibo.net/video/yumaoqiu/29623.html" target="_blank">22日 汤尤杯羽毛球赛1/4决赛 全场录像回放</a></li><li><a href="http://www.qqzhibo.net/video/yumaoqiu/29608.html" class="hei" target="_blank">21日 羽毛球 中国vs中华台北</a><a href="http://www.qqzhibo.net/video/yumaoqiu/29608.html" class="ml5" target="_blank">录像</a></li><li><a href="http://www.qqzhibo.net/video/yumaoqiu/29594.html" class="hei" target="_blank">20日 羽毛球 中国vs中华台北</a><a href="http://www.qqzhibo.net/video/yumaoqiu/29594.html" class="ml5" target="_blank">录像</a></li><li><a href="http://www.qqzhibo.net/video/yumaoqiu/29592.html" class="hei" target="_blank">20日 羽毛球 丹麦vs英格兰</a><a href="http://www.qqzhibo.net/video/yumaoqiu/29592.html" class="ml5" target="_blank">录像</a></li><li><a href="http://www.qqzhibo.net/video/yumaoqiu/29561.html" class="hei" target="_blank">18日 羽毛球 泰国vs中国香港</a><a href="http://www.qqzhibo.net/video/yumaoqiu/29561.html" class="ml5" target="_blank">录像</a></li><li><a href="http://www.qqzhibo.net/video/yumaoqiu/29560.html" class="hei" target="_blank">18日 羽毛球 中国vs俄罗斯</a><a href="http://www.qqzhibo.net/video/yumaoqiu/29560.html" class="ml5" target="_blank">录像</a></li><li><a href="http://www.qqzhibo.net/video/yumaoqiu/29550.html" class="hei" target="_blank">18日 羽毛球 丹麦vs中国香港</a><a href="http://www.qqzhibo.net/video/yumaoqiu/29550.html" class="ml5" target="_blank">录像</a></li><li><a href="http://www.qqzhibo.net/video/yumaoqiu/28954.html" target="_blank">25日 亚洲羽毛球锦标赛1/4决赛 全场录像回放</a></li><li><a href="http://www.qqzhibo.net/video/yumaoqiu/28531.html" target="_blank">13日 羽毛球世界羽联超级系列赛新加坡公开赛决赛 全场录像</a></li><li><a href="http://www.qqzhibo.net/video/yumaoqiu/22892.html" class="hei" target="_blank">08日 羽毛球 辽宁vs浙江</a><a href="http://www.qqzhibo.net/video/yumaoqiu/22892.html" class="ml5" target="_blank">录像</a></li><li><a href="http://www.qqzhibo.net/video/yumaoqiu/22807.html" class="hei" target="_blank">07日 羽毛球 湖北vs八一</a><a href="http://www.qqzhibo.net/video/yumaoqiu/22807.html" class="ml5" target="_blank">录像</a></li><li><a href="http://www.qqzhibo.net/video/yumaoqiu/22037.html" target="_blank">22日 2013香港羽毛球公开赛视频录像</a></li></ul>
            </div>
            <div id="ad_live_right"></div>  </div>
        <div class="c"></div>
    </div>
@endsection