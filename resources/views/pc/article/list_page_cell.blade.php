<?php
    $lastPage = isset($page) ? $page->lastPage() : 1;
    $curPage = $page->currentPage();
    $prefix = isset($prefix) ? $prefix : "news";
?>
@if($lastPage > 1)
    <div class="pages"><span>共{{$page->total()}}条</span>
    <?php
        $index = 0; $showBtn = 7;
        if ($lastPage - $curPage <= 3) {
            $index = $lastPage - $showBtn;
        } else {
            $index = $curPage - 3;
        }
        $index = $index <= 1 ? 2 : $index;
    ?>
    @if($lastPage > 7 && $curPage != 1)
        <a href="/{{$prefix}}/index{{$curPage - 1}}.html" class="a1">上一页</a>
    @endif
    @if($curPage == 1)
        <strong>1</strong>
    @else
        <a href="/{{$prefix}}/">1 @if($index > 2)...@endif</a>
    @endif
    @for($f_index = 0; $f_index < $showBtn; $f_index++)
        @continue($index >= $lastPage)
        @if($curPage == $index)
            <strong>{{$index}}</strong>
        @else
            <a href="/{{$prefix}}/index{{$index}}.html" >{{$index}}</a>
        @endif
        <?php $index++; ?>
    @endfor
    @if($curPage == $lastPage)
        <strong>{{$lastPage}}</strong>
    @else
        <a href='/{{$prefix}}/index{{$lastPage}}.html' >@if($index < $lastPage)...@endif{{$lastPage}}</a>
    @endif
    @if ($lastPage > 7 && $curPage != $lastPage) <a href="/{{$prefix}}/index{{$curPage + 1}}.html" class="a1">下一页</a> @endif
    </div>
@endif