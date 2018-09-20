@extends('pc.layout.base')
@section('main')
    <div id="zc_main">
        <div class="left l" style="width: 960px;">
            <div class="live" style="width: 940px;">
                <h2>{{$article->title}}</h2>
                <div class="tip">发布时间：{{substr($article->publish_at, 0, 16)}} &nbsp;&nbsp;作者：{{$article->author}} &nbsp;&nbsp;来源：{{$article->resource}}</div>
                <div class="channel" style="width: 100%;">
                    {!! $article->getContent() !!}
                </div>
            </div>
            <!--相关比赛-->
            <!--介绍内容-->
        </div>
        <div class="c"></div>
    </div>
@endsection