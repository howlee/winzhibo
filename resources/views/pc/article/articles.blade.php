@extends('pc.layout.base')
@section('main')
    <div id="zc_main">
        <div class="left l">
            <div class="list">
                <h2>热点资讯</h2>
                <ul>
                    @foreach($articles as $article)
                        <?php $info = $article->title; ?>
                        <li>
                            <a class="v" href="{{$article->url}}" title="{{$info}}" target="_blank">{{$info}}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
            @component('pc.article.list_page_cell', ['page'=>$articles]) @endcomponent
        </div>
        <div class="right r">
            @if(isset($matches))
                <div class="box">
                    <h2>赛事直播列表<a class="more" href="/">+更多</a></h2>
                    <ul id="content_zuqiu">
                        @foreach($matches as $match)
                            <?php
                                $sport = $match['sport'];
                                $type = \App\Http\Controllers\PC\Live\LiveController::SPORT_VAL_ARRAY[$sport];
                                $time = date('m-d H:i', strtotime($match['time']));
                                if ($sport == 3) {
                                    $info = $match['lname'] . ' ' . $match['hname'] . (empty($match['aname']) ? '' : (' VS ' . $match['aname']) );
                                } else {
                                    $info = $match['league_name'] . ' ' . $match['hname'] . ' VS ' . $match['aname'];
                                }
                            ?>
                            <li>
                                <a href="/{{$type}}/{{$match['mid']}}.html" class="hei" target="_blank">{{$info}}</a>
                                <a href="/{{$type}}/{{$match['mid']}}.html" class="ml5" target="_blank">高清直播</a>
                            </li>
                        @endforeach
                    </ul>
                    <ul style="display:none"></ul>
                </div>
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