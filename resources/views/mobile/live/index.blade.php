@extends('mobile.layout.base')
@section("content")
<div class="container">
    <div class="wrap">
        <div class="header">
            <a href="{{$m}}"><img src="/img/mobile/wap_logo.png"/></a>
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
                                    <bifen class="id126275">
                                        <p class="score-num gray"><span class="score score126275"> VS </span></p>
                                    </bifen>
                                    <p class="live" style="">{{$match['league_name']}} </p>
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

        <div class="game-list" style="display:none;">
            @foreach($footballs as $time=>$array)
                <h2 class="today">{{$time}}</h2>
                @foreach($array as $match)
                    <?php
                    $sport = $match['sport'];
                    $pName = $sport == 1 ? 'football' : ($sport == 2 ? 'basketball' : 'other');
                    ?>
                    @continue($sport != 1)
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
                                    <bifen class="id126275">
                                        <p class="score-num gray"><span class="score score126275"> VS </span></p>
                                    </bifen>
                                    <p class="live" style="">{{$match['league_name']}} </p>
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

        <div class="game-list" style="display:none;">
            @foreach($basketballs as $time=>$array)
                <h2 class="today">{{$time}}</h2>
                @foreach($array as $match)
                    <?php
                    $sport = $match['sport'];
                    $pName = $sport == 1 ? 'football' : ($sport == 2 ? 'basketball' : 'other');
                    ?>
                    @continue($sport != 2)
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
                                    <bifen class="id126275">
                                        <p class="score-num gray"><span class="score score126275"> VS </span></p>
                                    </bifen>
                                    <p class="live" style="">{{$match['league_name']}} </p>
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

        <div class="footer-bar">
            <a class="active" style="width: 50%;"><i class="live-on"></i><p>直播</p></a>
            <a href="{{$m}}/video/" style="width: 50%;"><i class="luxiang"></i><p>录像</p></a>
        </div>
    </div>
</div>
@endsection