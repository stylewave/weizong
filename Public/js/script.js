$(function () {

	//检测中心 - 添加检测
	$(".dttcenBox .aitem .icon a").click(function () { $(".dttcenAdd").show(); });
	$(".dttcenAdd .title .close").click(function () { $(".dttcenAdd").hide(); });

	$('.close').click(function () {
		$(".dttcenAdd").hide(); $('#errmess').hide();
	});

	// var path = window.document.location.href;
	var ml = window.document.location.pathname;
	webroot = ml.substring(0, ml.substr(1).indexOf('/') + 1);
	// webroot = '/hyx'; 
	redirecturl = webroot + '/index.php/Home';
	//captchaurl = webroot + '/index.php/Home/Layout/verify_captcha';
	captchaurl = webroot + '/Home/Layout/verify_captcha';

})