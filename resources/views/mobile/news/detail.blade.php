@extends("mobile.layout.base")
@section("css")
    <link href="/css/mobile/news/detail.css" rel="stylesheet" >
@endsection
@section("content")
    <div class="container">
        <div class="wrap" style="background-color: #ffffff;">
            <div class="header">
                <a href="{{$m}}"><img src="/img/mobile/wap_logo.png"/></a>
            </div>
            <div class="crumbs"><a href="{{$m}}">首页</a> - <a href="{{$m}}/news/">资讯</a> - <span>{{$news["title"]}}</span></div>
            <div class="title">{{$news["title"]}}</div>
            <div class="info">发布时间：{{substr($news['publish_at'], 0, 16)}} &nbsp;&nbsp;&nbsp;作者：{{$news['author']}}</div>
            <div class="content">
                {!! $news->getContent() !!}
            </div>
            <div class="footer-bar">
                <a href="/m/" style="width: 50%;"><i class="live"></i><p>直播</p></a>
                <a href="{{$m}}/video/" style="width: 50%;"><i class="luxiang"></i><p>录像</p></a>
            </div>
        </div>
    </div>
@endsection