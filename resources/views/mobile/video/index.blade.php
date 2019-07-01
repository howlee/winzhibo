@extends("mobile.layout.base")
@section("body_att") onscroll="scrollBottom(loadVideos);" @endsection
@section("content")
<div class="container">
    <div class="wrap">
        <div class="header">
            <a href="{{$m}}/"><img src="/img/mobile/wap_logo.png"/></a>
        </div>
        <div class="game-list" style="display:block;">
            @foreach($videos as $date=>$array)
                <h2 class="today">{{$date}}</h2>
                <div>
                @foreach($array as $video)
                    <?php
                        $id = $video['id'];
                        $path = $m . "/video/" . $id .".html";
                        $hicon = !empty($match['hicon']) ? ($match['hicon']) : '//static.liaogou168.com/img/icon_team_default.png';
                        $aicon = !empty($match['aicon']) ? $match['aicon'] : '//static.liaogou168.com/img/icon_team_default.png';

                        $hicon = str_replace('static.cdn.dlfyb.com', 'static.liaogou168.com', $hicon);
                        $aicon = str_replace('static.cdn.dlfyb.com', 'static.liaogou168.com', $aicon);
                    ?>
                    @continue(empty($path))
                    <a href="{{$path}}" class="game-item cPbtn" style="text-align: center;">
                        <div class="team-left">
                            <img src="{{$hicon}}" >
                            <p style="font-weight:bold;">  {{$video['hname']}}</p>
                        </div>
                        <div class="game-info">
                            <div class="team-score">
                                <p class="live" style="">{{$video['lname']}} </p>
                                <bifen class="id126275">
                                    <p class="score-num gray"><span class="score score126275"> VS </span></p>
                                </bifen>
                                <p class="time" style=""><span>{{date('H:i', strtotime($video['time']))}}</span></p>
                            </div>
                        </div>
                        <div class="team-right">
                            <img src="{{$aicon}}" >
                            <p style="font-weight:bold;">{{$video['aname']}}</p>
                        </div>
                        <div class="clear"></div>
                    </a>
                @endforeach
                </div>
            @endforeach
        </div>

        <div class="footer-bar">
            <a href="/m/" style="width: 50%;"><i class="live"></i><p>直播</p></a>
            <a class="active" style="width: 50%;"><i class="luxiang-on"></i><p>录像</p></a>
        </div>
    </div>
</div>
@endsection
@section("js")
    <script type="text/javascript" src="/js/m/videos.js"></script>
    <script type="text/javascript">
    </script>
@endsection