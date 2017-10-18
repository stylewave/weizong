$('document').ready(function(){
	var tip=$('#errtip').html();
	if( tip == 'EMAIL_EXISTED'){
	    $('.errmess').text('邮箱已存在').css('color','red');
	    $('#errmess').show();
	    $('#sure-err a').attr('href',redirecturl+'/User/register_user');
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
		$('#emailcheck').html('请输入类似xxx@xxx.xxx格式邮箱');
	}
});

$('input[name=pwd1]').blur(function(){
	if(  checkPassword($(this).val()) == false  ){
		$('#pwd1info').html('请输入6-18位可包含字母,数字,特殊字符!@#$%^&.*的组合密码');
	}else if(checkPassword($(this).val()) == true){
		$('#pwd1info').html('');
	}	
});
$('input[name=pwd2]').blur(function(){
	if(  $(this).val() != $('input[name=pwd1]').val() ){
		$('#pwd2info').html('两次密码不同');
	}else if($(this).val() == $('input[name=pwd1]').val()){
		$('#pwd2info').html('');
	}	
});

$('#question1').change(function(){
	if($(this).val() == '自己编辑问题'){
		$('#select').css('display','none');
		$('#text').css('display','block');
		$('#question2').focus();
	}
});
$('input[name=answer]').blur(function(){

	if( $(this).val().length < 1 ){
		$('#answerinfo').html('请输入密保答案,以便忘记密码时找回密码');
	}else{
		$('#answerinfo').html('');
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

			$('#captchainfo').html('验证码错误');
			$('#clickpic').attr('src',$('#clickpic').attr('src') +'?'+ Math.random());
		}
		
	},'text');
});

$('input[type=submit]').click(function(){
	var pwd1 = $('input[name=pwd1]').val();
	var pwd2 = $('input[name=pwd2]').val();
	var username= $('input[name=email]').val();
	var captchainfo 	= $('#captchainfo').html();
	var answer = $('input[name=answer]').val();
// alert(pwd1 +" "+pwd2+' '+username+' '+captchainfo);
	if( (checkEmailRes(username) == true) && (pwd1 == pwd2) ){
		if( username.length >= 2 ){ 
			if(answer.length > 1){
				if(captchainfo == '验证码正确'){
					var hash1 = hex_md5($('input[name=pwd2]').val());
					hash1 = hash1.substr(25,31);
					$('input[name=pwd2]').val(hash1);
					$('input[name=pwd1]').val('');
					$('#registerform').submit();
				}else{
					$('#captchainfo').html('请输入正确的验证码');
				}
			}else{
				$('#captchainfo').html('请输入密保答案,以便忘记密码时找回密码');
			}
		}else{
			$('#captchainfo').html('请输入符合要求的邮箱名');
		}					
	}else{
		$('#captchainfo').html('请输入符合要求的邮箱、密码以及确认密码');
	}
});