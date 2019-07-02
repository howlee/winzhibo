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
        var url = window.m + '/news/' + (curPage + 1) + '.json';
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
                if (json.news) {
                    var news_html = '', newsId, publishAt;
                    var items = json.news;
                    var lastDefault = $("div.game-list");
                    $.each(items, function (index, data) {
                      newsId = data.id;
                      publishAt = data.publish_at;
                      publishAt = publishAt.substr(0, 16);
                      news_html += '<a href="/m/news/' + newsId + '.html" class="game-item news" style="padding: 10px 20px;">';
                      news_html += data.title;
                      news_html += '<span>';
                      news_html += '发布时间：' + publishAt + '&nbsp;&nbsp;&nbsp;&nbsp;';
                      news_html += '作者：匿名';
                      news_html += '</span></a>';
                    });
                    lastDefault.append(news_html);
                }
                window.loadPage = false;
            },
            "error": function () { }
        });
    }
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