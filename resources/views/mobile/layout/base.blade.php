<!doctype html>
<html>
<head>
    <meta charset=utf8>
    <title>{{empty($title) ? '免费直播_NBA直播' : $title}}-球探直播</title>
    <meta name="keywords" content="{{empty($keywords) ? '足球直播,英超直播,NBA直播,欧冠直播' : $keywords}}">
    <meta name="description" content="{{empty($description) ? '免费的体育直播网站。高清足球直播、NBA直播、英超直播等全部免费看。' : $description}}">
    <meta charset="utf-8" >
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no">
    <meta name="applicable-device" content="mobile" >
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
    hm.src = "https://hm.baidu.com/hm.js?bea178e04cbf7ca1b6e231665baf94cf";
    var s = document.getElementsByTagName("script")[0];
    s.parentNode.insertBefore(hm, s);
  })();
</script>
</html>