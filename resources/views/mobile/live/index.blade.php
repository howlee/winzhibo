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
    <link href="/css/mobile/style.css" rel="stylesheet" >
    <link href="/css/mobile/font-awesome.min.css" rel="stylesheet">
    <script type="text/javascript" src="//apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
    <meta HTTP-EQUIV="Pragma" CONTENT="no-cache">
    <meta HTTP-EQUIV="Cache-Control" CONTENT="no-cache">
    <meta HTTP-EQUIV="Expires" CONTENT="0">
</head>
<body>
<div class="container">
    <div class="wrap">
        <div class="header">
            <a href="/m/index.html"><img src="/img/mobile/wap_logo.png"/></a>
        </div>
        <div class="module saishi shaixuan">
            <span value="all" class="current">全部</span>
            <span value="football">足球</span>
            <span value="basketball">篮球</span>
        </div>
        <div class="game-list" style="display:block;">
            @foreach($matches as $time=>$array)
                <h2 class="today">{{$time}}</h2>
                @foreach($array as $match)
                    <?php
                        $sport = $match['sport'];
                        $pName = $sport == 1 ? 'football' : ($sport == 2 ? 'basketball' : 'other');
                    ?>
                    <a href="https://www.aikq.cc/m/live/{{$pName}}/{{$match['mid']}}.html" class="game-item cPbtn" style="text-align: center;">
                    @if($sport == 3)
                        <p style="font-weight:bold;">  {{$match['hname'] . (empty($match['aname']) ? '' : (' VS ' . $match['aname']) ) }}</p>
                        <p class="time" style=""><span>{{substr($match['time'], 10, 6)}}</span></p>
                    @else
                        <div class="team-left">
                            <img src="{{!empty($match['home']['lg_icon']) ? ('http://static.liaogou168.com' . $match['home']['lg_icon']) : '//static.liaogou168.com/img/icon_team_default.png'}}" >
                            <p style="font-weight:bold;">  {{$match['hname']}}</p>
                        </div>
                        <div class="game-info">
                            <div class="team-score">
                                <bifen class="id126275">
                                    <p class="score-num gray"><span class="score score126275"> VS </span></p>
                                </bifen>
                                <p class="live" style="">{{$match['win_lname']}} </p>
                                <p class="time" style=""><span>{{substr($match['time'], 10, 6)}}</span></p>
                            </div>
                        </div>
                        <div class="team-right">
                            <img src="{{!empty($match['away']['lg_icon']) ? ('http://static.liaogou168.com' . $match['away']['lg_icon']) : '//static.liaogou168.com/img/icon_team_default.png'}}" >
                            <p style="font-weight:bold;">{{$match['aname']}}</p>
                        </div>
                        <div class="clear"></div>
                    @endif
                    </a>
                @endforeach
            @endforeach
        </div>

        <div class="game-list" style="display:none;">
            @foreach($footballs as $time=>$array)
                <h2 class="today">{{$time}}</h2>
                @foreach($array as $match)
                    <?php
                    $sport = $match['sport'];
                    $pName = $sport == 1 ? 'football' : ($sport == 2 ? 'basketball' : 'other');
                    ?>
                    @continue($sport != 1)
                    <a href="https://www.aikq.cc/m/live/{{$pName}}/{{$match['mid']}}.html" class="game-item cPbtn" style="text-align: center;">
                        @if($sport == 3)
                            <p style="font-weight:bold;">  {{$match['hname'] . (empty($match['aname']) ? '' : (' VS ' . $match['aname']) ) }}</p>
                            <p class="time" style=""><span>{{substr($match['time'], 10, 6)}}</span></p>
                        @else
                            <div class="team-left">
                                <img src="{{!empty($match['home']['lg_icon']) ? ('http://static.liaogou168.com' . $match['home']['lg_icon']) : '//static.liaogou168.com/img/icon_team_default.png'}}" >
                                <p style="font-weight:bold;">  {{$match['hname']}}</p>
                            </div>
                            <div class="game-info">
                                <div class="team-score">
                                    <bifen class="id126275">
                                        <p class="score-num gray"><span class="score score126275"> VS </span></p>
                                    </bifen>
                                    <p class="live" style="">{{$match['win_lname']}} </p>
                                    <p class="time" style=""><span>{{substr($match['time'], 10, 6)}}</span></p>
                                </div>
                            </div>
                            <div class="team-right">
                                <img src="{{!empty($match['away']['lg_icon']) ? ('http://static.liaogou168.com' . $match['away']['lg_icon']) : '//static.liaogou168.com/img/icon_team_default.png'}}" >
                                <p style="font-weight:bold;">{{$match['aname']}}</p>
                            </div>
                            <div class="clear"></div>
                        @endif
                    </a>
                @endforeach
            @endforeach
        </div>

        <div class="game-list" style="display:none;">
            @foreach($basketballs as $time=>$array)
                <h2 class="today">{{$time}}</h2>
                @foreach($array as $match)
                    <?php
                    $sport = $match['sport'];
                    $pName = $sport == 1 ? 'football' : ($sport == 2 ? 'basketball' : 'other');
                    ?>
                    @continue($sport != 2)
                    <a href="https://www.aikq.cc/m/live/{{$pName}}/{{$match['mid']}}.html" class="game-item cPbtn" style="text-align: center;">
                        @if($sport == 3)
                            <p style="font-weight:bold;">  {{$match['hname'] . (empty($match['aname']) ? '' : (' VS ' . $match['aname']) ) }}</p>
                            <p class="time" style=""><span>{{substr($match['time'], 10, 6)}}</span></p>
                        @else
                            <div class="team-left">
                                <img src="{{!empty($match['home']['lg_icon']) ? ('http://static.liaogou168.com' . $match['home']['lg_icon']) : '//static.liaogou168.com/img/icon_team_default.png'}}" >
                                <p style="font-weight:bold;">  {{$match['hname']}}</p>
                            </div>
                            <div class="game-info">
                                <div class="team-score">
                                    <bifen class="id126275">
                                        <p class="score-num gray"><span class="score score126275"> VS </span></p>
                                    </bifen>
                                    <p class="live" style="">{{$match['win_lname']}} </p>
                                    <p class="time" style=""><span>{{substr($match['time'], 10, 6)}}</span></p>
                                </div>
                            </div>
                            <div class="team-right">
                                <img src="{{!empty($match['away']['lg_icon']) ? ('http://static.liaogou168.com' . $match['away']['lg_icon']) : '//static.liaogou168.com/img/icon_team_default.png'}}" >
                                <p style="font-weight:bold;">{{$match['aname']}}</p>
                            </div>
                            <div class="clear"></div>
                        @endif
                    </a>
                @endforeach
            @endforeach
        </div>

        <div class="footer-bar">
            <a class="active" style="width: 50%;"><i class="live-on"></i><p>直播</p></a>
            <a href="/m/videos.html" style="width: 50%;"><i class="luxiang"></i><p>录像</p></a>
        </div>
    </div>
</div>
</body>
<script type="text/javascript">
    $(function () {
        $("div.module span").click(function () {
            var val = $(this).attr("value");

            $("div.module span").removeClass("current");
            $(this).addClass("current");

            $("div.game-list").hide();
            if (val == 'all') {
                $("div.game-list:first").show();
            } else if (val == 'football') {
                $("div.game-list:eq(1)").show();
            } else if (val == 'basketball') {
                $("div.game-list:last").show();
            }
        });
    });
</script>
</html>