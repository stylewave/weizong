$(document).ready(function(){
  var tip=$('#errtip').html();
  // var redirecturl = '/hyx/index.php/Home';
  if( tip == 'SEARCH_FALSE'){
	    $('.errmess').text('满足条件的项目不存在').css('color','red');
	    $('#errmess').show();
	    $('#sure-err a').attr('href',redirecturl+'/Detection/list_detection.html');
  }
  if( tip == "FEEDBACK_ASCRIPTION_USER_ERROR" ){
  		$('.errmess').text('该反馈属于此用户').css('color','red');
	    $('#errmess').show();
	    $('#sure-err a').attr('href',redirecturl+'/Personal/feedbacklist_personal.html');
  }
});


	function addAppType(){
		var url = $('#addVocationForm').attr('url');
		var addTypeName = $('#name').val();
		if(addTypeName.length > 0){
			$.get(url,{addAppType:addTypeName},function(data){
				if(data == 'TRUE'){
					$('#tipFrame').modal('show');
					$('#tipMsg').html('操作成功');
				}else{
					$('#tipFrame').modal('show');
					$('#tipMsg').html('操作失败');
				}

			});
		}else{
			$('#tipFrame').modal('show');
			$('#tipMsg').html('请添加所要添加的项目行业类型');
		}
	}
	function searchAppType(){
		var AppType 	= $('#searchAppType').val();
		var url  		= "{:U('Detection/searchAppType_detection')}";
		$.get(url,{appType:AppType},function(data){
			// console.log(data);
			if(data === "FALSE"){
				$('#tipFrame').modal('show');
				$('#tipMsg').html('没有相关记录');
				$('#btnClose').hide();
				$('#searchAppType').children('option').eq("0").attr('selected','selected');
				setTimeout("$('#tipFrame').modal('hide')",2000);
				sleep(2);
				window.location.href = '__MODULE__/Detection/searchAppType_detection?appType=null';
			}else{
				var url = '__MODULE__/Detection/searchAppType_detection?appType='+AppType;
				window.location.href = url;
			}
		}); 
	}
	$('#btnClose').click(function(){
		location.reload();
	});
		$num=$('.getscore');
		
		for(i=0;i<$num.length;i++){

			$score=$num.eq(i);
			var s=$score.text();
			
			if(s<60){
				$score.parent().parent().addClass('danger');
			}
			if(s>=60&&s<70){
				$score.parent().parent().addClass('warning');
			}
			if(s>=70&&s<80){
				$score.parent().parent().addClass('success');
			}
			if(s>=80){
				$score.parent().parent().addClass('primary');
			}
		}

 $('input[name=starttime]').datetimepicker();
 $('input[name=endtime]').datetimepicker();
