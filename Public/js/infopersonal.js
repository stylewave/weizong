$('document').ready(function(){
	var tip=$('#errtip').html();
	// var redirecturl = '/hyx/index.php/Home';
	if( tip == 'UPDATE_SUCCESS'){
	    $('.errmess').text('修改成功').css('color','green');
	    $('#errmess').show();
	    $('#sure-err a').attr('href',redirecturl+'/Personal/info_personal');
	}
	if( tip == 'UPDATE_FALSE'){
		$('.errmess').text('修改失败').css('color','red');
		$('#errmess').show();
		$('#sure-err a').attr('href',redirecturl+'/Personal/info_personal');
	}
});