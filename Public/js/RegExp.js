//验证手机号码
function checkPhone(str) {
	var re = /^(1[345678][0-9])\d{8}$/;
	var reg = /^(([0+]d{2,3}-)?(0d{2,3})-)(d{7,8})(-(d{3,}))?$/;

	if (re.test(str)) {
		return true;
	}
	if (reg.test(str)) {
		return true;
	} else {
		return false;
	}
}

//验证是否是数字

function checkNum(str) {
	var re = /^[1-9][0-9]+$/;
	if (re.test(str)) {
		return true;
	} else {
		return false;
	}
}

//验证密码
function checkPassword(str) {
	// var re = /^(?=.{6,18}$)[0-9a-zA-Z$#@^&]+$/;
	var re = /^(?![a-zA-z]+$)(?!\d+$)(?![!@#$%^&*\.]+$)[a-zA-Z\d!@#$%^&*\.]+$/;

	if (re.test(str)) {
		return true;
	} else {
		return false;
	}

}

//邮箱反馈
function checkEmailRes(str) {
	var re = /^(\w-*\.*)+@(\w-?)+(\.\w{2,})+$/;

	if (re.test(str)) {
		return true;
	} else {
		return false;
	}
}

function delRecord(url) {
	// var redirecturl = '/hyx/index.php/Home';
	alert(url);
	var r = confirm('您确定删除吗?');
	if (r) {
		$.get(url, '', function (data) {
			console.log(data);
			if (data == 'true') {
				$('.errmess').text('删除成功').css('color', 'green');
				$('#errmess').show();
				$('#sure-err a').attr('href', location.href);
			}
			if (data == 'false') {
				$('.errmess').text('删除失败').css('color', 'red');
				$('#errmess').show();
				$('#sure-err a').attr('href', location.href);
			}
		});
	}
}

//下载报告
function tipDownPdf(href) {
	//var url = redirecturl + "/Report/downlimit";
	var url = '/index.php/Home/Report/downlimit';
	console.log(url);
	$.get(url, '', function (data) {
		console.log(data.info, 'data');
		if (data.info == 'true') {
			$('.errmess').text('报告正在下载中...').css('color', 'green');
			$('#errmess').show();
			$('#sure-err a').click(function () {
				$('#errmess').hide();
			});
			location.href = href;
		} else {
			$('.errmess').html('您的报告下载次数没有啦,增加请联系管理员。').css('color', 'green');
			$('#errmess').show();
			$('#sure-err a').click(function () {
				$('#errmess').hide();
			});
		}
	});
}
//下载技术报告
function techPdfTip(href) {
	//var url = redirecturl + "/Report/downlimit";
	var url = '/index.php/Home/Report/downlimit';
	$.get(url, '', function (data) {
		if (data.info == 'true') {
			$('.errmess').text('报告正在下载中...').css('color', 'green');
			$('#errmess').show();
			$('#sure-err a').click(function () {
				$('#errmess').hide();
			});
			location.href = href;
		} else {
			var text = "移动应用安全检测平台提示您：</br>您的账户不提供下载技术报告功能，</br>需要查看更多信息和使用高级功能，请联系管理员";
			$('.errmess').html(text).css('color', 'green');
			$('#errmess').show();
			$('#sure-err a').click(function () {
				$('#errmess').hide();
			});
		}
	});
}

function regTipTestDetial() {
	var text = "移动应用安全检测平台提示您：</br>您的账户不提供下载技术报告功能，</br>需要查看更多信息和使用高级功能，请联系管理员";
	$('.errmess').html(text).css('color', 'green');
	$('#errmess').show();
	$('#sure-err a').click(function () {
		$('#errmess').hide();
	});
}

function tipCentDownPdf(href) {
	//var url = redirecturl + "/Report/downlimit"
	var url = '/index.php/Home/Report/downlimit';
	$.get(url, '', function (data) {
		if (data.info == 'true') {
			$('.errmess').text('报告正在下载中...').css('color', 'green');
			$('#errmess').show();
			$('#sure-err a').click(function () {
				$('#errmess').hide();
			});
			location.href = href;
		} else {
			$('.errmess').html('您的报告下载次数没有啦,增加请联系管理员').css('color', 'green');
			$('#errmess').show();
			$('#sure-err a').click(function () {
				$('#errmess').hide();
			});
		}
	});
}
function regTipCentDownPdf() {
	var text = "移动应用安全检测平台提示您</br>您的账户不提供下载技术报告功能，</br>需要查看更多信息和使用高级功能，请联系管理员";
	$('.errmess').html(text).css('color', 'green');
	$('#errmess').show();
	$('#sure-err a').click(function () {
		$('#errmess').hide();
	});
}

//删除用户的反馈申请
function feedbackcancel(url) {
	$.get(url, '', function (data) {
		if (data.info == 'true') {
			$('.errmess').text('撤销成功').css('color', 'green');
			$('#errmess').show();
			$('#sure-err a').attr('href', location.href);
		}
		if (data.info == 'false') {
			$('.errmess').text('撤销失败').css('color', 'red');
			$('#errmess').show();
			$('#sure-err a').attr('href', location.href);
		}
	});
}