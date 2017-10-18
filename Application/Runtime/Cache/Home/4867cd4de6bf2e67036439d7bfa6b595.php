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
	<style type="text/css">
	html,body{
		margin: 0;
		padding: 0;
		background-color: #666666;
	}
	.a4-container{
		width: 875px;
		margin:  30px auto;
		background-color: #ffffff;
		min-height: 300px;
		color: #454545;
		padding: 30px;
	}
	.bottom-line{
		width: 100%;
		height: 1px;
		background-color: #e1e1e1;
		margin: 50px 0;
	}
	.report-content{
		margin-top: 10px;
	}
	.report-content .report-group .title h3{
		font-weight: bold;
		float: left;
		padding-bottom: 5px;
		border-bottom: 3px solid #e1e1e1;
	}
         .cridanger-1{
                background-color: #a8000b;

                color: #ffffff;
                     }
	.danger-1{
		background-color: #ff212f;
		color: #ffffff;
	}
	.warning-1{
		background-color: #FF9800;
		color: #ffffff;
	}
	.normal-1{
		background-color: #4fca81;
		color: #ffffff;
	}
	.table tr .count{
		background-color: #2196F3;
		color: #ffffff;
	}
	.report-detail{
		border: 1px solid #e1e1e1;
	}
	.report-detail .detail-header{

	}
	.report-detail .detail-header .header-title{
		padding: 0 10px;
	}
	.report-detail .detail-body .detail-part .part-title{

		background-color: #e1e1e1;
	}
	.report-detail .detail-body .detail-part .part-title h5{
		padding: 10px;
	    margin: 0px 20px;
	    float: left;
	    background-color: #ffffff;
	}
	.report-detail .detail-body .detail-part .part-content{

	}
	.report-detail .detail-body .detail-part .part-content .part-list{
		margin:0;
		padding: 0 10px 0 22px;
	}
	.report-detail .detail-body .detail-part .part-content .part-list li{
		padding: 5px 0;
		list-style: disc;
	}
	.title-badge{
		display: inline-block;
		margin: 0;
		padding: 10px;
	}
	</style>
