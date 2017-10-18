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

<body class="loginPage">
<div class="layout ws10 mac">
  <div class="main-box">
    <div class="head-logo">
      <div class="logo-wrapper">
     <img src="/Public/img/jingtai_logo.png" class="img-responsive" />
<!--   <img src="/Public/img/jingtai_logo.png"/> -->
      </div>
    </div>

    <form class="formBox login-box" action="/index.php/Home/User/login_user" method="POST" id="login-form" >
      <!-- <div class="fs24 fcf">云终端应用检测系统</div> -->
        
      <div class="text mt30">
        <input class="ws12 wzh_input p5 bcn bd9 fcf" maxlength="32" type="text" placeholder="账号" name="email" />
      </div>
      <div class="mt15">
        <input class="ws12 wzh_input p5 bcn bd9 fcf" maxlength="32" type="password" placeholder="密码" name="pwd" />
      </div>
      <div class="mt15 ofh"> <img class="fr mt5 captcha" src="/index.php/Home/Layout/captcha" onClick="javascript:this.src = this.src +'?' + Math.random();" style="width:90px;height:30px;" id='clickpic'/>
        <input class="ws6 wzh_input p5 bcn bd9 fcf" maxlength="16" type="text" placeholder="验证码" name="captcha" />
      </div>
      <font id="tip" color="red">&nbsp;</font>
      <table class="mt20 lh24" width="100%" cellspacing="0" cellpadding="0">
        <tr>
          <td class="pr5"><input class="fs14 br3 fcf btn-border-blue tac p5 ws12 bd9" type="submit" value="登录" onClick="return false"/></td>
         
          <!-- <td class="pl5"><input class="fs14 br3 fcf bc0 tac p5 ws12 bd9" type="button" value="注册" onclick="location.href=$(this).attr('url')" url="<?php echo U('User/register_user');?>" /></td> -->
        </tr>
        <tr>


        </tr>
      </table>
    </form>
  </div>
</div>

<script type="text/javascript" src="/Public/js/userLogin.js"></script>


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
<script type="text/javascript" src="/Public/js/bootstrap.min.js"></script>
</body>
</html>