$(function(){
	int= self.setInterval('uploadlimit()',5000);	
	uploadlimit();
});
// 以前的插件
// $(document).ready(function(){
// 	$url=redirecturl +"/Detection/upload_apk?action=";
// 	var swfu=null;
// 	$('#button').hide();
//    $('#selectVocationtype').bind('change',function(){
//    		$('#choiceAfterHide').hide();
//         if(swfu==null||swfu==''){
//         	$url1=$url+$('#selectVocationtype').val();
//            swfu=swfupload_control($url1);
//         }else{
//         	$url2=$url+$('#selectVocationtype').val();
//         	var ssss=SWFUpload.instances['SWFUpload_0'];
//         	ssss.setUploadURL($url2);
//         	//swfu.destroy();
//         }
//    	    //$('#button').hide();
//    });



//   $('.bc2box').click(function(){
//   	$('#selectVocationtype').show();
//   	//$('#button').hide();
  	
// 	$('#buttonyes').click(function(){
// 		//$('#button').show();
// 	});
//   });

 
//  $('#laterUpload').css('display','none');
//  });
// function vocaUser(){
// 	$url=redirecturl +"/Detection/upload_apk?action="+$('#selectVocationtype').val();
// 	swfupload_control($url);
// }
function uploadlimit(){
	var url = redirecturl+"/Detection/interval";
	$.get(url,'',function(data){
		if(parseInt(data) > 300){
			int = window.clearInterval(int);
			$('#interval').show();
			$('#maninterval').show();
			$('#laterUpload').css('display','none');
			$('#normalUpload').css('display','block');
			// $('#maninterval').css('display','block');
			// $('#interval').css('display','block');
			// $('#manUpload').css('display','block');
			if(parseInt(data) == Date.parse(new Date())/1000){
				$('#interval').hide();
				$('#laterUpload').css('display','block');
				$('#normalUpload').css('display','none');
			}

		}else{
			$('#interval').hide();
			$('#laterUpload').css('display','block');
			$('#normalUpload').css('display','none');
		}
	});	
}


function swfupload_control(url){

	$swfwu=$('#swfupload-control').swfupload({
	//$swfwu=new SWFUpload({	
		upload_url: url,
		file_post_name: 'uploadfile',
		file_size_limit : "102400",
		file_types : "*.apk;*.ipa;*.zip",
		file_types_description : "Application test",
		file_upload_limit : 1,
		flash_url : webroot + "/Public/js/swfupload/swfupload.swf",
		button_image_url : webroot + '/Public/js/swfupload/wdp_buttons_upload_114x29.png',
		button_width : 114,
		button_height : 29,
		button_placeholder : $('#button')[0],
		debug: false
	});

	$swfwu.bind('fileQueued', function(event, file){
		var listitem='<li id="'+file.id+'" >'+
			'File: <em>'+file.name+'</em> ('+Math.round(file.size/1024)+' KB) <span class="progressvalue" ></span>'+
			'<div class="progressbar" style="width:360px;" ><div class="progress"  style="background:lightblue;width:360px;"></div></div>'+
			'<p class="status" >Pending</p>'+
			'<span class="cancel" >&nbsp;</span>'+
			'</li>';
		// $('#log').append(listitem);
		$('#log').html(listitem);
		$(this).swfupload('startUpload');
	})

	.bind('fileQueueError', function(event, file, errorCode, message){
		// alert('文件的大小 '+file.name+' 操过文件限制,最大50M');
		alert('对不起，您上传的文件过大');
	})

	.bind('fileDialogComplete', function(event, numFilesSelected, numFilesQueued){
		// $('#selectVocationtype').hide();	
		// $('#queuestatus').hide();
	})

	.bind('uploadStart', function(event, file){
		$('#log li#'+file.id).find('p.status').text('Uploading...');
		$('#log li#'+file.id).find('span.progressvalue').text('0%');
	})

	.bind('uploadProgress', function(event, file, bytesLoaded){
		//Show Progress
		var percentage=Math.round((bytesLoaded/file.size)*100);
		$('#log li#'+file.id).find('div.progress').css('width', percentage+'%');
		$('#log li#'+file.id).find('span.progressvalue').text(percentage+'%');

		// 特殊处理
		if(percentage == 100){
			this.uploadSuccess();
		}
	})
	.bind('uploadSuccess', function(event, file, serverData){
		var item=$('#log li#'+file.id);
		item.find('div.progress').css('width', '100%');
		item.find('span.progressvalue').text('100%');
		$('#queuestatus').html('');
		
		// if(serverData == 'USER_UPLOAD_LIMIT'){
		// 	$('#log').html('<div style="text-align:center;">今天的上传次数已满,请明天再来!</div>');
		// }else if(serverData == 'UPLOAD_TIME_LIMIT'){
		// 	$('#log').html('<div style="text-align:center;">应用检测中,请5分钟后再上传!</div>');
		// }else if(serverData == 'APK_IS_FALSE'){
		// 	$('#log').html('<div style="text-align:center;">这个APK是假的,请重新上传!</div>');
		// }else{
		// 	$('#SWFUpload_0').css('display','none');
		// 	$('#log').html('<div style="text-align:center;">上传成功,正在检测中。。。</div>');
		// }
		$('#selectVocationtype').hide();
		setTimeout("location.reload()",2000);     
	});
	return $swfwu;
}

$('#btnClose').click(function(){
	$('#selectVocationtype').html('');
	$('#buttonyes').hide();
	location.reload();
});

