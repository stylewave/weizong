$(document).ready(function(){
  var tip=$('#errtip').html();
  // var redirecturl = '/hyx/index.php/Home';
  if( tip == 'ANSWER_EMAIL_ERROR'){
    $('.errmess').text('邮箱或密保错误').css('color','red');
    $('#errmess').show();
    $('#sure-err a').attr('href',redirecturl+'/User/findpwd_user');

  }
  if( tip == 'RESET_PWD_FALSE'){
    $('.errmess').text('重置密码失败').css('color','red');
    $('#errmess').show();
    $('#sure-err a').attr('href',redirecturl+'/User/findpwd_user');

  }
});
$('input[name=securityemail]').blur(function(){
	if(checkEmailRes($(this).val()) == true ){
		// var url = "__MODULE__/Layout/getSecurityQuestion";
		var url = captchaurl+'/../../Layout/getSecurityQuestion';
		$.get(url,{ email:$(this).val() },function(data){
			$('#securityquestion').html(data);
			$('#securitycheck').html('');
		});
	}else{
		$('#securitycheck').html('邮箱格式不符合,请重新填写');
		$('#securityquestion').html('请输入邮箱↑');
	}
});

$('input[name=captcha]').blur(function(){
	var captcha = $(this).val();
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
	if($('#captchainfo').html() == '验证码正确'){
		if(checkEmailRes($('input[name=securityemail]').val()) == true ){
			if($('input[name=answer]').val().length > 1){
				$('#formfindpwd').submit();
			}else{
				$('#captchainfo').html('请输入密保答案!').css('visibility','visible');
			}
		}else{
			$('#captchainfo').html('请输入正确的邮箱').css('visibility','visible');
		}
	}else{
		$('#clickpic').click();
		$('#captchainfo').html('请输入正确的验证码').css('visibility','visible');
	}
});