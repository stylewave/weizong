<?php

namespace Home\Controller;

use Home\Model\Wordmaker;
use Think\Controller;

class WordController extends CommonController {

    //截取字符串
    function cut_str($string, $sublen, $start = 0, $code = 'UTF-8') {
        if ($code == 'UTF-8') {
            $pa = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/";
            preg_match_all($pa, $string, $t_string);

            if (count($t_string[0]) - $start > $sublen)
                return join('', array_slice($t_string[0], $start, $sublen)) . "...";
            return join('', array_slice($t_string[0], $start, $sublen));
        }
        else {
            $start = $start * 2;
            $sublen = $sublen * 2;
            $strlen = strlen($string);
            $tmpstr = '';

            for ($i = 0; $i < $strlen; $i++) {
                if ($i >= $start && $i < ($start + $sublen)) {
                    if (ord(substr($string, $i, 1)) > 129) {
                        $tmpstr.= substr($string, $i, 2);
                    } else {
                        $tmpstr.= substr($string, $i, 1);
                    }
                }
                if (ord(substr($string, $i, 1)) > 129)
                    $i++;
            }
            if (strlen($tmpstr) < $strlen)
                $tmpstr.= "...";
            return $tmpstr;
        }
    }
    
     public function repdfs() {
         $appid = I('get.appid');
         $this->two($appid);
         $this->three($appid);
         $this->four($appid);
     //   dump($appid);die;
        Vendor('mpdf60.mpdf');
        //设置中文编码
        $mpdf = new \mPDF('zh-CN', 'A4', 0, '宋体');
        $mpdf->useAdobeCJK = true; //打开这个选项比较好
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->SetWatermarkText($marktext);
        $mpdf->showWatermarkText = true;
        $html = '
                 <html xmlns="http://www.w3.org/1999/xhtml">
                 <head>
                 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
              


                 <title>微众源代码安全检测系统</title>
                         <style type="text/css">
                         html,body{
                                 margin: 0;
                                 padding: 0;
                                
                         }
                         .a5-container{
                                 width: 875px;
                                 margin:  30px auto;
                                 background-color: #ffffff;
                                 height: auto;
                                 color: #454545;
                                 padding: 30px;
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
                         h4{
                         height:50px;
                         
                         }
                         span{
                       
                          font-size:24px;
                         }
                        #titl{
                            background-color: #5CACEE;
                            color: #ffffff;
                            padding:0px;
                            margin:0px;
                            height:50px;
                            
                            line-height:50px;
                         }
                         .table tr .count{
                                 background-color: #2196F3;
                                 color: #ffffff;
                         }
                         .report-detail{
                                 border: 0px solid #e1e1e1;
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
                        .tr{
                               padding:10px 0; 
                        }
                        .table{
                           
                            width: 100%;
                            max-width: 100%;
                            margin-bottom: 20px;
                            border: 1px solid #ddd;
                        }
                        .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
                            padding: 8px;
                            line-height: 1.42857143;
                            vertical-align: top;
                            border-top: 1px solid #ddd;
                            word-break: break-all;
                        }
                        table{
                         
                            border-spacing: 0;
                            border-collapse: collapse;
                        }
                        .clearfix{
                            display:block;
                            clear:both;
                        }
                         
                 </style>
                 </head>
                 <body>';
       // $appid = 1139;
         $risk = array(array('eq','critical'),array('eq','high'), 'or') ;
//        if($risk=='all'){
//            $risk = array(array('eq','critical'),array('eq','high'), 'or') ;
//           // $risk = array('eq','high') ;
//        }
        $det = M('detection');
        $appinfo = D('Appinfo');
        $info = $appinfo->where(array('appid' => $appid))->find();
        $count = $det->where(array('appid' => $appid))->count();
        $hcount = $det->where(array('appid' => $appid, 'result' => 'high'))->count();
        $midcount = $det->where(array('result' => 'medium', 'appid' => $appid))->count();
       
        $shu = $det->where(array('appid' => $appid))->find();
        
        $listcount = $det->group('testtype')->where(array('appid' => $appid))->select();
        $leicount =count($listcount);
     
        $html.='<div class="a4-container">           
                         <h1 class="text-center" style="color:#147efb;text-align:center;font-size:40px;">' . $info['name'] . '项目</h1>
                         <h3 class="text-center" style="text-align:center;">源代码检测报告</h3>
                         <p class="text-center" style="text-align:center;">' . $info['subtime'] . '</p> 
                             <div class="bottom-line"></div>

                                 <p>检测工具：Fortify</p>';

          $mpdf->writeHTML($html);
          $mpdf->AddPage();
          
      
            
        
        $html ='

                                 <div class="report-content">
                                         <div class="report-group">
                                                 <div class="title">
                                                         <h3>摘要</h3>
                                                         <div class="clearfix"></div>
                                                         <p>本报告为开发人员提供源代码扫描细节和信息理解和解决源代码审计过程中发现的风险。本报告的读者主要是项目经理和开发人员。本节提供的分析过程中发现的风险进行了概述。</p>
                                                 </div>
                                                  <table class="table table-bordered" border="1">
                                                
                                                         <tbody>
                                                                 <tr>
                                                                         <td>项目名</td>
                                                                         <td>' . $info['name'] . '</td>
                                                                         <td>检测工具</td>
                                                                         <td>Fortify(16.10.0095 )</td>
                                                                 </tr>
                                                                 <tr>
                                                                         <td>软件版本</td>
                                                                         <td>' . $info['version'] . '</td>
                                                                         <td>风险库版本</td>
                                                                         <td>16.10.0095</td>
                                                                 </tr>
                                                                  <tr>
                                                                         <td>编译环境</td>
                                                                         <td>' .$info['env'] . '</td>
                                                                         <td>代码语言</td>
                                                                         <td>' . $info['lang'] . '</td>
                                                                 </tr>
                                                                  <tr>
                                                                         <td>压缩包MD5</td>
                                                                         <td>' .$info['md5'] . '</td>
                                                                         <td>预编译命令</td>
                                                                         <td>' . $info['shell'] . '</td>
                                                                 </tr>
                                                                  <tr>
                                                                         <td>提交时间</td>
                                                                         <td>' .$info['subtime']. '</td>
                                                                         <td>测试用时</td>
                                                                         <td>' . $info['spendtime'] . '</td>
                                                                 </tr>
                                                                 <tr>
                                                                         <td>风险种类个数</td>
                                                                         <td>' . $leicount . '</td>
                                                                         <td>中危风险个数</td>
                                                                         <td>' . $midcount . '</td>
                                                                 </tr>
                                                                 <tr>
                                                                         <td>总风险个数</td>
                                                                         <td>' . $count . '</td>
                                                                         <td>高危风险个数</td>
                                                                         <td>'. $hcount . '</td>
                                                                 </tr>
                                                         </tbody>
                                                 </table>
                                         </div>

                                         <div class="bottom-line"></div>';
//                           <div style="padding-left:60px;" >   <img src="' . __ROOT__ . '/Uploads/example/one.png" hight="250px" width="460px" ></div>
                                          
                            if($shu){
                                   $html .='
                                             <div style="padding-left:60px;">    <img src="' . __ROOT__ . '/Uploads/example/two.png "   hight="100px" width="460px"></div>
                                             <div style="padding-left:60px;">      <img src="' . __ROOT__ . '/Uploads/example/three.png "  hight="100px" width="460px"></div>';
//                                            $mpdf->writeHTML($html);
//                                            $mpdf->AddPage();
                                     $html .=' <div class="report-group">
                                                 <div class="title">
                                                         <h3>风险汇总</h3>
                                                         <div class="clearfix"></div>
                                                 </div>

                                                 <div class="chart-img" >


                                              <div style="padding-left:60px;">      <img src="' . __ROOT__ . '/Uploads/example/f.png "  hight="100px" width="560px"></div>

                                                 </div>
                                                  <p></p>
                                                 <table class="table table-bordered" border="1">
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
                                                                     <tbody>';
         /**
          * 类型的分类
          */                            
         $lists = $det->field('testtype')->group('testtype')->where(array('appid' => $appid,'result'=>$risk))->select();                          
        foreach ($lists as $ke => $v) {
            $listb = $v['testtype'];
            $crib = $det->where(array('appid' => $appid, 'testtype' => $v['testtype'], 'result' => 'critical'))->count();
            $hib = $det->where(array('appid' => $appid, 'testtype' => $v['testtype'], 'result' => 'high'))->count();
            $medb = $det->where(array('appid' => $appid, 'testtype' => $v['testtype'], 'result' => 'medium'))->count();
            $lowb = $det->where(array('appid' => $appid, 'testtype' => $v['testtype'], 'result' => 'low'))->count();
            $sumcount = $hib + $medb + $lowb+$crib;
            $html .='<tr>
                                                                         <td>' . $listb . '</td>
                                                                         <td>' . $crib . '</td>
                                                                         <td>' . $hib . '</td>
                                                                         <td>' . $medb . '</td>
                                                                         <td>' . $lowb . '</td>
                                                                         <td>' . $sumcount . '</td>
                                                                 </tr>';
        }

        $html.=' </tbody>
                                                 </table>
                                         </div>

                                         <div class="bottom-line"></div>

                                         <div class="report-group">
                                         <h2 class="text-center">风险详情</h2>';

        /**
         * 分类
         * **/
        $det = M('detection');
        $listdet = $det->group('testtype')->where(array('appid' => $appid,'result'=>$risk))->select();
   //dump($listdet);die;
        foreach ($listdet as $kv => $vl) {
            // $mone['id'] = $vl['id'];
            $testtype = $vl['testtype'];
            $count = $det->where(array('appid' => $appid, 'testtype' => $vl['testtype']))->count();
            $children = $det->where(array('at_detection.appid' => $appid, 'at_detection.testtype' => $vl['testtype'],'at_detection.result'=>$risk))->field('at_detection.id,at_detection.scaid,at_detection.appid,at_detection.testname,at_detection.testtype,at_detection.result,at_detection.info,at_resulttype.zhresult')->join('left join at_resulttype on at_resulttype.result=at_detection.result')->select();
            $cribb = $det->where(array('appid' => $appid, 'testtype' => $vl['testtype'], 'result' => 'critical'))->count();
            $hibb = $det->where(array('appid' => $appid, 'testtype' => $vl['testtype'], 'result' => 'high'))->count();
            $medbb = $det->where(array('appid' => $appid, 'testtype' => $vl['testtype'], 'result' => 'medium'))->count();
            $lowbb = $det->where(array('appid' => $appid, 'testtype' => $vl['testtype'], 'result' => 'low'))->count();
            $sumcountb = $hibb + $medbb + $lowbb+$cribb;
            $data = $det->field('at_detection.id as id,at_detection.scaid as scaid,at_detectype.zhtesttype,at_detectype.damage as damage,at_detectype.suggest as suggest,at_detection.appid as appid,at_detection.testtype as testtype,at_detection.info as info')->where(array('at_detection.id' =>  $vl['id']))->join('left join at_detectype on at_detectype.testtype = at_detection.testtype')->find();
  
            $k = $kv + 1;

    // dump($testtype);（' . $count . '个风险）
    // dump($children);die;

            $html .= '    <h3>第' . $k . '类：' . $testtype . '</h3>
                              <h3>中文名：'.$data['zhtesttype'].'</h3>
                                                 <div class="title">
                                                         <h3>风险解释</h3>
                                                         <div class="clearfix"></div>
                                                         <p>'.$data['damage'].'</p>
                                                 </div>
                                                 <div class="title">
                                                         <h3>修复建议</h3>
                                                         <div class="clearfix"></div>
                                                         <p>'.$data['suggest'].'</p>
                                                 </div>

                                                 <div class="title">
                                                         <h3>概要</h3>
                                                         <div class="clearfix"></div>
                                                 </div>
                                                 <table class="table table-bordered" border="1">
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
                                                                 <tr>';
            $html.='<td>' . $testtype . '</td>
                                                               <td>' . $cribb . '</td>
                                                               <td>' . $hibb . '</td>
                                                               <td>' . $medbb . '</td>
                                                               <td>' . $lowbb . '</td>
                                                               <td>' . $sumcountb . '</td>';

            $html .='</tr>

                                                         </tbody>
                                                 </table>

                                                 <div class="title">
                                                         <h3>详情</h3>
                                                         <div class="clearfix"></div>
                                                 </div>
                                               
                                                

              

                                                 <div class="report-detail">';
            


            foreach ($children as $ks => $vs) {

                $k = $ks + 1;

                $html .='  
                          <table class="table table-bordered">
					<thead>
						<tr>
							<th style="background:#5CACEE;text-align:left;color:#ffffff;font-size:20px;width:90%;" >' . $k . ':' .explode(")",$vs['info'] , -1)[0] . ")" . '</th>';
					
                                          if ($vs['zhresult'] == '严重') {
                                                $html.= '<th class="cridanger-1" style="width:10%">严重</th>';
                                            } 
                                            else if ($vs['zhresult'] == '高危') {
                                                $html.= '<th class="danger-1" style="width:10%">高危</th>';
                                            } else if ($vs['zhresult'] == '中危') {
                                                $html.= ' <th class="warning-1" style="width:10%">中危</th>';
                                            } else if ($vs['zhresult'] == '低危') {
                                                $html.= ' <th class="normal-1" style="width:10%">低危</th>';
                                            }
                               $html .='
							
						</tr>
                                            
                                          </thead>
                                        
                                         <thead> 
                                              <tr style="background:#ccc;text-align:left" >
							<th style="height:30px;">代码位置</th>
							<th></th>
							
						</tr>
					</thead>     
					<tbody >';
//                               $in = $vs['info'];
//                              substr("Hello world",10)."<br>";
                           //  $u = explode("----",$vs['info'] , -1)[0];
                              $u = strip_tags($vs['info']);
                             $u =htmlspecialchars($u);
//                             $u = str_replace("\r", "<br>", $u);
                             $u = str_replace("\n", "<br>", $u);
                             $u = str_replace("\t", "&nbsp;&nbsp;", $u);
                             $u = str_replace("  ", "&nbsp;", $u);
                             $u = str_replace(" ", "&nbsp;", $u);
                            $u =  str_replace("\r\n", '<br>', $u);
                          //  $u =  str_replace("\r\n", '<br>', $u);
                         
//                            $count=30;//截取字符长度
//                            $cont_len=strlen($u);
//                              dump($cont_len);
//                            $_num=intval($cont_len/$count);
//                            
//                            $sub_len=$count*$_num;
//                            $div_len=$cont_len-$sub_len;
//                           
//                            for($i=0;$i<$_num;$i++){
//                                  echo substr($u,$i*$count,$count)."<br/>";
//                            }

                           // echo substr($u,$sub_len,$div_len);
                           // die;
                          
                         //   $str = str_replace('  ',"<br>",$in);
                     //   echo $u; die;
                   
				$html .='	<tr  >';
				      $html .='<td class="trs" >'.$u.'</td>';
				         $html .='	  <td></td>
						</tr >';
                                 
                             
				$html .='</tbody>
				</table>  <p>&nbsp;</p>';   
//                                break;
                                
                      
                    
                    
            }
            $html .= '</div>';
        }



        $html .='    </div>';
        
   } else {
            $html .= '<p style="font-size:20px;text-align:center">没有其他数据了</p>';
        }

        
         $html .='          </div>

                     </div>
                 </body>
                 </html>
            ';
      
       //echo $html;die;
        $mpdf->WriteHTML($html);
         $name = '检测报表'.'.pdf';
         $mpdf->Output($name, 'D');
        // $mpdf->Output();
        exit;
    }

   
 
