<?php if (!defined('THINK_PATH')) exit();?><!-- <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> -->
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="icon" href="/Public/img/fav_icon_32.ico" />
<link type="text/css" rel="stylesheet" href="/Public/css/style.css" />
<link rel="stylesheet" type="text/css" href="/Public/css/font-awesome.css"/>
<link rel="stylesheet" type="text/css" href="/Public/css/bootstrap.css"/>
<link rel="stylesheet" type="text/css" href="/Public/css/dropzone/basic.min.css"/>
<link rel="stylesheet" type="text/css" href="/Public/css/dropzone/dropzone.min.css"/>

<!--[if !IE]> -->
<!-- <script src="/Public/js/jquery-2.1.4.min.js"></script> -->
<![endif]-->
<!--  IE8只能支持jQuery1.9 -->
<!--[if IE]> -->
<script src="/Public/js/jquery-1.9.1.min.js"></script>
<!-- <![endif]-->
<script src="/Public/js/md5.js"></script>
<script type="text/javascript" src='/Public/js/swfupload/swfupload.js'></script>

<script type="text/javascript" src='/Public/js/jquery.swfupload.js'></script>
<script type="text/javascript" src="/Public/js/script.js"></script>
<script type="text/javascript" src="/Public/js/RegExp.js"></script>
<script type="text/javascript" src="/Public/js/bootstrap.min.js"></script>
	<title>微众源代码安全检测系统</title>
</head>

<?php if(CONTROLLER_NAME !='User'): ?>
<body class="mainPage">
	<div class="header">
	  <div class="layout ws10 mac ofh">
	    <div class="fl logoBox"><img src="/Public/img/jingtai_logo.png"/></div>
	    <ul class="fr menuBox">
	      	<li <?php if((CONTROLLER_NAME == 'Detection' AND (ACTION_NAME != 'list_detection') AND (ACTION_NAME != 'searchapp_detection')) OR (CONTROLLER_NAME == 'Report')): ?>class="sel jiance"<?php else: ?>class="jiance"<?php endif; ?> ><a href="<?php echo U('Detection/center_detection');?>"><i class="fa fa-dashboard"></i> 检测</a></li>
	        <li <?php if((CONTROLLER_NAME == 'Detection') AND (ACTION_NAME == 'list_detection' OR ACTION_NAME == 'searchapp_detection')): ?>class="sel liebiao"<?php else: ?>class="liebiao"<?php endif; ?> ><a href="<?php echo U('Detection/list_detection');?>"><i class="fa fa-file-text"></i> 列表</a></li>
	        <li <?php if((CONTROLLER_NAME == 'Personal') AND (ACTION_NAME != 'detial_personal') AND (ACTION_NAME != 'modifyinfo_personal') AND (ACTION_NAME != 'modifypass_personal') AND (ACTION_NAME != 'modifypower_personal')): ?>class="sel yonghu"<?php else: ?>class="yonghu"<?php endif; ?> ><a href="<?php echo U('Personal/info_personal');?>"><i class="fa fa-user"></i> 个人</a></a></li>
	        <?php if($_SESSION['power'] == 'all'): ?><li <?php if((CONTROLLER_NAME == 'Manage') OR ((CONTROLLER_NAME == 'Personal') AND (ACTION_NAME == 'detial_personal') OR ((CONTROLLER_NAME == 'Personal') AND (ACTION_NAME == 'modifypass_personal')) OR ((CONTROLLER_NAME == 'Personal') AND (ACTION_NAME == 'modifyinfo_personal')) OR ((CONTROLLER_NAME == 'Personal') AND (ACTION_NAME == 'modifypower_personal')) OR (CONTROLLER_NAME == 'Vocationtype') OR (CONTROLLER_NAME == 'Company') )): ?>class="sel shezhi"<?php else: ?>class="shezhi"<?php endif; ?> ><a href="<?php echo U('Manage/info_manage');?>"><i class="fa fa-gear"></i> 设置</a></li><?php endif; ?>
	      <li class="tuichu"><a href="<?php echo U('User/logout_user');?>"><i class="fa fa-power-off"></i> 退出</a></li>
	    </ul>
	  </div>
	</div>
