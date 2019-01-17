var player;
function goPlay (Link) {
	var videoObject = {
		container: '.player',//“#”代表容器的ID，“.”或“”代表容器的class
		variable: 'player',//该属性必需设置，值等于下面的new chplayer()的对象
		flashplayer: false,//如果强制使用flashplayer则设置成true
		video: Link,//视频地址
		autoplay: true,
		live: true,
		loaded:'loadedHandler'//监听播放器加载成功
	};
	if (player) {
        player.newVideo({"video": Link});
	} else {
        player = new ckplayer(videoObject);
	}
}

function loadedHandler(){//播放器加载后会调用该函数
	player.addListener('play', playHandler); //监听播放时间,addListener是监听函数，需要传递二个参数，'time'是监听属性，这里是监听时间，timeHandler是监听接受的函数
	player.addListener('error', errorHandler); //监听播放时间,addListener是监听函数，需要传递二个参数，'time'是监听属性，这里是监听时间，timeHandler是监听接受的函数
}

function changeLine (obj) {
	if (!$(obj).hasClass('on')) {
		loadLine(obj);
		$(obj).addClass('on').siblings('.on').removeClass('on');
	}
}

window.onload = function () {
	var Line = $('#MyPlayer .list .li.on').attr('line')
	if (Line != '') {
		// goPlay(Line)
	}
}

function playHandler (e) {
	console.log(e)
}

function errorHandler (e) {
	console.log(e)	
}