    public function one() {
        import('Think.pChart.pPie');
        import('Think.pChart.pDraw');
        import('Think.pChart.pData');
        import('Think.pChart.pImage');
       
        $appid = 1304;
        $appinfo = D('Appinfo');
        $detec = D('Detection');
        $test = array();
         $test['cricount'] = $detec->where(array('appid' => $appid, 'result' => critical))->count();
        $test['highcount'] = $detec->where(array('appid' => $appid, 'result' => high))->count();
        $test['midcount'] = $detec->where(array('appid' => $appid, 'result' => medium))->count();
        $test['lowcount'] = $detec->where(array('appid' => $appid, 'result' => low))->count();
        // dump($test);die;
        /* Create and populate the pData object */
        $MyData = new \pData();
        $MyData->addPoints($test, "ScoreA");
        //$MyData->addPoints(array(50,2,3,4,7,10,25,48,41,10),"ScoreA");   
        $MyData->setSerieDescription("ScoreA", "Application A");

        /* Define the absissa serie */

        $arr = array("严重","高危", "中危", "低危");
        $MyData->addPoints($arr, "Labels");
        //$MyData->addPoints(array("A0","B1","C2","D3","E4","F5","G6","H7","I8","J9"),"Labels"); 
        $MyData->setAbscissa("Labels");
      
        /* Create the pChart object */
        $myPicture = new \pImage(400, 380, $MyData);
 
        /* Draw a solid background */
        $Settings = array("R" => 255, "G" => 255, "B" => 255, "Dash" => 0,);
        //  $Settings = array("R"=>170, "G"=>183, "B"=>87, "Dash"=>0, "DashR"=>190, "DashG"=>203, "DashB"=>107); 
        $myPicture->drawFilledRectangle(80, 20, 400, 350, $Settings);
      //$myPicture->setGraphArea(100,20,680,270);
        /* Overlay with a gradient *///背景颜色
       //  $Settings = array("StartR"=>219, "StartG"=>231, "StartB"=>139, "EndR"=>1, "EndG"=>138, "EndB"=>68, "Alpha"=>50); 
        // $myPicture->drawGradientArea(0,0,400,360,DIRECTION_VERTICAL,$Settings); 
        // $myPicture->drawGradientArea(80, 20, 400, 450,DIRECTION_VERTICAL,array("StartR"=>0,"StartG"=>0,"StartB"=>0,"EndR"=>50,"EndG"=>50,"EndB"=>50,"Alpha"=>100)); 

        /* Add a border to the picture */ //边框架
         // $myPicture->drawRectangle(50,20,399,360,array("R"=>198,"G"=>149,"B"=>149, "Alpha" => 60)); 

        /* Write the picture title */
        //  $n = UPLOAD_PATH.'fonts/h.ttf';
        $n = UPLOAD_PATH . 'fonts/simsun.ttc';
        // $name =''
        //  dump($name);die;
       
        $myPicture->setFontProperties(array("FontName" => $n, "FontSize" => 22));
        $myPicture->drawText(140, 90, "风险统计图", array("R" => 7, "G" => 6, "B" => 6));

        /* Set the default font properties */
        // $names = UPLOAD_PATH.'fonts/Forgotte.ttf';
       // $names = UPLOAD_PATH . 'fonts/heiti.ttf';
         $names = UPLOAD_PATH . 'fonts/simsun.ttc';

        $myPicture->setFontProperties(array("FontName" => $names, "FontSize" => 12, "R" => 80, "G" => 80, "B" => 80));

        /* Enable shadow computing */
        $myPicture->setShadow(TRUE, array("X" => 2, "Y" => 2, "R" => 0, "G" => 0, "B" => 0, "Alpha" => 50));

        /* Create the pPie object */
        $PieChart = new \pPie($myPicture, $MyData);




        /* Define the slice color复制颜色 */
        $PieChart->setSliceColor(0, array("R" => 168, "G" => 0, "B" => 11));
        
        $PieChart->setSliceColor(1, array("R" => 255, "G" => 33, "B" => 47));

        $PieChart->setSliceColor(2, array("R" => 225, "G" => 152, "B" => 0));

        $PieChart->setSliceColor(3, array("R" => 79, "G" => 202, "B" => 129));

        /* Draw an AA pie chart */
        //$PieChart->draw2DRing(160,140,array("WriteValues"=>TRUE,"ValueR"=>255,"ValueG"=>255,"ValueB"=>255,"Border"=>TRUE)); 
        $PieChart->draw3DPie(210, 280, array("Radius" => 100, "DrawLabels" => true, "Border" => TRUE, "WriteValues" => PIE_VALUE_PERCENTAGE,'Shadow'=>FALSE));

        /* Write the legend box */
        $myPicture->setShadow(FALSE);
        $PieChart->drawPieLegend(60, 110, array("Alpha" => 20));
        //$myPicture->stroke();
      
        /* Render the picture (choose the best way) */
    //  $myPicture->autoOutput("./templates_c/example.draw2DPie.png");
        // $FileName = date(Ymd)."one.png";
       // $FileName = UPLOAD_PATH . "example/" . date(Ymd) . "one.png";
          $FileName = UPLOAD_PATH . "example/" . "one.png";
        $myPicture->render($FileName);
    }

    public function two($appid) {
        import('Think.pChart.pDraw');
        import('Think.pChart.pData');
        import('Think.pChart.pImage');

       
       // $appid = 1139;
        $appinfo = D('Appinfo');
        $detec = D('Detection');
        $test = array();
        $test['cricount'] = $detec->where(array('appid' => $appid, 'result' => critical))->count();
        $test['highcount'] = $detec->where(array('appid' => $appid, 'result' => high))->count();
        $test['midcount'] = $detec->where(array('appid' => $appid, 'result' => medium))->count();
        $test['lowcount'] = $detec->where(array('appid' => $appid, 'result' => low))->count();

        $MyData = new \pData();


        $MyData->addPoints($test, "");
        // $MyData->setAxisName(0,"Hits");

        $arr = array("严重","高危", "中危", "低危");
        $MyData->addPoints($arr, "Browsers");

        //$MyData->addPoints(array("Firefox","Chrome","Internet Explorer","Opera","Safari","Mozilla","SeaMonkey","Camino","Lunascape"),"Browsers"); 
        $MyData->setSerieDescription("Browsers", "Browsers");
        $MyData->setAbscissa("Browsers");
       // $MyData->setAbscissaName("Browsers"); 
      //  $MyData->setAxisColor(0,array("R"=>255,"G"=>128,"B"=>0));
      
        /* Create the pChart object */
        $myPicture = new \pImage(515, 310, $MyData);
        // $a= UPLOAD_PATH.'fonts/heiti.ttf';
        $name = UPLOAD_PATH . 'fonts/simsun.ttc';

//背景
        //$myPicture->drawGradientArea(0,0,500,500,DIRECTION_VERTICAL,array("StartR"=>240,"StartG"=>240,"StartB"=>240,"EndR"=>180,"EndG"=>180,"EndB"=>180,"Alpha"=>100)); 
        //$myPicture->drawGradientArea(0,0,500,500,DIRECTION_HORIZONTAL,array("StartR"=>240,"StartG"=>240,"StartB"=>240,"EndR"=>180,"EndG"=>180,"EndB"=>180,"Alpha"=>20)); 
        $myPicture->setFontProperties(array("FontName" => $name, "FontSize" => 10));
        //$myPicture->setFontProperties(array("FontName"=>"../fonts/pf_arma_five.ttf","FontSize"=>6)); 

        /* Draw the chart scale */
        $myPicture->setGraphArea(70, 80, 480, 280);
        //"CycleBackground" => TRUE,背景有背影
        $myPicture->drawScale(array("DrawSubTicks" => TRUE, "GridR" => 0, "GridG" => 0, "GridB" => 0, "GridAlpha" => 0, "Pos" => SCALE_POS_TOPBOTTOM));
      //标题
    
        $myPicture->drawText(195, 50, "风险等级分布图",array("R"=>7,"G"=>6,"B"=>6,"Alpha" => 150,"FontSize" => 22));
        //边框
      //  $myPicture->drawRectangle(20,2,510,290,array("R"=>198,"G"=>149,"B"=>149, "Alpha" => 60));
        
        /* Turn on shadow computing */
        $myPicture->setShadow(TRUE, array("X" => 1, "Y" => 1, "R" => 0, "G" => 0, "B" => 0, "Alpha" => 10));

        /* Create the per bar palette */
//        $Palette = array("0" => array("R" => 188, "G" => 224, "B" => 46, "Alpha" => 100),
//                         "1" => array("R" => 224, "G" => 100, "B" => 46, "Alpha" => 100),
//                         "2" => array("R" => 224, "G" => 214, "B" => 46, "Alpha" => 100),
//        );
        //     
 
        
        $Palette = array("0" => array("R" => 168, "G" => 0, "B" => 11),
            "1" => array("R" => 255, "G" => 33, "B" => 47),
            "2" => array("R" => 225, "G" => 152, "B" => 0),
            "3" => array("R" => 79, "G" => 202, "B" => 129),
        );

        /* Draw the chart *///图  
        $myPicture->drawBarChart(array("DisplayPos" => LABEL_POS_INSIDE, "DisplayValues" => TRUE, "Rounded" => TRUE, "Surrounding" => 30, "OverrideColors" => $Palette));

        /* Write the legend */
      //  $myPicture->drawLegend(10, 10, array("Style" => LEGEND_NOBORDER, "Mode" => LEGEND_HORIZONTAL));

        /* Render the picture (choose the best way) */
      // $myPicture->autoOutput("pictures/example.drawBarChart.palette.png");
 // $FileName = UPLOAD_PATH . "example/" . date(Ymd) . "two.png";
        $FileName = UPLOAD_PATH . "example/" . "two.png";

        $myPicture->render($FileName);
    }
     public function three($appid) {
        import('Think.pChart.pPie');
        import('Think.pChart.pDraw');
        import('Think.pChart.pData');
        import('Think.pChart.pImage');
        $det = M('detection');
     
      // $appid = 1284;
        $risk = array(array('eq','critical'),array('eq','high'), 'or') ;
        $lists = $det->field('testtype')->group('testtype')->where(array('appid' => $appid,'result'=>$risk))->select();
        $list = array();
      
       
        foreach ($lists as $kl => $vl) {

            $data[$kl]['testtype'] = $vl['testtype'];
            //$data[$kl] = $det->where(array('appid' => $appid, 'testtype' => $vl['testtype']))->count();
            $data[$kl]['cricount'] = $det->where(array('appid' => $appid, 'testtype' => $vl['testtype'], 'result' => 'critical',))->count();
            $data[$kl]['hicount'] = $det->where(array('appid' => $appid, 'testtype' => $vl['testtype'], 'result' => 'high',))->count();
            $data[$kl]['count'] =$data[$kl]['cricount'] + $data[$kl]['hicount'];
            //  $data[$kl]['children'] = $det->where(array('at_detection.appid'=>$appid,'at_detection.testtype'=>$vl['testtype']))->field('at_detection.id,at_detection.scaid,at_detection.appid,at_detection.testname,at_detection.testtype,at_detection.result,at_detection.info,at_resulttype.zhresult')->join('left join at_resulttype on at_resulttype.result=at_detection.result')->select();
        }
          foreach ($data as $k => $v) {

           $answer[$k]['num']=$v['count'];
           $answer[$k]['name']=$v['testtype'];
            
            //  $list[$k] = substr($v['testtype'],0,32);
        }
        arsort($answer);
      //  dump($answer);die;
      
        $listnum =array_slice($answer,0,10,true);
         
        foreach ($listnum as $kl2 => $vl2) {
            
            //   $data[$kl]['testtype'] = $vl['testtype'];
            $num[$kl2] = $vl2['num'];
            $name[$kl2] =$vl2['name'];
            //  $data[$kl]['children'] = $det->where(array('at_detection.appid'=>$appid,'at_detection.testtype'=>$vl['testtype']))->field('at_detection.id,at_detection.scaid,at_detection.appid,at_detection.testname,at_detection.testtype,at_detection.result,at_detection.info,at_resulttype.zhresult')->join('left join at_resulttype on at_resulttype.result=at_detection.result')->select();
         }
       
        /* Create and populate the pData object */
        $MyData = new \pData();
        $MyData->addPoints($num, "ScoreA");
        //$MyData->addPoints(array(50,20,30,50,20,30),"ScoreA");  
        //$MyData->addPoints(array(50,2,3,4,7,10,25,48,41,10),"ScoreA");   
        $MyData->setSerieDescription("ScoreA", "Application A");

        /* Define the absissa serie */

        $arr = array("high", "low", "medium", "high");
        $MyData->addPoints($name, "Labels");
        //$MyData->addPoints(array("A0","B1","C2","D3","E4","F5","G6","H7","I8","J9"),"Labels"); 
        $MyData->setAbscissa("Labels");

        /* Create the pChart object */
        $myPicture = new \pImage(400, 410, $MyData);

        /* Draw a solid background */
        //$Settings = array("R"=>170, "G"=>183, "B"=>87, "Dash"=>1, "DashR"=>190, "DashG"=>203, "DashB"=>107); 
        $Settings = array("R" => 255, "G" => 255, "B" => 255, "Dash" => 0,);

        //$myPicture->drawFilledRectangle(0,0,600,600,$Settings);
        $myPicture->drawFilledRectangle(80, 20, 400, 400, $Settings);

        /* Overlay with a gradient */
// $Settings = array("StartR"=>219, "StartG"=>231, "StartB"=>139, "EndR"=>1, "EndG"=>138, "EndB"=>68, "Alpha"=>50); 
// $myPicture->drawGradientArea(0,0,300,260,DIRECTION_VERTICAL,$Settings); 
// $myPicture->drawGradientArea(0,0,300,20,DIRECTION_VERTICAL,array("StartR"=>0,"StartG"=>0,"StartB"=>0,"EndR"=>50,"EndG"=>50,"EndB"=>50,"Alpha"=>100)); 

        /* Add a border to the picture */ //边框线
        //$myPicture->drawRectangle(0,0,299,259,array("R"=>0,"G"=>0,"B"=>0)); 
        //  $myPicture->drawRectangle(50,20,397,350, array("R"=>198,"G"=>149,"B"=>149, "Alpha" => 60));
        /* Write the picture title */
        // $name= UPLOAD_PATH.'fonts/h.ttf';
        $name = UPLOAD_PATH . 'fonts/simsun.ttc';
        $myPicture->setFontProperties(array("FontName" => $name, "FontSize" => 18));
        $myPicture->drawText(125, 60, "TOP10高危风险分布",array("R"=>7,"G"=>6,"B"=>6,"Alpha" => 150));

        /* Set the default font properties */
//  $names = UPLOAD_PATH.'fonts/heiti.ttf';
        $names = UPLOAD_PATH . 'fonts/simsun.ttc';
        $myPicture->setFontProperties(array("FontName" => $names, "FontSize" => 8, "R" => 80, "G" => 80, "B" => 80));

        /* Enable shadow computing */
        $myPicture->setShadow(TRUE, array("X" => 2, "Y" => 2, "R" => 0, "G" => 0, "B" => 0, "Alpha" => 50));

        /* Create the pPie object */
        $PieChart = new \pPie($myPicture, $MyData);



        /* Draw an AA pie chart */
        //$PieChart->draw2DRing(160,180,array("WriteValues"=>TRUE,"ValueR"=>255,"ValueG"=>255,"ValueB"=>255,"Border"=>TRUE));"DrawLabels" => true, 
        $PieChart->draw3DPie(220, 315, array("Radius" => 130, "Border" => true, "WriteValues" => PIE_VALUE_PERCENTAGE));

        /* Write the legend box */
        $myPicture->setShadow(FALSE);
        //位置
        $PieChart->drawPieLegend(55, 80, array("Alpha" => 20));

        /* Render the picture (choose the best way) */
        //$myPicture->autoOutput("./templates_c/example.draw2DPie.png");

        $FileName = UPLOAD_PATH . "example/three.png";

        $myPicture->render($FileName);
    }
    
  
    public function threes() {
        import('Think.pChart.pPie');
        import('Think.pChart.pDraw');
        import('Think.pChart.pData');
        import('Think.pChart.pImage');
        $det = M('detection');
        $appid = 1284;
      //  $lists = $det->field('testtype')->group('testtype')->where(array('appid' => $appid))->limit(0,10)->select();
        $risk = array(array('eq','critical'),array('eq','high'), 'or') ;
         $lists = $det->group('testtype')->where(array('appid' => $appid,'result'=>$risk))->select();
        // dump($lists);die;
        $data = array();
        foreach ($lists as $k => $v) {
            
               $data[$k]['testtype'] = $v['testtype'];
              
            //  $list[$k] = substr($v['testtype'],0,32);
          //    $data[$kl]['count'] = $det->where(array('appid' => $appid, 'testtype' => $vl['testtype']))->count();
                $data[$k]['cricount'] = $det->where(array('appid' => $appid, 'testtype' => $v['testtype'], 'result' => 'critical',))->count();
                $data[$k]['hicount'] = $det->where(array('appid' => $appid, 'testtype' => $v['testtype'], 'result' => 'high',))->count();
                $data[$k]['count'] =$data[$k]['cricount'] + $data[$k]['hicount'];
            //    $data[$kl]['medcount'] = $det->where(array('appid' => $appid, 'testtype' => $vl['testtype'], 'result' => 'medium',))->count();
          //      $data[$kl]['lowcount'] = $det->where(array('appid' => $appid, 'testtype' => $vl['testtype'], 'result' => 'low',))->count();
               $data[$k]['children'] = $det->where(array('at_detection.appid' => $appid, 'at_detection.testtype' => $v['testtype']))->field('at_detection.id,at_detection.scaid,at_detection.appid,at_detection.testname,at_detection.testtype,at_detection.result,at_detection.info,at_resulttype.zhresult')->join('left join at_resulttype on at_resulttype.result=at_detection.result')->select();
               $data[$k]['children'][$k]['cricount'] = $det->where(array('appid' => $appid, 'testtype' => $v['testtype'], 'result' => 'critical',))->count();
               $data[$k]['children'][$k]['hicount'] = $det->where(array('appid' => $appid, 'testtype' => $v['testtype'], 'result' => 'high',))->count();
               $data[$k]['children'][$k]['count'] =$data[$k]['children'][$k]['cricount'] +$data[$k]['children'][$k]['hicount'];
                $data[$k]['children'][$k]['testtypes'] =$v['testtype'];
             }
              foreach ($data as $kk => $vv) {
//                //  dump($vv['children']);
//                   foreach ($vv['children'] as $kk2 => $vv2) {
//                     //  dump($vv2);
//                    //  $answer=asort($vv2['count']);
//                      if($vv2['count'] > 0){
//                          $weee[$kk2]= $vv2;
//                         //  dump($vv2);
//                        
//                      }  
//                   }
                    $answer[$kk]['num']=$vv['count'];
                    $answer[$kk]['name']=$vv['testtype'];
                    $wa['count'] = $vv['count'];
              }
            //  $array = array('a'=>1,'b'=>4,'c'=>3,'d'=>2);
            arsort($answer);
            $listnum =array_slice($answer,0,10,true);
           
          
             //$answer=asort($data['cricount']);
         //   dump($a);die;
           // dump($answer);die;
       //  dump($data);die;
        foreach ($listnum as $kl2 => $vl2) {
            
            //   $data[$kl]['testtype'] = $vl['testtype'];
            $num[$kl2] = $vl2['num'];
            $name[$kl2] =$vl2['name'];
            //  $data[$kl]['children'] = $det->where(array('at_detection.appid'=>$appid,'at_detection.testtype'=>$vl['testtype']))->field('at_detection.id,at_detection.scaid,at_detection.appid,at_detection.testname,at_detection.testtype,at_detection.result,at_detection.info,at_resulttype.zhresult')->join('left join at_resulttype on at_resulttype.result=at_detection.result')->select();
         }
      //  dump($num);
      //  dump($name);
       //   dump($listnum);die;
        // dump($lists);die;
        /* Create and populate the pData object */
        $MyData = new \pData();
        $MyData->addPoints($num, "ScoreA");
        //$MyData->addPoints(array(50,20,30,50,20,30),"ScoreA");  
        //$MyData->addPoints(array(50,2,3,4,7,10,25,48,41,10),"ScoreA");   
        $MyData->setSerieDescription("ScoreA", "Application A");

        /* Define the absissa serie */

        $arr = array("high", "low", "medium", "hight");
        $MyData->addPoints($name, "Labels");
        //$MyData->addPoints(array("A0","B1","C2","D3","E4","F5","G6","H7","I8","J9"),"Labels"); 
        $MyData->setAbscissa("Labels");

        /* Create the pChart object */
        $myPicture = new \pImage(400, 410, $MyData);

        /* Draw a solid background */
        //$Settings = array("R"=>170, "G"=>183, "B"=>87, "Dash"=>1, "DashR"=>190, "DashG"=>203, "DashB"=>107); 
        $Settings = array("R" => 255, "G" => 255, "B" => 255, "Dash" => 0,);

        //$myPicture->drawFilledRectangle(0,0,600,600,$Settings);
        $myPicture->drawFilledRectangle(80, 20, 400, 400, $Settings);

        /* Overlay with a gradient */
// $Settings = array("StartR"=>219, "StartG"=>231, "StartB"=>139, "EndR"=>1, "EndG"=>138, "EndB"=>68, "Alpha"=>50); 
// $myPicture->drawGradientArea(0,0,300,260,DIRECTION_VERTICAL,$Settings); 
// $myPicture->drawGradientArea(0,0,300,20,DIRECTION_VERTICAL,array("StartR"=>0,"StartG"=>0,"StartB"=>0,"EndR"=>50,"EndG"=>50,"EndB"=>50,"Alpha"=>100)); 

        /* Add a border to the picture */ //边框线
        //$myPicture->drawRectangle(0,0,299,259,array("R"=>0,"G"=>0,"B"=>0)); 
        //  $myPicture->drawRectangle(50,20,397,350, array("R"=>198,"G"=>149,"B"=>149, "Alpha" => 60));
        /* Write the picture title */
        // $name= UPLOAD_PATH.'fonts/h.ttf';
        $name = UPLOAD_PATH . 'fonts/simsun.ttc';
        $myPicture->setFontProperties(array("FontName" => $name, "FontSize" => 22));
        $myPicture->drawText(95, 60, "TOP10高危风险分布",array("R"=>7,"G"=>6,"B"=>6,"Alpha" => 150));

        /* Set the default font properties */
//  $names = UPLOAD_PATH.'fonts/heiti.ttf';
        $names = UPLOAD_PATH . 'fonts/simsun.ttc';
        $myPicture->setFontProperties(array("FontName" => $names, "FontSize" => 8, "R" => 80, "G" => 80, "B" => 80));

        /* Enable shadow computing */
        $myPicture->setShadow(TRUE, array("X" => 2, "Y" => 2, "R" => 0, "G" => 0, "B" => 0, "Alpha" => 50));

        /* Create the pPie object */
        $PieChart = new \pPie($myPicture, $MyData);



        /* Draw an AA pie chart */
        //$PieChart->draw2DRing(160,180,array("WriteValues"=>TRUE,"ValueR"=>255,"ValueG"=>255,"ValueB"=>255,"Border"=>TRUE));"DrawLabels" => true, 
        $PieChart->draw3DPie(220, 315, array("Radius" => 130, "Border" => true, "WriteValues" => PIE_VALUE_PERCENTAGE));

        /* Write the legend box */
        $myPicture->setShadow(FALSE);
        //位置
        $PieChart->drawPieLegend(55, 80, array("Alpha" => 20));

        /* Render the picture (choose the best way) */
       $myPicture->autoOutput("./templates_c/example.draw2DPie.png");
       //  $FileName = UPLOAD_PATH . "example/" . date(Ymd) . "three.png";
        $FileName = UPLOAD_PATH . "example/". "three.png";

        $myPicture->render($FileName);
    }
    
   

