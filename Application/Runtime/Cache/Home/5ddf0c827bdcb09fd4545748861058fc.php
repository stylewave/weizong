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
<head>
	<title>检测应用列表</title>
  <link rel="stylesheet" type="text/css" href="/Public/plugins/timepicker/css/jquery-ui.css" />
  <script type="text/javascript" src="/Public/plugins/timepicker/js/jquery-ui.js"></script>
  <script type="text/javascript" src="/Public/plugins/timepicker/js/jquery-ui-slide.min.js"></script>
  <script type="text/javascript" src="/Public/plugins/timepicker/js/jquery-ui-timepicker-addon.js"></script>
</head>

<div class="layout ws10 mac content dttcenBox dttlistBox">
  <div class="mt30 bc2box br10 p30 ofh">
  <?php if($_SESSION['power']['usertypeid'] == 3): ?><div><font style="color:#E2C4A9;" size="5"><?php echo ($_SESSION['power']['zhvocationtype']); ?> 行业</font></div><br/><?php endif; ?>
  <form method="get" action="<?php echo U('Detection/searchapp_detection');?>">
      <input class="wzh_input" type="text" name="appname" placeholder="应用名" />
     <input class="wzh_input" type="text" name="version" placeholder="软件版本" />
      <input class="wzh_input" type="text" name="md5" placeholder="md5" />
      <!-- <input class="wzh_input" type="text" name="starttime" placeholder="开始时间" /> -->
      <!-- <input class="wzh_input" type="text" name="endtime" placeholder="结束时间" /> -->
      
      <!-- <input class="wzh_input" type="text" name="level" placeholder="安全等级" /> -->
      <?php if($_SESSION['power']['usertypeid'] == 3): ?><input class="wzh_input" type="hidden" name="vocation" value="<?php echo ($_SESSION['power']['vocatypeid']); ?>" /><?php endif; ?>
      <select name="condition" class="pl10 bcn fcwhite oh" style="border-radius: 3px;">
        <option value="appid">默认</option>
        <option value="time">检测时间</option>
        <option value="version">版本号</option>
      </select>
      <select name="sort" class="pl10 bcn fcwhite oh" style="border-radius: 3px;">
      	<option value="DESC">降序</option>
        <option value="ASC">升序</option>
      </select>
      <input type="submit" value="搜索" class="btn btn-default"/>
    </form><br/>
<!--      <a href="/reportpdf.pdf">下载pdf</a>-->
    <table width="100%" cellspacing="0" cellpadding="0" class="tableBlue table">
        <tr>
          <th class="nwp">序号</th>
          <th class="nwp tal">项目名称</th>
         
          <th class="bbh nwp tal">软件版本</th>
          <th class="md5 nwp tal">MD5</th>
           <th class="name nwp tal">提交用户</th>
          <th class="time nwp tal">提交时间</th>
           <th class="nwp tal">检测状态</th>
          <th class="nwp tal">操作</th>
        </tr>
        <?php if(is_array($applist)): $i = 0; $__LIST__ = $applist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
          <td class="tac fs16"><?php echo ($i+$star); ?></td>
          <td class="fs16"><?php echo ($vo["name"]); ?></td>
         
          <td class="bbh fs16"><?php echo ($vo["version"]); ?></td>
          <td class="md5 fs16"><?php echo ($vo["md5"]); ?></td>
          <td class="name fs16"><?php if($vo['adminlogin'][0]['loginemail'] != '' ): echo ($vo['adminlogin'][0]['loginemail']); else: echo ($vo['userlogin'][0]['loginemail']); endif; ?></td>
          <td class="time fs16"><?php echo ($vo["subtime"]); ?></td>
           <td class="fs16">
          <?php if($vo['status'] == 1): ?>检测完成
          <?php elseif($vo['status'] == 0): ?>
          检测中
          <?php else: ?>
          检测失败<?php endif; ?>
          </td>
          <td>
      <?php if($vo['status'] == 1): ?>
     
          <a class="btn btn-default" href="<?php echo U('Report/base_report',array('appid'=>$vo['appid']));?>">查看</a>
           <!--<a class="btn btn-default" href="<?php echo U('Word/repdfs',array('appid'=>$vo['appid']));?>"><span onclick="checkModal('<?php echo ($vo["appid"]); ?>')">word</span></a>-->
