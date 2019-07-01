@extends('pc.layout.base')
@section('main')
    <div id="zc_main">
        <div class="left l">
            @if(isset($imArray) && count($imArray) > 0)
            <div class="box">
                <h2 class="cp">
                    <b>推荐</b>重点推荐<span id="list_rec_span"></span><img id="list_rec_img" src="/img/pc/show_no.gif" title="收起/展开" alt="收起/展开">
                </h2>
                <div class="rec_match">
                    @foreach($imArray as $match)
                        <?php $sport = $match['sport']; $type = $sport_val[$sport]; ?>
                        <a href="/{{$type}}/{{$match['mid']}}.html" title="{{date('m月d日 H:i', strtotime($match['time']))}} {{$match['league_name']}} {{$match['hname']}}VS{{$match['aname']}}" target="_blank">{{$match['hname']}} VS {{$match['aname']}}</a>
                    @endforeach
                    <div class="c"></div>
                </div>
            </div>
            @endif
            @foreach($matches as $time=>$matchArray) <?php $w = date('w', strtotime($time)); $wCn = $week_array[$w]; $isToday = date('Y-m-d') == $time; ?>
            <div class="box">
                <h2 class="cp">
                    <b @if($isToday) class="h" @endif >{{$wCn}}</b>{{$time}} {{$wCn}} 直播节目表<span></span>
                    <img src="/img/pc/show_no.gif" title="收起/展开" alt="收起/展开">
                </h2>
                <ul>
                    @foreach($matchArray as $match)
                        @continue($match["status"] < 0)
                        <?php
                        $hourCn = date('H:i', strtotime($match['time']));
                        $league = $match['league_name'];
                        $sport = $match['sport'];
                        $type = $sport_val[$sport];
                        if ($sport == 1) {
                            $sportCn = '足球';
                        } else if ($sport == 2) {
                            $sportCn = '篮球';
                        } else if ($sport == 3) {
                            $sportCn = empty($match['project']) ? '节目' : $match['project'];
                        }
                        $league = empty($league) ? $sportCn : $league;
                        $matchInfo = $match['hname'];
                        if (!empty($match['aname'])) {
                            $matchInfo = $matchInfo . ' VS ' . $match['aname'];
                        }
                        $m_title = date('m月d日 H:i', strtotime($match['time'])) . ' ' . $sportCn . ' ' . $matchInfo . '直播';
                        ?>
                        <li>
                            <div class="tit">
                                {{$hourCn}}<strong class="b"><a target="_blank" href="/{{$type}}/" title="{{$league}}直播">{{$league}}</a></strong>
                                <a href="/{{$type}}/{{$match['mid']}}.html" title="{{$m_title}}" target="_blank">{{$matchInfo}}</a>
                            </div>
                            <div class="con">
                                <a href="/{{$type}}/{{$match['mid']}}.html" target="_blank">球探直播</a>
                            </div>
                        </li>
                    @endforeach
                </ul>
                <div class="c"></div>
            </div>
            @endforeach
        </div>
        <div class="right r">
            @if(isset($articles))
                <div class="box">
                    <h2>热点资讯<a class="more" target="_blank" href="/news">+更多</a></h2>
                    <ul id="content_zuqiu">
                        @foreach($articles as $article)
                            <li><a href="/news/{{$article->id}}.html" class="hei" target="_blank">{{$article->title}}</a></li>
                        @endforeach
                    </ul>
                    <ul style="display:none"></ul>
                </div>
            @endif
            @if(isset($videos))
                @foreach($videos as $data)
                    <div class="box">
                        <h2>{{isset($data['league']['lname']) ? $data['league']['lname'] : ''}}视频录像<a class="more" href="/video/">+更多</a></h2>
                        <ul id="content_zuqiu">
                            @foreach($data['videos'] as $video)
                                <?php $time = date('m-d H:i', strtotime($video['time'])); ?>
                                <li>
                                    <a href="/video/{{$video['id']}}.html" class="hei" target="_blank">{{$video['hname'] . ' VS ' . $video['aname']}}</a>
                                    <a href="/video/{{$video['id']}}.html" class="ml5" target="_blank">录像</a>
                                </li>
                            @endforeach
                        </ul>
                        <ul style="display:none"></ul>
                    </div>
                @endforeach
            @endif
        </div>
        <div class="c"></div>
    </div>
@endsection
@section('js')
    <script>
        $("h2.cp").click(function () {
            var $this = $(this);
            var $next = $this.next();
            var display = $next.css('display');
            if (display == 'none') {
                $this.find('img').attr('src', '/img/pc/show_yes.gif');
                $next.show();
            } else {
                $this.find('img').attr('src', '/img/pc/show_no.gif');
                $next.hide();
            }
        });
    </script>
@endsection