<?php endif; ?>
<div class="layout ws10 mac content afcf dttcenBox">
  <div class="mt10 ws4 fl appear-block appear-from-center">
    <div class="bc2box br10 ml15 mr15 item aitem">
      <div class="pt30 icon tac">
		  <?php if(($recent[0]['status'] == 1) OR (count($recnet) == 0)): if(($_SESSION['power'] == 'all')): if($manRecent["status"] != null || count($manRecent) == 0): ?>
		      	<a class="brs5 bc1box" id="maninterval" ><img src="/Public/img/jiance_add.png" /></a>
				<?php endif; endif; ?>
		      <?php if($_SESSION['power'] != 'all'): ?><if condition="$uploadfunction eq 'true'">
			          <a class="brs5 bc1box" id="interval" style="display: none;"><img src="/Public/img/jiance_add.png" /></a>
			      <?php elseif($uploadfunction == 'false'): ?>
			        今天的上传次数完毕,请明天再来<?php endif; endif; ?>
	     </if>
	    <!--  <?php if(($recent[0]['status'] == 0) AND ($_SESSION['power'] != 'all')): if(count($recent) != 0): ?><div class="mt30 pt40 fs24 tac fw2">请等待检测完毕</div><?php endif; endif; ?> -->
		 <!-- <?php if(count($manRecent) != 0 AND ($manRecent['status'] == 0) AND ($_SESSION['power'] == 'all')): if(count($recent) == 0 ): ?><font class="mt30 pt40 fs24 tac fw2" style="top:20%;padding: 20%;">请等待检测完毕</font><?php endif; endif; ?> -->
      </div>
      <?php if($recent[0]['status'] == 1 OR $recnet == null): if($uploadfunction == 'true'): if($_SESSION["power"] == 'all'): ?>
  				<?php if($manRecent['status'] == 1 || count($manRecent) == 0): ?>
  				<!-- <div class="mt30 pt40 fs24 tac fw2" id="manUpload" >上传检测</div> -->
  				<?php endif;?>
  			<?php endif; endif; endif; ?>
    </div>
  </div>
  <?php if(is_array($recent)): $i = 0; $__LIST__ = $recent;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="mt10 ws4 fl appear-block appear-from-center">
    <div class="bc2box br10 ml15 mr15 p30 item sitem">
      <table width="100%" cellspacing="0" cellpadding="0">
        <tr>
          <?php if(substr($vo['icon'],0,4) != 'http'): ?><td align="right" style=" " class="mt30 fs28 fw2">
            <?php echo ($vo["name"]); ?>  </td>
            <?php else: ?>
             <td><img src="<?php echo ($vo["icon"]); ?>" width="80" /></td><?php endif; ?>
          <?php if($vo["status"] == 0): ?><td align="right" style="margin-right:20px; " class="mt30 fs28 fw2">
            正在检测中 
            <!--60秒后自动刷新 -->
            <head><meta http-equiv="refresh" content="260"></head>
            </td>
          <?php elseif($vo["status"] == 1): ?>
          <td align="right" class="score fw2 mt30">
           检测完成
          </td>
          <td valign="bottom" class="fs16"><span class="db pl5 pb5"></span></td>
          <?php else: ?>
          <td align="right" style="margin-right:20px; " class="mt30 fs28 fw2">
            检测失败 
          </td><?php endif; ?>
        </tr>
      </table>
      <div class="mt10 fs28 fw2"><?php echo ($vo["realname"]); ?></div>
      <div class="mt10 nwp">版本号:<?php echo ($vo["version"]); ?><br/>
        开发语言:<?php echo ($vo["lang"]); ?><br/>
        编译环境:<?php echo ($vo["env"]); ?><br/>
         项目大小:<?php echo ($vo["size"]); ?><br/>
         MD5:<?php echo ($vo["md5"]); ?><br/>
         风险总类:<?php echo (count($vo["listcount"])); ?><br/>
         总风险:<?php echo ($vo["count"]); ?><br/>
         严重风险:<?php echo ($vo["cricount"]); ?><br/>
         高危风险:<?php echo ($vo["highcount"]); ?><br/>
         中危风险:<?php echo ($vo["midcount"]); ?><br/>
         低危风险:<?php echo ($vo["lowcount"]); ?><br/>


        提交时间:<?php echo ($vo["subtime"]); ?></div>
        <?php if($vo["status"] == 1): ?><div class="mt10 ofh"><a class="fl bc3box p10 fs14 ws4 tac db br3" href="<?php echo U('Report/base_report',array('appid'=>$vo['appid']));?>">查看结果</a> 
       <?php if($_SESSION['power']['userpayid'] ==1 && $_SESSION['power'] != 'all'):?>
          <a class="fr bc3box p10 fs14 ws4 tac db br3" onclick="regTipCentDownPdf()">下载报告</a>
       <?php else:?>