<!--          <a class="ml5 btn btn-success" ><span onclick="checkModal('<?php echo ($vo["appid"]); ?>')">下载报告</span></a>-->
<!--            <a class="btn btn-default" href="<?php echo U('Word/ww',array('appid'=>$vo['appid']));?>">word</a> -->
<!--            <a class="btn btn-default" href="<?php echo U('Word/makePdfReportsss',array('appid'=>$vo['appid']));?>">pdf</a> -->
          <a class="ml5 btn btn-success" url="<?php echo U('Word/makePdfReportsss',array('appid'=>$vo['appid']));?>" ><span  onclick='tipDownPdf($(this).parent().attr("url"));' >下载报告</span></a>
        	<a class="ml5 btn btn-danger" url="<?php echo U('Manage/delApkinfo_manage',array('appid'=>$vo['appid']));?>" onclick="delRecord($(this).attr('url'));">删除</a> 
                <a class="ml5 btn btn-danger" href="<?php echo U('Manage/delApkinfo_manage',array('appid'=>$vo['appid']));?>" >删除2</a>  
       <?php elseif($vo['status'] == 2): ?>
          <a class="btn btn-default  disabled" href="<?php echo U('Report/base_report',array('appid'=>$vo['appid']));?>">查看</a>
           <a class="ml5 btn btn-success disabled" ><span onclick="checkModal('<?php echo ($vo["appid"]); ?>')">下载报告</span></a>
          <!--<a class="ml5 btn btn-success  disabled" url="" ><span  onclick='tipDownPdf($(this).parent().attr("url"));' >下载报告</span></a>-->
          <a class="ml5 btn btn-danger  " url="<?php echo U('Manage/delApkinfo_manage',array('appid'=>$vo['appid']));?>" onclick="delRecord($(this).attr('url'));">删除</a> 
       <?php elseif($vo['status'] == 0): ?>
          <a class="btn btn-default  disabled" href="<?php echo U('Report/base_report',array('appid'=>$vo['appid']));?>">查看</a>
           <a class="ml5 btn btn-success disabled" ><span onclick="checkModal('<?php echo ($vo["appid"]); ?>')">下载报告</span></a>
          <!--<a class="ml5 btn btn-success  disabled" url="" ><span  onclick='tipDownPdf($(this).parent().attr("url"));' >下载报告</span></a>-->
          <a class="ml5 btn btn-danger  disabled" url="<?php echo U('Manage/delApkinfo_manage',array('appid'=>$vo['appid']));?>" onclick="delRecord($(this).attr('url'));">删除</a> 
          <?php endif; ?>
          </td>
        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
    </table>
    <div align="center">
      <?php echo ($pageshow); ?>
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
                          <div class="modal-body">    
                           <div class="row">
                                 <div class="col-sm-3"></div>
                                         <div class="col-sm-9">
                                             <p style="font-size:16px;">风险类别：
                                                 <select name="risk">
                                                     <option value="">请选择风险类别</option>
                                                       <option value="all">全部</option>
                                                       <option value="critical">严重</option>
                                                       <option value="high">高危</option>
                                                       <option value="medium">中危</option>
                                                       <option value="low">低危</option>
                                           </select>
                                           </p>
                                         </div>
                           </div>
                          </div>
                           <div class="modal-footer">
                            <input class="btn btn-primary" type="submit" value="确定下载">
                            <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>

                        </div>

                         </div></form>
                </div>
            </div>
    
</div>
<script type="text/javascript" src="/Public/js/listdetection.js">
    
</script>  <script type="text/javascript">
    function checkModal(appid) {
       // alert(url);
        $('input[name=appid]').val(appid);
        $("#report").modal('show');
   }
</script>

		<span id="errtip" style="display: none;"><?php echo ($_GET['tip']); ?></span>
			<div class="dttcenAdd bc2box" id="errmess">
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

		<div class="footer-copy-right">
			<p class="fs16 pr15 p5">版权所有 深圳前海微众银行股份有限公司</p>
		</div>
		
	</body>
</html>