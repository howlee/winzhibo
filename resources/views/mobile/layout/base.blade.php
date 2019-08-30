<!doctype html>
<html>
<head>
    <meta charset=utf8>
    <title>{{empty($title) ? '红单体育直播_足球篮球免费赛事直播,竞彩推荐' : $title}}-红单直播</title>
    <meta name="keywords" content="{{empty($keywords) ? '足球直播,英超直播,NBA直播,欧冠直播' : $keywords}}">
    <meta name="description" content="{{empty($description) ? '免费的体育直播网站。高清足球直播、NBA直播、英超直播等全部免费看。' : $description}}">
    <meta charset="utf-8" >
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no">
    <meta name="applicable-device" content="mobile" >
    @yield("first_js")
    <script>
          if(!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
                var url = window.location.href;
                var path = location.pathname;
                if (window.pathReg && window.pathReg.test(path) ) {
                  url = url.replace(path, "");
                } else if (path == "/live/" || path == "/live") {
                  url = url.replace("/live/", "").replace("/live", "");
                } else if (/^\/(\w+\/)team\d+(_\w+_\d+).html/.test(path) ) {
                  url = url.replace(/_\w+_\d+/, "");
                }
                url = url.replace(/(https?:\/\/)m\./, "$1www.");
                window.location.href = url;
          }
    </script>
    <link href="/css/mobile/style.css" rel="stylesheet" >
    <link href="/css/mobile/font-awesome.min.css" rel="stylesheet">
    @yield("css")
    <meta HTTP-EQUIV="Pragma" CONTENT="no-cache">
    <meta HTTP-EQUIV="Cache-Control" CONTENT="no-cache">
    <meta HTTP-EQUIV="Expires" CONTENT="0">
</head>
<body @yield("body_att") >
@yield("content")
</body>
<script type="text/javascript" src="//apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
<script type="text/javascript">
  $(function () {
    $("div.module span").click(function () {
      var val = $(this).attr("value");

      $("div.module span").removeClass("current");
      $(this).addClass("current");

      $("div.game-list").hide();
      if (val == 'all') {
        $("div.game-list:first").show();
      } else if (val == 'football') {
        $("div.game-list:eq(1)").show();
      } else if (val == 'basketball') {
        $("div.game-list:last").show();
      }
    });
  });
</script>
@yield("js")
<script>
  var _hmt = _hmt || [];
  (function() {
    var hm = document.createElement("script");
    hm.src = "https://hm.baidu.com/hm.js?f83759b4187ea14a212918961719d3e4";
    var s = document.getElementsByTagName("script")[0];
    s.parentNode.insertBefore(hm, s);
  })();
</script>
</html>