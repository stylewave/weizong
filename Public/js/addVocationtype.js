$('#captcha').blur(function(){
	var captcha = $('#captcha').val();
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
function addVocationtype(){
	var vocationtype 		= $('input[name=vocationtype]').val();
	var zhvocationtype 		= $('input[name=zhvocationtype]').val();
	var info 				= $('input[name=info]').val();
	var captchainfo = $('#captchainfo').html();
	if( zhvocationtype.length > 0 ){
		if(captchainfo == '验证码正确'){
			$('.form').submit();	
		}else{

		}
	}else{
		$('#zhvocationtypetip').html('此选项不能为空!').css('color','red');
	}
}
