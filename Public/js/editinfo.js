$(document).ready(function(){
  var tip=$('#errtip').html();
  // var redirecturl = '/hyx/index.php/Home';
  if( tip == 'UPDATE_SUCCESS'){
    $('.errmess').text('修改密码成功').css('color','green');
    $('#errmess').show();
    $('#sure-err a').attr('href',redirecturl+'/Personal/info_personal');

  }
  if( tip == 'UPDATE_FALSE'){
    $('.errmess').text('修改密码失败').css('color','red');
    $('#errmess').show();
    $('#sure-err a').attr('href',redirecturl+'/Personal/info_personal');

  }
});
$('input[name=captcha]').blur(function(){
	var captcha = $('input[name=captcha]').val();
	// $.get(captchaurl,{captcha:captcha},function(data,status){
	// 	if(data == 'true'){
	$.getJSON(captchaurl,{captcha:captcha},function(data,status){
		if(data.info == "success"){
			$('#tip').html('验证码正确');
		}else{
			$('#tip').html('验证码错误');
			$('#clickpic').attr('src',$('#clickpic').attr('src') +'?'+ Math.random());
		}
		
	},'text');
});
$('input[name=updatePersonalInfo]').click(function(){
	var tip = $('#tip').html();
	if(tip == '验证码正确'){
		$('.form').submit();
	}else{
		$('#tip').html('请填写正确的验证码!');
	}
});