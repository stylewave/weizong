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
<link rel="stylesheet" type="text/css" href="/Public/css/syntaxy.light.min.css"/>
<div class="layout ws10 mac content afcf dttcenBox dttdtlBox">
    <div class="mt30 bc2box br10 ofh">
        <div class="ws4 fl">
            <div class="item p30">
                <table width="100%" cellspacing="0" cellpadding="0">
                    <tr>

                        <!--                    <?php if(substr($info['icon'],0,4) != 'http'): ?><td><img src="/<?php echo ($info["icon"]); ?>" width="80" /></td>
                                                <?php else: ?>
                                                <td><img src="<?php echo ($info["icon"]); ?>" width="80" /></td><?php endif; ?>-->

                        <td>项目名称：<?php echo ($info["name"]); ?></td>
                        <!--<td align="right" class="score fw2"><?php echo (ranking($info["secscore"])); ?></td>-->
                        <td valign="bottom" class="fs16"><span class="db pl5 pb5"></span></td>
                    </tr>
                </table>
                <div class="mt30 fs28 fw2"><?php echo ($info["realname"]); ?></div>

                <div class="mt30 nwp">
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
                            <td><?php echo (count($listview)); ?></td>
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
                </div>

                <div class="mt40 ofh">
                    <a class="fl bc3box p10 fs14 ws4 tac db br3" href="<?php echo U('Report/base_report',array('appid'=>$info['appid']));?>">返回</a>
                    <?php if($_SESSION['power']['userpayid'] >= '2' OR $_SESSION['power'] == 'all'): ?><!--                        <a class="fr bc3box p10 fs14 ws4 tac db br3"  onclick="report('<?php echo ($info["appid"]); ?>')" >下载报告</a>-->
                        <a class="fr bc3box p10 fs14 ws4 tac db br3" url=" <?php echo U('Word/makePdfReportsss',array('appid'=>$info['appid']));?> " onclick='tipDownPdf($(this).attr("url"));'>下载报告</a><?php endif; ?>
                </div>

                <div class="mt40 ofh tac">
                    <div class="mt40 ofh">
                        <!--<?php if($multiVersion == 'false'): ?>-->
                        <?php if($_SESSION['power']['userpayid'] >= '1' OR $_SESSION['power'] == 'all'): ?><a class="fr bc3box p10 fs14 ws4 tac db br3" style="margin-right: 30%;" url="<?php echo U('Report/downtech_report',array('appid'=>$info['appid']));?>"  
                               <?php if($_SESSION['power']['userpayid'] == '3' OR $_SESSION['power'] == 'all'): ?>onclick="tipDownPdf($(this).attr('url'));" 
                                    <?php else: ?>
                                    onclick="regTipTestDetial();"<?php endif; ?>
                                />下载技术报告</a><?php endif; ?>  
                        <!--<?php else: ?>-->
                        <!--<a class="fr bc3box p10 fs14 ws4 tac db br3" url="<?php echo U('Report/downtech_report',array('appid'=>$info['appid']));?>"  
                           <?php if($_SESSION['power'] == 'all' OR $_SESSION['power']['userpayid'] >= '3'): ?>onclick="techPdfTip($(this).attr('url'));"
                                <?php else: ?>
                                onclick="regTipTestDetial();"<?php endif; ?>
                            />下载技术报告
                        </a>
                        <a class="fl bc3box p10 fs14 ws4"  href="<?php echo U('Report/compare_report',array('appid'=>$info['appid']));?>">历史版本比较</a>
                        <?php endif;?> -->
                    </div>       
                    <!--<div class="ml40 pl40 bdl0 show" style="margin-top: 30%;">
                        <ul style="width:115%;position:relative;left:-13%;">
                            <li class="" style="float:left;"><span>威胁等级:</span></li>
                            <li class="anqun" style="float:left;"><span class="fclowrisk">通过</span>
                            <li class="diwei" style="float:left;"><span class="fcmidrisk">低危</span>
                            <li class="zhongwei" style="float:left;"><span class="fczhongwei">中危</span>
                            <li class="gaowei" style="float:left;"><span class="fchighrisk">高危</span>
                        </ul>
                      </div>-->
                </div>

            </div>
        </div>
        <div class="ws8 fr pt30 pb30">
            <div class="ml40 pl40 pr30 bdl9 show" style="overflow: hidden;">

                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                    <?php if(is_array($listview)): foreach($listview as $keylists=>$ss): ?><div class="panel panel-default" >
                            <div class="panel-heading" role="tab" id="headingOne">
                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne<?php echo ($ss['id']); ?>" aria-expanded="true" aria-controls="collapseOne">
                                    <h4 class="panel-title">
                                        <?php echo ($keylists+1); ?>、 <?php echo ($ss["testtype"]); ?>&nbsp;
                                        <span style="color:#000;">总(<?php echo ($ss["count"]); ?>) </span> 
                                        <?php if($ss["cricount"] != 0): ?>|<span style="color:#a8000b;"> 严重(<?php echo ($ss["cricount"]); ?>)</span><?php endif; ?>  
                                        <?php if($ss["hicount"] != 0): ?>| <span style="color:#ff212f;"> 高危(<?php echo ($ss["hicount"]); ?>)</span><?php endif; ?>  
                                        <?php if($ss["medcount"] != 0): ?>|  <span style="color:#FF9800;">中危(<?php echo ($ss["medcount"]); ?>)</span><?php endif; ?>  
                                        <?php if($ss["lowcount"] != 0): ?>| <span style="color:#56ea23;">低危(<?php echo ($ss["lowcount"]); ?>)</span><?php endif; ?>
                                        <span style="color:red;"> </span>
                                       
                                    </h4>
                                </a>
                            </div>
                            <div id="collapseOne<?php echo ($ss['id']); ?>" class="panel-collapse collapse <?php if($keylists == 0): ?>in<?php endif; ?>" role="tabpanel" aria-labelledby="headingOne">

                                <ul class="list-group">


                                    <?php if(is_array($ss['children'])): $keylist = 0; $__LIST__ = $ss['children'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$tt): $mod = ($keylist % 2 );++$keylist;?><li class="list-group-item">

                                            <span  <?php if($tt["zhresult"] == '严重'): ?>class="cridanger-level"
                                                    <?php elseif($tt["zhresult"] == '高危'): ?> class="danger-level"
                                                    <?php elseif($tt["zhresult"] == '低危'): ?> class="nomal-level" <?php elseif($tt["zhresult"] == '中危'): ?> class="warning-level"<?php else: ?> class="pass-level"<?php endif; ?>
                                                ><?php echo ($keylist); ?>: <?php echo (mb_substr($tt["infos"],0,100)); ?>...<?php echo ($tt["zhresult"]); ?>
                                            </span> 
                                           
                                            <span class="pull-right"><a class="check" onclick= "checkModal('<?php echo ($tt["id"]); ?>', '<?php echo ($tt["zhresult"]); ?>', '<?php echo ($tt["testtype"]); ?>')" href="#" >查看</a>
                                                <a class="edit" onclick="editModal('<?php echo ($tt["id"]); ?>', '<?php echo ($tt["result"]); ?>', '<?php echo ($tt["testtype"]); ?>')" href="#">修改</a><a href="#" class="danger" onclick="deleteModel('<?php echo ($tt["id"]); ?>', '<?php echo ($tt["appid"]); ?>')">删除</a></span></li><?php endforeach; endif; else: echo "" ;endif; ?>	
                                </ul>

                            </div>

                        </div><?php endforeach; endif; ?>


                </div>
            </div>

            <?php if(is_array($detectInfo)): $k = 0; $__LIST__ = $detectInfo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v0): $mod = ($k % 2 );++$k; if($v0['testtype'] != null): ?><div class="fs24"><?php echo ($v0['zhtesttype']); ?></div><?php endif; ?>
                <?php if(($v0['showdiv'] == 1) AND ($v0['first'] == 1)): ?><div class="mt15 ofh"><?php endif; ?>

                <ul>
                    <?php if($v0["result"] == 1): ?><li class="anqun"><span class="fclowrisk"><?php echo ($v0["resultname"]); ?></span><span class="fclowrisk"><?php echo ($v0["zhtestname"]); endif; ?>
                    <?php if($v0["result"] == 2): ?><li class="diwei"><span class="fcmidrisk"><?php echo ($v0["resultname"]); ?></span><span class="fcmidrisk"><?php echo ($v0["zhtestname"]); endif; ?>
                    <?php if($v0["result"] == 3): ?><li class="zhongwei"><span class="fczhongwei"><?php echo ($v0["resultname"]); ?></span><span class="fczhongwei"><?php echo ($v0["zhtestname"]); endif; ?>
                    <?php if($v0["result"] == 4): ?><li class="gaowei"><span class="fchighrisk"><?php echo ($v0["resultname"]); ?></span><span class="fchighrisk"><?php echo ($v0["zhtestname"]); endif; ?>
                    <?php if($v0['appid'] != null): ?><span class="highline" style="float:right;margin-right: 30px;" onclick="feedback('<?php echo ($v0["zhtestname"]); ?> <?php echo ($v0["resultname"]); ?>', '<?php echo ($v0["result"]); ?>', '<?php echo ($info["appid"]); ?>', '<?php echo ($v0["testname"]); ?>')">反馈</span><?php endif; ?>
                    </li>
                </ul>
                <?php if(($v0['showdiv'] == 1) AND ($v0['end'] == 1)): ?></div> 
                    <hr /><?php endif; endforeach; endif; else: echo "" ;endif; ?>


        </div>
    </div>
