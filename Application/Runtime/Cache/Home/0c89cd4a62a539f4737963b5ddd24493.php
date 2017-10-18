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
	.danger-1{
		background-color: #F44336;
		color: #ffffff;
	}
	.warning-1{
		background-color: #FF9800;
		color: #ffffff;
	}
	.normal-1{
		background-color: #FFC107;
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
    	<h1 class="text-center" style="color:#147efb;">舆情项目</h1>
    	<h3 class="text-center">源代码检测报告</h3>
    	<p class="text-center">2016年7月21日22:53:10</p>

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
							<td>舆情</td>
							<td>检测工具</td>
							<td>Fortify(16.10.0095 )</td>
						</tr>
						<tr>
							<td>工具版本</td>
							<td>1.2</td>
							<td>漏洞库版本</td>
							<td>16.10.0095</td>
						</tr>
						<tr>
							<td>高危问题数</td>
							<td>230</td>
							<td>时间</td>
							<td>2016年7月21日23:22:05</td>
						</tr>
						<tr>
							<td>文件数</td>
							<td>442</td>
							<td>代码行数</td>
							<td>54244</td>
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
                                 
                                  <div style="align:center;padding-left: 65px;">   <img src='/sca/Uploads/example/20160717one.png' hight="100px" width="660px" ></div>;
                                <div style='align:center;padding-left: 65px;'>   <img src='/sca/Uploads/example/20160717two.png '   hight="100px" width="560px"></div>;
                                 <div style='align:center;padding-left: 65px;'>      <img src='/sca/Uploads/example/20160717three.png '  hight="100px" width="660px"></div>;
                                  <div style='align:center;'>      <img src='/sca/Uploads/example/20160717f.png '  hight="100px" width="860px"></div>;
                              
                                </div>

				<table class="table table-bordered" border="1" width="100%" >
					<thead>
						<tr>
							<th>类别</th>
							<th class="danger-1">高危数</th>
							<th class="warning-1">中危数</th>
							<th class="normal-1">低危数</th>
							<th class="count">统计</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>J2EE Bad Practices</td>
							<td>1</td>
							<td>23</td>
							<td>0</td>
							<td>24</td>
						</tr>
						<tr>
							<td>SQL Injection : Hibernate</td>
							<td>1</td>
							<td>23</td>
							<td>0</td>
							<td>24</td>
						</tr>
						<tr>
							<td>J2EE Bad Practices : Threads</td>
							<td>1</td>
							<td>23</td>
							<td>0</td>
							<td>24</td>
						</tr>
						<tr>
							<td>Unreleased Resource : Streams</td>
							<td>1</td>
							<td>23</td>
							<td>0</td>
							<td>24</td>
						</tr>
						<tr>
							<td>Unreleased Resource : Streams</td>
							<td>1</td>
							<td>23</td>
							<td>0</td>
							<td>24</td>
						</tr>
					</tbody>
				</table>
			</div>

			<div class="bottom-line"></div>

			<div class="report-group">
				<h2 class="text-center">问题详情</h2>

				<h3>第1类：J2EE Bad Practices（24个问题）</h3>
				<div class="title">
					<h3>问题解释</h3>
					<div class="clearfix"></div>
					<p>Cross-Site Scripting (XSS) 漏洞在以下情况下发生： 1. 数据通过一个不可信赖的数据源进入 Web 应用程序。对于基于 DOM 的 XSS，将从 URL 参数或浏览器中 的其他值读取数据，并使用客户端代码将其重新写入该页面。对于 Reflected XSS，不可信赖的源通常为 Web 请求，而对于 Persisted（也称为 Stored）XSS，该源通常为数据库或其。</p>
				</div>

				<div class="title">
					<h3>概要</h3>
					<div class="clearfix"></div>
				</div>
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>类别</th>
							<th class="danger-1">高危数</th>
							<th class="warning-1">中危数</th>
							<th class="normal-1">低危数</th>
							<th class="count">统计</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>J2EE Bad Practices</td>
							<td>1</td>
							<td>23</td>
							<td>0</td>
							<td>24</td>
						</tr>
					</tbody>
				</table>

				<div class="title">
					<h3>详情</h3>
					<div class="clearfix"></div>
				</div>

				<div class="report-detail">
					<div class="detail-header">
						<h4 class="header-title pull-left">1：src/action/timer/Baidu.java(274)（J2EE Bad Practices）</h4>
						<h4 class="danger-1 pull-right title-badge">高危</h4>
						<div class="clearfix"></div>
					</div>
					<div class="detail-body">
						<div class="detail-part">
							<div class="part-title">
								<h5>问题描述</h5>
								<div class="clearfix"></div>
							</div>
							<div class="part-content">
								<ul class="part-list">
									<li>44 Automatically calculates the editor base path based on the _samples  directory.</li>
									<li>45 This is usefull only for these samples. A real application should use  something like this:</li>
									<li>46 dim oRegex</li>
								</ul>
							</div>
						</div>
						<div class="detail-part">
							<div class="part-title">
								<h5>代码位置</h5>
								<div class="clearfix"></div>
							</div>
							<div class="part-content">
								<ul class="part-list">
									<li>44 Automatically calculates the editor base path based on the _samples  directory.</li>
									<li>45 This is usefull only for these samples. A real application should use  something like this:</li>
									<li>46 dim oRegex</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
                                
                                
                                
                                
                                <h3>第2类：SQL Injection : Hibernate（5个问题）</h3>
				<div class="title">
					<h3>问题解释</h3>
					<div class="clearfix"></div>
					<p>Cross-Site Scripting (XSS) 漏洞在以下情况下发生： 1. 数据通过一个不可信赖的数据源进入 Web 应用程序。对于基于 DOM 的 XSS，将从 URL 参数或浏览器中 的其他值读取数据，并使用客户端代码将其重新写入该页面。对于 Reflected XSS，不可信赖的源通常为 Web 请求，而对于 Persisted（也称为 Stored）XSS，该源通常为数据库或其。</p>
				</div>

				<div class="title">
					<h3>概要</h3>
					<div class="clearfix"></div>
				</div>
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>类别</th>
							<th class="danger-1">高危数</th>
							<th class="warning-1">中危数</th>
							<th class="normal-1">低危数</th>
							<th class="count">统计</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>J2EE Bad Practices</td>
							<td>1</td>
							<td>23</td>
							<td>0</td>
							<td>24</td>
						</tr>
					</tbody>
				</table>

				<div class="title">
					<h3>详情</h3>
					<div class="clearfix"></div>
				</div>

				<div class="report-detail">
					<div class="detail-header">
						<h4 class="header-title pull-left">1：src/action/timer/Baidu.java(274)（J2EE Bad Practices）</h4>
						<h4 class="danger-1 pull-right title-badge">高危</h4>
						<div class="clearfix"></div>
					</div>
					<div class="detail-body">
						<div class="detail-part">
							<div class="part-title">
								<h5>问题描述</h5>
								<div class="clearfix"></div>
							</div>
							<div class="part-content">
								<ul class="part-list">
									<li>44 Automatically calculates the editor base path based on the _samples  directory.</li>
									<li>45 This is usefull only for these samples. A real application should use  something like this:</li>
									<li>46 dim oRegex</li>
								</ul>
							</div>
						</div>
						<div class="detail-part">
							<div class="part-title">
								<h5>代码位置</h5>
								<div class="clearfix"></div>
							</div>
							<div class="part-content">
								<ul class="part-list">
									<li>44 Automatically calculates the editor base path based on the _samples  directory.</li>
									<li>45 This is usefull only for these samples. A real application should use  something like this:</li>
									<li>46 dim oRegex</li>
								</ul>
							</div>
						</div>
					</div>
                                </div>
                                
                                
                          
                                
                                
                                
                                

			</div>
                        
                        
                        
                        
                        
                        
                        
                        
                        

		</div>

    </div>
</body>
</html>