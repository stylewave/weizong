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
<div class="layout ws10 mac content afcf dttcenBox dttdtlBox">
    <div class="mt30 bc2box br10 ofh">
        <div class="ws4 fl">
            <div class="item p30">
                <table width="100%" cellspacing="0" cellpadding="0">
                    <tr>


                    <td>项目名称：<?php echo ($info["name"]); ?></td>
                    <!--<td align="right" class="score fw2"><?php echo (ranking($info["secscore"])); ?></td>-->
                    <td valign="bottom" class="fs16"><span class="db pl5 pb5"></span></td>
                    </tr>
                </table>
        <div class="mt30 fs28 fw2"><?php echo ($info["realname"]); ?></div>
        <div class="mt30 nwp" >
          
        	<table class="table">
        		<tr>
        			<td>软件版本</td>
        			<td><?php echo ($info["version"]); ?></td>
        		</tr>
        		<tr>
        			<td>编译环境</td>
        			<td><?php echo ($info["env"]); ?></td>
        		</tr>
        		<tr>
        			<td>压缩包MD5</td>
        			<td><?php echo ($info["md5"]); ?></td>
        		</tr>
        		<tr>
        			<td>代码语言</td>
        			<td><?php echo ($info["lang"]); ?></td>
        		</tr>
                        <tr>
        			<td>项目大小</td>
        			<td><?php echo ($info["size"]); ?></td>
        		</tr>
                         <tr>
                                <td>风险总类</td>
                                <td><?php echo (count($listcount)); ?></td>
                        </tr>
        		
                         <tr>
                                            <td>总风险数</td>
		        			<td><?php echo ($loophole["count"]); ?></td>
		        		</tr>
                                        <tr>
		        			<td>严重风险数</td>
		        			<td><?php echo ($loophole["cricount"]); ?></td>
		        		</tr>
		        		<tr>
		        			<td>高危风险数</td>
		        			<td><?php echo ($loophole["highcount"]); ?></td>
		        		</tr>
		        		<tr>
		        			<td>中危风险数</td>
		        			<td><?php echo ($loophole["midcount"]); ?></td>
		        		</tr>
                                        <tr>
		        			<td>低危风险数</td>
		        			<td><?php echo ($loophole["lowcount"]); ?></td>
		        		</tr>
                                        <tr>
        			<td>提交时间</td>
        			<td><?php echo ($info["subtime"]); ?></td>
        		</tr>
        	</table>
        
<!--              <font class="fs16">软件版本:<?php echo ($info["version"]); ?><font><br/>
              <font class="fs16">编译环境:<?php echo ($info["env"]); ?></font><br/>
              <font class="fs16">压缩包MD5:<?php echo ($info["md5"]); ?></font><br/>
              <font class="fs16">代码语言:<?php echo ($info["lang"]); ?></font><br/>
              <font class="fs16">提交时间:<?php echo ($info["subtime"]); ?></font>-->
  </div>
        <div class="mt40 ofh" style="margin-top:20px;">
        <a class="fl bc3box p10 fs14 ws4 tac db br3" href="<?php echo U('Detection/center_detection');?>">返回</a>
        <?php if($_SESSION['power']['userpayid'] >= 2 OR $_SESSION['power'] == 'all'): ?><a class="fr bc3box p10 fs14 ws4 tac db br3" href="<?php echo U('Report/basedetial_report',array('appid'=>$info['appid']));?>" >检测详情</a>
        <?php else: ?>
            <a class="fr bc3box p10 fs14 ws4 tac db br3" onclick="regTipTestDetial()" />检测详情</a><?php endif; ?>


         
<!--        <div class="mt40 ofh" style="margin-top:50%;">
        <a class="fl bc3box p10 fs14 ws4 tac db br3" href="<?php echo U('Detection/center_detection');?>">返回</a>
        <?php if($_SESSION['power']['userpayid'] >= 2 OR $_SESSION['power'] == 'all'): ?><a class="fr bc3box p10 fs14 ws4 tac db br3" href="<?php echo U('Report/basedetial_report',array('appid'=>$info['appid']));?>" >检测详情</a>
        <?php else: ?>
            <a class="fr bc3box p10 fs14 ws4 tac db br3" onclick="regTipTestDetial()" />检测详情</a><?php endif; ?>-->
        </div>
      </div>
    </div>
    <div class="ws8 fr pt30 pb30 charts">
      <div class="ml40 pl40 pr30 bdl9 show" style="overflow: hidden;">
     
        <div class="fl wp50" id="scorepic" style="height:350px;">
           sss

        </div>
        <div class="fl wp50" id="locate" style="height:350px;">
           ss

        </div>
        <div class="fl wp100" id="locatebar" style="height:400px;">
           ss
        </div>

    </div>
  </div>
</div>
<!--<?php echo (var_export($info['appid'])); ?>-->
<script src="/Public/js/echarts.min.js"></script>
<script src="/Public/js/loaddata.js"></script>
<script type="text/javascript">
  $.getJSON("<?php echo U('Report/appstatistics',array('appid'=>$info['appid']));?>",function(data){
   option1.series[0].data[0].value=data.score;
   myChart1.setOption(option4);
  //console.log(data);
 //console.log(data.bar.xaxis);
   for(var i=0;i<data.pie.length;i++){
     option2.series[0].data[i].value=data.pie[i];
   }
   
   locate.setOption(option2);   
  
  for(var y=0;y<data.round.length;y++){
     option4.series[0].data[y] = data.round[y];
    // option4.legend[0].data[y] = data.round[y].name[y];
   }
   for(var x=0;x<data.round.length;x++){
    // option4.series[0].data[y] = data.round[y];
    option4.legend.data[x] = data.round[x].name;
   }
   option4.series[0].name= "风险种类";
   console.log(option4,"123");
   scorepic.setOption(option4);
//    option4.legend[0].data=data.round.name;
//    option4.series[0].data[0].value=data.round;
    
//    scorepic.setOption(option4);
  // console.log(data.bar.xaxis);
    option5.xAxis[0].data=data.bar.xaxis;
   option5.series[0].data=data.bar.cri;
   option5.series[1].data=data.bar.height;
   option5.series[2].data=data.bar.mid;
   option5.series[3].data=data.bar.low;
 
    locatebar.setOption(option5);
  
    
}); 
   
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