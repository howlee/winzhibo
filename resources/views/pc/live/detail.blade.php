@extends('pc.layout.base')
@section('main')
    <div id="zc_main">
        <div class="left l" style="width: 960px;">
            <div class="live" style="width: 940px;">
                <h2>{{isset($match['time']) ? substr($match['time'], 0, 11) : ''}} {{$info}}</h2>
                <div class="tip">如果以下信号都无效，请进入<a href="/">球探直播</a>主页查看最新直播信号 </div>
                <div class="channel">
                    <p>【站外直播】： <a href="http://www.aikq.cc/live/spPlayer/player-{{$match['mid']}}-{{$match['sport']}}.html" target="_blank">高清直播</a></p>
                </div>
            </div>
            <div class="box" style="width: 960px;">
                <h3>{{isset($match['time']) ? substr($match['time'], 0, 16) : ''}} {{$info}}</h3>
                <div class="info">
                    @if($match['sport'] != 3)
                    <p>对阵双方：主队：{{$match['hname']}}　客队：{{$match['aname']}}</p>
                    @endif
                    <p>开赛时间：{{isset($match['time']) ? substr($match['time'], 0, 16) : ''}}</p>
                    <p>比赛时长：2小时</p>
                </div>
            </div>
            <!--相关比赛-->
            <!--介绍内容-->
        </div>
        <div class="c"></div>
    </div>
@endsection