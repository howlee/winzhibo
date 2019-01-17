<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <meta charset="UTF-8">
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Keywords" content="">
    <meta name="Description" content="">
    <meta http-equiv="X-UA-Compatible" content="edge" />
    <link rel="stylesheet" type="text/css" href="/css/pc/player.css">
</head>
<body>
    <div id="MyPlayer" class="hasList">
        <ul class="list pc" style="display: none">
            <span>信号源：</span>
            @foreach($pcChannels as $index=>$pch)
                @continue($pch["player"] == 16)
                <li class="li {{$index == 0 ? "on" : ""}}" onclick="changeLine(this)" channelId="{{$pch["channelId"]}}" >{{$pch["name"]}}</li>
                @if($index == 0)<a href="" target="_blank" class="li" style="background: #8751E7;">{{$adName}}</a>@endif
            @endforeach
        </ul>
        <ul class="list m" style="display: none">
            <span>信号源：</span>
            @foreach($mChannels as $index=>$mch) @continue($mch["player"] == 16)
                <li class="li {{$index == 0 ? "on" : ""}}" onclick="changeLine(this)" channelId="{{$mch["channelId"]}}" >{{$mch["name"]}}</li>
                @if($index == 0)<a href="" target="_blank" class="li" style="background: #8751E7;">{{$adName}}</a>@endif
            @endforeach
        </ul>
        <div class="player">
            <div class="noLive">
                <p>距离比赛还有 <b>-:-:-</b></p>
                {{--<p>加微信 <b>kanqiu8888</b></p>--}}
                {{--<p>与球迷赛事交流，乐享高清精彩赛事！</p>--}}
            </div>
        </div>
    </div>
</body>
<script type="text/javascript" src="/js/jquery1.11.1.min.js"></script>
<script type="text/javascript" src="/js/player/ckplayer/ckplayer.js"></script>
<script type="text/javascript" src="/js/player/player.js"></script>
<script type="text/javascript">

    var time = parseInt('{{$time}}');
    window.ep = 0;

    function isLive() {
        var now = (new Date()).getTime() / 1000;
        return parseInt('{{$live ? 1 : 0}}') || ( time - now < 30 * 60 ) ;
    }

    function isPhone() {
        if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
            return true;
        }else{
            return false;
        }
    }

    function loadLine(obj) {
        if (!isLive()) return;
        var cid;
        if (!obj) {
            if (isPhone()) {
                obj = $("#MyPlayer ul.m li.on")[0];
            } else {
                obj = $("#MyPlayer ul.pc li.on")[0];
            }
        }
        cid = obj.getAttribute("channelId");
        var url;
        if (isPhone()) {
            url = "/json/channels/m/{{$sport}}{{$mid}}.json";
        } else {
            url = "/json/channels/pc/{{$sport}}{{$mid}}.json";
        }
        $.ajax({
            "url": url,
            "dataType": "json",
            "success": function (channels) {
                for (var index = 0; index < channels.length; index++) {
                    var channel = channels[index];
                    var channelId = channel.channelId;
                    if (channelId == cid) {
                        var cp = channel.player;
                        var link = channel.link;
                        if (cp == 11) {
                            player = null;
                            $("div.player").html('<iframe src="'+link+'" width="100%" height="100%" scrolling="no"></iframe>');
                            break;
                        } else {
                            goPlay(link);
                            break;
                        }
                    }
                }
            },
            "error": function () {

            }
        });
    }

    //倒计时
    function countdown() {
        var now = (new Date()).getTime() / 1000;
        if (now >= time && window.ep < 2) {//现在大于等比赛时间，再请求一次
            window.errorRepeat++;
            loadLine();
            return;
        }
        if (now >= time && window.ep >= 2) {
            return;
        }
        var hour = Math.floor( (time - now) / (60 * 60) );
        var minute = Math.floor( (time - now - hour * 60 * 60) / 60 );
        var second = Math.floor( (time - now - hour * 60 * 60 - minute * 60) );

        hour = hour < 10 ? "0" + hour : hour;
        minute = minute < 10 ? "0" + minute : minute;
        second = second < 10 ? "0" + second : second;

        var html = hour + ":" + minute + ":" + second;
        var $b = $("div.noLive p:first b");
        if ($b.length > 0) {
            $b.html(html);
        }
        setTimeout(countdown, 1000);
    }


    if (isPhone()) {
        $("#MyPlayer ul.m").show();
    } else {
        $("#MyPlayer ul.pc").show();
    }

    if (isLive()) {
        //获取线路
        loadLine();
    } else {
        countdown()//倒计时
    }
    
    
</script>
</html>