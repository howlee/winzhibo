@extends('pc.layout.base')
@section("meta")
<meta name="robots"content="nofollow">
@endsection
@section('crumbs')
    <div class="crumbs">
        <a href="/">首页</a>@if(isset($parent)) - <a href="{{$parent["link"]}}">{{$parent["name"]}}</a>@endif - <span>{{$info}}</span>
    </div>
@endsection
@section('main')
    <div id="zc_main">
        <div class="left l" style="width: 960px;">
            <div class="live" style="width: 940px;">
                <h2>{{isset($match['time']) ? substr($match['time'], 0, 11) : ''}} {{$info}}</h2>
                <div class="tip">如果以下信号都无效，请进入<a href="/">球探直播</a>主页查看最新直播信号 </div>
                {{--<h3>{{isset($match['time']) ? substr($match['time'], 0, 16) : ''}} {{$info}}</h3>--}}
                <div class="info">{{-- style="height: 500px;" --}}
                    {{--<iframe style="border: none;" src="/live/player/{{$match["sport"]}}_{{$match["mid"]}}.html" width="100%" height="100%" scrolling="no"></iframe>--}}
                    @if($match['sport'] != 3)
                        <p>对阵双方：主队：{{$match['hname']}}　客队：{{$match['aname']}}</p>
                    @endif
                    <p>开赛时间：{{isset($match['time']) ? substr($match['time'], 0, 16) : ''}}</p>
                    <p>比赛时长：2小时</p>
                </div>
            </div>
            <div class="box" style="width: 960px;height: 500px;">
                <iframe style="border: none;" src="{{env("PLAYER_URL")}}/player/{{$match["sport"] . $match["mid"]}}.html" width="100%" height="100%" scrolling="no"></iframe>
            </div>
            <!--相关比赛-->
            <!--介绍内容-->
        </div>
        <div class="c"></div>
    </div>
@endsection