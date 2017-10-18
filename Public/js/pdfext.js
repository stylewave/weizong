
$('#captcha').blur(function(){
	var captcha = $('#captcha').val();
	$.getJSON(captchaurl,{captcha:captcha},function(data,status){
		console.log(data);
		if(data.info == 'success'){
			$('#captchainfo').html('验证码正确').css('visibility','hidden');
		}else{
			$('#captchainfo').html('验证码错误');
			$('#clickpic').attr('src',$('#clickpic').attr('src') +'?'+ Math.random());
		}
		
	},'text');
});
function pdfextset(){
	var headcontent 		= $('input[name=headerup]').val();
	var footcontent 		= $('input[name=headerdown]').val();
	var captchainfo = $('#captchainfo').html();
	if( headcontent.length != 0 && footcontent.length != 0 ){
		if(captchainfo == '验证码正确'){
			$('.form').submit();	
		}
	}else if(headcontent.length == 0 && footcontent.length == 0){
		$('#watermarktip').html('页眉(上)内容,页眉(下)内容,页眉的图片不能为空').css('color','red');
	}
}
