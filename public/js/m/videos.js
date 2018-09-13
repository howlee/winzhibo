//翻页到页底
function scrollBottom (endFunc) {
    var ClientHeight,BodyHeight,ScrollTop;
    if(document.compatMode == "CSS1Compat"){
        ClientHeight = document.documentElement.clientHeight;
    }else{
        ClientHeight = document.body.clientHeight;
    }

    BodyHeight = document.body.offsetHeight;

    ScrollTop = getPageScroll()[1];

    if (BodyHeight - ScrollTop - ClientHeight < 20) {
        endFunc();
    }
}

function loadVideos() {
    if (!window.curPage)  window.curPage = 1;
    if (!window.loadPage) window.loadPage = false;
    if (!window.lastPage) window.lastPage = 5;

    var curPage = parseInt(window.curPage);
    var isLoading = window.loadPage;
    var hasPage = window.curPage < window.lastPage;
    if (!isLoading && hasPage) {
        window.loadPage = true;
        var url = '/json/subject/videos/all/' + (curPage + 1) + '.json';//location.href;
        var week = ['周日','周一','周二','周三','周四','周五','周六'];
        $.ajax({
            "url": url,
            "dataType": "json",
            "success": function (json) {
                if (json.page) {
                    window.curPage = json.page.curPage;
                    window.lastPage = json.page.lastPage;
                } else {
                    window.curPage = window.curPage + 1;
                }
                if (json.matches) {
                    var match_array, v_day, v_date, v_title, d_html = '';
                    match_array = json.matches;

                    var lastDay = $(".today:last").html();
                    var lastDefault = $(".today:last").next('div');
                    $.each(match_array, function (day, matches) {
                        if (day == lastDay) {
                            $.each(matches, function (v_index, match) {
                                v_title = match.hname + " " + match.hscore + " - " + match.ascore + " " + match.aname;
                                var html = createdVideoHtml(match);
                                lastDefault.append(html);
                                //lastDefault.append(html);
                            });
                        } else {
                            var date = new Date(day);
                            d_html += '<h2 class="today">' + day + '</h2>';
                            d_html += '<div>';
                            $.each(matches, function (v_index, match) {
                                var html = createdVideoHtml(match);
                                d_html += html;
                            });
                            d_html += '</div>';
                        }
                    });
                    lastDefault.after(d_html);
                }
                window.loadPage = false;
            },
            "error": function () { }
        });
    }
}

function createdVideoHtml(match) {
    var v_date = new Date(match.time * 1000);
    var hour = v_date.getHours();
    var minute = v_date.getMinutes();
    hour = hour < 10 ? '0' + hour : hour;
    minute = minute < 10 ? '0' + minute : minute;

    var hicon = match.hicon;
    var aicon = match.aicon;

    if (!hicon) {
        hicon = '//static.liaogou168.com/img/icon_team_default.png';
    }
    if (!aicon) {
        aicon = '//static.liaogou168.com/img/icon_team_default.png';
    }

    hicon = hicon.replace('static.cdn.dlfyb.com', 'static.liaogou168.com');
    aicon = aicon.replace('static.cdn.dlfyb.com', 'static.liaogou168.com');

    var html = '<a href="' + subjectVideoLink(match.id) + '" class="game-item cPbtn" style="text-align: center;" >';
    //主队内容 开始
    html += '<div class="team-left">';
    html += '<img src="' + hicon + '">';
    html += '<p style="font-weight:bold;">  ' + match.hname + '</p>';
    html += '</div>';
    //主队内容 结束

    //对阵 开始
    html += '<div class="game-info">';
    html += '<div class="team-score">';
    html += '<bifen class="id126275">';
    html += '<p class="score-num gray"><span class="score"> VS </span></p>';
    html += '</bifen>';
    html += '<p class="live" style="">' + match.lname + ' </p>';
    html += '<p class="time" style=""><span>' + hour + ':' + minute + '</span></p>';
    html += '</div>';
    html += '</div>';
    //对阵 结束

    //客队内容  开始
    html += '<div class="team-right">';
    html += '<img src="' + aicon + '">';
    html += '<p style="font-weight:bold;">' + match.aname + '</p>';
    html += '</div>';
    //客队内容  结束
    html += '<div class="clear"></div>';
    html += '</a>';
    return html;
}

function subjectVideoLink(id) {
    var idStr = id + '';
    if (idStr.length < 4) {
        return "";
    }
    var first = idStr.substr(0, 2);
    var second = idStr.substr(2, 4);
    return "http://www.aikq.cc/m/live/subject/video/" + first + "/" + second + "/" + id + ".html";
}

function getPageScroll() {
    var xScroll, yScroll;
    if (self.pageYOffset) {
        yScroll = self.pageYOffset;
        xScroll = self.pageXOffset;
    } else if (document.documentElement && document.documentElement.scrollTop) { // Explorer 6 Strict
        yScroll = document.documentElement.scrollTop;
        xScroll = document.documentElement.scrollLeft;
    } else if (document.body) {// all other Explorers
        yScroll = document.body.scrollTop;
        xScroll = document.body.scrollLeft;
    }
    arrayPageScroll = new Array(xScroll,yScroll);
    return arrayPageScroll;
}