$(document).ready(function(){
	//点击上传的图片,是否显示上传功能
	$('.bc1box').click(function(){
	    var select = $('#selectVocationtype').val();
	    if(select =='0'){
	      $('#uploadmain .fileinput-button').hide();
	    }else{
	      $('#uploadmain .fileinput-button').show();
	     uploadfile();
             // address();
	    }
	});
	
	// $("#appreinforce").click(function(){
	// 	if(document.getElementById("appreinforce").checked){
	// 	    alert("checkbox is checked");
	// 	}
	// });


	$("#fileupload").change(function(){
		var getfile = $("#fileupload").val();
		$("#showfileurl").val(getfile);
//		uploadfile();
	});
	
	//当更改行业类型值的时候,隐藏select option 为空的值
	$('#selectVocationtype').change(function(){
	    $('#choiceAfterHide').hide();
	    $('#uploadmain .fileinput-button').show();
	    uploadfile();
	});
});

//上传js的函数

function uploadfile(){
//$(function () {
      'use strict';
      var url = redirecturl+ "/Detection/upload_apk";
      $('#fileupload').fileupload({
          url: url,
          dataType: 'json',
          autoUpload:true,
          done: function (e, data) {
              if(data.result.info == "USER_UPLOAD_LIMIT"){
                 $('#uploadmain').hide();
                 $('#uploadtip').html('您账户的检测此时已用完，如需更多检测次数请联系管理员。').css('color','green');
              }else if(data.result.info == "UPLOAD_SUCCESS"){
                 $('#uploadmain').hide();
                 $('#uploadtip').html('上传成功,正在检测中...');
              }else if(data.result.info == 'EXT_NOT_ALLOW'){
              	console.log(data.result);
              	 $('#uploadmain').hide();
                 $('#uploadtip').html('请上传500M以下的应用,并且文件类型为:zip,gz,tar,tgz,rar');
              }
              else
              {
              	 $('#uploadmain').hide();
                 $('#uploadtip').html(data.result.info);
              }
          },
          progressall: function (e, data) {
              var progress = parseInt(data.loaded / data.total * 100, 10);
              if(progress >0){
                 $('#progress').show();
              }
              $('#progress .progress-bar').css(
                  'width',
                  progress + '%'
              );

              if(progress == '100'){
                  setTimeout("location.reload()",10000); 
              }
          },
          fail:function(e,data){
               $('#uploadmain').hide();
               $('#uploadtip').html('应用上传错误');
          }
      }).bind('fileuploadadd',function(e,data){
	 	//data.url = url + "/action/"+$('#selectVocationtype').val()+"/test/1"+'/version/'+$('input[name=softversion]').val()+'/projectname/'+$('input[name=projectname]').val()+'/lang/'+$('#lang').val()+'/makeenv/'+$('#makeenv').val()+'/mekecommand/'+$('input[name=makecommand]').val()+'.html';    
      data.url = url + "/action/"+$('#selectVocationtype').val()+"/test/1"+'/version/'+$('input[name=softversion]').val()+'/projectname/'+$('input[name=projectname]').val()+'/lang/'+$('#lang').val()+'/makeenv/'+$('#makeenv').val()+'/mekecommand/'+$('input[name=makecommand]').val()+'/vocation/'+$('#vocation').val()+'.html';
      }).prop('disabled', !$.support.fileInput)
      .parent().addClass($.support.fileInput ? undefined : 'disabled');
//});
}



function address(){
//$(function () {
      'use strict';
      var url = redirecturl+ "/Detection/upload_app";
      $('#address').fileupload({
//          url: url,
//          dataType: 'json',
//          autoUpload:true,
//          done: function (e, data) {
//              if(data.result.info == "USER_UPLOAD_LIMIT"){
//                 $('#uploadmain').hide();
//                 $('#uploadtip').html('您账户的检测此时已用完，如需更多检测次数请联系管理员。').css('color','green');
//              }else if(data.result.info == "UPLOAD_SUCCESS"){
//                 $('#uploadmain').hide();
//                 $('#uploadtip').html('上传成功,正在检测中...');
//              }else if(data.result.info == 'EXT_NOT_ALLOW'){
//              	console.log(data.result);
//              	 $('#uploadmain').hide();
//                 $('#uploadtip').html('请上传500M以下的应用,并且文件类型为:zip,gz,tar,tgz,rar');
//              }
//              else
//              {
//              	 $('#uploadmain').hide();
//                 $('#uploadtip').html(data.result.info);
//              }
//          },
//          progressall: function (e, data) {
//              var progress = parseInt(data.loaded / data.total * 100, 10);
//              if(progress >0){
//                 $('#progress').show();
//              }
//              $('#progress .progress-bar').css(
//                  'width',
//                  progress + '%'
//              );
//
//              if(progress == '100'){
//                  setTimeout("location.reload()",10000); 
//              }
//          },
//          fail:function(e,data){
//               $('#uploadmain').hide();
//               $('#uploadtip').html('应用上传错误');
//          }
      }).bind('fileuploadadd',function(e,data){
	 	//data.url = url + "/action/"+$('#selectVocationtype').val()+"/test/1"+'/version/'+$('input[name=softversion]').val()+'/projectname/'+$('input[name=projectname]').val()+'/lang/'+$('#lang').val()+'/makeenv/'+$('#makeenv').val()+'/mekecommand/'+$('input[name=makecommand]').val()+'.html';    
      data.url = url + "/action/"+$('#selectVocationtype').val()+"/test/1"+'/version/'+$('input[name=softversion]').val()+'/projectname/'+$('input[name=projectname]').val()+'/lang/'+$('#lang').val()+'/makeenv/'+$('#makeenv').val()+'/mekecommand/'+$('input[name=makecommand]').val()+'/vocation/'+$('#vocation').val()+'.html';
      }).prop('disabled', !$.support.fileInput)
      .parent().addClass($.support.fileInput ? undefined : 'disabled');
//});
}
