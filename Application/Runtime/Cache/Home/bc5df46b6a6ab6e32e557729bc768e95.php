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

<div class="layout ws10 mac content afcf yonghuBox">
  <div class="mt30 bc2box br10 p30 ofh">
    <div class="ws2 fl sleft">
      <ul class="fs14 lh30 mr30 tac">
        <li class="bc1box br3"><a href="<?php echo U('Manage/info_manage');?>">账户管理</a></li>
        <li class="mt5"><a href="<?php echo U('Vocationtype/list_vocationtype');?>">应用类型</a></li>
        <li class="mt5"><a href="<?php echo U('Company/list_company');?>">部门名称</a></li>
        <li class="mt5"><a href="<?php echo U('Manage/log_manage');?>">日志管理</a></li>
        <li class="mt5"><a href="<?php echo U('Manage/pdfext_list');?>">报告设置</a></li>
        <!-- <li class="mt5"><a href="<?php echo U('Manage/feedbacklist_manage');?>">应用反馈</a></li> -->
      </ul>
    </div>
    <div class="ws10 fr bdl9 pl30 pr30 sright">
    <!-- 修改次数限制 -->  
    <form class="form" action="/sca/index.php/Personal/modifypower_personal/uid/10218.html" method="POST" id="form3">
        <div class="fs16 fwb"><span>修改权限</span><a style="float: right;margin-right:2%;" class="fr bc3box pt5 pb5 pl20 pr20 fs14 tac br3" href="<?php echo U('Manage/info_manage');?>">返回</a></div>
        <table cellspacing="0" cellpadding="5" class="mt20">
          <tr>
            <td class="tar"></td>
            <td class="pl10"><?php echo ($info["loginemail"]); ?></td>
            <td class="pl10">&nbsp;</td>
          </tr>
          <tr>
            <td class="tar nwp">上传限制类型</td>
            <td class="pl10">
            <?php if(is_array($limittypelist)): $kl = 0; $__LIST__ = $limittypelist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vl): $mod = ($kl % 2 );++$kl;?><input  type="radio" value='<?php echo ($vl["id"]); ?>' name="uploadlimittype" <?php if($userpower['uploadlimittype'] == $vl['id']): ?>checked="checked"<?php endif; ?> <?php if($vl['id'] == '2'): ?>onclick="$('#uploadtimespace').hide();" id='upload1'<?php else: ?>onclick="$('#uploadtimespace').show();"<?php endif; ?> /><?php echo ($vl["liminame"]); ?>
            <?php if($vl['id'] == '2'): ?><script>$('#uploadtimespace').hide();</script><?php endif; endforeach; endif; else: echo "" ;endif; ?>
            </td>
            <td class="pl10">&nbsp;</td>
          </tr>
           <tr id="uploadtimespace">
            <td class="tar nwp">上传时间间隔</td>
            <td class="pl10">
            <select name="uparmar" class="pl10 bcn fcwhite">
              <?php $__FOR_START_215564695__=1;$__FOR_END_215564695__=13;for($utp=$__FOR_START_215564695__;$utp < $__FOR_END_215564695__;$utp+=1){ ?><option value="<?php echo ($utp); ?>" <?php if($userpower['utp'] == $utp): ?>selected='selected'<?php endif; ?> ><?php echo ($utp); ?></option><?php } ?>
            </select>
            <select name="utimespace" class="pl10 bcn fcwhite">
              <?php if(is_array($timespacelist)): $kt = 0; $__LIST__ = $timespacelist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vt): $mod = ($kt % 2 );++$kt;?><option value="<?php echo ($vt["id"]); ?>" <?php if($userpower['uploadtimespaceid'] == $vt['id']): ?>selected='selected'<?php endif; ?> ><?php echo ($vt["info"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
            </select>
            </td>
            <td class="pl10">&nbsp;</td>
          </tr>
          <tr>
            <td class="tar">上传次数</td>
            <td class="pl10"><input class="ws12 wzh_input p5 bcn bd9 fcf" type="text" name="uploadlimit" value="<?php echo ($userpower['uploadlimit']); ?>" /></td>
            <td class="pl10"><span id="uploadinfo" style="color:red;">&nbsp;</span></td>
          </tr>
          <tr>
            <td class="tar nwp">下载限制类型</td>
            <td class="pl10">
            <?php if(is_array($limittypelist)): $kl1 = 0; $__LIST__ = $limittypelist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vl): $mod = ($kl1 % 2 );++$kl1;?><input  type="radio" value='<?php echo ($vl["id"]); ?>' name="downlimittype" <?php if($userpower['downlimittype'] == $vl['id']): ?>checked="checked"<?php endif; ?> <?php if($vl['id'] == '2'): ?>onclick="$('#downtimespace').hide();" id="down1"<?php else: ?>onclick="$('#downtimespace').show();"<?php endif; ?>  /><?php echo ($vl["liminame"]); endforeach; endif; else: echo "" ;endif; ?>
            </td>
            <td class="pl10">&nbsp;</td>
          </tr>
           <tr id="downtimespace">
            <td class="tar nwp">下载时间间隔</td>
            <td class="pl10">
            <select name="dparmar" class="pl10 bcn fcwhite">
              <?php $__FOR_START_1387243222__=1;$__FOR_END_1387243222__=13;for($dtp=$__FOR_START_1387243222__;$dtp < $__FOR_END_1387243222__;$dtp+=1){ ?><option value="<?php echo ($dtp); ?>" <?php if($userpower['dtp'] == $dtp): ?>selected='selected'<?php endif; ?> ><?php echo ($dtp); ?></option><?php } ?>
            </select>
            <select name="dtimespace" class="pl10 bcn fcwhite">
              <?php if(is_array($timespacelist)): $kt = 0; $__LIST__ = $timespacelist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vt): $mod = ($kt % 2 );++$kt;?><option value="<?php echo ($vt["id"]); ?>" <?php if($userpower['downtimespaceid'] == $vt['id']): ?>selected='selected'<?php endif; ?> ><?php echo ($vt["info"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
            </select>
            </td>
            <td class="pl10">&nbsp;</td>
          </tr>
          <tr>
            <td class="tar nwp">下载次数</td>
            <td class="pl10"><input class="ws12 p5 bcn bd9 fcf" type="text" name="downlimit"  value="<?php echo ($userpower['downlimit']); ?>"/></td>
            <td class="pl10"><span id="downinfo"  style="color:red;">&nbsp;</span></td>
          </tr>
          <tr>
            <td class="tar nwp">权限类型</td>
            <td class="pl10">
            <select name="payid" class="pl10 bcn fcwhite">
              <?php if(is_array($userpaylist)): $i = 0; $__LIST__ = $userpaylist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>" <?php if($userpower['userpayid'] == $vo['id']): ?>selected="selected"<?php endif; ?> ><?php echo ($vo["zhpaytype"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
            </select>
            
            </td>
            <td class="pl10">&nbsp;</td>
          </tr>
          <tr>
            <td class="tar nwp">用户类型</td>
            <td class="pl10">
            <select name="usertype" class="pl10 bcn fcwhite">
            <?php if(is_array($usertypelist)): $i = 0; $__LIST__ = $usertypelist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v1): $mod = ($i % 2 );++$i;?><option value="<?php echo ($v1["id"]); ?>" <?php if($userpower['usertypeid'] == $v1['id']): ?>selected="selected"<?php endif; ?> ><?php echo ($v1["zhusertype"]); ?></option>
  
              <?php if($v1['id'] == $userpower['usertypeid'] && $userpower['usertypeid'] == '2'): ?>
                  <script type="text/javascript">
                    $(document).ready(function(){
                      $('#company').show();
                      $('#vocation').hide();
                    });
                  </script>
                <?php endif; ?>
                <?php if($v1['id'] == $userpower['usertypeid'] && $userpower['usertypeid'] == '3'): ?>
                  <script type="text/javascript">
                    $(document).ready(function(){
                      $('#company').hide();
                      $('#vocation').show();
                    });
                  </script>
                <?php endif; endforeach; endif; else: echo "" ;endif; ?>
            </select>
            </td>
            <td class="pl10">&nbsp;</td>
          </tr>
          <tr id="company" style="display: none;">
            <td class="tar nwp">部门名称</td>
            <td class="pl10">
            <select name="usercompany" class="pl10 bcn fcwhite">
              <?php if(is_array($companylist)): $i = 0; $__LIST__ = $companylist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if($vo["zhcompanytype"] != '无'): ?><option value="<?php echo ($vo["id"]); ?>"  <?php if($userpower['comtypeid'] == $vo['id']): ?>selected="selected"<?php endif; ?> /><?php echo ($vo["zhcompanytype"]); ?></option><?php endif; endforeach; endif; else: echo "" ;endif; ?>
            </select>
            </td>
            <td class="pl10">&nbsp;</td>
          </tr>
          <tr id="vocation" style="display: none;">
            <td class="tar nwp">行业类型</td>
            <td class="pl10">
            <select name="uservocatype" class="pl10 bcn fcwhite">
              <?php if(is_array($vocationtypelist)): $i = 0; $__LIST__ = $vocationtypelist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vv): $mod = ($i % 2 );++$i; if($vv["zhvocationtype"] != '无'): ?><option value="<?php echo ($vv["id"]); ?>" <?php if($userpower['vocatypeid'] == $vv['id']): ?>selected="selected"<?php endif; ?> /><?php echo ($vv["zhvocationtype"]); ?></option><?php endif; endforeach; endif; else: echo "" ;endif; ?>
            </select>
            </td>
            <td class="pl10">&nbsp;</td>
          </tr>
          <tr>
            <td></td>
            <td class="pl10 pt20"><input type="button" class="ws12 bc3box p5 fs14 fcf tac db br3 bdn" value="修改" id="formsubmit3" /></td>
            <td><font id="limitErrorInfo" color="red"></font></td>
          </tr>
        </table>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript" src="/sca/Public/js/modifypersonal.js"></script>

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