    public function four($appid) {

        import('Think.pChart.pDraw');
        import('Think.pChart.pData');
        import('Think.pChart.pImage');

        $det = M('detection');
       // $appid = 1139;
        $risk = array(array('eq','critical'),array('eq','high'), 'or') ;
        $lists = $det->field('testtype')->group('testtype')->where(array('appid' => $appid,'result'=>$risk))->limit(0,10)->select();

        $list = array();
        $hi = array();
        $med = array();
        $low = array();
        foreach ($lists as $k => $v) {

          //  $list[$k] = $v['testtype'];cut_str($string, $sublen, $start = 0, $code = 'UTF-8')
          // $list[$k] = mb_substr($v['testtype'], 0, 8, 'utf-8');
            $list[$k] = $this->cut_str($v['testtype'], 8, 0);
             $cri[$k] = $det->where(array('appid' => $appid, 'testtype' => $v['testtype'], 'result' => 'critical'))->count();
            $hi[$k] = $det->where(array('appid' => $appid, 'testtype' => $v['testtype'], 'result' => 'high'))->count();
            $med[$k] = $det->where(array('appid' => $appid, 'testtype' => $v['testtype'], 'result' => 'medium'))->count();
            $low[$k] = $det->where(array('appid' => $appid, 'testtype' => $v['testtype'], 'result' => 'low'))->count();
        }


        $MyData = new \pData();
 

         $Palette = array( "0" => array("R" => 168, "G" => 0, "B" => 11),
             "1" => array("R" => 255, "G" => 33, "B" => 47),
            "2" => array("R" => 225, "G" => 152, "B" => 0),
            "3" => array("R" => 79, "G" => 202, "B" => 129),
        );
        
        $MyData->setPaletteColor($Palette);
        //  $MyDraw = new \pDraw();
         $MyData->addPoints($cri, "严重");
        $MyData->addPoints($hi, "高危");
        $MyData->addPoints($med, "中危");
        $MyData->addPoints($low, "低危");

     // $MyData->setAxisColor(0,array("R"=>255,"G"=>128,"B"=>0));
        //   $MyData->setAxisColor($Palette);
        // $MyData->setAxisName(0,"Average Usage"); 
        $MyData->addPoints($list, "Labels");
        //  $MyData->addPoints(array("Jan","Feb","Mar","Apr","May","Jun","Jan","Feb","Mar","Apr","May","Jun"),"Labels"); 
        $MyData->setSerieDescription("Labels", "Months");
        $MyData->setAbscissa("Labels");
       
      
        /* Create the pChart object */
        $myPicture = new \pImage(510, 240, $MyData);


        //背景
        //  $myPicture->drawGradientArea(0,0,700,230,DIRECTION_VERTICAL,array("StartR"=>240,"StartG"=>240,"StartB"=>240,"EndR"=>180,"EndG"=>180,"EndB"=>180,"Alpha"=>100)); 
        //  $myPicture->drawGradientArea(0,0,700,230,DIRECTION_HORIZONTAL,array("StartR"=>240,"StartG"=>240,"StartB"=>240,"EndR"=>180,"EndG"=>180,"EndB"=>180,"Alpha"=>20)); 

        /* Set the default font properties */
        //  $name = UPLOAD_PATH.'fonts/heiti.ttf';
        $name = UPLOAD_PATH . 'fonts/simsun.ttc';
        $myPicture->setFontProperties(array("FontName" => $name, "FontSize" => 10));

        /* Draw the scale and the chart */
       // $myPicture->drawRectangle(25,2,509,239,array("R"=>198,"G"=>149,"B"=>149, "Alpha" => 60));

//$myPicture->drawBarChart(array("DisplayPos"=>LABEL_POS_INSIDE,"DisplayValues"=>TRUE,"Rounded"=>TRUE,"Surrounding"=>30,"OverrideColors"=>$Palette));
//         
        $myPicture->setGraphArea(70, 50, 490, 180);
        $myPicture->drawScale(array("DrawSubTicks" => TRUE, "Mode" => SCALE_MODE_ADDALL_START0,"LabelRotation"=>35));//"LabelRotation"=>25，斜度
        $myPicture->setShadow(FALSE);
        $myPicture->drawStackedBarChart(array("Surrounding" => -15, "InnerSurrounding" => 15));

        /* Write a label */
        //   $myPicture->writeLabel(array("height #1","medium #2","low #3"),1,array("DrawVerticalLine"=>TRUE));  
         $name = UPLOAD_PATH . 'fonts/simsun.ttc';
       // $myPicture->setFontProperties(array("FontName" => $name, "FontSize" => 20));
          $myPicture->drawText(185, 50, "风险分布图", array("R" => 7, "G" => 6, "B" => 6,"FontSize" => 22));
        /* Write the chart legend */
        //  $arr= array('高危','低危','中危');
        //  $myPicture->drawLegend(480,210,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL)); 
        $myPicture->drawLegend(280, 318, array("Style" => LEGEND_NOBORDER, "Mode" => LEGEND_HORIZONTAL));



        /* Render the picture (choose the best way) */
       // $myPicture->autoOutput("pictures/example.drawStackedBarChart.shaded.png");
       // $FileName = UPLOAD_PATH . "example/" . date(Ymd) . "f.png";
         $FileName = UPLOAD_PATH . "example/" .  "f.png";
        $myPicture->render($FileName);
    }

