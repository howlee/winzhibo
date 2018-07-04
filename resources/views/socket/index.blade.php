<html>
    <head>
        <meta charset="utf-8"/>
    </head>
    <body>
        <div id="message" style="border: #0099FF 1px; height: 100px;overflow-y: auto;">

        </div>
        <p><input value="" id="text"></p>
        <p><button onclick="send()">发表</button></p>
    </body>
    <script type="text/javascript" src='https://cdn.bootcss.com/socket.io/2.0.3/socket.io.js'></script>
    <script type="text/javascript" src="//apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
    <script>
        function GetQueryString(str,href) {
            var Href;
            if (href != undefined && href != '') {
                Href = href;
            }else{
                Href = location.href;
            }
            var rs = new RegExp("([\?&])(" + str + ")=([^&#]*)(&|$|#)", "gi").exec(Href);
            if (rs) {
                return decodeURI(rs[3]);
            } else {
                return '';
            }
        }

    </script>

    <script>
        // 如果服务端不在本机，请把127.0.0.1改成服务端ip
        var socket = io('http://127.0.0.1:3000');
        // 触发服务端的chat message事件

        socket.emit('user_send_message', {"message": "欢迎进入聊天室"});
        // 服务端通过emit('chat message from server', $msg)触发客户端的chat message from server事件
        socket.on('notification', function(msg){
            console.log('get message:' + msg + ' from notification');
            $("#message").append("<p>" + msg + "</p>");
            var div = $("#message")[0];
            div.scrollTop = div.scrollHeight;
        });
        // 当连接服务端成功时触发connect默认事件
        socket.on('connect', function(){
            console.log('connect success');
            socket.emit('user_mid', {"mid": GetQueryString('mid',window.location), "name": GetQueryString('name',window.location) });
        });

        function send() {
            var message = document.getElementById('text');
            var req = {'message':message.value};
            message.value = "";
            socket.emit('user_send_message', req);
        }
    </script>
</html>