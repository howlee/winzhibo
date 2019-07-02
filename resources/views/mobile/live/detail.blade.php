@extends('mobile.layout.base')
@section('content')
    <div class="container">
        <div class="wrap" style="background-color: #ffffff;">
            <div class="header">
                <a href="{{$m}}"><img src="/img/mobile/wap_logo.png"/></a>
            </div>
            <div class="crumbs"><a href="{{$m}}">首页</a> @if(isset($parent)) - <a href="{{$m . $parent['link']}}">{{$parent['name']}}</a> @endif - <span>{{$match["league_name"]}} {{$match["hname"]}} vs {{$match["aname"]}}</span></div>
            <div class="game-list" style="display:block;">
                <div class="game-item cPbtn" style="text-align: center;">
                    <div class="team-left">
                        <img src="{{$hicon}}">
                        <p style="font-weight:bold;">{{$match["hname"]}}</p>
                    </div>
                    <div class="game-info">
                        <div class="team-score">
                            <bifen class="id126275">
                                <p class="score-num gray"><span class="score"> VS </span></p>
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
            @include('mobile.layout.bottom')
        </div>
</div>
@endsection