    public function makeMpdfReports($info, $detec) {
        Vendor('mpdf60.mpdf');
        //设置中文编码
        $mpdf = new \mPDF('zh-CN', 'A4', 0, '宋体');
        $mpdf->useAdobeCJK = true; //打开这个选项比较好
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->SetWatermarkText($marktext);
        $mpdf->showWatermarkText = true;
        //页眉内容
        //第一页
        $html = '<style>
			table.show{ border: 1px solid;border-collapse: collapse;width:750px;height:auto;}
			.show td { border: 1px solid #cbcbcb; border-collapse: collapse;}
			.show tr{ border: 1px solid #cbcbcb; border-collapse: collapse;}
			showtd2 { height:auto;font-size:12pt; }
			h1 font{ font-weight:5px; }
			b{ width:5px; }
			.childtitle{ font-size:36pt;font-weight:normal; }
			div .position{ font-size:20; } 
			.xiahuaxian{ text-decoration:underline;min-width: 400px; }
			.grandtitle{ font-size:20px;font-weight:4; }
			</style>
		<h1>&nbsp;</h1><h1>&nbsp;</h1>
		<h1 align="center"><font size="20px"><b>' . $info['realname'] . '</b></font>应用安全检测评估报告' . '</h1>
		<h1 align="center"><font size="20px"><b>Android版</b></font></h1>
		<h1>&nbsp;</h1><h1>&nbsp;</h1>
				<div style="text-align:center;">
					<div>
						<img width="100px" src="';
        if (!file_exists($info['icon'])) {
            $html .= __ROOT__ . '/' . UPLOAD_PATH . '/icon/default.png';
        } else {
            $html .= __ROOT__ . '/' . $info["icon"];
        }
        $html .='" /></div></div>
				<h1>&nbsp;</h1><h1>&nbsp;</h1>
				<div align="center">
					<table style="font-size:20px;margin-left:180px;">
						<tr><td>应用名</td><td><span>' . $info["realname"] . '</span><hr width="300px" style="margin-top:0px;margin-bottom:-5px;"/></td></tr>
						<tr><td>版本号</td><td><span>' . $info["version"] . '</span><hr width="300px" style="margin-top:0px;margin-bottom:-5px;"/></td></tr>
						<tr><td>检测时间</td><td><span>' . $info["subtime"] . '</span><hr width="300px" style="margin-top:0px;margin-bottom:-5px;"/></td></tr>
					</table>
				</div>
				</div>';
        $mpdf->writeHTML($html);

        $mpdf->AddPage();
        $html = '<span>&nbsp;</span><p class="childtitle">一、检测概述</p><div style="text-align:center;">
			<img width="100" src="';
        if (!file_exists($info['icon'])) {
            $html .= __ROOT__ . '/' . UPLOAD_PATH . '/icon/default.png';
        } else {
            $html .= __ROOT__ . '/' . $info["icon"];
        }
        $html .='" /><br/>
			<font  size="18pt" style="padding-top: 0.5mm;padding-bottom: 0.5mm;">' . $info["realname"] . '</font><br/>
			<font  size="18pt" style="padding-top: 0.5mm;padding-bottom: 0.5mm;">安全等级</font><br/><font style="font-size:25pt">' . ranking($info["secscore"]) . '</font>
		</div>';
        $gaowei = 0;
        foreach ($detec as $k => $v) {
            if ($v["result"] == 4) {
                ++$gaowei;
            }
        }
        $html .= '<p class="childtitle">二、基本信息</p>
		<table class="show" style="text-align: left;width:750px;">
			<tr>
				<td style="width:100px;">应用名称</td>
				<td>' . $info["realname"] . '</td>
				<td style="width:100px;">版本号</td>
				<td>' . $info["version"] . '</td>
			</tr>
			<tr>
				<td style="width:100px;">包名</td>
				<td>' . $info["package"] . '</td>
				<td style="width:100px;">检测时间</td>
				<td>' . $info["subtime"] . '</td>
			</tr>
			<tr>
				<td width="110px">高危风险个数</td><td >' . $gaowei . '</td>
				<td>风险个数</td><td >' . $info["bugs"] . '</td>
			</tr>
			<tr>
				<td style="width:100px;">MD5</td><td colspan="3" >' . $info["md5"] . '</td>
			</tr>
			<tr>
				<td style="width:100px;">SHA-1</td><td colspan="3" >' . $info["sha1"] . '</td>
			</tr>
			<tr>
				<td style="width:100px;">SHA-256</td><td colspan="3" >' . $info["sha256"] . '</td>
			</tr>
			<tr>
				<td style="width:100px;">证书信息</td><td colspan="3" >' . $info["cert"] . '</td>
			</tr>
		</table>';
        $html .= '<p class="childtitle">三、检测概述</p>
		<table style="text-align: left;" class="show">
				<tr><td style="text-align:center;width:100px;" >序号</td><td style="text-align:center;width:330px;">检测项目</td><td style="text-align:center;width:110px;">检测类型</td><td style="text-align:center;width:110px;">危险系数</td></tr>';
        foreach ($detec as $k => $v) {
            $index = $k + 1;
            $html .= '<tr><td style="text-align:center;">' . $index . '</td><td>' . $v["zhtestname"] . '</td><td style="text-align:center;">' . $v["zhtesttype"] . '</td><td style="text-align:center;">';
            if ($v['result'] == 1) {
                $html .= '<font color="#10CA19">' . $v['resultname'] . '</font>';
            } elseif ($v['result'] == 2) {
                $html .= '<font color="orange">' . $v['resultname'] . '</font>';
            } elseif ($v['result'] == 3) {
                $html .= '<font color="#F5470A">' . $v['resultname'] . '</font>';
            } else {
                $html .= '<font color="red">' . $v['resultname'] . '</font>';
            }
            $html .= '</td></tr>';
        }
        $html .= '</table>';
        $mpdf->writeHTML($html);
        $html = "<span>&nbsp;</span>
		<p class='childtitle'>四、详细检测结果</p>";

        $oldtestytpt = 0;
        $testtypenum = 1;
        // foreach ($detec as $k => $v) {
        $requestname_val = C('SERVER_TRANS_ZH');
        $transportinfo = C('PORT_TRANS_ZH');
        $needshowportinfo = C('NEED_SHOW_PORT');
        $len = count($detec);
        foreach ($detec as $k => $v) {
            if ($oldtestytpt == $v['testtype']) {
                
            } else {
                $html .= "<p class='grandtitle'>" . $testtypenum . '、  ' . $v['zhtesttype'] . "</p>";
                $testtypenum ++;
            }
            $oldtestytpt = $detec[$k]['testtype'];

            $html .= "<div style='border:1px solid #e1e1e1;padding:5px;width:750px;'>
				<div><p style='margin:5px 0;border-bottom:1px solid #e1e1e1;'>检测名称：<span>" . $v['zhtestname'] . "</span></p></div><div>";

            if ($v['steps'] || $v['request']) {
                $html .= "<p style='margin:5px 0;border-bottom:1px solid #e1e1e1;'>检测记录：<br/><span>";
                if ($v['steps']) {
                    foreach ($v['steps'] as $ks => $vs) {
                        if ($vs['img']) {
                            if ($ks == 0) {
                                $html .= "<span>截图:</span><img src='" . __ROOT__ . '/' . $vs['img'] . "' width='60px'>";
                            } else {
                                $html .= "<img src='" . __ROOT__ . '/' . $vs['img'] . "' width='60px'>";
                            }
                        }
                        if ($vs['sinfo']) {
                            $html .= "<p>" . $vs['sinfo'] . "</p>";
                        }
                        if ($vs['srequestraw']) {
                            // $html .= "<p style='margin:5px 0;border-bottom:1px solid #e1e1e1;'>报文:</p>";

                            $srequestraw = json_decode($vs['srequestraw'], true);
                            foreach ($srequestraw as $kvs => $vvs) {
                                if ($kvs == 'vul_info') {
                                    // $html .= "<p style='margin:5px 0;border-bottom:1px solid #e1e1e1;'>检测信息：</p>";
                                    foreach ($vvs as $kvs1 => $vvs1) {
                                        $html .= "<p style='margin:5px 0;border-bottom:1px solid #e1e1e1;'><span>描述:</span><span>" . $kvs1 . ": </span><span>" . $vvs1 . "</span></p>";
                                    }
                                } else {
                                    foreach ($vvs as $kvv1 => $value) {
                                        if ($kvv1 == 'portinfo') {
                                            $html .= "<p style='margin:5px 0;border-bottom:1px solid #e1e1e1;'><span>端口扫描信息:</span></p>";
                                            foreach ($value as $kvv2 => $vvv2) {
                                                foreach ($vvv2 as $kvv3 => $vvv3) {
                                                    if (in_array($kvv3, $needshowportinfo)) {
                                                        $html .= "<p style='margin:5px 0;border-bottom:1px solid #e1e1e1;'><span>" . $transportinfo[$kvv3] . ": </span><span>" . $vvv3 . "</span></p>";
                                                    }
                                                }
                                                $html .= "<br/>";
                                            }
                                        } elseif ($kvv1 == 'bad_pwd') {
                                            //当出现键值等于 bad_pwd的时候
                                            foreach ($value as $kbd => $vbd) {
                                                $html .= "<p style='margin:5px 0;border-bottom:1px solid #e1e1e1;'><span>" . $kbd . ": </span><span>" . $vbd . "</span></p>";
                                            }
                                            if ($vt['port']) {
                                                $html .= "<p style='margin:5px 0;border-bottom:1px solid #e1e1e1;'><span>" . $kvv1 . ": </span><span>" . $value . "</span></p>";
                                            }
                                            if ($vt['service']) {
                                                $html .= "<p style='margin:5px 0;border-bottom:1px solid #e1e1e1;'><span>" . $kvv1 . ": </span><span>" . $value . "</span></p>";
                                            }
                                        } else {
                                            $html .= "<p style='margin:5px 0;border-bottom:1px solid #e1e1e1;'><br/><span>" . $kvv1 . ":</span><span>" . $value . "</span></p>";
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                if ($v['request']) {
                    foreach ($detec[$k]['request'] as $kr => $vr) {
                        if ($kr == 0) {
                            $html .= "<br/>";
                        }
                        foreach ($vr as $krk => $vrv) {
                            $html .= "<div><span>" . $requestname_val[$krk] . ": </span><span>" . htmlentities(str_replace(array("\r\n", "\n", "\r"), '<br/>', $vrv), ENT_QUOTES) . "</span></div>";
                        }
                        $html .= '<br/>';
                    }
                }

                if (trim($v['dinfo']) != null) {
                    $html .= "<p style='margin:5px 0;border-bottom:1px solid #e1e1e1;'>";
                    if ($v['request'] == null && $v['steps'] == null) {
                        $html .= "检测记录：<br/>";
                    }

                    $html .= "<span>描述:</span><span>" . str_replace(array("\r\n", "\n", "\r"), '<br/>', $v['dinfo']) . "</span>";
                }
            }
            $html .= "</span></p></div><div><p style='margin:5px 0;'>检测结果：<span>";
            if ($v['result'] == 1) {
                $html .= '<font color="#10CA19">' . $v['resultname'] . '</font>';
            } elseif ($v['result'] == 2) {
                $html .= '<font color="orange">' . $v['resultname'] . '</font>';
            } elseif ($v['result'] == 3) {
                $html .= '<font color="#F5470A">' . $v['resultname'] . '</font>';
            } else {
                $html .= '<font color="red">' . $v['resultname'] . '</font>';
            }
            $html .= "</span></p></div>";
            if (trim($detec[$k]['info'], ' ') != null) {
                $html .= "<div><p style='margin:5px 0;border-bottom:1px solid #e1e1e1;'>检测详情：<span>" . $v['info'] . "</span></p></div>";
            }
            if ($v['result'] != 1 && $v['suggest'] != null) {
                $html .= "<div><p style='margin:5px 0;border-bottom:1px solid #e1e1e1;'>修复建议：<span>" . $v['suggest'] . "</span></p></div>";
            }
            $html .= "</div><br/><br/>";
        }
        // echo $html;
        $mpdf->WriteHTML($html);
        $name = $info['package'] . strtotime($info['subtime']) . '.pdf';
        $mpdf->Output($name, 'D');
        // $mpdf->Output();
        exit;
    }

    function WordMakes($content, $absolutePath = "", $isEraseLink = true) {
        import("Org.Util.Wordmaker");
        //  vendor('Wordmaker');
        $mht = new \Wordmaker();
        if ($isEraseLink) {
            $content = preg_replace('/<a\s*.*?\s*>(\s*.*?\s*)<\/a>/i', '$1', $content);   //去掉链接
        }
        $images = array();
        $files = array();
        $matches = array();
        //这个算法要求src后的属性值必须使用引号括起来
        if (preg_match_all('/<img[.\n]*?src\s*?=\s*?[\"\'](.*?)[\"\'](.*?)\/>/i', $content, $matches)) {
            $arrPath = $matches[1];
            for ($i = 0; $i < count($arrPath); $i++) {
                $path = $arrPath[$i];
                $imgPath = trim($path);
                if ($imgPath != "") {
                    $files[] = $imgPath;
                    if (substr($imgPath, 0, 7) == 'http://') {
                        //绝对链接，不加前缀
                    } else {
                        $imgPath = $absolutePath . $imgPath;
                    }
                    $images[] = $imgPath;
                }
            }
        }
        $mht->AddContents("tmp.html", $mht->GetMimeType("tmp.html"), $content);
        for ($i = 0; $i < count($images); $i++) {
            $image = $images[$i];
            if (@fopen($image, 'r')) {
                $imgcontent = @file_get_contents($image);
                if ($content)
                    $mht->AddContents($files[$i], $mht->GetMimeType($image), $imgcontent);
            }
            else {
                echo "file:" . $image . " not exist!<br />";
            }
        }
        return $mht->GetFile();
    }
    public function ww(){
        $appid = I('get.appid');
        $html = '
                 <html xmlns="http://www.w3.org/1999/xhtml">
                 <head>
                 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
              


                 <title>微众源代码安全检测系统</title>
                         <style type="text/css">
                         html,body{
                                 margin: 0;
                                 padding: 0;
                                
                         }
                         .a5-container{
                                 width: 875px;
                                 margin:  30px auto;
                                 background-color: #ffffff;
                                 height: auto;
                                 color: #454545;
                                 padding: 30px;
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
                         h4{
                         height:50px;
                         
                         }
                         span{
                       
                          font-size:24px;
                         }
                        #titl{
                            background-color: #5CACEE;
                            color: #ffffff;
                            padding:0px;
                            margin:0px;
                            height:50px;
                            
                            line-height:50px;
                         }
                         .table tr .count{
                                 background-color: #2196F3;
                                 color: #ffffff;
                         }
                         .report-detail{
                                 border: 0px solid #e1e1e1;
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
                        .tr{
                               padding:10px 0; 
                        }
                        .table{
                           
                            width: 100%;
                            max-width: 100%;
                            margin-bottom: 20px;
                            border: 1px solid #ddd;
                        }
                        .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
                            padding: 8px;
                            line-height: 1.42857143;
                            vertical-align: top;
                            border-top: 1px solid #ddd;
                            word-break: break-all;
                        }
                        table{
                         
                            border-spacing: 0;
                            border-collapse: collapse;
                        }
                        .clearfix{
                            display:block;
                            clear:both;
                        }
                         
                 </style>
                 </head>
                 <body>';
       // $appid = 1139;
        $det = M('detection');
        $appinfo = D('Appinfo');
        $info = $appinfo->where(array('appid' => $appid))->find();
        $count = $det->where(array('appid' => $appid))->count();
        $hcount = $det->where(array('appid' => $appid, 'result' => 'high'))->count();
        $midcount = $det->where(array('result' => 'medium', 'appid' => $appid))->count();
       
        $shu = $det->where(array('appid' => $appid))->find();
        
        $listcount = $det->group('testtype')->where(array('appid' => $appid))->select();
        $leicount =count($listcount);
     
        $html.='<div class="a4-container">           
                         <h1 class="text-center" style="color:#147efb;text-align:center;font-size:40px;">' . $info['name'] . '项目</h1>
                         <h3 class="text-center" style="text-align:center;">源代码检测报告</h3>
                         <p class="text-center" style="text-align:center;">' . $info['subtime'] . '</p> 
                             <div class="bottom-line"></div>

                                 <p>检测工具：Fortify</p>';
//
//          $mpdf->writeHTML($html);
//          $mpdf->AddPage();
//          
//       
            
        
        $html .='

                                 <div class="report-content">
                                         <div class="report-group">
                                                 <div class="title">
                                                         <h3>摘要</h3>
                                                         <div class="clearfix"></div>
                                                         <p>本报告为开发人员提供源代码扫描细节和信息理解和解决源代码审计过程中发现的风险。本报告的读者主要是项目经理和开发人员。本节提供的分析过程中发现的风险进行了概述。</p>
                                                 </div>
                                                  <table class="table table-bordered" border="1">
                                                
                                                         <tbody>
                                                                 <tr>
                                                                         <td>项目名</td>
                                                                         <td>' . $info['name'] . '</td>
                                                                         <td>检测工具</td>
                                                                         <td>Fortify(16.10.0095 )</td>
                                                                 </tr>
                                                                 <tr>
                                                                         <td>软件版本</td>
                                                                         <td>' . $info['version'] . '</td>
                                                                         <td>风险库版本</td>
                                                                         <td>16.10.0095</td>
                                                                 </tr>
                                                                  <tr>
                                                                         <td>编译环境</td>
                                                                         <td>' .$info['env'] . '</td>
                                                                         <td>代码语言</td>
                                                                         <td>' . $info['lang'] . '</td>
                                                                 </tr>
                                                                  <tr>
                                                                         <td>压缩包MD5</td>
                                                                         <td>' .$info['md5'] . '</td>
                                                                         <td>预编译命令</td>
                                                                         <td>' . $info['shell'] . '</td>
                                                                 </tr>
                                                                  <tr>
                                                                         <td>提交时间</td>
                                                                         <td>' .$info['subtime']. '</td>
                                                                         <td>测试用时</td>
                                                                         <td>' . $info['spendtime'] . '</td>
                                                                 </tr>
                                                                 <tr>
                                                                         <td>风险种类个数</td>
                                                                         <td>' . $leicount . '</td>
                                                                         <td>中危风险个数</td>
                                                                         <td>' . $midcount . '</td>
                                                                 </tr>
                                                                 <tr>
                                                                         <td>总风险个数</td>
                                                                         <td>' . $count . '</td>
                                                                         <td>高危风险个数</td>
                                                                         <td>'. $hcount . '</td>
                                                                 </tr>
                                                         </tbody>
                                                 </table>
                                         </div>

                                         <div class="bottom-line"></div>';
//                           <div style="padding-left:60px;" >   <img src="' . __ROOT__ . '/Uploads/example/one.png" hight="250px" width="460px" ></div>
                                          
                            if($shu){
                                   $html .='
                                             <div style="padding-left:60px;">    <img src="' . __ROOT__ . '/Uploads/example/two.png "   hight="100px" width="460px"></div>
                                             <div style="padding-left:60px;">      <img src="' . __ROOT__ . '/Uploads/example/three.png "  hight="100px" width="460px"></div>';
//                                            $mpdf->writeHTML($html);
//                                            $mpdf->AddPage();
                                     $html .=' <div class="report-group">
                                                 <div class="title">
                                                         <h3>风险汇总</h3>
                                                         <div class="clearfix"></div>
                                                 </div>

                                                 <div class="chart-img" >


                                              <div style="padding-left:60px;">      <img src="' . __ROOT__ . '/Uploads/example/f.png "  hight="100px" width="560px"></div>

                                                 </div>
                                                  <p></p>
                                                 <table class="table table-bordered" border="1">
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
                                                                     <tbody>';
            $risk = array(array('eq','critical'),array('eq','high'),'or');                         
           $lists = $det->field('testtype')->group('testtype')->where(array('appid' => $appid,'result'=>$risk))->select();                        
        foreach ($lists as $ke => $v) {
            $listb = $v['testtype'];
            $crib = $det->where(array('appid' => $appid, 'testtype' => $v['testtype'], 'result' => 'critical'))->count();
            $hib = $det->where(array('appid' => $appid, 'testtype' => $v['testtype'], 'result' => 'high'))->count();
            $medb = $det->where(array('appid' => $appid, 'testtype' => $v['testtype'], 'result' => 'medium'))->count();
            $lowb = $det->where(array('appid' => $appid, 'testtype' => $v['testtype'], 'result' => 'low'))->count();
            $sumcount = $hib + $medb + $lowb+$crib;
            $html .='<tr>
                                                                         <td>' . $listb . '</td>
                                                                         <td>' . $crib . '</td>
                                                                         <td>' . $hib . '</td>
                                                                         <td>' . $medb . '</td>
                                                                         <td>' . $lowb . '</td>
                                                                         <td>' . $sumcount . '</td>
                                                                 </tr>';
        }

        $html.=' </tbody>
                                                 </table>
                                         </div>

                                         <div class="bottom-line"></div>

                                         <div class="report-group">
                                         <h2 class="text-center">风险详情</h2>';

        $det = M('detection');

        $listdet = $det->group('testtype')->where(array('appid' => $appid,'result'=>$risk))->select();
   //dump($listdet);die;
        foreach ($listdet as $kv => $vl) {
            // $mone['id'] = $vl['id'];
            $testtype = $vl['testtype'];
            $count = $det->where(array('appid' => $appid, 'testtype' => $vl['testtype']))->count();
            $children = $det->where(array('at_detection.appid' => $appid, 'at_detection.testtype' => $vl['testtype'],'at_detection.result'=>$risk))->field('at_detection.id,at_detection.scaid,at_detection.appid,at_detection.testname,at_detection.testtype,at_detection.result,at_detection.info,at_resulttype.zhresult')->join('left join at_resulttype on at_resulttype.result=at_detection.result')->select();
             $cribb = $det->where(array('appid' => $appid, 'testtype' => $vl['testtype'], 'result' => 'critical'))->count();
            $hibb = $det->where(array('appid' => $appid, 'testtype' => $vl['testtype'], 'result' => 'high'))->count();
            $medbb = $det->where(array('appid' => $appid, 'testtype' => $vl['testtype'], 'result' => 'medium'))->count();
            $lowbb = $det->where(array('appid' => $appid, 'testtype' => $vl['testtype'], 'result' => 'low'))->count();
            $sumcountb = $hibb + $medbb + $lowbb+$cribb;
            $data = $det->field('at_detection.id as id,at_detection.scaid as scaid,at_detectype.zhtesttype,at_detectype.damage as damage,at_detectype.suggest as suggest,at_detection.appid as appid,at_detection.testtype as testtype,at_detection.info as info')->where(array('at_detection.id' =>  $vl['id']))->join('left join at_detectype on at_detectype.testtype = at_detection.testtype')->find();
  
            $k = $kv + 1;

    // dump($testtype);
    // dump($children);die;

            $html .= '    <h3>第' . $k . '类：' . $testtype . '（' . $count . '个风险）</h3>
                              <h3>中文名：'.$data['zhtesttype'].'</h3>
                                                 <div class="title">
                                                         <h3>风险解释</h3>
                                                         <div class="clearfix"></div>
                                                         <p>'.$data['damage'].'</p>
                                                 </div>
                                                 <div class="title">
                                                         <h3>修复建议</h3>
                                                         <div class="clearfix"></div>
                                                         <p>'.$data['suggest'].'</p>
                                                 </div>

                                                 <div class="title">
                                                         <h3>概要</h3>
                                                         <div class="clearfix"></div>
                                                 </div>
                                                 <table class="table table-bordered" border="1">
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
                                                                 <tr>';
            $html.='<td>' . $testtype . '</td>
                                                               <td>' . $cribb . '</td>
                                                               <td>' . $hibb . '</td>
                                                               <td>' . $medbb . '</td>
                                                               <td>' . $lowbb . '</td>
                                                               <td>' . $sumcountb . '</td>';

            $html .='</tr>

                                                         </tbody>
                                                 </table>

                                                 <div class="title">
                                                         <h3>详情</h3>
                                                         <div class="clearfix"></div>
                                                 </div>
                                               
                                                

              

                                                 <div class="report-detail">';
            


            foreach ($children as $ks => $vs) {

                $k = $ks + 1;

                $html .='  
                          <table class="table table-bordered">
					<thead>
						<tr>
							<th style="background:#5CACEE;text-align:left;color:#ffffff;font-size:20px;width:90%;" >' . $k . ':' .explode(")",$vs['info'] , -1)[0] . ")" . '</th>';
					
                                          if ($vs['zhresult'] == '严重') {
                                                $html.= '<th class="cridanger-1" style="width:10%">严重</th>';
                                            } 
                                            else if ($vs['zhresult'] == '高危') {
                                                $html.= '<th class="danger-1" style="width:10%">高危</th>';
                                            } else if ($vs['zhresult'] == '中危') {
                                                $html.= ' <th class="warning-1" style="width:10%">中危</th>';
                                            } else if ($vs['zhresult'] == '低危') {
                                                $html.= ' <th class="normal-1" style="width:10%">低危</th>';
                                            }
                               $html .='
							
						</tr>
                                            
                                          </thead>
                                        
                                         <thead> 
                                              <tr style="background:#ccc;text-align:left" >
							<th style="height:30px;">代码位置</th>
							<th></th>
							
						</tr>
					</thead>     
					<tbody >';
                             //  $in = $vs['info'];
                           //  $u = explode("----",$vs['info'] , -1)[0];
                              $u = strip_tags($vs['info']);
                             $u =htmlspecialchars($u);
//                             $u = str_replace("\r", "<br>", $u);
                             $u = str_replace("\n", "<br>", $u);
                             $u = str_replace("\t", "&nbsp;&nbsp;", $u);
                             $u = str_replace("  ", "&nbsp;", $u);
                            // $u = str_replace(" ", "&nbsp;", $u);
                            $u =  str_replace("\r\n", '<br>', $u);
                          
                           
                         //   $str = str_replace('  ',"<br>",$in);
                      //  echo $u; die;
                   
				$html .='	<tr  >
							<td class="trs" >'.$u.'</td>
							<td></td>
						</tr >';
                                 
                             
				$html .='</tbody>
				</table>  <p>&nbsp;</p>';   
//                                break;
                                
                      
                    
                    
            }
            $html .= '</div>';
        }



        $html .='    </div>';
        
   } else {
            $html .= '<p style="font-size:20px;text-align:center">没有其他数据了</p>';
        }

        
         $html .='          </div>

                     </div>
                 </body>
                 </html>
            ';
          
         
       
        echo $html;die;  
     downloadWord($html, '检测报告.doc');
        
    
    }

    public function word($appid) {
       
       // $this->one($appid);
        $this->two($appid);
        $this->three($appid);
        $this->four($appid);

        $this->ww($appid);
        // downloadWord($data,'abc.doc');
    }
    
    public function rewo($appid) {

        $det = M('detection');
        $appinfo = D('Appinfo');
     
       // $appid = 1139;
     
        $lists = $det->field('testtype')->group('testtype')->where(array('appid' => $appid))->select();
         $info = $appinfo->where(array('appid' => $appid))->find();
        $count = $det->where(array('appid' => $appid))->count();
        $hcount = $det->where(array('appid' => $appid, 'result' => 'high'))->count();
        $midcount = $det->where(array('result' => 'medium', 'appid' => $appid))->count();
        $lists = $det->field('testtype')->group('testtype')->where(array('appid' => $appid))->select();
        $shu = $det->where(array('appid' => $appid))->find();
        
        $listcount = $det->group('testtype')->where(array('appid' => $appid))->select();
        $leicount =count($listcount);
        // dump($filecount);
        //   dump($info);die;
        $data = '
            <html>
            <head>
             <script src="'.__ROOT__.'/public/js/jquery-1.9.1.min.js"></script>
             <script src="'.__ROOT__.'/public/js/echarts.min.js"></script>
            <script src="'.__ROOT__.'/public/js/loaddata.js"></script>

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
                    #titl{
                            background-color: #5CACEE;
                            color: #ffffff;
                            padding:0px;
                            margin:0px;
                            height:40px;

                            line-height:40px;
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
                            padding: 0 1px;
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
                       .tr{
                               padding:10px 0; 
                          }
                         .trs{
                               padding:10px 0; 
                             
                          }
                          .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
                            padding: 8px;
                            line-height: 1.42857143;
                            vertical-align: top;
                            border-top: 1px solid #ddd;
                            word-break: break-all;
                        }
                        #tab{
                               margin: 0px 0px;
                         }

                    </style>
            </head>
           <body>';
         
                  

        $data .= '<div class="a4-container">
                <h1 class="text-center" style="color:#147efb;text-align:center">' . $info['name'] . '项目</h1>
                <h3 class="text-center" style="text-align:center;">源代码检测报告</h3>
                <p class="text-center" style="text-align:center;">' . $info['subtime'] . '</p>';


        $data .= '<div class="bottom-line"></div>

		<p>检测工具：Fortify</p>

		<div class="report-content">
			<div class="report-group">
				<div class="title">
					<h3>摘要</h3>
					<div class="clearfix"></div>
					<p>本报告为开发人员提供源代码扫描细节和信息理解和解决源代码审计过程中发现的风险。本报告的读者主要是项目经理和开发人员。本节提供的分析过程中发现的风险进行了概述。</p>
				</div>
				<table class="table table-bordered" border="1px" cellspacing="0" style="border-collapse:collapse;border:1px solid #e1e1e1;width:100%;margin:10px auto;">
					  <tbody>
                                                                 <tr>
                                                                         <td>项目名</td>
                                                                         <td>' . $info['name'] . '</td>
                                                                         <td>检测工具</td>
                                                                         <td>Fortify(16.10.0095 )</td>
                                                                 </tr>
                                                                 <tr>
                                                                         <td>软件版本</td>
                                                                         <td>' . $info['version'] . '</td>
                                                                         <td>风险库版本</td>
                                                                         <td>16.10.0095</td>
                                                                 </tr>
                                                                  <tr>
                                                                         <td>编译环境</td>
                                                                         <td>' .$info['env'] . '</td>
                                                                         <td>代码语言</td>
                                                                         <td>' . $info['lang'] . '</td>
                                                                 </tr>
                                                                  <tr>
                                                                         <td>压缩包MD5</td>
                                                                         <td>' .$info['md5'] . '</td>
                                                                         <td>预编译命令</td>
                                                                         <td>' . $info['shell'] . '</td>
                                                                 </tr>
                                                                  <tr>
                                                                         <td>提交时间</td>
                                                                         <td>' .$info['subtime']. '</td>
                                                                         <td>测试用时</td>
                                                                         <td>' . $info['spendtime'] . '</td>
                                                                 </tr>
                                                                 <tr>
                                                                         <td>风险种类个数</td>
                                                                         <td>' . $leicount . '</td>
                                                                         <td>中危风险个数</td>
                                                                         <td>' . $midcount . '</td>
                                                                 </tr>
                                                                 <tr>
                                                                         <td>总风险个数</td>
                                                                         <td>' . $count . '</td>
                                                                         <td>高危风险个数</td>
                                                                         <td>'. $hcount . '</td>
                                                                 </tr>
                                                         </tbody>
				</table>
			</div>

			<div class="bottom-line"></div>';


        if ($shu) {

            // $data .= "<div style='align:center;padding-left:150px'><img src='http://" . $_SERVER['SERVER_ADDR'] . __ROOT__ . '/' . UPLOAD_PATH . 'example/one.png' . "'  hight='460px' width='660px'></div>";

            $data .= "<div style='align:center;'><img src='http://" . $_SERVER['SERVER_ADDR'] . __ROOT__ . '/' . UPLOAD_PATH . 'example/two.png' . "' width='660px' hight='400px;'></div>";
            $data .= "<div style='align:center;padding-left:50px'><img src='http://" . $_SERVER['SERVER_ADDR'] . __ROOT__ . '/' . UPLOAD_PATH . 'example/three.png' . "' hight='400px' width='660px' ></div>";

            $data .= '<div class="report-group">
				<div class="title">
					<h3>风险汇总</h3>
					<div class="clearfix"></div>
				</div>

				<div class="chart-img">';
//                       $data .='图表图片  <div style="align:center;">   <img src="http://'.$_SERVER['SERVER_ADDR'].__ROOT__.'/Uploads/example/20160717one.png" hight="500px" width="60px" ></div>;
//                                <div style="align:center;">   <img src="'.$_SERVER['SERVER_ADDR'].__ROOT__.'/Uploads/example/20160717two.png "   hight="100px" width="560px"></div>;
//                                 <div style="align:center;">      <img src="'.$_SERVER['SERVER_ADDR'].__ROOT__.'/Uploads/example/20160717three.png "  hight="100px" width="660px"></div>;
//                                  <div style="align:center;">      <img src="'.$_SERVER['SERVER_ADDR'].__ROOT__.'/Uploads/example/20160717f.png "  hight="100px" width="860px"></div>;';
            //  $data .= '<div ><img src= "$_SERVER["SERVER_ADDR"].__ROOT__.''.UPLOAD_PATH.'example/20160717two.png'. " " width="360px"></div>';               
          
            $data .= "<div style=''><img src='http://" . $_SERVER['SERVER_ADDR'] . __ROOT__ . '/' . UPLOAD_PATH . 'example/f.png' . "'  hight='200px' width='660px'></div>";


            $data .='        </div>';

            $data .='<table class="table table-bordered" border="1px" cellspacing="0" style="border-collapse:collapse;border:1px solid #e1e1e1;width:100%;margin:10px auto;">
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
					<tbody>';

            foreach ($lists as $ke => $v) {
                $listb = $v['testtype'];
                $crib = $det->where(array('appid' => $appid, 'testtype' => $v['testtype'], 'result' => 'critical'))->count();
                $hib = $det->where(array('appid' => $appid, 'testtype' => $v['testtype'], 'result' => 'high'))->count();
                $medb = $det->where(array('appid' => $appid, 'testtype' => $v['testtype'], 'result' => 'medium'))->count();
                $lowb = $det->where(array('appid' => $appid, 'testtype' => $v['testtype'], 'result' => 'low'))->count();
                $sumcount = $hib + $medb + $lowb+$crib;
            
                $data .='<tr>
							<td>' . $listb . '</td>
                                                        <td>' . $crib . '</td>
							<td>' . $hib . '</td>
							<td>' . $medb . '</td>
							<td>' . $lowb . '</td>
							<td>' . $sumcount . '</td>
						</tr>';
            }
            $data .='</tbody>
				</table>
			</div>

			<div class="bottom-line"></div>';

            $data .='<div class="report-group">
		 		<h2 class="text-center">风险详情</h2>';

            $det = M('detection');
            $listdet = $det->group('testtype')->where(array('appid' => $appid))->select();

            foreach ($listdet as $kv => $vl) {
                // $mone['id'] = $vl['id'];
                $testtype = $vl['testtype'];
                $count = $det->where(array('appid' => $appid, 'testtype' => $vl['testtype']))->count();
                $children = $det->where(array('at_detection.appid' => $appid, 'at_detection.testtype' => $vl['testtype']))->field('at_detection.id,at_detection.scaid,at_detection.appid,at_detection.testname,at_detection.testtype,at_detection.result,at_detection.info,at_resulttype.zhresult')->join('left join at_resulttype on at_resulttype.result=at_detection.result')->select();
                $cribb = $det->where(array('appid' => $appid, 'testtype' => $vl['testtype'], 'result' => 'critical'))->count();
                $hibb = $det->where(array('appid' => $appid, 'testtype' => $vl['testtype'], 'result' => 'high'))->count();
                $medbb = $det->where(array('appid' => $appid, 'testtype' => $vl['testtype'], 'result' => 'medium'))->count();
                $lowbb = $det->where(array('appid' => $appid, 'testtype' => $vl['testtype'], 'result' => 'low'))->count();
                $sumcountb =$cribb + $hibb + $medbb + $lowbb;
                $datalist = $det->field('at_detection.id as id,at_detection.scaid as scaid,at_detectype.zhtesttype,at_detectype.damage as damage,at_detectype.suggest as suggest,at_detection.appid as appid,at_detection.testtype as testtype,at_detection.info as info')->where(array('at_detection.id' =>  $vl['id']))->join('left join at_detectype on at_detectype.testtype = at_detection.testtype')->find();
  
                $k = $kv + 1;

                $data.='<h3>第' . $k . '类：' . $testtype . '（' . $count . '个风险）</h3>
                        <h3>中文名：'.$datalist['zhtesttype'].'</h3>
				<div class="title">
					<h3>风险解释</h3>
					<div class="clearfix"></div>
					<p>'.$datalist['damage'].'</p>
				</div>
                                <div class="title">
					<h3>修复建议</h3>
					<div class="clearfix"></div>
					<p>'.$datalist['suggest'].'</p>
				</div>

				<div class="title">
                               
					<h3>概要</h3>
					<div class="clearfix"></div>
				</div>
				<table class="table table-bordered" border="1px" cellspacing="0" style="border-collapse:collapse;border:1px solid #e1e1e1;width:100%;margin:10px auto;">
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
						<tr>';

                //  dump($testtype);
                $data.='<td>' . $testtype . '</td>
                                                       <td>' . $cribb . '</td>
							<td>' . $hibb . '</td>
							<td>' . $medbb . '</td>
							<td>' . $lowbb . '</td>
							<td>' . $sumcountb . '</td>';
                //       }
                $data .='</tr>
					</tbody>
				</table>

				<div class="title">
					<h3>详情</h3>
					<div class="clearfix"></div>
				</div>';

                $data .='<div class="report-detail">';

//             <thead>
//                                                <tr style="background:#cccccc; ">
//							<th style="height:40px;width:88%;">风险描述</th>
//							<th style="width:12%;"></th>
//							
//						</tr>
//                                          </thead>
//                                          <tbody>
//						
//                                                <tr >
//							
//							<td  class="tr"> &nbsp;</td>
//							
//						</tr>
//						
//						
//					  </tbody>     
                //  dump($testtype);
                foreach ($children as $ks => $vs) {
                    //   dump($vs);
                    $k = $ks + 1;

                    $data.= ' <div class="detail-header">
                              <table class="table table-bordered" width="100%">
					<thead>
						<tr>
							<th style="background:#5CACEE;text-align:left;color:#ffffff;font-size:18px;width:88%;height:35px;" >' . $k . ':'.explode(")",$vs['info'] , -1)[0] . ")" .  '</th>';
					     if ($vs['zhresult'] == '严重') {
                                                $data.= '<th class="cridanger-1" style="width:12%">严重</th>';
                                            }
                                            elseif ($vs['zhresult'] == '高危') {
                                                $data.= '<th class="danger-1" style="width:12%">高危</th>';
                                            } else if ($vs['zhresult'] == '中危') {
                                                $data.= ' <th class="warning-1" style="width:12%">中危</th>';
                                            } else if ($vs['zhresult'] == '低危') {
                                                $data.= ' <th class="normal-1" style="width:12%">低危</th>';
                                            }
                               $data .='
							
						</tr>
                                           </thead>
                                         
                                         <thead> 
                                              <tr style="background:#ccc;text-align:left" >
							<th style="height:25px;">代码位置</th>
							<th></th>
							
						</tr>
					</thead>     
					<tbody >';
                               		
                              $u = strip_tags($vs['info']);
                           //  $u = explode("----",$vs['info'] , -1)[0];
                             //  $u = strip_tags($u); 
                            $u =htmlspecialchars($u);
//                             $u = str_replace("\r", "<br>", $u);
                             $u = str_replace("\n", "<br>", $u);
                             $u = str_replace("\t", "&nbsp;&nbsp;", $u);
                            // $u = str_replace("  ", "&nbsp;", $u);
                            // $u = str_replace(" ", "&nbsp;", $u);
                            $u =  str_replace("", '<br>', $u);
                            $u =  str_replace("\r\n", '<br>', $u);
                               
				$data .='	<tr  >
							<td class="trs">'.$u.'</td>
							<td></td>
						</tr >
                                                
						
						
					</tbody>
				</table> </div><span style="background:red;maign:0;padding:0;height:1px;"></span> '; 
                }
            }


            $data .= '  </div>';
            $datat .=' </div>';
        } else {
            $data .= '<p style="font-size:20px;text-align:center">没有其他数据了</p>';
        }


        $data .= '</div>';

        $data .= '  </div>
            </body>
            </html>';
       
        //echo $data;die;  
     downloadWord($data, '检测报告.doc');
        
    }

 

    public function pdf($appid,$risk) {

        $det = M('detection');
        $appinfo = D('Appinfo');
        //  $appid = I('get.appid');
       // $appid = 1139;
     
       // $this->one($appid);
        $this->two($appid);
        $this->three($appid);
        $this->four($appid);
        $this->repdfs($appid,$risk);
    }

   
    
     public function repdf($appid) {
        
        Vendor('mpdf60.mpdf');
        //设置中文编码
        $mpdf = new \mPDF('zh-CN', 'A4', 0, '宋体');
        $mpdf->useAdobeCJK = true; //打开这个选项比较好
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->SetWatermarkText($marktext);
        $mpdf->showWatermarkText = true;
        $html = '
                 <html xmlns="http://www.w3.org/1999/xhtml">
                 <head>
                 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
              


                 <title>微众源代码安全检测系统</title>
                         <style type="text/css">
                         html,body{
                                 margin: 0;
                                 padding: 0;
                                
                         }
                         .a5-container{
                                 width: 875px;
                                 margin:  30px auto;
                                 background-color: #ffffff;
                                 height: auto;
                                 color: #454545;
                                 padding: 30px;
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
                         h4{
                         height:50px;
                         
                         }
                         span{
                       
                          font-size:24px;
                         }
                        #titl{
                            background-color: #5CACEE;
                            color: #ffffff;
                            padding:0px;
                            margin:0px;
                            height:50px;
                            
                            line-height:50px;
                         }
                         .table tr .count{
                                 background-color: #2196F3;
                                 color: #ffffff;
                         }
                         .report-detail{
                                 border: 0px solid #e1e1e1;
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
                        .tr{
                               padding:10px 0; 
                        }
                        .table{
                           
                            width: 100%;
                            max-width: 100%;
                            margin-bottom: 20px;
                            border: 1px solid #ddd;
                        }
                        .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
                            padding: 8px;
                            line-height: 1.42857143;
                            vertical-align: top;
                            border-top: 1px solid #ddd;
                            word-break: break-all;
                        }
                        table{
                         
                            border-spacing: 0;
                            border-collapse: collapse;
                        }
                        .clearfix{
                            display:block;
                            clear:both;
                        }
                         
                 </style>
                 </head>
                 <body>';
       // $appid = 1139;
        $det = M('detection');
        $appinfo = D('Appinfo');
        $info = $appinfo->where(array('appid' => $appid))->find();
        $count = $det->where(array('appid' => $appid))->count();
        $hcount = $det->where(array('appid' => $appid, 'result' => 'high'))->count();
        $midcount = $det->where(array('result' => 'medium', 'appid' => $appid))->count();
        $lists = $det->field('testtype')->group('testtype')->where(array('appid' => $appid))->select();
        $shu = $det->where(array('appid' => $appid))->find();
        
        $listcount = $det->group('testtype')->where(array('appid' => $appid))->select();
        $leicount =count($listcount);
     
        $html.='<div class="a4-container">           
                         <h1 class="text-center" style="color:#147efb;text-align:center;font-size:40px;">' . $info['name'] . '项目</h1>
                         <h3 class="text-center" style="text-align:center;">源代码检测报告</h3>
                         <p class="text-center" style="text-align:center;">' . $info['subtime'] . '</p> 
                             <div class="bottom-line"></div>

                                 <p>检测工具：Fortify</p>';

          $mpdf->writeHTML($html);
          $mpdf->AddPage();
          
      
            
        
        $html ='

                                 <div class="report-content">
                                         <div class="report-group">
                                                 <div class="title">
                                                         <h3>摘要</h3>
                                                         <div class="clearfix"></div>
                                                         <p>本报告为开发人员提供源代码扫描细节和信息理解和解决源代码审计过程中发现的风险。本报告的读者主要是项目经理和开发人员。本节提供的分析过程中发现的风险进行了概述。</p>
                                                 </div>
                                                  <table class="table table-bordered" border="1">
                                                
                                                         <tbody>
                                                                 <tr>
                                                                         <td>项目名</td>
                                                                         <td>' . $info['name'] . '</td>
                                                                         <td>检测工具</td>
                                                                         <td>Fortify(16.10.0095 )</td>
                                                                 </tr>
                                                                 <tr>
                                                                         <td>软件版本</td>
                                                                         <td>' . $info['version'] . '</td>
                                                                         <td>风险库版本</td>
                                                                         <td>16.10.0095</td>
                                                                 </tr>
                                                                  <tr>
                                                                         <td>编译环境</td>
                                                                         <td>' .$info['env'] . '</td>
                                                                         <td>代码语言</td>
                                                                         <td>' . $info['lang'] . '</td>
                                                                 </tr>
                                                                  <tr>
                                                                         <td>压缩包MD5</td>
                                                                         <td>' .$info['md5'] . '</td>
                                                                         <td>预编译命令</td>
                                                                         <td>' . $info['shell'] . '</td>
                                                                 </tr>
                                                                  <tr>
                                                                         <td>提交时间</td>
                                                                         <td>' .$info['subtime']. '</td>
                                                                         <td>测试用时</td>
                                                                         <td>' . $info['spendtime'] . '</td>
                                                                 </tr>
                                                                 <tr>
                                                                         <td>风险种类个数</td>
                                                                         <td>' . $leicount . '</td>
                                                                         <td>中危风险个数</td>
                                                                         <td>' . $midcount . '</td>
                                                                 </tr>
                                                                 <tr>
                                                                         <td>总风险个数</td>
                                                                         <td>' . $count . '</td>
                                                                         <td>高危风险个数</td>
                                                                         <td>'. $hcount . '</td>
                                                                 </tr>
                                                         </tbody>
                                                 </table>
                                         </div>

                                         <div class="bottom-line"></div>';
//                           <div style="padding-left:60px;" >   <img src="' . __ROOT__ . '/Uploads/example/one.png" hight="250px" width="460px" ></div>
                                          
                            if($shu){
                                   $html .='
                                             <div style="padding-left:60px;">    <img src="' . __ROOT__ . '/Uploads/example/two.png "   hight="100px" width="460px"></div>
                                             <div style="padding-left:60px;">      <img src="' . __ROOT__ . '/Uploads/example/three.png "  hight="100px" width="460px"></div>';
//                                            $mpdf->writeHTML($html);
//                                            $mpdf->AddPage();
                                     $html .=' <div class="report-group">
                                                 <div class="title">
                                                         <h3>风险汇总</h3>
                                                         <div class="clearfix"></div>
                                                 </div>

                                                 <div class="chart-img" >


                                              <div style="padding-left:60px;">      <img src="' . __ROOT__ . '/Uploads/example/f.png "  hight="100px" width="560px"></div>

                                                 </div>
                                                  <p></p>
                                                 <table class="table table-bordered" border="1">
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
                                                                     <tbody>';
                                  
        foreach ($lists as $ke => $v) {
            $listb = $v['testtype'];
            $crib = $det->where(array('appid' => $appid, 'testtype' => $v['testtype'], 'result' => 'critical'))->count();
            $hib = $det->where(array('appid' => $appid, 'testtype' => $v['testtype'], 'result' => 'high'))->count();
            $medb = $det->where(array('appid' => $appid, 'testtype' => $v['testtype'], 'result' => 'medium'))->count();
            $lowb = $det->where(array('appid' => $appid, 'testtype' => $v['testtype'], 'result' => 'low'))->count();
            $sumcount = $hib + $medb + $lowb+$crib;
            $html .='<tr>
                                                                         <td>' . $listb . '</td>
                                                                         <td>' . $crib . '</td>
                                                                         <td>' . $hib . '</td>
                                                                         <td>' . $medb . '</td>
                                                                         <td>' . $lowb . '</td>
                                                                         <td>' . $sumcount . '</td>
                                                                 </tr>';
        }

        $html.=' </tbody>
                                                 </table>
                                         </div>

                                         <div class="bottom-line"></div>

                                         <div class="report-group">
                                         <h2 class="text-center">风险详情</h2>';

        $det = M('detection');

        $listdet = $det->group('testtype')->where(array('appid' => $appid))->select();
   //dump($listdet);die;
        foreach ($listdet as $kv => $vl) {
            // $mone['id'] = $vl['id'];
            $testtype = $vl['testtype'];
            $count = $det->where(array('appid' => $appid, 'testtype' => $vl['testtype']))->count();
            $children = $det->where(array('at_detection.appid' => $appid, 'at_detection.testtype' => $vl['testtype']))->field('at_detection.id,at_detection.scaid,at_detection.appid,at_detection.testname,at_detection.testtype,at_detection.result,at_detection.info,at_resulttype.zhresult')->join('left join at_resulttype on at_resulttype.result=at_detection.result')->select();
             $cribb = $det->where(array('appid' => $appid, 'testtype' => $vl['testtype'], 'result' => 'critical'))->count();
            $hibb = $det->where(array('appid' => $appid, 'testtype' => $vl['testtype'], 'result' => 'high'))->count();
            $medbb = $det->where(array('appid' => $appid, 'testtype' => $vl['testtype'], 'result' => 'medium'))->count();
            $lowbb = $det->where(array('appid' => $appid, 'testtype' => $vl['testtype'], 'result' => 'low'))->count();
            $sumcountb = $hibb + $medbb + $lowbb+$cribb;
            $data = $det->field('at_detection.id as id,at_detection.scaid as scaid,at_detectype.zhtesttype,at_detectype.damage as damage,at_detectype.suggest as suggest,at_detection.appid as appid,at_detection.testtype as testtype,at_detection.info as info')->where(array('at_detection.id' =>  $vl['id']))->join('left join at_detectype on at_detectype.testtype = at_detection.testtype')->find();
  
            $k = $kv + 1;

    // dump($testtype);
    // dump($children);die;

            $html .= '    <h3>第' . $k . '类：' . $testtype . '（' . $count . '个风险）</h3>
                              <h3>中文名：'.$data['zhtesttype'].'</h3>
                                                 <div class="title">
                                                         <h3>风险解释</h3>
                                                         <div class="clearfix"></div>
                                                         <p>'.$data['damage'].'</p>
                                                 </div>
                                                 <div class="title">
                                                         <h3>修复建议</h3>
                                                         <div class="clearfix"></div>
                                                         <p>'.$data['suggest'].'</p>
                                                 </div>

                                                 <div class="title">
                                                         <h3>概要</h3>
                                                         <div class="clearfix"></div>
                                                 </div>
                                                 <table class="table table-bordered" border="1">
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
                                                                 <tr>';
            $html.='<td>' . $testtype . '</td>
                                                               <td>' . $cribb . '</td>
                                                               <td>' . $hibb . '</td>
                                                               <td>' . $medbb . '</td>
                                                               <td>' . $lowbb . '</td>
                                                               <td>' . $sumcountb . '</td>';

            $html .='</tr>

                                                         </tbody>
                                                 </table>

                                                 <div class="title">
                                                         <h3>详情</h3>
                                                         <div class="clearfix"></div>
                                                 </div>
                                               
                                                

              

                                                 <div class="report-detail">';
            


            foreach ($children as $ks => $vs) {

                $k = $ks + 1;

                $html .='  
                          <table class="table table-bordered">
					<thead>
						<tr>
							<th style="background:#5CACEE;text-align:left;color:#ffffff;font-size:20px;width:90%;" >' . $k . ':' .explode(")",$vs['info'] , -1)[0] . ")" . '</th>';
					
                                          if ($vs['zhresult'] == '严重') {
                                                $html.= '<th class="cridanger-1" style="width:10%">严重</th>';
                                            } 
                                            else if ($vs['zhresult'] == '高危') {
                                                $html.= '<th class="danger-1" style="width:10%">高危</th>';
                                            } else if ($vs['zhresult'] == '中危') {
                                                $html.= ' <th class="warning-1" style="width:10%">中危</th>';
                                            } else if ($vs['zhresult'] == '低危') {
                                                $html.= ' <th class="normal-1" style="width:10%">低危</th>';
                                            }
                               $html .='
							
						</tr>
                                            
                                          </thead>
                                        
                                         <thead> 
                                              <tr style="background:#ccc;text-align:left" >
							<th style="height:30px;">代码位置</th>
							<th></th>
							
						</tr>
					</thead>     
					<tbody >';
//                               $in = $vs['info'];
//                              substr("Hello world",10)."<br>";
                           //  $u = explode("----",$vs['info'] , -1)[0];
                              $u = strip_tags($vs['info']);
                             $u =htmlspecialchars($u);
//                             $u = str_replace("\r", "<br>", $u);
                             $u = str_replace("\n", "<br>", $u);
                             $u = str_replace("\t", "&nbsp;&nbsp;", $u);
                             $u = str_replace("  ", "&nbsp;", $u);
                            // $u = str_replace(" ", "&nbsp;", $u);
                            $u =  str_replace("\r\n", '<br>', $u);
                            $u =  str_replace("\r\n", '<br>', $u);
                          
                         //   $str = str_replace('  ',"<br>",$in);
                     //   echo $u; die;
                   
				$html .='	<tr  >
							<td class="trs" >'.$u.'</td>
							<td></td>
						</tr >';
                                 
                             
				$html .='</tbody>
				</table>  <p>&nbsp;</p>';   
//                                break;
                                
                      
                    
                    
            }
            $html .= '</div>';
        }



        $html .='    </div>';
        
   } else {
            $html .= '<p style="font-size:20px;text-align:center">没有其他数据了</p>';
        }

        
         $html .='          </div>

                     </div>
                 </body>
                 </html>
            ';
      
       //echo $html;die;
        $mpdf->WriteHTML($html);
         $name = '检测报表'.'.pdf';
         $mpdf->Output($name, 'D');
        // $mpdf->Output();
        exit;
    }
    
    /**
     * 搜索导出pdf
     */
   public function repdfsearch($appid) {
        
        Vendor('mpdf60.mpdf');
        //设置中文编码
        $mpdf = new \mPDF('zh-CN', 'A4', 0, '宋体');
        $mpdf->useAdobeCJK = true; //打开这个选项比较好
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->SetWatermarkText($marktext);
        $mpdf->showWatermarkText = true;
        $html = '
                 <html xmlns="http://www.w3.org/1999/xhtml">
                 <head>
                 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
              


                 <title>微众源代码安全检测系统</title>
                         <style type="text/css">
                         html,body{
                                 margin: 0;
                                 padding: 0;
                                
                         }
                         .a5-container{
                                 width: 875px;
                                 margin:  30px auto;
                                 background-color: #ffffff;
                                 height: auto;
                                 color: #454545;
                                 padding: 30px;
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
                         h4{
                         height:50px;
                         
                         }
                         span{
                       
                          font-size:24px;
                         }
                        #titl{
                            background-color: #5CACEE;
                            color: #ffffff;
                            padding:0px;
                            margin:0px;
                            height:50px;
                            
                            line-height:50px;
                         }
                         .table tr .count{
                                 background-color: #2196F3;
                                 color: #ffffff;
                         }
                         .report-detail{
                                 border: 0px solid #e1e1e1;
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
                        .tr{
                               padding:10px 0; 
                        }
                        .table{
                           
                            width: 100%;
                            max-width: 100%;
                            margin-bottom: 20px;
                            border: 1px solid #ddd;
                        }
                        .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
                            padding: 8px;
                            line-height: 1.42857143;
                            vertical-align: top;
                            border-top: 1px solid #ddd;
                            word-break: break-all;
                        }
                        table{
                         
                            border-spacing: 0;
                            border-collapse: collapse;
                        }
                        .clearfix{
                            display:block;
                            clear:both;
                        }
                         
                 </style>
                 </head>
                 <body>';
       // $appid = 1139;
        $det = M('detection');
        $appinfo = D('Appinfo');
        $info = $appinfo->where(array('appid' => $appid))->find();
        $count = $det->where(array('appid' => $appid))->count();
        $hcount = $det->where(array('appid' => $appid, 'result' => 'high'))->count();
        $midcount = $det->where(array('result' => 'medium', 'appid' => $appid))->count();
       
        $shu = $det->where(array('appid' => $appid))->find();
        
        $listcount = $det->group('testtype')->where(array('appid' => $appid))->select();
        $leicount =count($listcount);
     
        $html.='<div class="a4-container">           
                         <h1 class="text-center" style="color:#147efb;text-align:center;font-size:40px;">' . $info['name'] . '项目</h1>
                         <h3 class="text-center" style="text-align:center;">源代码检测报告</h3>
                         <p class="text-center" style="text-align:center;">' . $info['subtime'] . '</p> 
                             <div class="bottom-line"></div>

                                 <p>检测工具：Fortify</p>';
//
//          $mpdf->writeHTML($html);
//          $mpdf->AddPage();
//          
//       
            
        
        $html .='

                                 <div class="report-content">
                                         <div class="report-group">
                                                 <div class="title">
                                                         <h3>摘要</h3>
                                                         <div class="clearfix"></div>
                                                         <p>本报告为开发人员提供源代码扫描细节和信息理解和解决源代码审计过程中发现的风险。本报告的读者主要是项目经理和开发人员。本节提供的分析过程中发现的风险进行了概述。</p>
                                                 </div>
                                                  <table class="table table-bordered" border="1">
                                                
                                                         <tbody>
                                                                 <tr>
                                                                         <td>项目名</td>
                                                                         <td>' . $info['name'] . '</td>
                                                                         <td>检测工具</td>
                                                                         <td>Fortify(16.10.0095 )</td>
                                                                 </tr>
                                                                 <tr>
                                                                         <td>软件版本</td>
                                                                         <td>' . $info['version'] . '</td>
                                                                         <td>风险库版本</td>
                                                                         <td>16.10.0095</td>
                                                                 </tr>
                                                                  <tr>
                                                                         <td>编译环境</td>
                                                                         <td>' .$info['env'] . '</td>
                                                                         <td>代码语言</td>
                                                                         <td>' . $info['lang'] . '</td>
                                                                 </tr>
                                                                  <tr>
                                                                         <td>压缩包MD5</td>
                                                                         <td>' .$info['md5'] . '</td>
                                                                         <td>预编译命令</td>
                                                                         <td>' . $info['shell'] . '</td>
                                                                 </tr>
                                                                  <tr>
                                                                         <td>提交时间</td>
                                                                         <td>' .$info['subtime']. '</td>
                                                                         <td>测试用时</td>
                                                                         <td>' . $info['spendtime'] . '</td>
                                                                 </tr>
                                                                 <tr>
                                                                         <td>风险种类个数</td>
                                                                         <td>' . $leicount . '</td>
                                                                         <td>中危风险个数</td>
                                                                         <td>' . $midcount . '</td>
                                                                 </tr>
                                                                 <tr>
                                                                         <td>总风险个数</td>
                                                                         <td>' . $count . '</td>
                                                                         <td>高危风险个数</td>
                                                                         <td>'. $hcount . '</td>
                                                                 </tr>
                                                         </tbody>
                                                 </table>
                                         </div>

                                         <div class="bottom-line"></div>';
//                           <div style="padding-left:60px;" >   <img src="' . __ROOT__ . '/Uploads/example/one.png" hight="250px" width="460px" ></div>
                              
//                                             <div style="padding-left:60px;">      <img src="' . __ROOT__ . '/Uploads/example/three.png "  hight="100px" width="460px"></div>            
                            if($shu){
                                   $html .='
                                             <div style="padding-left:60px;">    <img src="' . __ROOT__ . '/Uploads/example/two.png "   hight="100px" width="460px"></div>';
//                                            $mpdf->writeHTML($html);
//                                            $mpdf->AddPage();
                                     $html .=' <div class="report-group">
                                                 <div class="title">
                                                         <h3>风险汇总</h3>
                                                         <div class="clearfix"></div>
                                                 </div>

                                                 <div class="chart-img" >


                                              <div style="padding-left:60px;">      <img src="' . __ROOT__ . '/Uploads/example/f.png "  hight="100px" width="560px"></div>

                                                 </div>
                                                  <p></p>
                                                 <table class="table table-bordered" border="1">
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
                                                                     <tbody>';
       /**
        * 类别的统计
        */
        $lists = $det->field('testtype')->group('testtype')->where(array('appid' => $appid,'result'=>'high'))->select();
        foreach ($lists as $ke => $v) {
            $listb = $v['testtype'];
            $crib = $det->where(array('appid' => $appid, 'testtype' => $v['testtype'], 'result' => 'critical'))->count();
            $hib = $det->where(array('appid' => $appid, 'testtype' => $v['testtype'], 'result' => 'high'))->count();
            $medb = $det->where(array('appid' => $appid, 'testtype' => $v['testtype'], 'result' => 'medium'))->count();
            $lowb = $det->where(array('appid' => $appid, 'testtype' => $v['testtype'], 'result' => 'low'))->count();
            $sumcount = $hib + $medb + $lowb+crib;
            $html .='<tr>
                                                                         <td>' . $listb . '</td>
                                                                         <td>' . $crib . '</td>
                                                                         <td>' . $hib . '</td>
                                                                         <td>' . $medb . '</td>
                                                                         <td>' . $lowb . '</td>
                                                                         <td>' . $sumcount . '</td>
                                                                 </tr>';
        }

        $html.=' </tbody>
                                                 </table>
                                         </div>

                                         <div class="bottom-line"></div>

                                         <div class="report-group">
                                         <h2 class="text-center">风险详情</h2>';

        $det = M('detection');
/**
 * 风险详情
 *  */
        $listdet = $det->group('testtype')->where(array('appid' => $appid,'result'=>'high'))->select();
  // dump($listdet);die;
        foreach ($listdet as $kv => $vl) {
            // $mone['id'] = $vl['id'];
            $testtype = $vl['testtype'];
            $count = $det->where(array('appid' => $appid, 'testtype' => $vl['testtype']))->count();
            $children = $det->where(array('at_detection.appid' => $appid, 'at_detection.testtype' => $vl['testtype'],'at_detection.result'=>'high'))->field('at_detection.id,at_detection.scaid,at_detection.appid,at_detection.testname,at_detection.testtype,at_detection.result,at_detection.info,at_resulttype.zhresult')->join('left join at_resulttype on at_resulttype.result=at_detection.result')->select();
             $cribb = $det->where(array('appid' => $appid, 'testtype' => $vl['testtype'], 'result' => 'critical'))->count();
            $hibb = $det->where(array('appid' => $appid, 'testtype' => $vl['testtype'], 'result' => 'high'))->count();
            $medbb = $det->where(array('appid' => $appid, 'testtype' => $vl['testtype'], 'result' => 'medium'))->count();
            $lowbb = $det->where(array('appid' => $appid, 'testtype' => $vl['testtype'], 'result' => 'low'))->count();
            $sumcountb = $hibb + $medbb + $lowbb;
            $data = $det->field('at_detection.id as id,at_detection.scaid as scaid,at_detectype.zhtesttype,at_detectype.damage as damage,at_detectype.suggest as suggest,at_detection.appid as appid,at_detection.testtype as testtype,at_detection.info as info')->where(array('at_detection.id' =>  $vl['id']))->join('left join at_detectype on at_detectype.testtype = at_detection.testtype')->find();
  
            $k = $kv + 1;

    // dump($testtype);'（' . $count . '个风险）
    // dump($children);die;

            $html .= '    <h3>第' . $k . '类：' . $testtype . '</h3>
                              <h3>中文名：'.$data['zhtesttype'].'</h3>
                                                 <div class="title">
                                                         <h3>风险解释</h3>
                                                         <div class="clearfix"></div>
                                                         <p>'.$data['damage'].'</p>
                                                 </div>
                                                 <div class="title">
                                                         <h3>修复建议</h3>
                                                         <div class="clearfix"></div>
                                                         <p>'.$data['suggest'].'</p>
                                                 </div>

                                                 <div class="title">
                                                         <h3>概要</h3>
                                                         <div class="clearfix"></div>
                                                 </div>
                                                 <table class="table table-bordered" border="1">
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
                                                                 <tr>';
            $html.='<td>' . $testtype . '</td>
                                                               <td>' . $cribb . '</td>
                                                               <td>' . $hibb . '</td>
                                                               <td>' . $medbb . '</td>
                                                               <td>' . $lowbb . '</td>
                                                               <td>' . $sumcountb . '</td>';

            $html .='</tr>

                                                         </tbody>
                                                 </table>

                                                 <div class="title">
                                                         <h3>详情</h3>
                                                         <div class="clearfix"></div>
                                                 </div>
                                               
                                                

              

                                                 <div class="report-detail">';
            


            foreach ($children as $ks => $vs) {

                $k = $ks + 1;

                $html .='  
                          <table class="table table-bordered">
					<thead>
						<tr>
							<th style="background:#5CACEE;text-align:left;color:#ffffff;font-size:20px;width:90%;" >' . $k . ':' .explode(")",$vs['info'] , -1)[0] . ")" . '</th>';
					
                                          if ($vs['zhresult'] == '严重') {
                                                $html.= '<th class="cridanger-1" style="width:10%">严重</th>';
                                            } 
                                            else if ($vs['zhresult'] == '高危') {
                                                $html.= '<th class="danger-1" style="width:10%">高危</th>';
                                            } else if ($vs['zhresult'] == '中危') {
                                                $html.= ' <th class="warning-1" style="width:10%">中危</th>';
                                            } else if ($vs['zhresult'] == '低危') {
                                                $html.= ' <th class="normal-1" style="width:10%">低危</th>';
                                            }
                               $html .='
							
						</tr>
                                            
                                          </thead>
                                        
                                         <thead> 
                                              <tr style="background:#ccc;text-align:left" >
							<th style="height:30px;">代码位置</th>
							<th></th>
							
						</tr>
					</thead>     
					<tbody >';
                              $u = strip_tags($vs['info']);
                           //  $u = explode("----",$vs['info'] , -1)[0];
                             //  $u = strip_tags($u); 
                            $u =htmlspecialchars($u);
//                             $u = str_replace("\r", "<br>", $u);
                             $u = str_replace("\n", "<br>", $u);
                             $u = str_replace("\t", "&nbsp;&nbsp;", $u);
                            // $u = str_replace("  ", "&nbsp;", $u);
                            // $u = str_replace(" ", "&nbsp;", $u);
                            $u =  str_replace("", '<br>', $u);
                            $u =  str_replace("\r\n", '<br>', $u);
                          
                         //   $str = str_replace('  ',"<br>",$in);
                     //   echo $u; die;
                   
				$html .='	<tr  >
							<td class="trs" >'.$u.'</td>
							<td></td>
						</tr >';
                                 
                             
				$html .='</tbody>
				</table>  <p>&nbsp;</p>';   
//                                break;
                                
                      
                    
                    
            }
            $html .= '</div>';
        }



        $html .='    </div>';
        
   } else {
            $html .= '<p style="font-size:20px;text-align:center">没有其他数据了</p>';
        }

        
         $html .='          </div>

                     </div>
                 </body>
                 </html>
            ';
      
     // echo $html;die;
         $mpdf->WriteHTML($html);
         $name = '分类检测报表'.'.pdf';
         $mpdf->Output($name, 'D');
        // $mpdf->Output();
        exit;
    }   
    
    
    public function re(){
         $appid = I('get.appid');
        // dump($appid);die;
        $this->makePdfReport($appid);
    }
    
    public function report(){
       // dump($_POST);die;
        $appid = I('post.appid');
        $risk = I('post.risk');
         $this->pdf($appid,$risk);
      //  $lei = I('post.lei');
//        if($lei == 'word'){
//            $this->word($appid);
//        }else if($lei == 'pdf'){
//            $this->pdf($appid);
//           // $this->makePdfReport($appid);
//        }
     
    }
    
    
  public  function makePdfReport(){
               $appid = I('get.appid');
               ini_set('max_execution_time', '0');
               ini_set('memory_limit','528M');
               set_time_limit(180000) ;
		Vendor('tcpdf.tcpdf');
                
		$pdf = new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		// set document information
		//$pdf->SetCreator(PDF_CREATOR);
		//$pdf->SetAuthor('Nicola Asuni');
		//$pdf->SetTitle($info['realname']);
		//$pdf->SetSubject('TCPDF Tutorial');
		//$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

	
		// set header and footer fonts
		//$pdf->setHeaderFont(Array('stsongstdlight', '', PDF_FONT_SIZE_MAIN));
		//$pdf->setFooterFont(Array('stsongstdlight', '', PDF_FONT_SIZE_DATA));
               // $pdf->SetHeaderData('logo.png', 60, 'baijunyao.com', '白俊遥博客', array(0,64,255), array(0,64,128));
                // $pdf->setHeaderData( '',0,"移动应用检测报告" );
                // $pdf->setPrintHeader(true); //设置打印页眉
               //  $pdf->setPrintFooter(true); //设置打印页脚
                 
                $pdf->SetCreator(PDF_CREATOR);
                $pdf->SetAuthor('Author');
                $pdf->SetTitle('TCPDF HTML Table');
                $pdf->SetSubject('TCPDF Tutorial');
                $pdf->SetKeywords('TCPDF, PDF, html,table, example, test, guide');
                // set default header data
                 $pdf->setHeaderData('',0,"" ,'源代码安全检测报告',array(5,4,1), array(5,4,1));
               // $pdf->SetHeaderData('', '', ' HTML table', '');
              
                
                // set header and footer fonts
                $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
                $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
                // set default monospaced font
                //$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
                // set margins
                $pdf->SetMargins(15, 15, 15);
              //  $pdf->SetHeaderMargin(5);
                $pdf->SetFooterMargin(15);
               // set auto page breaks
                $pdf->SetAutoPageBreak(TRUE, 15);
		// set default monospaced font
		//$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
                 //  $pdf->SetAutoPageBreak(TRUE, 2000); 
		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);



		$pdf->AddPage();

//		$html ="<br/><br/><br/><br/><br/>";
//		$pdf->writeHTML($html, true, false, true, false, '');
//
//		$pdf->SetFont('droidsansfallback', 'B', 25);
//		$appname = $info['realname'];
//		$pdf->Write(0, $appname.'应用安全检测评估报告', '', 0, 'C', true, 0, false, false, 0);
//
//		$html ="<br/>";
//
//		$pdf->writeHTML($html, true, false, true, false, '');
//
//		// $pdf->SetFont('droidsansfallback', 'B', 25);
//		$pdf->SetFont('droidsansfallback', 'B', 25);
//
//		$pdf->Write(0, 'Android版', '', 0, 'C', true, 0, false, false, 0);
         $html = '
                 <html xmlns="http://www.w3.org/1999/xhtml">
                 <head>
                 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
              


                 <title>微众源代码安全检测系统</title>
                         <style type="text/css">
                         html,body{
                                 margin: 0;
                                 padding: 0;
                                
                         }
                         .a5-container{
                                 width: 875px;
                                 margin:  30px auto;
                                 background-color: #ffffff;
                                 height: auto;
                                 color: #454545;
                                 padding: 30px;
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
                       
                        .ticri{ 
                                text-align:left;
                                height:45px;
                                 line-height:1.8;
                                font-size:18px;
                                background-color: #2196F3;
                                color:#ffffff;
                        }
                          .cri{
                                text-align:left;
                                 height:35px;
                                 line-height:25px;
                                  font-size:16px;
                                 background-color: #cccccc;
                                 color: #000000;
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
                         h4{
                         height:50px;
                         
                         }
                         span{
                       
                          font-size:24px;
                         }
                        #titl{
                            background-color: #5CACEE;
                            color: #ffffff;
                            padding:0px;
                            margin:0px;
                            height:50px;
                            
                            line-height:50px;
                         }
                         .table tr .count{
                                 background-color: #2196F3;
                                 color: #ffffff;
                         }
                         .report-detail{
                                 border: 0px solid #e1e1e1;
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
                        .tr{
                               padding:10px 0; 
                        }
                       
                        .table{
                           
                            width: 100%;
                            max-width: 100%;
                            margin-bottom: 20px;
                            border: 1px solid #ddd;
                        }
                        .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
                            padding: 8px;
                            line-height: 1.42857143;
                            vertical-align: top;
                            border-top: 1px solid #ddd;
                            word-break: break-all;
                        }
                        table{
                         
                            border-spacing: 0;
                            border-collapse: collapse;
                        }
                        .clearfix{
                            display:block;
                            clear:both;
                        }
                        th{
                        text-align:center;
                        height:30px;
                        line-height:1.8;
                           }
                      p{
                      font-size:14px;
                      }
                   
                         
                 </style>
                 </head>
                 <body>';
       // $appid = 1139;
        $det = M('detection');
        $appinfo = D('Appinfo');
        $info = $appinfo->where(array('appid' => $appid))->find();
        $count = $det->where(array('appid' => $appid))->count();
        $hcount = $det->where(array('appid' => $appid, 'result' => 'high'))->count();
        $midcount = $det->where(array('result' => 'medium', 'appid' => $appid))->count();
       
        $shu = $det->where(array('appid' => $appid))->find();
        
        $listcount = $det->group('testtype')->where(array('appid' => $appid))->select();
        $leicount =count($listcount);
     
        $html.='<div class="a4-container">     
                          <h1>&nbsp;</h1>
                           <h1>&nbsp;</h1>
                         <h1 class="text-center" style="color:#147efb;text-align:center;font-size:40px;">' . $info['name'] . '项目</h1>
                         <h3 class="text-center" style="text-align:center;">源代码检测报告</h3>
                         <p class="text-center" style="text-align:center;">' . $info['subtime'] . '</p> 
                             
                               <div class="clearfix"></div>
                               <div class="bottom-line"></div>
                               <p></p>
                                 <h2>检测工具：Fortify</h2>';
    
            
        $pdf->writeHTML($html, true, false, true, false, '');
         $pdf->AddPage();
        $html ='
                <style type="text/css">
                         html,body{
                                 margin: 0;
                                 padding: 0;
                                
                         }
                         .a5-container{
                                 width: 875px;
                                 margin:  30px auto;
                                 background-color: #ffffff;
                                 height: auto;
                                 color: #454545;
                                 padding: 30px;
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
                       
                        .ticri{ 
                                text-align:left;
                                height:35px;
                                 line-height:25px;
                                font-size:16px;
                                background-color: #2196F3;
                                color:#ffffff;
                        }
                          .cri{
                                text-align:left;
                                 height:35px;
                                 line-height:25px;
                                 font-size:16px;
                                 background-color: #cccccc;
                                 color: #000000;
                        }
                          .cridanger-1s{
                              height:35px;
                                 line-height:1.8;
                                font-size:16px;
                                 background-color: #a8000b;
                                 color: #ffffff;
                        }
                         .danger-1s{
                              height:35px;
                                 line-height:1.8;
                                font-size:16px;
                                 background-color: #ff212f;
                                 color: #ffffff;
                         }
                         .warning-1s{
                                height:35px;
                                 line-height:1.8;
                                font-size:16px;
                                 background-color: #FF9800;
                                 color: #ffffff;
                         }
                         .normal-1s{
                                height:35px;
                                 line-height:1.8;
                                font-size:16px;
                                 background-color: #4fca81;
                                 color: #ffffff;
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
                         h4{
                         height:50px;
                         
                         }
                         span{
                       
                          font-size:24px;
                         }
                        #titl{
                            background-color: #5CACEE;
                            color: #ffffff;
                            padding:0px;
                            margin:0px;
                            height:50px;
                            
                            line-height:50px;
                         }
                         .table tr .count{
                                 background-color: #2196F3;
                                 color: #ffffff;
                         }
                         .report-detail{
                                 border: 0px solid #e1e1e1;
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
                        .tr{
                               padding:10px 0; 
                        }
                       
                        .table{
                           
                            width: 100%;
                            max-width: 100%;
                            margin-bottom: 20px;
                            border: 1px solid #ddd;
                        }
                        .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
                            padding: 8px;
                            line-height: 1.42857143;
                            vertical-align: top;
                            border-top: 1px solid #ddd;
                            word-break: break-all;
                        }
                        table{
                         
                            border-spacing: 0;
                            border-collapse: collapse;
                        }
                        .clearfix{
                            display:block;
                            clear:both;
                        }
                        th{
                        text-align:center;
                        height:30px;
                        line-height:1.8;
                           }
                      p{
                      font-size:14px;
                      color:#070707;
                      }
                    
                         
                 </style>

                                 <div class="report-content">
                                         <div class="report-group">
                                                 <div class="title">
                                                         <h2>摘要</h2>
                                                         <div class="clearfix"></div>
                                                         <p>本报告为开发人员提供源代码扫描细节和信息理解和解决源代码审计过程中发现的风险。本报告的读者主要是项目经理和开发人员。本节提供的分析过程中发现的风险进行了概述。</p>
                                                 </div>
                                                  <table class="table table-bordered" border="1">
                                                
                                                         <tbody>
                                                                 <tr>
                                                                         <td>项目名</td>
                                                                         <td>' . $info['name'] . '</td>
                                                                         <td>检测工具</td>
                                                                         <td>Fortify(16.10.0095 )</td>
                                                                 </tr>
                                                                 <tr>
                                                                         <td>软件版本</td>
                                                                         <td>' . $info['version'] . '</td>
                                                                         <td>风险库版本</td>
                                                                         <td>16.10.0095</td>
                                                                 </tr>
                                                                  <tr>
                                                                         <td>编译环境</td>
                                                                         <td>' .$info['env'] . '</td>
                                                                         <td>代码语言</td>
                                                                         <td>' . $info['lang'] . '</td>
                                                                 </tr>
                                                                  <tr>
                                                                         <td>压缩包MD5</td>
                                                                         <td>' .$info['md5'] . '</td>
                                                                         <td>预编译命令</td>
                                                                         <td>' . $info['shell'] . '</td>
                                                                 </tr>
                                                                  <tr>
                                                                         <td>提交时间</td>
                                                                         <td>' .$info['subtime']. '</td>
                                                                         <td>测试用时</td>
                                                                         <td>' . $info['spendtime'] . '</td>
                                                                 </tr>
                                                                 <tr>
                                                                         <td>风险种类个数</td>
                                                                         <td>' . $leicount . '</td>
                                                                         <td>中危风险个数</td>
                                                                         <td>' . $midcount . '</td>
                                                                 </tr>
                                                                 <tr>
                                                                         <td>总风险个数</td>
                                                                         <td>' . $count . '</td>
                                                                         <td>高危风险个数</td>
                                                                         <td>'. $hcount . '</td>
                                                                 </tr>
                                                         </tbody>
                                                 </table>
                                         </div>

                                         <div class="bottom-line"></div>';
//                           <div style="padding-left:60px;" >   <img src="' . __ROOT__ . '/Uploads/example/one.png" hight="250px" width="460px" ></div>
                              
//                                                        
                            if($shu){
                                   $html .='
                                             <div style="padding-left:50px;">    <img style="text-align:center" src="http://'.$_SERVER["HTTP_HOST"]. __ROOT__ . '/Uploads/example/two.png "   hight="100px" width="550px"></div>';
//                                            $mpdf->writeHTML($html);
//                                            $mpdf->AddPage(); <img src="' . __ROOT__ . '/Uploads/example/f.png "  hight="100px" width="560px">
                                     $html .=' <div class="report-group">
                                                 <div class="title">
                                                         <h3>风险汇总</h3>
                                                         <div class="clearfix"></div>
                                                 </div>

                                                 <div class="chart-img"  >
                                                                      <div > <img  src="http://'.$_SERVER["HTTP_HOST"]. __ROOT__ . '/Uploads/example/three.png " width="550px" ></div> 
                                                                      <div> <img style="text-align:center" src="http://'.$_SERVER["HTTP_HOST"].__ROOT__.'/Uploads/example/f.png" width="550px"/></div>

                                                  </div>

                                                 </div>
                                                  <p></p>
                                                 <table class="table table-bordered" border="1">
                                                         <thead>
                                                                 <tr class="tr">
                                                                         <th class="th" width="45%">类别</th>
                                                                         <th class="cridanger-1" width="11%">严重数</th>
                                                                         <th class="danger-1" width="11%">高危数</th>
                                                                         <th class="warning-1" width="11%">中危数</th>
                                                                         <th class="normal-1" width="11%">低危数</th>
                                                                         <th class="count" width="11%">统计</th>
                                                                 </tr>
                                                         </thead>
                                                                     <tbody>';
       /**
        * 类别的统计
        */
         $risk = array(array('eq','critical'),array('eq','high'), 'or') ;                         
        $lists = $det->field('testtype')->group('testtype')->where(array('appid' => $appid,'result'=>$risk))->select();
        foreach ($lists as $ke => $v) {
            $listb = $v['testtype'];
            $crib = $det->where(array('appid' => $appid, 'testtype' => $v['testtype'], 'result' => 'critical'))->count();
            $hib = $det->where(array('appid' => $appid, 'testtype' => $v['testtype'], 'result' => 'high'))->count();
            $medb = $det->where(array('appid' => $appid, 'testtype' => $v['testtype'], 'result' => 'medium'))->count();
            $lowb = $det->where(array('appid' => $appid, 'testtype' => $v['testtype'], 'result' => 'low'))->count();
            $sumcount = $hib + $medb + $lowb+$crib;
            $html .='<tr>
                                                                         <td width="45%">' . $listb . '</td>
                                                                         <td width="11%">' . $crib . '</td>
                                                                         <td width="11%">' . $hib . '</td>
                                                                         <td width="11%">' . $medb . '</td>
                                                                         <td width="11%">' . $lowb . '</td>
                                                                         <td width="11%">' . $sumcount . '</td>
                                                                 </tr>';
        }

        $html.=' </tbody>
                                                 </table>
                                         </div>

                                         <div class="bottom-line"></div>

                                         <div class="report-group">
                                         <h2 class="text-center">风险详情</h2>';

        $det = M('detection');
/**
 * 风险详情
 *  */
        $listdet = $det->group('testtype')->where(array('appid' => $appid,'result'=>$risk))->select();
  // dump($listdet);die;
        foreach ($listdet as $kv => $vl) {
            // $mone['id'] = $vl['id'];
            $testtype = $vl['testtype'];
            $count = $det->where(array('appid' => $appid, 'testtype' => $vl['testtype']))->count();
            $children = $det->where(array('at_detection.appid' => $appid, 'at_detection.testtype' => $vl['testtype'],'at_detection.result'=>$risk))->field('at_detection.id,at_detection.scaid,at_detection.appid,at_detection.testname,at_detection.testtype,at_detection.result,at_detection.info,at_resulttype.zhresult')->join('left join at_resulttype on at_resulttype.result=at_detection.result')->select();
             $cribb = $det->where(array('appid' => $appid, 'testtype' => $vl['testtype'], 'result' => 'critical'))->count();
            $hibb = $det->where(array('appid' => $appid, 'testtype' => $vl['testtype'], 'result' => 'high'))->count();
            $medbb = $det->where(array('appid' => $appid, 'testtype' => $vl['testtype'], 'result' => 'medium'))->count();
            $lowbb = $det->where(array('appid' => $appid, 'testtype' => $vl['testtype'], 'result' => 'low'))->count();
            $sumcountb =$cribb+ $hibb + $medbb + $lowbb;
            $data = $det->field('at_detection.id as id,at_detection.scaid as scaid,at_detectype.zhtesttype,at_detectype.damage as damage,at_detectype.suggest as suggest,at_detection.appid as appid,at_detection.testtype as testtype,at_detection.info as info')->where(array('at_detection.id' =>  $vl['id']))->join('left join at_detectype on at_detectype.testtype = at_detection.testtype')->find();
  
            $k = $kv + 1;

    // dump($testtype);'（' . $count . '个风险）
    // dump($children);die;

            $html .= '    <h2>第' . $k . '类：' . $testtype . '</h2>
                              <h3>中文名：'.$data['zhtesttype'].'</h3>
                                                 <div class="title">
                                                         <h2>风险解释</h2>
                                                         <div class="clearfix"></div>
                                                         <p>'.$data['damage'].'</p>
                                                 </div>
                                                 <div class="title">
                                                         <h2>修复建议</h2>
                                                         <div class="clearfix"></div>
                                                         <p>'.$data['suggest'].'</p>
                                                 </div>

                                                 <div class="title">
                                                         <h2>概要</h2>
                                                         <div class="clearfix"></div>
                                                 </div>
                                                 <table class="table table-bordered" border="1">
                                                         <thead>
                                                                 <tr>
                                                                         <th width="45%">类别</th>
                                                                          <th class="cridanger-1" width="11%">严重数</th>
                                                                         <th class="danger-1" width="11%">高危数</th>
                                                                         <th class="warning-1" width="11%">中危数</th>
                                                                         <th class="normal-1" width="11%">低危数</th>
                                                                         <th class="count" width="11%">统计</th>
                                                                 </tr>
                                                         </thead>
                                                         <tbody>
                                                                 <tr>';
            $html.='                                        <td width="45%">' . $testtype . '</td>
                                                               <td width="11%">' . $cribb . '</td>
                                                               <td width="11%">' . $hibb . '</td>
                                                               <td width="11%">' . $medbb . '</td>
                                                               <td width="11%">' . $lowbb . '</td>
                                                               <td width="11%">' . $sumcountb . '</td>';

            $html .='</tr>

                                                         </tbody>
                                                 </table>

                                                 <div class="title">
                                                         <h2>详情</h2>
                                                         <div class="clearfix"></div>
                                                 </div>
                                               
                                                

              

                                                 <div class="report-detail">';
            
                                     break;

            foreach ($children as $ks => $vs) {

                $k = $ks + 1;
               
                $html .='  
                          <table class="table table-bordered">';
//				   $html .='  	<thead>
//						<tr>
//							<th style="background:#5CACEE;text-align:left;color:#ffffff;font-size:20px;width:100%;" >' . $k . ':' .explode(")",$vs['info'] , -1)[0] . ")" . '</th>';
////					
////                                          if ($vs['zhresult'] == '严重') {
////                                                $html.= '<th class="cridanger-1" style="width:10%">严重</th>';
////                                            } 
////                                            else if ($vs['zhresult'] == '高危') {
////                                                $html.= '<th class="danger-1" style="width:10%">高危</th>';
////                                            } else if ($vs['zhresult'] == '中危') {
////                                                $html.= ' <th class="warning-1" style="width:10%">中危</th>';
////                                            } else if ($vs['zhresult'] == '低危') {
////                                                $html.= ' <th class="normal-1" style="width:10%">低危</th>';
////                                            }
//                               $html .='
//							
//						</tr>
//                                            
//                                          </thead>';
                                        
                                    $html .='  <thead > 
                                                <tr >
							<th class="ticri" >' . $k . ':' .explode(")",$vs['info'] , -1)[0] . ")" . '</th>
						</tr>
                                                 <tr >';
                                          if ($vs['zhresult'] == '严重') {
                                                $html.= '<th class="cridanger-1s" >严重</th>';
                                            } 
                                            else if ($vs['zhresult'] == '高危') {
                                                $html.= '<th class="danger-1s" >高危</th>';
                                            } else if ($vs['zhresult'] == '中危') {
                                                $html.= ' <th class="warning-1s">中危</th>';
                                            } else if ($vs['zhresult'] == '低危') {
                                                $html.= ' <th class="normal-1" >低危</th>';
                                            }
					 $html .=' </tr>
                                              <tr >
							<th class="cri">代码位置</th>
						</tr>
					</thead>     
					<tbody >';
                              $u = strip_tags($vs['info']);
                           //  $u = explode("----",$vs['info'] , -1)[0];
                             //  $u = strip_tags($u); 
                            $u =htmlspecialchars($u);
//                             $u = str_replace("\r", "<br>", $u);
                             $u = str_replace("\n", "<br>", $u);
                             $u = str_replace("\t", "&nbsp;&nbsp;", $u);
                            // $u = str_replace("  ", "&nbsp;", $u);
                            // $u = str_replace(" ", "&nbsp;", $u);
                            $u =  str_replace("", '<br>', $u);
                            $u =  str_replace("\r\n", '<br>', $u);
                          
                         //   $str = str_replace('  ',"<br>",$in);
                     //   echo $u; die;
                   
				$html .='	<tr  >
							<td class="trs" >'.$u.'</td>
							
						</tr >';
                                 
                             
				$html .='</tbody>
				</table>  <p>&nbsp;</p>';   
                                break;
                                
                      
                    
                    
            }
            $html .= '</div>';
        }



        $html .='    </div>';
        
   } else {
            $html .= '<p style="font-size:20px;text-align:center">没有其他数据了</p>';
        }

        
         $html .='          </div>

                     </div>
                 </body>
                 </html>
            ';
		

		//echo $html;die;
          
			
		  $pdf->SetFont('droidsansfallback', '', 10);

			// output the HTML content
//			
		    $pdf->writeHTML($html, true, false, true, false, '');

		    $pdf->lastPage();
		    $name = $info['package'].'_'.$info['subtime'].'.pdf';
		    $pdf->Output( $name, 'D');
	}
    
    
  
        
        
        
        
   public function makePdfReportsss($appid){
       $this->two($appid);
       $this->three($appid);
       $this->four($appid);
       makePdfReportss($appid);
   }     
        
        
        
   
   
 
 
    
    

}
