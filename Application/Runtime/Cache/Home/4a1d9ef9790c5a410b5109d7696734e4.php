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

<div class="layout ws10 mac content afcf yonghuBox">
  <div class="mt30 bc2box br10 p30 ofh">
    <div class="ws2 fl sleft">
      <ul class="fs14 lh30 mr30 tac">
        <li><a href="<?php echo U('Personal/info_personal');?>">账户信息</a></li>
        <?php if($_SESSION['power']['usertypeid'] == '1' OR $_SESSION['power'] == 'all'): ?><li class="mt5"><a href="<?php echo U('Personal/editinfo_personal');?>">修改信息</a></li><?php endif; ?>
        <li class="bc1box br3 mt5"><a href="<?php echo U('Personal/editpass_personal');?>">修改密码</a></li>
        <!-- <li class="mt5"><a href="<?php echo U('Personal/feedbacklist_personal');?>">查看反馈</a></li> -->
      </ul>
    </div>
    <div class="ws10 fr bdl9 pl30 pr30 sright">
      <form class="form" action="/index.php/Personal/editpass_personal.html" method="POST" id="form">
        <div class="fs16 fwb">修改密码</div>
        <table class="table table-hover mt20">
          <tr>
            <td class="tar">旧密码</td>
            <td class="pl10"><input class="ws12 wzh_input p5 bcn bd9 fcf" type="password" name="pwd" /></td>
            <td class="pl10">&nbsp;</td>
          </tr>
          <tr>
            <td class="tar">新密码</td>
            <td class="pl10"><input class="ws12 wzh_input p5 bcn bd9 fcf" type="password" name="pwd1" /></td>
            <td class="pl10"><span id="pwd1info" style="color:red;">&nbsp;</span></td>
          </tr>
          <tr>
            <td class="tar nwp">确认新密码</td>
            <td class="pl10"><input class="ws12 wzh_input p5 bcn bd9 fcf" type="password" name="pwd2" /></td>
            <td class="pl10"><span id="pwd2info"  style="color:red;">&nbsp;</span></td>
          </tr>
          <tr>
            <td class="tar">验证码</td>
            <td class="pl10"><input class="ws12 wzh_input p5 bcn bd9 fcf" type="text" name="captcha"/></td>
            <td class="pl10"><img src="/index.php/Home/Layout/captcha" onclick="javascript:this.src = this.src +'?' + Math.random();" id='clickpic' style="width: 20%;" />
            <span id="captchainfo" style="color:red;">&nbsp;</span>
            </td>
          </tr>
          <tr>
            <td></td>
            <td class="pl10 pt20"><input type="button" class="ws12 bc3box p5 fs14 fcf tac db br3 bdn" value="修改密码" id="form-submit" /></td>
            <td></td>
          </tr>
        </table>
      </form>
    </div>
  </div>
</div>
<script src="/Public/js/editpass.js"></script>

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