<!--          <a class="fr bc3box p10 fs14 ws4 tac db br3"  onclick="checkModal('<?php echo ($vo["appid"]); ?>')" >下载报告</a>-->
          <a class="fr bc3box p10 fs14 ws4 tac db br3" url="<?php echo U('Word/makePdfReportsss',array('appid'=>$vo['appid']));?>" onclick="javascript:tipCentDownPdf($(this).attr('url')); ">下载报告</a>
       <?php endif;?>
      </div>
      <!-- <div class="mt30 nwp"><a class="fr bc3box p10 fs14 ws4 tac db br3">提交加固</a></div> --><?php endif; ?>
    </div>
  </div><?php endforeach; endif; else: echo "" ;endif; ?>
</div>
<link rel="stylesheet" type="text/css" href="/Public/plugins/jqueryUpload/css/jquery.fileupload.css">
<script type="text/javascript" src="/Public/plugins/jqueryUpload/js/vendor/jquery.ui.widget.js"></script>
<script type="text/javascript" src="/Public/plugins/jqueryUpload/js/jquery.fileupload.js"></script>
<!--enctype ="multipart/form-data"-->

<script type="text/javascript">  

    $(function(){  
        //方法  
        //$.post(url,params,function(data,status){});  
        $("#send").click(function(){  
         
//            var url = "/index.php/Home/Detection/upload_app";
            var url = "<?php echo U('Detection/upload_app');?>";
            console.log(url);
             var params = {
                           action: $('#selectVocationtype').val(),
                           address:$('#address').val(),
                           test:1,
                           version:$('input[name=softversion]').val(),
                           projectname:$('input[name=projectname]').val(),
                           lang:$('#lang').val(),
                           makeenv:$('#makeenv').val(),
                           mekecommand:$('input[name=makecommand]').val(),
                           vocation:$('#vocation').val(),
                           git:$('input[name=git]').val(),
                       };
                    
        console.log(params);
            $.post(url,params,function(data){  
                  console.log(data);
                 if(data=='UPLOAD_SUCCESS'){
                       $('#uploadmain').hide();
                        $('#uploadtip').html('提交成功,正在检测中...');
			//alert('恭喜提交成功.');
			//location.href = "<?php echo U('Detection/center_detection');?>";
                 }else if(data=='b'){
                      $('#uploadmain').hide();
                       $('#uploadtip').html('项目名不可为空');
                     //  location.href = "<?php echo U('Detection/center_detection');?>";
                
		}else if(data=='version'){
                      $('#uploadmain').hide();
                       $('#uploadtip').html('软件版本不可为空');
                     //  location.href = "<?php echo U('Detection/center_detection');?>";
                
		}else if(data=='lang'){
                      $('#uploadmain').hide();
                       $('#uploadtip').html('开发语言不可为空');
                     //  location.href = "<?php echo U('Detection/center_detection');?>";
                 
		}else if(data=='env'){
                      $('#uploadmain').hide();
                       $('#uploadtip').html('编译环境不可为空');
                      // location.href = "<?php echo U('Detection/center_detection');?>";
                
                
		}
                else{
			 $('#uploadmain').hide();
                       $('#uploadtip').html('提交失败');		
		}
              })	         
        });  
    });  
</script>  

 <form action="/index.php/Home/Detection/upload_app" method="post" >
