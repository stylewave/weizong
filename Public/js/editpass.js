$(document).ready(function(){
  var tip=$('#errtip').html();
  // var redirecturl = '/hyx/index.php/Home';
  if( tip == 'UPDATE_FALSE'){
    $('.errmess').text('修改密码失败').css('color','red');
    $('#errmess').show();
    $('#sure-err a').attr('href',redirecturl+'/Personal/editpass_personal');
  }
  if( tip == 'UPDATE_SUCCESS'){
    $('.errmess').text('修改密码成功').css('color','green');
    $('#errmess').show();
    $('#sure-err a').attr('href',redirecturl+'/Personal/info_personal');
  }
  if( tip == 'UPDATE_FALSE'){
    $('.errmess').text('修改密码失败').css('color','green');
    $('#errmess').show();
    $('#sure-err a').attr('href',redirecturl+'/Personal/editpass_personal');
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
$('input[name=pwd2]').blur(function(){
	if($('input[name=pwd1]').val() != $(this).val()){
		$('#pwd2info').html('与上一次密码不同,请重新输入');
	}else if($('input[name=pwd1]').val()==''){
		$('#pwd2info').html('请输入新密码!');
	}else{
		$('#pwd2info').html('OK,进入下一步');
	} 
});
$('input[name=captcha]').blur(function(){
	var captcha = $(this).val();
	// var url  = window.location.href+"/../../Layout/verify_captcha";
	$.getJSON(captchaurl,{captcha:captcha},function(data,status){
		if(data.info == "success"){
			$('#captchainfo').html('验证码正确').css('visibility','hidden');
		}else{
			console.log(data);
			$('#captchainfo').html('验证码错误');
			$('#clickpic').attr('src',$('#clickpic').attr('src') +'?'+ Math.random());
		}
		
	},'text');
});
$('#form-submit').click(function(){
	var pwd1 		= $('input[name=pwd1]').val();
	var pwd2 		= $('input[name=pwd2]').val();
	var captchainfo = $('#captchainfo').html();
	if( (pwd1 == pwd2) && (checkPassword(pwd1) == true) && (checkPassword(pwd2) == true)){
		if(captchainfo == '验证码正确'){
			var hash1 = hex_md5($('input[name=pwd2]').val());
			hash1 = hash1.substr(25,31);
			$('input[name=pwd2]').val(hash1);
			var hash2 = hex_md5($('input[name=pwd]').val());
			hash2 = hash2.substr(25,31);
			$('input[name=pwd]').val(hash2);
			$('input[name=pwd1]').val('');
			$('#form').submit();
		}
	}
	if(pwd1 == ''){
		$('#pwd1info').html('请填写新密码');
	}
	if(pwd2 == ''){
		$('#pwd2info').html('请再次填写新密码');
	}
});