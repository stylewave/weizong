<?php if (!defined('THINK_PATH')) exit();?><!-- <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> -->
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="icon" href="/sca/Public/img/fav_icon_32.ico" />
<link type="text/css" rel="stylesheet" href="/sca/Public/css/style.css" />
<link rel="stylesheet" type="text/css" href="/sca/Public/css/font-awesome.css"/>
<link rel="stylesheet" type="text/css" href="/sca/Public/css/bootstrap.css"/>
<link rel="stylesheet" type="text/css" href="/sca/Public/css/dropzone/basic.min.css"/>
<link rel="stylesheet" type="text/css" href="/sca/Public/css/dropzone/dropzone.min.css"/>

<!--[if !IE]> -->
<!-- <script src="/sca/Public/js/jquery-2.1.4.min.js"></script> -->
<![endif]-->
<!--  IE8只能支持jQuery1.9 -->
<!--[if IE]> -->
<script src="/sca/Public/js/jquery-1.9.1.min.js"></script>
<!-- <![endif]-->
<script src="/sca/Public/js/md5.js"></script>
<script type="text/javascript" src='/sca/Public/js/swfupload/swfupload.js'></script>

<script type="text/javascript" src='/sca/Public/js/jquery.swfupload.js'></script>
<script type="text/javascript" src="/sca/Public/js/script.js"></script>
<script type="text/javascript" src="/sca/Public/js/RegExp.js"></script>
<script type="text/javascript" src="/sca/Public/js/bootstrap.min.js"></script>
	<title>微众源代码安全检测系统</title>
</head>

<?php if(CONTROLLER_NAME !='User'): ?>
<body class="mainPage">
	<div class="header">
	  <div class="layout ws10 mac ofh">
	    <div class="fl logoBox"><img src="/sca/Public/img/jingtai_logo.png"/></div>
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
<link rel="stylesheet" type="text/css" href="/sca/Public/plugins/timepicker/css/jquery-ui.css" />
<script type="text/javascript" src="/sca/Public/plugins/timepicker/js/jquery-ui.js"></script>
<script type="text/javascript" src="/sca/Public/plugins/timepicker/js/jquery-ui-slide.min.js"></script>
<script type="text/javascript" src="/sca/Public/plugins/timepicker/js/jquery-ui-timepicker-addon.js"></script>

<div class="layout ws10 mac content afcf settingBox setlogBox">
  <div class="mt30 bc2box br10 p30 ofh">
    <div class="ws2 fl sleft">
      <ul class="fs14 lh30 mr30 tac">
        <li><a href="<?php echo U('Manage/info_manage');?>">账户管理</a></li>
        <li class="mt5"><a href="<?php echo U('Vocationtype/list_vocationtype');?>">应用类型</a></li>
        <li class="mt5"><a href="<?php echo U('Company/list_company');?>">部门名称</a></li>
        <li class="bc1box br3 mt5"><a href="<?php echo U('Manage/log_manage');?>">日志管理</a></li>
        <li class="mt5"><a href="<?php echo U('Manage/pdfext_list');?>">报告设置</a></li>
        <!-- <li class="mt5"><a href="<?php echo U('Manage/feedbacklist_manage');?>">应用反馈</a></li> -->
      </ul>
    </div>
    <div>
      <div>
        <table width="83%" cellspacing="0" cellpadding="0" class="table tableBlue fs14">
          <form action="<?php echo U('Manage/searchlog_manage');?>" method="GET" id="searchlog">
          <tr>
            <td>登录账号:<input class="bcn wzh_input oh fcwhite fs14" type="text" name="loginemail" <?php if($_GET['loginemail'] != null): ?>value="<?php echo ($_GET['loginemail']); ?>"<?php endif; ?> placeholder="输入账号" />
            IP:<input class="bcn wzh_input oh fcwhite fs14" type="text" name="ip" <?php if($_GET['ip'] != null): ?>value="<?php echo ($_GET['ip']); ?>"<?php endif; ?> placeholder="IP" />
            开始时间:<input class="bcn wzh_input oh fcwhite fs14" type="text" name="starttime" <?php if($_GET['starttime'] != null): ?>value="<?php echo date('Y-m-d H:i',$searchlog['0']['handletime']);?>"<?php endif; ?> placeholder="开始时间" />
            结束时间:<input class="bcn wzh_input oh fcwhite fs14" type="text" name="endtime" <?php if($_GET['endtime'] != null): ?>value="<?php echo date('Y-m-d H:i');?>"<?php endif; ?> placeholder="结束时间" />
            操作:<input class="bcn wzh_input oh fcwhite fs14" type="text" name="action" <?php if($_GET['action'] != null): ?>value="<?php echo ($_GET['action']); ?>"<?php endif; ?> placeholder="操作条件" />
<div class="btn" style="background-color: #fff;"><img src="/sca/Public/img/icon_search.png" width="20" onclick="$('#searchlog').submit();"/></div></td>
          </tr>
          </form>
        </table>
      </div><br/>
      <div>
      <table width="83%" cellspacing="0" cellpadding="0" class="table tableBlue fs14" id="logShow" >
          <tr id="logHead">
            <th class="tal nwp time">时间</th>
            <th class="tal nwp">ID</th>
            <th class="tal nwp">登录账号</th>
            <th class="tal nwp">用户名</th>
            <th class="tal nwp inip">IP</th>
            <th class="tal nwp">操作</th>
          </tr>
          <tbody class="ajax" id="logDetialContent">
            <?php if(is_array($searchlog)): $i = 0; $__LIST__ = $searchlog;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v1): $mod = ($i % 2 );++$i;?><tr>
              <td class="time"><?php echo (date("Y-m-d H:i:s",$v1["handletime"])); ?></td>
              <td><?php echo ($v1["userid"]); ?></td>
              <td><?php echo ($v1["username"]); ?></td>
              <td><?php if($v1['username'] == 'admin'): ?>管理员<?php else: echo ($v1["realname"]); endif; ?></td>
              <td class="inip"><?php echo ($v1["handleip"]); ?></td>
              <td><?php echo ($v1["handlecontent"]); ?></td>
            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
          </tbody>
      </table>
      <div style="text-align: center;"><?php echo ($pageshow); ?></div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript" src="/sca/Public/js/logmanage.js"></script>

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