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
            @include('mobile.layout.bottom')
        </div>
    </div>
@endsection