<div class="dttcenAdd bc2box">
  <div class="ws6 mac bcf br10">
    <div class="title pl20 pr20 pt15 pb10 fs22 fc3">
    	<span class="cp close">×</span>上传代码包</div>
     
    	
      <div class="button pl20 pr20 pt15 pb40" id="swfupload-control">
        <div id="uploadmain">
        	<div class="row">
            <div class="col-md-3">
              <p>项目名:</p>
            </div>
             <div class="col-md-2" style='padding:0 -5px 0 0;'>
                 <select name='vocation' id="vocation" style="float: left;width: 100%;height:30px;margin-right: 10px;font-size:14px">
                     <option value=""  >无前缀</option>
                  <?php if(is_array($vocationlist)): $i = 0; $__LIST__ = $vocationlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vocation): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vocation['zhvocationtype']); ?>"  ><?php echo ($vocation['zhvocationtype']); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
              </select>
            </div>
                    <div class="col-md-4" style="padding-left: 5px;" >
              <input type="text" name="projectname" placeholder="请填写项目名称(必填)" />
            </div>
          </div>
          <div class="row">
            <div class="col-md-3">
              <p>软件版本:</p>
            </div>
            <div class="col-md-6">
              <input type="text" name="softversion" placeholder="请填写软件版本(必填)" />
            </div>
          </div>
          <div class="row">
            <div class="col-md-3">
              <p>开发语言:</p>
            </div>
            <div class="col-md-6">
              <!-- <input type="text" name="lang" placeholder="请填写开发语言" /> -->
              <select name='lang' id="lang" style="float: left;width: 100%;height:30px;margin-right: 10px;font-size:16px">
                <?php if(is_array($langtypelist)): $i = 0; $__LIST__ = $langtypelist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$lang): $mod = ($i % 2 );++$i;?><option value="<?php echo ($lang['lang']); ?>"  class="pl10 bcn" ><?php echo ($lang['lang']); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3">
              <p>编译环境:</p>
            </div>
            <div class="col-md-6">
              <!-- <input type="text" name="makeenv" placeholder="请选择编译环境" /> -->
              <select name='mekeenv' id='makeenv' style="float: left;width: 100%;height:30px;margin-right: 10px;font-size:16px">
                <?php if(is_array($envtypelist)): $i = 0; $__LIST__ = $envtypelist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$envid): $mod = ($i % 2 );++$i;?><option value="<?php echo ($envid['env']); ?>"  class="pl10 bcn" ><?php echo ($envid['env']); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3">
              <p>编译命令:</p>
            </div>
            <div class="col-md-6">
              <input type="text" name="makecommand" placeholder="请编写编译命令(选填)" />
            </div>
          </div>
            
            <div class="rows" >
                <div class="col-md-3">
        			<p>上传类型：</p>
        		</div>
                <div class="col-md-6">
        		
                     <input type="radio"  name="lei"   value="no" checked
                        onclick="document.getElementById('bao').style.display='';
                              document.getElementById('address').style.display='none';
                               "/>压缩包&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                      <input type="radio"  name="lei"   value="yes" 
                          onclick="document.getElementById('address').style.display='';
                                document.getElementById('bao').style.display='none';" />地址      
                        
        		</div>
             
            </div>
            
             <div class="row">
            
          </div>
            
           <div class="row" id="address" style="display:none">
                <div class="col-md-3">
                  <p>git地址:</p>
                </div>
                <div class="col-md-6">
                  <input type="text" name="git" placeholder="http://www.demo.com/www.git" id="address" />
<!--                  <label class="btn btn-success fileinput-button" >  <input type="submit" value="确定上传" /></label> -->
                 
                   
                </div>
               <div class="col-md-3"> <button type="button" id="send" class="btn btn-success fileinput-button" >提交</button></div>
               
<!--               	<div class="col-md-3">
                    <label class="btn btn-success fileinput-button"  for="fileupload">
                        <input type="submit" value="确定上传" />
		              <i class="fa fa-upload"></i>
                              上传地址
                         
		          </label>
        		</div>-->
          </div>
            </form>     
<!--          style="display:none"-->
            
        	<div class="row" id="bao"  >
        		<div class="col-md-3">
<!--        			<p>源代码上传：</p>-->
                                <p>上传压缩包：</p>
        		</div>
        		<div class="col-md-6">
        			<input type="text" value="" id="showfileurl" readonly="readonly" placeholder="支持类型: zip,gz,tar,tgz,rar"/>
		          <input id="fileupload" type="file" name="uploadfile" multiple style="display: none;">
                          
<!--                             <input id="fileuploads" type="file" name="uploadfile"  >
                          -->
                          
		          <div id="progress" style="display:none;" class="progress">
                              
		              <div class="progress-bar progress-bar-success" > </div>
		          </div>
        		</div>
        		<div class="col-md-3">
        			<label class="btn btn-success fileinput-button" for="fileupload">
		              <i class="fa fa-upload"></i>
                              上传压缩包
