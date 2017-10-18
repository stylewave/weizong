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

<link rel="stylesheet" type="text/css" href="/Public/plugins/timepicker/css/jquery-ui.css" />
<script type="text/javascript" src="/Public/plugins/timepicker/js/jquery-ui.js"></script>
<script type="text/javascript" src="/Public/plugins/timepicker/js/jquery-ui-slide.min.js"></script>
<script type="text/javascript" src="/Public/plugins/timepicker/js/jquery-ui-timepicker-addon.js"></script>


<div class="layout ws10 mac content afcf settingBox setlogBox">
  <div class="mt30 row bc2box br10 p30 ofh">
    <div class="col-sm-2">
      <ul class="fs14 lh30 mr30 tac">
        <li><a href="<?php echo U('Manage/info_manage');?>">账户管理</a></li>
        <li class="mt5"><a href="<?php echo U('Vocationtype/list_vocationtype');?>">应用前缀</a></li>
        <li class="mt5"><a href="<?php echo U('Company/list_company');?>">部门名称</a></li>
        <li class="mt5"><a href="<?php echo U('Manage/log_manage');?>">日志管理</a></li>
        <li class="bc1box br3 mt5"><a href="<?php echo U('Manage/pdfext_list');?>">报告设置</a></li>
        <!-- <li class="mt5"><a href="<?php echo U('Manage/feedbacklist_manage');?>">应用反馈</a></li> -->
      </ul>
    </div>
    
    <div class="col-sm-10">
    	<div class="row">
    	
	    <div class="pull-left">
	      <form action="/index.php/Home/Manage/pdfext_expandswitch" method="post">
	        <div class="fl">
	        	<label class="wzh_radio" for="expandswitch1">
	        		<input id="expandswitch1" class="wzh_check" type="radio" name="expandswitch" width="25px" value="1" <?php if($showWartermark['textpic'] == 1): ?>checked<?php endif; ?> >
	        		展示水印等内容
	        		<span class="wzh_icon_checked"></span>
	        	</label>
	        	<label class="wzh_radio" for="expandswitch2">
	        		<input id="expandswitch2" class="wzh_check" type="radio" name="expandswitch" value="0" <?php if($showWartermark['textpic'] == 0): ?>checked="checked"<?php endif; ?> >
	        		隐藏水印等内容
	        		<span class="wzh_icon_checked"></span>
	        	</label>
	          <!--<input type="radio" name="expandswitch" width="25px" value="1" <?php if($showWartermark['textpic'] == 1): ?>checked="checked"<?php endif; ?> ><font size="5">展示水印等内容</font>
	          <input type="radio" name="expandswitch" value="0" <?php if($showWartermark['textpic'] == 0): ?>checked="checked"<?php endif; ?> ><font size="5">隐藏水印等内容</font>-->
	        </div>
	        <input class="btn btn-border-blue" type="submit" value="确定"/>
	      </form>
	    </div>
	    
	    <div class="pull-right">
    			<a class="btn btn-border-blue" href="/index.php/Home/Manage/pdfext_add">增加PDF拓展</a>
    		</div>
    
	    <div class="col-sm-12">
	      <table width="83%" cellspacing="0" cellpadding="0" class="table tableBlue fs14" id="logShow" style="margin-top: 20px;">
	          <tr id="logHead">
	            <th class="tal nwp">选择状态</th>
	            <th class="tal nwp">页眉(上)内容</th>
	            <th class="tal nwp">页眉(下)内容</th>
	            <th class="tal nwp">背景图片</th>
	            <th class="tal nwp">头部图片</th>
	            <th class='tal nwp' style="text-align: center;">操作</th>
	          </tr>
	          <tbody class="ajax" id="logDetialContent">
	            <?php if(is_array($pdfextlist)): $i = 0; $__LIST__ = $pdfextlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v1): $mod = ($i % 2 );++$i;?><tr>
	              <td><?php if($v1['status'] == 1): ?><img src="/Public/css/choice.png" width="20px"/><?php else: ?><img src="/Public/css/nochoice.png" width="20px"/><?php endif; ?></td>
	              <td class="time"><?php echo ($v1["headerup"]); ?></td>
	              <td class="time"><?php echo ($v1["headerdown"]); ?></td>
	              <td>
	              <?php if($v1['background'] != '不存在'): ?><img src="/<?php echo ($v1["background"]); ?>" width="20px" />
	              <?php else: ?>
	                <?php echo ($v1["background"]); endif; ?>
	              </td>
	              <td>
	              <?php if($v1['headimg'] != '不存在'): ?><img src="/<?php echo ($v1["headimg"]); ?>" width="20px" />
	              <?php else: ?>
	                <?php echo ($v1["headimg"]); endif; ?>
	              </td>
	              <td style="text-align: center;"><a href="/index.php/Home/Manage/pdfext_setcontent/pdfextid/<?php echo ($v1['id']); ?>">使用此样式</a>&nbsp;&nbsp;&nbsp;<a href="/index.php/Home/Manage/pdfext_set/pdfextid/<?php echo ($v1['id']); ?>">修改</a> | <a href="/index.php/Home/Manage/pdfext_del/pdfextid/<?php echo ($v1[id]); ?>">删除</a></td>
	            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
	          </tbody>
	      </table>
	      <div style="text-align: center;"><?php echo ($pageshow); ?></div>
	      </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript" src="/Public/js/pdfextlist.js"></script>

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