</div>

<!-- $(".dttcenAddDownpDFtip").show(); -->
<!-- 下载pdf提示 -->
<div class="dttcenAddDownpDFtip bc2box" id="errmess">
    <div class="ws6 mac bcf br10" >
        <div  class="title pl20 pr20 pt15 pb10 fs22 fc3"><span class="cp close">×</span>提示</div>
        <div class="button pl20 pr20 pt15 pb40 fs22 errmess" style="color: red;text-align: center;"></div>
        <div style="text-align: center;" id="btntipaction" style="display:block;">
            <div id='sure-err' >
                <a hre="" class="bdn fcf bc3box pt8 pb8 pl30 pr30 fs14 tac br5" >确定</a>
            </div><br/>
        </div>
    </div>
</div>
</div>






<!-- 检测项意见表 -->
<div class="dttcenAddDownpDFtip bc2box" id="errmess1">
    <div class="ws6 mac br10 row">
        <div class="title col-xs-12 fs22 fc3 model-header">
            <span class="cp close">×</span>
            <h3>意见反馈</h3>
        </div>
        <form action="<?php echo U('Report/feedback');?>" method="POST">
            <div class="fc3 model-body col-xs-12">
                <div class="row">
                    <div class="col-sm-3">
                        <p>修改项:</p> 
                    </div>
                    <div class="col-sm-9">
                        <p id="oldinfo"></p>
                        <input type="hidden" name="oldresult">
                        <input type="hidden" name="appid">
                        <input type="hidden" name="testname">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <p>修改为:</p>
                    </div>
                    <div class="col-sm-9">
                        <select id="selectnewresult" name="newresult" class="pl10 bcn oh">
                            <?php if(is_array($resultlist)): $i = 0; $__LIST__ = $resultlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vr): $mod = ($i % 2 );++$i;?><option class="pl10 bcn oh" value="<?php echo ($vr["id"]); ?>" ><?php echo ($vr["resultname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <p>修改理由:</p>
                    </div>
                    <div class="col-sm-9">
                        <textarea name='reason' class="ws10" style="height:20%;margin-top: 10px;"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <input  class="btn btn-primary center-block" type="submit" value="提交"/>
                    </div>
                    <div class="col-sm-6">
                        <input type="button" class="btn btn-success center-block"  value="取消" onclick="$('.dttcenAddDownpDFtip').hide();">
                    </div>

                </div>
        </form>
    </div>
</div>
</div>

<div class="modal fade" id="checkmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">查看详情</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-2">
                        <p class="title-text text-right">风险类别:</p> 
                    </div>
                    <div class="col-sm-10">
                        <!--                         <input type="text" name="testtypes"  />-->
                        <!--                        <p id="oldinfo" id="testtype">应用权限管理安全 通过</p>-->
                        <p class="title-text" id="testtype" name='testtype'></p>
                        <input type="hidden" name="oldresult" value="1">

                        <input type="hidden" name="appid" value="1205">
                        <input type="hidden" name="testname" value="10">
                    </div>
                </div>
                   <div class="row">
                    <div class="col-sm-2">
                        <p class="title-text text-right">中文名:</p>
                    </div>
                    <div class="col-sm-10">
                         <p class="title-text" id="testname2" name='testname2'></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2">
                        <p class="title-text text-right">检测结果:</p>
                    </div>
                    <div class="col-sm-10">
                        <input class="input" style="text-align: center;" type="text" name="reuseltss" /><?php if(value == hight ): ?>高<?php endif; ?>
                    </div>
                </div>
                 <div class="row">
                        <div class="col-sm-2">
                            <p class="title-text text-right">风险危害:</p>
                        </div>
                        <div class="col-sm-10">
                            <p class="title-text" id="dangerdata2" name='dangerdata2'>
                               test
                               </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2">
                            <p class="title-text text-right" >修复建议:</p>
                        </div>
                        <div class="col-sm-10">
                            <p class="title-text" id="suggestdata2" name="suggestdata2">test
                               </p>
                        </div>
                    </div>

                <div class="row">
                    <!--<div class="col-sm-3">
                        <p>详细信息:</p>
                    </div>-->
                    <div class="col-xs-12" style="margin-top: 10px;">
                        <pre style="min-height: 100px;" id="codebox" data-type="default" class="bg-light shadow-big"></pre>    
                        <!--                        <textarea name="reason" class="ws10 rea" id="rea" style="width: 100%;height:40%;margin-top: 10px;"></textarea>
                        -->                 </div>
                </div>

            </div>

            <!--            <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-3">
                                    <p>修改项:</p> 
                                </div>
                                <div class="col-sm-9">
                                    <p id="oldinfo">应用权限管理安全 通过</p>
                                    <input type="hidden" name="oldresult" value="1">
                                    
                                    <input type="hidden" name="appid" value="1205">
                                    <input type="hidden" name="testname" value="10">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p>修改为:</p>
                                </div>
                                <div class="col-sm-9">
                                    <select id="selectnewresult" name="newresult" class="pl10 bcn oh">
                                        <option class="pl10 bcn oh" value="1">通过</option><option class="pl10 bcn oh" value="2">低危</option><option class="pl10 bcn oh" value="3">中危</option><option class="pl10 bcn oh" value="4">高危</option>			              </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p>修改理由:</p>
                                </div>
                                <div class="col-sm-9">
                                    <textarea name="reason" class="ws10" style="height:20%;margin-top: 10px;"></textarea>
                                </div>
                            </div>
                        </div>-->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="editmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <form action="/index.php/Home/Report/save" method='post'>

            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">修改检测结果</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-2">
                            <p class="title-text text-right">风险类别:</p> 
                        </div>
                        <div class="col-sm-10">
                            <p class="title-text" id="oldinfos" name='testtype'></p>
                            <input type="hidden" name="oldresult">
                            <input type="hidden" name="id" >
                            <!--                        <input type="hidden" name="testname" >-->
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-2">
                            <p class="title-text text-right">中文名:</p>
                        </div>
                        <div class="col-sm-10">
                           <p class="title-text" id="testname" name='testname'></p>
                        </div>
                 </div>
                    <div class="row">
                        <div class="col-sm-2">
                            <p class="title-text text-right">检测结果:</p>
                        </div>
                        <div class="col-sm-10">
                            <select id="selectnewresult2" name="newresult" class="pl10 bcn oh">
                                <?php if(is_array($resultlist)): $i = 0; $__LIST__ = $resultlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vr): $mod = ($i % 2 );++$i;?><option class="pl10 bcn oh" value="<?php echo ($vr["result"]); ?>" ><?php echo ($vr["zhresult"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                <!--                            <option class="pl10 bcn oh" value="1">通过</option><option class="pl10 bcn oh" value="2">低危</option><option class="pl10 bcn oh" value="3">中危</option><option class="pl10 bcn oh" value="4">高危</option>-->			
                            </select>
                        </div>
                    </div>
                   
                    <div class="row">
                        <div class="col-sm-2">
                            <p class="title-text text-right">风险危害:</p>
                        </div>
                        <div class="col-sm-10">
                            <p class="title-text" id="dangerdata" name='dangerdata'>
                                test
                               </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2">
                            <p class="title-text text-right" >修复建议:</p>
                        </div>
                        <div class="col-sm-10">
                            <p class="title-text" id="suggestdata" name="suggestdata">test
                               </p>
                        </div>
                    </div>

                    <div class="row" style="margin-top: 10px;">
                        <div class="col-xs-12">
                            <pre style="min-height: 100px;" id="codebox2" data-type="default" class="bg-light shadow-big"></pre>
                            <!--<textarea name="reason" class="rea2" style="height:40%;margin-top: 10px;width: 100%;"></textarea>-->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <input class="btn btn-primary " id="sent" type="button" value="提交">
                </div>

            </div><!-- /.modal-content --></form>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!--下载报表-->
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
</div>    

<!--修改页面-->
<div class="modal fade" id="save" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <form action="" method='post'>
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">&nbsp;</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-9">
                            <input type="hidden" name="id" >
                            <input type="hidden" name="appid" >
                            <p style="font-size:32px;">提交成功,正在修改....</p> 
                        </div>

                    </div>

                </div></form>
    </div>
</div>
</div>

<!--修改页面失败-->
<div class="modal fade" id="savefail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <form action="" method='post'>
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">&nbsp;</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-9">
                            <input type="hidden" name="id" >
                            <input type="hidden" name="appid" >
                            <p style="font-size:32px;">提交修改失败</p> 
                        </div>

                    </div>

                </div></form>
    </div>
</div>
</div>




<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <form action="/index.php/Home/Report/delete" method='post'>
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">删除</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-9">
                            <input type="hidden" name="id" >
                            <input type="hidden" name="appid" >
                            <p style="font-size:32px;">真的要删除这条数据吗？</p> 
                        </div>

                    </div>



                    <div class="modal-footer">
                        <input class="btn btn-primary" type="submit" value="确定">
                        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>

                    </div>

                </div></form>
    </div>
</div>
<script src="/Public/js/syntaxy.min.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
                            var options = {
                                codeTitle: "详细信息",
                                minHeight: "100px",
                                wordWrap: true
                            };
                            function checkModal(id, reuselt, testtype) {
                                // alert(reuselt);

                                $('#checkmodal').fadeIn();
                                //$('.rea').text(info);
                                $('#testtype').html(testtype);
                                // $('input[name=testtypes]').val(testtype);
                                $('input[name=reuseltss]').val(reuselt);

                                var url = "<?php echo U('Report/info');?>";
                                $.post(url, {id: id}, function (data) {
                                      $('#dangerdata2').html(data['damage']);
                                   // console.log(data); 
                                    $('#testname2').html(data['zhtesttype']);
                                    $('#suggestdata2').html(data['suggest']);
                                    $('#codebox').text(data['info']);
                                    $('#codebox').syntaxy(options);
                                });
                               
                                $("#checkmodal").modal('show');
                            }
                            // $(".check").on("click", checkModal);
                            //修改
                            function editModal(id, reuselt, testtype) {
                               // alert(id);
                                // alert(id+info+','+reuselt+','+testtype);
                                $('#editmodal').fadeIn();
                                $('#oldinfos').html(testtype);
                                //$('.rea2').text(info);
                                var url = "<?php echo U('Report/info');?>";
                                $.post(url, {id: id}, function (data) {
                                     $('#dangerdata').html(data['damage']);
                                   // console.log(data); 
                                    $('#testname').html(data['zhtesttype']);
                                
                                    $('#suggestdata').html(data['suggest']);
                                    $('#codebox2').text(data['info']);
                                    $('#codebox2').syntaxy(options);
                                });

                                // $( '#codebox2' ).text(info);

                                var sel = document.getElementById('selectnewresult2');

                                for (var i = 0; i < sel.options.length; i++) {
                                    if (reuselt == sel.options[i].value) {
                                        sel.options[i].selected = true;
                                        console.log(sel.options[i].value);
                                    }
                                }
                                $('input[name=oldresult]').val(reuselt);
                                $('input[name=id]').val(id);
                                $("#editmodal").modal('show');
                            }
                            //  $(".edit").on("click", editModal);

                            function deleteModel(id, appid) {
                                $('input[name=id]').val(id);
                                $('input[name=appid]').val(appid);
                                $("#delete").modal('show');
                            }

                            function report(appid) {
                                //alert(appid);
                                $('input[name=appid]').val(appid);
                                $("#report").modal('show');
                            }

</script>
<script>
    $(function () {

        $("#sent").click(function () {
            var url = "<?php echo U('Report/save');?>";
            //  alert(url);
            // console.log(url);

            var params = {
                oldresult: $('input[name=oldresult]').val(),
                id: $('input[name=id]').val(),
                newresult: $('#selectnewresult2').val(),
            };
            console.log(params);
            $.post(url, params, function (data) {
                console.log(data);
                if (data == 'SUCCESS') {
                    $("#save").modal('show');
                    $("#editmodal").modal('hide');

                    setTimeout(function () {
                        history.go(0);
                    }, 3000)


                } else {
                    $("#savefail").modal('show');
                    $("#editmodal").modal('hide');
                    //  alert('修改失败');

                    setTimeout(function () {
                        history.go(0);
                    }, 2000)
                }
            })
        });
    });
</script>
<script type="text/javascript" src="/Public/js/basedetial_report.js"></script>

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