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
<?php if(count($userlist) == 0): ?><span id="p" style="display: none;"><?php echo $_GET["p"]; php?></span>
<script>
  var p = $('#p').html();
  if( p == 0){
    p=1; 
    window.location.href="/index.php/Home/Manage/info_manage/p/"+p+'.html'; 
  }
</script><?php endif; ?>

<div class="layout ws10 mac content afcf settingBox">
  <div class="mt30 bc2box br10 p30 ofh">
    <div class="ws2 fl sleft">
      <ul class="fs14 lh30 mr30 tac">
        <li class="bc1box br3"><a href="<?php echo U('Manage/info_manage');?>">账户管理</a></li>
        <li class="mt5"><a href="<?php echo U('Vocationtype/list_vocationtype');?>">应用前缀</a></li>
        <li class="mt5"><a href="<?php echo U('Company/list_company');?>">部门名称</a></li>
        <li class="mt5"><a href="<?php echo U('Manage/log_manage');?>">日志管理</a></li>
        <li class="mt5"><a href="<?php echo U('Manage/pdfext_list');?>">报告设置</a></li>
        <!-- <li class="mt5"><a href="<?php echo U('Manage/feedbacklist_manage');?>">应用反馈</a></li> -->
      </ul>
    </div>
    <div class="ws10 fr bdl9 pl30 sright">
      <div class="tar"><a class="bc3box pt5 pb5 pl20 pr20 fs14 tac dib br3" href="<?php echo U('Manage/adduser_manage');?>">创建账户</a></div>
      <table width="100%" cellspacing="0" cellpadding="0" class="table tableBlue mt10">
          <tr>
            <th class="nwp">邮箱</th>
            <th class="nwp">收费类型</th>
            <th class="nwp">用户类型</th>
            <th class="nwp">用户名</th>
            <th class="time nwp">最后登录时间</th>
            <th class="inip nwp">最后登录IP</th>
            <th class="nwp">操作</th>
          </tr>
          <?php if(is_array($userlist)): $i = 0; $__LIST__ = $userlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
            <td><?php echo ($vo["loginemail"]); ?></td>
            <td>
            <?php echo ($vo["zhpaytype"]); ?>
            </td>
            <td>
            <?php if($vo["usertypeid"] == 3): echo ($vo["zhusertype"]); ?>&nbsp;&nbsp;&nbsp;<?php echo ($vo["zhvocationtype"]); ?>
            <?php elseif($vo["usertypeid"] == 2): ?>
              <?php echo ($vo["zhusertype"]); ?>
            <?php else: ?>
              <?php echo ($vo["zhusertype"]); endif; ?>
            </td>

            <td><?php echo ($vo["realname"]); ?></td>
            <td class="time"><?php echo ($vo["lasttime"]); ?></td>
            <td class="inip"><?php echo ($vo["ip"]); ?></td>
            <td class="btn">
              <a href="<?php echo U('Personal/detial_personal',array('userid'=>$vo['userid']));?>">详细</a>
              <a class="ml5" href="<?php echo U('Personal/modifypass_personal',array('uid'=>$vo['userid']));?>">修改密码</a>
              <a class="ml5" href="<?php echo U('Personal/modifyinfo_personal',array('uid'=>$vo['userid']));?>">修改信息</a>
              <a class="ml5" href="<?php echo U('Personal/modifypower_personal',array('uid'=>$vo['userid']));?>">修改权限</a>
              <a class="ml5" url="<?php echo U('Manage/deluser_manage',array('uid'=>$vo['userid']));?>" onclick="delRecord($(this).attr('url'));">删除</a></td>
          </tr><?php endforeach; endif; else: echo "" ;endif; ?>
      </table>
      <div align="center" class="fenye">
      <?php echo ($pageshow); ?>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript" src="/Public/js/infomanage.js"></script>

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