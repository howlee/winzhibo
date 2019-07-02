@extends('mobile.layout.base')
@section("content")
<div class="container">
    <div class="wrap">
        <div class="header">
            <a href="{{$m}}"><img src="/img/mobile/wap_logo.png"/></a>
        </div>
        <div class="module saishi shaixuan">
            <span value="all" @if($sport == 0)class="current"@endif>@if($sport == 0) 全部 @else <a href="{{$m}}/">全部</a> @endif</span>
            <span value="football" @if($sport == 1)class="current"@endif>@if($sport == 1) 足球 @else <a href="{{$m}}/zuqiu/" >足球</a> @endif</span>
            <span value="basketball" @if($sport == 2)class="current"@endif>@if($sport == 2) 篮球 @else <a href="{{$m}}/nba/" >篮球</a> @endif</span>
        </div>
        <div class="game-list" style="display:block;">
            @foreach($matches as $time=>$array)
                <h2 class="today">{{$time}}</h2>
                @foreach($array as $match)
                    @continue($match["status"] < 0)
                    <?php
                    $sport = $match['sport'];
                    $pName = $sport == 1 ? 'football' : ($sport == 2 ? 'basketball' : 'other');
                    ?>
                    <a href="{{$m}}/{{$sport_val[$sport]}}/{{$match['mid']}}.html" class="game-item cPbtn" style="text-align: center;">
                        @if($sport == 3)
                            <p style="font-weight:bold;">  {{$match['hname'] . (empty($match['aname']) ? '' : (' VS ' . $match['aname']) ) }}</p>
                            <p class="time" style=""><span>{{substr($match['time'], 10, 6)}}</span></p>
                        @else
                            <div class="team-left">
                                <img src="{{!empty($match['host_icon']) ? ($match['host_icon']) : '//static.liaogou168.com/img/icon_team_default.png'}}" >
                                <p style="font-weight:bold;">  {{$match['hname']}}</p>
                            </div>
                            <div class="game-info">
                                <div class="team-score">
                                    <p class="live" style="">{{$match['league_name']}}</p>
                                    <bifen class="id126275">
                                        <p class="score-num gray"><span class="score score126275"> VS </span></p>
                                    </bifen>
                                    <p class="time" style=""><span>{{substr($match['time'], 10, 6)}}</span></p>
                                </div>
                            </div>
                            <div class="team-right">
                                <img src="{{!empty($match['away_icon']) ? ($match['away_icon']) : '//static.liaogou168.com/img/icon_team_default.png'}}" >
                                <p style="font-weight:bold;">{{$match['aname']}}</p>
                            </div>
                            <div class="clear"></div>
                        @endif
                    </a>
                @endforeach
            @endforeach
        </div>
        @include('mobile.layout.bottom')
    </div>
</div>
@endsection