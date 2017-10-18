$(document).ready(function(){
  var tip=$('#errtip').html();
  // var redirecturl = '/hyx/index.php/Home';
  if( tip == 'RESET_PWD_FALSE'){
    $('.errmess').text('修改密码失败').css('color','red');
    $('#errmess').show();
    $('#sure-err a').attr('href',redirecturl+'/User/findpwd_user');

  }
});
$('input[name=pwd1]').blur(function(){
	if($(this).val().length > 5  && $(this).val().length <19){
		if(  checkPassword($(this).val()) == false  ){
			$('#pwd1info').html('不允许纯字母或纯数字,也不允许"!@#$%^&*"之外的特殊字符!');
		}else{
			$('#pwd1info').html('');
		}
	}else{
		$('#pwd1info').html('请重新输入6-18个字符');
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
$('input[name=pwd2]').blur(function(){
	if($('input[name=pwd1]').val() != $(this).val()){
		$('#pwd2info').html('与上一次密码不同,请重新输入');
	}else{
		$('#pwd2info').html('');
	} 
});


$('input[type=submit]').click(function(){
	var pwd1   		= $('input[name=pwd1]').val();
	var pwd2   		= $('input[name=pwd2]').val();
	if((pwd1 == pwd2) && (checkPassword(pwd1) == true) && (checkPassword(pwd2) == true)) {
		if($('#captchainfo').html() == '验证码正确'){
			var hash1 = hex_md5($('input[name=pwd2]').val());
			hash1 = hash1.substr(25,31);
			$('input[name=pwd2]').val(hash1);
			$('input[name=pwd1]').val('');
			$('#resetpwd').submit();
		}else{
			$('#captchainfo').html('验证码错误');
		}
	}else{
		$('#captchainfo').html('操作失败,请填写新密码和确认密码,并使它们相同');
	}
});