</head>
<body>
    <div class="a4-container">
      
    	<h1 class="text-center" style="color:#147efb;"><?php echo ($info["name"]); ?></h1>
    	<h3 class="text-center">源代码检测报告</h3>
    	<p class="text-center"><?php echo ($info["subtime"]); ?></p>

    	<div class="bottom-line"></div>

		<p>检测工具：Fortify</p>

		<div class="report-content">
			<div class="report-group">
				<div class="title">
					<h3>摘要</h3>
					<div class="clearfix"></div>
					<p>本报告为开发人员提供源代码扫描细节和信息理解和解决源代码审计过程中发现的风险。本报告的读者主要是项目经理和开发人员。本节提供的分析过程中发现的问题进行了概述。</p>
				</div>
				<table class="table table-bordered" style="border:1px solid #e1e1e1;">
					<tbody>
						  <tr>
                                                                         <td>项目名</td>
                                                                         <td><?php echo ($info['name']); ?></td>
                                                                         <td>检测工具</td>
                                                                         <td>Fortify(16.10.0095 )</td>
                                                                 </tr>
                                                                 <tr>
                                                                         <td>软件版本</td>
                                                                         <td><?php echo ($info['version']); ?></td>
                                                                         <td>风险库版本</td>
                                                                         <td>16.10.0095</td>
                                                                 </tr>
                                                                  <tr>
                                                                         <td>编译环境</td>
                                                                         <td><?php echo ($info['env']); ?></td>
                                                                         <td>代码语言</td>
                                                                         <td><?php echo ($info['lang']); ?></td>
                                                                 </tr>
                                                                  <tr>
                                                                         <td>压缩包MD5</td>
                                                                         <td><?php echo ($info['md5']); ?></td>
                                                                         <td>预编译命令</td>
                                                                         <td><?php echo ($info['shell']); ?></td>
                                                                 </tr>
                                                                  <tr>
                                                                         <td>提交时间</td>
                                                                         <td><?php echo ($info['subtime']); ?></td>
                                                                         <td>测试用时</td>
                                                                         <td><?php echo ($info['spendtime']); ?></td>
                                                                 </tr>
                                                                 <tr>
                                                                         <td>风险种类个数</td>
                                                                         <td><?php echo ($leicount); ?></td>
                                                                         <td>中危风险个数</td>
                                                                         <td><?php echo ($midcount); ?></td>
                                                                 </tr>
                                                                 <tr>
                                                                         <td>总风险个数</td>
                                                                         <td><?php echo ($count); ?></td>
                                                                         <td>高危风险个数</td>
                                                                         <td><?php echo ($hcount); ?></td>
                                                                 </tr>
					</tbody>
				</table>
			</div>

			<div class="bottom-line"></div>

			<div class="report-group">
				<div class="title">
					<h3>问题汇总</h3>
					<div class="clearfix"></div>
				</div>

				<div class="chart-img">图表图片
                                 
                                  <!--<div style="align:center;padding-left: 65px;">   <img src='/sca/Uploads/example/one.png' hight="100px" width="660px" ></div>;-->
                                <div style='align:center;padding-left: 65px;'>   <img src='/sca/Uploads/example/two.png '   hight="100px" width="560px"></div>;
                                 <!--<div style='align:center;padding-left: 65px;'>      <img src='/sca/Uploads/example/three.png '  hight="100px" width="660px"></div>;-->
                                  <div style='align:center;'>      <img src='/sca/Uploads/example/f.png '  hight="100px" width="860px"></div>;
                              
                                </div>

				<table class="table table-bordered" border="1" width="100%" >
					<thead>
						<tr>
							<th>类别</th>
                                                        <th class="danger-1">严重数</th>
							<th class="danger-1">高危数</th>
							<th class="warning-1">中危数</th>
							<th class="normal-1">低危数</th>
							<th class="count">统计</th>
						</tr>
					</thead>
					<tbody>
                                            <?php if(is_array($datalist)): foreach($datalist as $key=>$vv): ?><tr>
							<td><?php echo ($vv["testtype"]); ?></td>
                                                        <td><?php echo ($vv["cricount"]); ?></td>
							<td><?php echo ($vv["hicount"]); ?></td>
							<td><?php echo ($vv["medcount"]); ?></td>
							<td><?php echo ($vv["lowcount"]); ?></td>
							<td><?php echo ($vv["count"]); ?></td>
						</tr><?php endforeach; endif; ?>	
					</tbody>
				</table>
			</div>

			<div class="bottom-line"></div>

			<div class="report-group">
				<h2 class="text-center">问题详情</h2>
                         <?php if(is_array($datalist)): foreach($datalist as $key=>$vvv): ?><h3>第<?php echo ($key+1); ?>类：<?php echo ($vvv["testtype"]); ?></h3>
				<div class="title">
					<h3>风险解释</h3>
					<div class="clearfix"></div>
					<p><?php echo ($vvv['datalist']['damage']); ?></p>
				</div>
                                <div class="title">
					<h3>修复建议</h3>
					<div class="clearfix"></div>
					<p><?php echo ($vvv['datalist']['suggest']); ?></p>
				</div>

				<div class="title">
					<h3>概要</h3>
					<div class="clearfix"></div>
				</div>
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>类别</th>
                                                            <th class="cridanger-1">严重数</th>
							<th class="danger-1">高危数</th>
							<th class="warning-1">中危数</th>
							<th class="normal-1">低危数</th>
							<th class="count">统计</th>
						</tr>
					</thead>
					<tbody>
						<tr>
                                                              <td><?php echo ($vvv["testtype"]); ?></td>
                                                               <td><?php echo ($vvv["cricount"]); ?></td>
                                                               <td><?php echo ($vvv["hicount"]); ?></td>
                                                               <td><?php echo ($vvv["medcount"]); ?></td>
                                                               <td><?php echo ($vvv["lowcount"]); ?></td>
                                                               <td><?php echo ($vvv["count"]); ?></td>
							
						</tr>
					</tbody>
				</table>

				<div class="title">
					<h3>详情</h3>
					<div class="clearfix"></div>
				</div>

				<div class="report-detail">
                                     <?php if(is_array($vvv["children"])): foreach($vvv["children"] as $key=>$vvv2): ?><div class="detail-header">
						<h4 class="header-title pull-left"><?php echo ($key); ?>：<?php echo ($vvv2["infos"]); ?></h4>
                                                <?php if($vvv2["zhresult"] == '严重' ): ?><h4 class="cridanger-1 pull-right title-badge">严重</h4>
                                                <?php elseif($vvv2["zhresult"] == '高危' ): ?><h4 class="danger-1 pull-right title-badge">高危</h4>
                                                 <?php elseif($vvv2["zhresult"] == '中危' ): ?><h4 class="warning-1 pull-right title-badge">中危</h4>
                                                  <?php elseif($vvv2["zhresult"] == '低危' ): ?><h4 class="normal-1 pull-right title-badge">低危</h4><?php endif; ?>
						
						<div class="clearfix"></div>
					</div>
					<div class="detail-body">
						
						<div class="detail-part">
							<div class="part-title">
								<h5>代码位置</h5>
								<div class="clearfix"></div>
							</div>
							<div class="part-content">
								<ul class="part-list">
									<li><?php echo ($vvv2["infoss"]); ?></li>
									
								</ul>
							</div>
						</div>
					</div><?php endforeach; endif; ?>
				</div><?php endforeach; endif; ?>
                                
                                
                              
                                
                          
                                
                                
                                
                                

			</div>
                        
                        
                        
                        
                        
                        
                        
                        
                        

		</div>

    </div>
</body>
</html>