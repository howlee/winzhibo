@extends('pc.layout.base')
@section('main')
    <div id="zc_main">
        <div class="left l">
            <div class="list">
                <h2>综合视频录像集锦</h2>
                <ul>
                    @foreach($videos as $video)
                        <?php $info = date('m月d日 H:i', $video['time']) .' ' . $video['lname'] . ' ' . $video['hname'] . ' VS ' . $video['aname']; ?>
                        <li>
                            <a class="v" href="/live/videos/detail/{{$video['id']}}.html" title="{{$info}}" target="_blank">{{$info}}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
            @component('pc.video.list_page_cell', ['page'=>$page]) @endcomponent
        </div>
        <div class="right r">
            @if(isset($matches))
                <div class="box">
                    <h2>赛事直播列表<a class="more" href="/">+更多</a></h2>
                    <ul id="content_zuqiu">
                        @foreach($matches as $match)
                            <?php
                                $sport = $match['sport'];
                                $type = $sport == 1 ? 'football' : ($sport == 2 ? 'basketball' : 'other');
                                $time = date('m-d H:i', strtotime($match['time']));
                                if ($sport == 3) {
                                    $info = $match['lname'] . ' ' . $match['hname'] . (empty($match['aname']) ? '' : (' VS ' . $match['aname']) );
                                } else {
                                    $info = $match['win_lname'] . ' ' . $match['hname'] . ' VS ' . $match['aname'];
                                }
                            ?>
                            <li>
                                <a href="/live/{{$type}}/{{$match['mid']}}.html" class="hei" target="_blank">{{$info}}</a>
                                <a href="/live/{{$type}}/{{$match['mid']}}.html" class="ml5" target="_blank">高清直播</a>
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