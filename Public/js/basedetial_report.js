$(document).ready(function(){
	var tip=$('#errtip').html();
	// var redirecturl = '/hyx/index.php/Home';
	if(tip == 'FEEDBACK_SUCCESS'){
		$('.errmess').text('您的反馈已提交,请等待管理员处理!').css('color','green');
		$('#errmess').show();
		$('#infotip').show();
	    $('#sure-err a').click(function(){
	    	var href = location.href;
	    	location.href = href.substring(0,href.indexOf('/tip'))+'.html';
	    });

	}
	if( tip == 'FEEDBACK_FALSE'){
		$('.errmess').text('您的反馈失败,请重新填写!').css('color','red');
		$('#errmess').show();
		$('#infotip').show();
	    $('#sure-err a').click(function(){
	    	var href = location.href;
	    	location.href = href.substring(0,href.indexOf('/tip'))+'.html';
	    });
	}
	$('.close').click(function(){
	    $('.dttcenAddDownpDFtip').fadeOut();
	});
});
//反馈调用方法
function feedback(data,optindex,appid,testname){
    $('#errmess1').fadeIn();
    $('#oldinfo').text(data);
    // $('select[name=newresult] option[value='+optindex+']').attr('selected',true);
    //上面容易在第三次后失效，故而采用原生的javascript
    var sel = document.getElementById('selectnewresult');
    for (var i = 0; i <sel.options.length; i++) {
    	if(optindex == sel.options[i].value){
    		sel.options[i].selected = true;
    	}
    }
    $('input[name=oldresult]').val(optindex);
    $('input[name=appid]').val(appid);
    $('input[name=testname]').val(testname);
}