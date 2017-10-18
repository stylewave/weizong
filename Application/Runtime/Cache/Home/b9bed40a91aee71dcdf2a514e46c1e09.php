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
<!-- 	<body class="mainPage">
<div class="header">
  <div class="layout ws10 mac ofh">
  	<div class="fl logoBox"><h3 class="brand-text">移动应用安全检测平台</h3></div>
    <ul class="fr menuBox">
    	<li class="jiance"><a href="<?php echo U('Detection/center_detection');?>"><i class="fa fa-dashboard"></i> 检测</a></li>
      <li class="sel yonghu"><a href="<?php echo U('Personal/info_personal');?>"><i class="fa fa-user"></i> 个人</a></a></li>
      <li class="liebiao"><a href="<?php echo U('Detection/list_detection');?>"><i class="fa fa-file-text"></i> 列表</a></li>
      <?php if($_SESSION['power'] == 'all'): ?><li class="shezhi"><a href="<?php echo U('Manage/info_manage');?>"><i class="fa fa-gear"></i> 设置</a></li><?php endif; ?>
      <li class="tuichu"><a href="<?php echo U('User/logout_user');?>"><i class="fa fa-power-off"></i> 退出</a></li>
    </ul>
  </div>
</div> -->
<div class="layout ws10 mac content afcf yonghuBox">
  <div class="mt30 bc2box br10 p30 ofh">
    <div class="ws2 fl sleft">
      <ul class="fs14 lh30 mr30 tac">
        <li class="bc1box br3"><a href="<?php echo U('Personal/info_personal');?>">账户信息</a></li>
        <?php if($_SESSION['power']['usertypeid'] == '1' OR $_SESSION['power'] == 'all'): ?><li class="mt5"><a href="<?php echo U('Personal/editinfo_personal');?>">修改信息</a></li><?php endif; ?>
        <li class="mt5"><a href="<?php echo U('Personal/editpass_personal');?>">修改密码</a></li>
        <!-- <li class="mt5"><a href="<?php echo U('Personal/feedbacklist_personal');?>">查看反馈</a></li> -->
      </ul>
    </div>
    <div class="ws10 fr bdl9 pl30 pr30 sright">
        <div class="fs16 fwb">账户资料</div>
        <table class="table table-hover mt20">
          <tr>
            <td>登录名</td>
            <td class="pl10"><?php echo ($info["loginemail"]); ?></td>
          </tr>
          <tr>
            <td>职业</td>
            <td class="pl10"><?php echo ($info["job"]); ?></td>
          </tr>
          <tr>
            <td>姓名</td>
            <td class="pl10"><?php echo ($info["realname"]); ?></td>
          </tr>
          <tr>
            <td>联系电话</td>
            <td class="pl10"><?php echo ($info["phone"]); ?></td>
          </tr>
          <tr>
            <td>联系地址</td>
            <td class="pl10"><?php echo ($info["address"]); ?></td>
          </tr>
          <tr>
            <td>开发者类型</td>
            <td class="pl10">
            <?php if($info["dvrtype"] == 1): ?>企业
            <?php else: ?>
            个人<?php endif; ?>
            </td>
          </tr>
          <tr>
            <td>注册时间</td>
            <td class="pl10"><?php echo ($info["regtime"]); ?></td>
          </tr>
          <tr>
            <td>检测数量</td>
            <td class="pl10"><?php echo ($info["count"]); ?></td>
          </tr>
          <tr>
            <td>最近登录</td>
            <td class="pl10"><?php echo ($info["lasttime"]); ?></td>
          </tr>
          <tr>
            <td>最近登录IP</td>
            <td class="pl10"><?php echo ($info["ip"]); ?></td>
          </tr>
        </table>
    </div>
  </div>
</div>
<script type="text/javascript" src="/Public/js/infopersonal.js"></script>

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