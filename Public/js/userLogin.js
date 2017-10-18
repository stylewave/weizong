$(document).ready(function(){
	var tip=$('#errtip').html();
	// var redirecturl = '/hyx/index.php/Home';
	if(tip == 'REGISTER_SUCCESS'){
		$('.errmess').text('注册成功').css('color','green');
		$('#errmess').show();
	    $('#sure-err a').attr('href',redirecturl+'/User/login_user');

	}
	if( tip == 'EMAIL_EXISTED'){
		$('.errmess').text('用户已存在,请重新注册').css('color','red');
		$('#errmess').show();
	    $('#sure-err a').attr('href',redirecturl+'/User/login_user');

	}
	if( tip == 'ERROR_UM_PD'){
		$('.errmess').text('用户名或密码错误,请重新输入').css('color','red');
		$('#errmess').show();	
	    $('#sure-err a').attr('href',redirecturl+'/User/login_user');

	}
	if( tip == 'RESET_PWD_SUCCESS'){
		$('.errmess').text('重置密码成功').css('color','green');
		$('#errmess').show();	
	    $('#sure-err a').attr('href',redirecturl+'/User/login_user');

	}
});


$('input[name=captcha]').blur(function(){
	var captcha = $(this).val();
	console.log(captchaurl,'captchaurl');
	$.getJSON(captchaurl,{captcha:captcha},function(data,status){
		if(data.info == "success"){
			$('#tip').html('验证码正确').css('visibility','hidden');
		}else{
			$('#tip').html('验证码错误');
			
			$('#clickpic').attr('src',$('#clickpic').attr('src') +'?'+ Math.random());
		}
	},'text');
});
$('input[type=submit]').click(function(){
	var tip 	= $('#tip').html();
	var email 	= $('input[name=email]').val();
	var pwd 	= $('input[name=pwd]').val();

	if(tip == '验证码正确'){
		if((email.length >= 2) && (pwd.length > 2) ){
			var hash = hex_md5($('input[name=pwd]').val());
			hash = hash.substr(25,31);
			$('input[name=pwd]').val(hash);
			$('#login-form').submit();
		}else{
			$('#tip').html('邮箱或密码错误!');
		}
	}else{
		$('#tip').html('验证码错误');
	}
});