<!--		              <span><a class="fl bc3box p3 fs14 tac db br3 ml20 pt5 pb5 pl30 pr30">点击上传</a></span>-->
<!--		              	浏览-->
<!--		               The file input field used as target for the file upload widget -->
		          </label>
        		</div>
        	</div>
          
        	
        	<!-- <div class="row">
	        		<div class="col-md-3">
	        			<p>选择服务：</p>
	        		</div>
	        		<div class="col-md-6">
                  <?php if($servicelist[0]['show'] == '1'): ?><label class="wzh_radio" for="appcheck">
				        		<input id="appcheck" class="wzh_check" type="checkbox" name="app" width="25px" checked disabled />
				        		<?php echo ($servicelist[0]['info']); ?>
				        		<span class="wzh_icon_checked"></span>
				        	</label><?php endif; ?>
                  <?php if($servicelist[1]['show'] == '1'): ?><label class="wzh_radio" for="appreinforce">
				        		<input id="appreinforce" class="wzh_check" type="checkbox" name="app1" width="25px" />
				        		<?php echo ($servicelist[1]['info']); ?>
				        		<span class="wzh_icon_checked"></span>
				        	</label><?php endif; ?>
			        </div>
        	</div> -->
          <!--拖动上传-->
          <!--<div class="upload-area">
          	<form action="/file-upload" class="dropzone" id="dropzone">
						  <div class="fallback">
						    <input id="drop-file" name="file" type="file" />
						  </div>
						</form>
						<label for="drop-file">上传</label>
          </div>-->
          
        </div>
        <div id="uploadtip" style="text-align: left;font-size: 30px;color: #333;">
          </div>
        
      </div>
  </div>
</div>
  <script type="text/javascript" src="/Public/js/centerDetection.js"></script>


    <span id="errtip" style="display: none;"><?php echo ($_GET['tip']); ?></span>
      <div class="dttcenAddDownpDFtip bc2box" id="errmess">
        <div class="ws6 mac bcf br10">
          <div class="title pl20 pr20 pt15 pb10 fs22 fc3"><span class="cp close">×</span>提示</div>
            <div class="button pl20 pr20 pt15 pb40 fs22 errmess" style="color: red;text-align: center;">     
            </div>
            <div style="text-align: center;" id="btntipaction" style="display:block;">
              <div id='sure-err' >
                <a hre="" class="bdn fcf bc3box pt8 pb8 pl30 pr30 fs14 tac br5" >确定</a>
              </div>
            </div><br/>
        </div>
      </div>
    
    
    
      <div class="modal fade" id="report" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                  <form action="<?php echo U('Word/report');?>" method='post'>
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">下载报告</h4>
                        </div>
                         <div class="modal-body">
                             <div class="row">
                                 <div class="col-sm-3"></div>
                                <div class="col-sm-9">
                                     <input type="hidden" name="id" >
                                      <input type="hidden" name="appid" >
                                    <p style="font-size:32px;">请选择报告类型</p>
                                    <p style="font-size:28px;">	
                                        <input type="radio"  name="lei"   value="word" checked/>word &nbsp;&nbsp; &nbsp;     
                                        <input type="radio"  name="lei"   value="pdf"/>pdf</p> 
                                </div>

                            </div>



                           <div class="modal-footer">
                            <input class="btn btn-primary" type="submit" value="确定下载">
                            <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>

                        </div>

                         </div></form>
                </div>
            </div>
  <script type="text/javascript">
    function checkModal(appid) {
       // alert(appid);
        $('input[name=appid]').val(appid);
        $("#report").modal('show');
   }
</script>
<!--  <script src="/Public/plugins/dropzone/dropzone.min.js" type="text/javascript" charset="utf-8"></script>-->
  <!--<script type="text/javascript">
  	$("#dropzone").dropzone({
  		url: "./Uploads" ,
  		method: "post",
  		uploadMultiple: false,
  		addRemoveLinks: true,
  		filesizeBase: 1024,
  		maxFiles: 1,
  		autoProcessQueue: false,
  		dictRemoveFile: "移出当前文件",
  		dictFallbackMessage: "当前浏览器不支持该上传插件",
  		dictMaxFilesExceeded: "一次只能上传一个文件",
  		dictDefaultMessage: "拖动文件上传，或者点击上传"
  	});
  </script>-->
  </body>
</html>