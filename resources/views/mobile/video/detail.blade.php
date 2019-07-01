@extends("mobile.layout.base")
@section("css")
    <link href="/css/mobile/video/detail.css" rel="stylesheet" >
@endsection
@section("content")
    <div class="container">
        <div class="wrap" style="background-color: #ffffff;">
            <div class="header">
                <a href="{{$m}}"><img src="/img/mobile/wap_logo.png"/></a>
            </div>
            <div class="crumbs"><a href="{{$m}}">首页</a> - <a href="{{$m}}/video/">录像</a> - <span>{{$video["lname"]}} {{$video["hname"]}} vs {{$video["aname"]}}</span></div>
            <div class="game-list" style="display:block;">
                <div class="game-item cPbtn" style="text-align: center;">
                    <div class="team-left">
                        <img src="{{$hicon}}">
                        <p style="font-weight:bold;">{{$video["hname"]}}</p>
                    </div>
                    <div class="game-info">
                        <div class="team-score">
                            <p class="live" style="">{{$video["lname"]}}</p>
                            <bifen class="id126275">
                                <p class="score-num gray"><span class="score"> VS </span></p>
                            </bifen>
                            <p class="time" style=""><span>{{substr($video["time"], 0, 16)}}</span></p>
                        </div>
                    </div>
                    <div class="team-right">
                        <img src="{{$aicon}}">
                        <p style="font-weight:bold;">{{$video["aname"]}}</p>
                    </div>
                    <div class="clear"></div>
                </div>
                <div style="height: 350px">
                    <div class="video">录像信号</div>
                    <div class="channels">
                        @foreach($channels as $channel)
                            <a target="_blank" href="{{$channel["content"]}}">{{$channel["title"]}}</a>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="footer-bar">
                <a href="/m/" style="width: 50%;"><i class="live"></i><p>直播</p></a>
                <a href="{{$m}}/video/" style="width: 50%;"><i class="luxiang"></i><p>录像</p></a>
            </div>
        </div>
    </div>
@endsection