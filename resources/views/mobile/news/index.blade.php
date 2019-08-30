@extends("mobile.layout.base")
@section("css")
<style>
    .news {
        display: block;
        height: 80px;
    }
    .news span {
        display: block;font-size: 12px;line-height: 30px;color: #999;
    }
</style>
@endsection
@section("body_att") onscroll="scrollBottom(loadVideos);" @endsection
@section("content")
<div class="container">
    <div class="wrap">
        <div class="header">
            <a href="{{$m}}/"><img src="/img/mobile/wap_logo.png"/></a>
        </div>
        <div class="game-list" style="display:block;">
            @foreach($news as $item)
                <a href="{{$m}}/{{$prefix}}/{{$item['id']}}.html" class="game-item news" style="padding: 10px 20px;">
                    {{$item["title"]}}
                    <span>
                        发布时间：{{substr($item['publish_at'], 0, 16)}}&nbsp;&nbsp;&nbsp;&nbsp;
                        作者：{{$item["author"]}}
                    </span>
                </a>
            @endforeach
        </div>
        @include('mobile.layout.bottom')
    </div>
</div>
@endsection
@section("js")
    <script type="text/javascript">
        window.m = '{{$m}}';
        window.tuijian = '{{$prefix == 'tuijian' ? 1 : 0}}';
    </script>
    <script type="text/javascript" src="/js/m/news.js"></script>
@endsection