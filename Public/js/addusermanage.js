$('input[name=phone]').blur(function(){
	if(checkPhone($(this).val()) == false){
		$('#phoneinfo').html('请输入符合要求的联系电话');
	}else{
		$('#phoneinfo').html('&nbsp;');
	}
});

$('input[name=email]').blur(function(){
	if(checkEmailRes($(this).val()) == true){
		var url = captchaurl+"/../../Layout/check_email";
		$.get(url,{email:$(this).val()},function(data,status){
				$('#emailcheck').html(data);
		});
	}
	if( checkEmailRes($(this).val()) == false ){
		$('#emailcheck').html('邮箱格式不符合,请重新填写');
	}
});
$('input[name=pwd1]').blur(function(){
	if($(this).val().length < 6 || $(this).val().length >18 ){
		$('#pwd1info').html('请输入长度6-18位的字符');
	}else{
		$('#pwd1info').html('');
	}
});
$('input[name=pwd2]').blur(function(){
	if($('input[name=pwd1]').val() != $(this).val()){
		$('#pwd2info').html('与上一次密码不同,请重新输入');
	}else{
		$('#pwd2info').html('');
	} 
});
$('input[name=captcha]').blur(function(){
	var captcha = $(this).val();
	// $.get(captchaurl,{captcha:captcha},function(data,status){
	// 	if(data == 'true'){
	$.getJSON(captchaurl,{captcha:captcha},function(data,status){
		if(data.info == "success"){
			$('#captchainfo').html('验证码正确').css('visibility','hidden');
		}else{
			// console.log(data);
			$('#captchainfo').html('验证码错误');
			$('#clickpic').attr('src',$('#clickpic').attr('src') +'?'+ Math.random());
		}
		
	},'text');
});
$('#add').click(function(){
	if($('#emailcheck').text() =='该邮箱可以注册'){
		if(  ($('#captchainfo').html()== '验证码正确') && ($('input[name=pwd2]').val()==$('input[name=pwd1]').val()) ){
			if($('#phoneinfo').text().length >5){
				$('input[name=phone]').val('');
			}
			var hash1 = hex_md5($('input[name=pwd2]').val());
			hash1 = hash1.substr(25,31);
			$('input[name=pwd2]').val(hash1);
			$('input[name=pwd1]').val('');
			$('#adduser').submit();
		}else{
			$('#pwd2info').html('请输入相同密码,并且输入用户!');
		}
	}else{
		$('#emailcheck').html('请输入符合邮箱账号');
	}
});