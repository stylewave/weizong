<?php

//加密
function aes_encrypt($str){
	Vendor('aes.Aes');
	$aes  = new AES();
	return $aes->encrypt($str);
}
//解密
function aes_decrypt($str){
	Vendor('aes.Aes');
	$aes  = new AES();
	return $aes->decrypt($str);
}

	/*
	* 检测是否是apk
	* 是apk返回包名
	* 不是则返回false
	*/
	function checkApkInfo($file){
		Vendor('ApkParser.Apkparser');
		$appObj = new ApkParser();

		if($appObj->open($file)){
			return $appObj->getPackage();
		}else{
			return false;
		}
	}

	//$name  pdf名称
	//$info  apk信息
	//$detec 对应appid的视图
	function makePdfReport($info,$detec){
		Vendor('tcpdf.tcpdf');
		class MYPDF extends TCPDF {

			//需要传递背景图片进来
			public function Header() {
				if ($this->header_xobjid === false) {
					// start a new XObject Template
					$this->header_xobjid = $this->startTemplate($this->w, $this->tMargin);
					$headerfont = $this->getHeaderFont();
					$headerdata = $this->getHeaderData();
					$this->y = $this->header_margin;
					if ($this->rtl) {
						$this->x = $this->w - $this->original_rMargin;
					} else {
						$this->x = $this->original_lMargin;
					}
					if (($headerdata['logo']) AND ($headerdata['logo'] != K_BLANK_IMAGE)) {
						$imgtype = TCPDF_IMAGES::getImageFileType(K_PATH_IMAGES.$headerdata['logo']);
						if (($imgtype == 'eps') OR ($imgtype == 'ai')) {
							$this->ImageEps(K_PATH_IMAGES.$headerdata['logo'], '', '', '','7.5');
						} elseif ($imgtype == 'svg') {
							$this->ImageSVG(K_PATH_IMAGES.$headerdata['logo'], '', '', '','7.5');
						} else {
							$this->Image(K_PATH_IMAGES.$headerdata['logo'], '', '', '','7.5');
						}
						$imgy = $this->getImageRBY();
					} else {
						$imgy = $this->y;
					}
					$cell_height = $this->getCellHeight($headerfont[2] / $this->k);
					// set starting margin for text data cell
					$imglogwidth = getimagesize(K_PATH_IMAGES.$headerdata['logo']);
					//页眉logo图片的在pdf中的宽度等于 宽除以高 再除以13,目前看来最合适的比例
					$tmpwidth  = $imglogwidth[0] * ( $imglogwidth[0] / $imglogwidth[1] / 13 ); 

					if ($this->getRTL()) {
						$header_x = $this->original_rMargin + ($tmpwidth);
					} else {
						$header_x = $this->original_lMargin + ($tmpwidth);
					}
					$cw = $this->w - $this->original_lMargin - $this->original_rMargin - ($tmpwidth);
					$this->SetTextColorArray($this->header_text_color);
					// header title
					$this->SetFont($headerfont[0], 'B', $headerfont[2] + 1);
					$this->SetX($header_x);
					$this->Cell($cw, $cell_height, $headerdata['title'], 0, 1, '', 0, '', 0);
					// header string
					$this->SetFont($headerfont[0], $headerfont[1], $headerfont[2]);
					$this->SetX($header_x);
					$this->MultiCell($cw, $cell_height, $headerdata['string'], 0, '', 0, 1, '', '', true, 0, false, true, 0, 'T', false);
					// print an ending header line
					$this->SetLineStyle(array('width' => 0.85 / $this->k, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => $headerdata['line_color']));
					$this->SetY((2.835 / $this->k) + max($imgy, $this->y));
					if ($this->rtl) {
						$this->SetX($this->original_rMargin);
					} else {
						$this->SetX($this->original_lMargin);
					}
					$this->Cell(($this->w - $this->original_lMargin - $this->original_rMargin), 0, '', 'T', 0, 'C');
					$this->endTemplate();
				}
				// print header template
				$x = 0;
				$dx = 0;
				if (!$this->header_xobj_autoreset AND $this->booklet AND (($this->page % 2) == 0)) {
					// adjust margins for booklet mode
					$dx = ($this->original_lMargin - $this->original_rMargin);
				}
				if ($this->rtl) {
					$x = $this->w + $dx;
				} else {
					$x = 0 + $dx;
				}
				$this->printTemplate($this->header_xobjid, $x, 0, 0, 0, '', '', false);
				if ($this->header_xobj_autoreset) {
					// reset header xobject template at each page
					$this->header_xobjid = false;
				}
				$pdfext 	= D('Pdfext');
				$pdfinfo 	= $pdfext->where('status=1')->limit(1)->select()[0];
				$pdfextshow = $pdfext->where('id=0')->select()[0]['textpic'];
				if( $pdfinfo != null && $pdfextshow == 1 && file_exists($pdfinfo['background']) ){
					
					$background 	= __ROOT__.'/'.$pdfinfo['background'];
					$bMargin = $this->getBreakMargin();
					// get current auto-page-break mode
					$auto_page_break = $this->AutoPageBreak;
					// disable auto-page-break
					$this->SetAutoPageBreak(false, 0);
					// set bacground image
					// $img_file = K_PATH_IMAGES.'img.png';
					$this->Image($background, 5, 30, 200, 350, '', '', '', false, 300, '', false, false, 0);
					// restore auto-page-break status
					$this->SetAutoPageBreak($auto_page_break, $bMargin);
					// set the starting point for the page content
					$this->setPageMark();
				}				
			}

		}


		$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdfext 	= D('Pdfext');
		$pdfinfo 	= $pdfext->where('status=1')->limit(1)->select()[0];
		$pdfextshow = $pdfext->where('id=0')->select()[0]['textpic'];
		if($pdfinfo != null && $pdfextshow == 1){
			if(file_exists($pdfinfo['headimg'])){
				$pdf->SetHeaderData('../../../../../../..'.__ROOT__.'/'.$pdfinfo['headimg'], '25', $pdfinfo['headerup'],$pdfinfo['headerdown']);
			}else{
				$pdf->SetHeaderData('', '25', $pdfinfo['headerup'],$pdfinfo['headerdown']);
			}
		}
		

		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Nicola Asuni');
		$pdf->SetTitle($info['realname']);
		$pdf->SetSubject('TCPDF Tutorial');
		$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

		// set header and footer fonts
		$pdf->setHeaderFont(Array('stsongstdlight', '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array('stsongstdlight', '', PDF_FONT_SIZE_DATA));

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);//PDF_MARGIN_HEADER
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
			require_once(dirname(__FILE__).'/lang/eng.php');
			$pdf->setLanguageArray($l);
		}

		$pdf->AddPage();

		$html ="<br/><br/><br/><br/><br/>";
		$pdf->writeHTML($html, true, false, true, false, '');

		$pdf->SetFont('droidsansfallback', 'B', 25);
		$appname = $info['realname'];
		$pdf->Write(0, $appname.'应用安全检测评估报告', '', 0, 'C', true, 0, false, false, 0);

		$html ="<br/>";

		$pdf->writeHTML($html, true, false, true, false, '');

		// $pdf->SetFont('droidsansfallback', 'B', 25);
		$pdf->SetFont('droidsansfallback', 'B', 25);

		if($info['type'] == 'ipa'){
			$apptypename 	= "iOS版";
		}else{
			$apptypename 	= "Android版";
		}

		$pdf->Write(0, $apptypename, '', 0, 'C', true, 0, false, false, 0);

		$html = '<style>div .position{font-size:20;} </style>			
				<div style="text-align:center;">
				<div class="position">&nbsp;<br/><br/></div>	
					<div>';

					// $html .= '<img width="100px" src="'.__ROOT__.'/'.$info["icon"].'" />'
		if(substr($info['icon'], 0,4) == 'http'){
			$html .= '<img width="100" src="'.$info['icon'].'" /><br/>';
		}else{
			$html .= '<img width="100" src="'.__ROOT__.'/'.$info["icon"].'" />';
		}
		$html .='</div></div><div class="position">&nbsp;<br/><br/><br/></div>
				<div width="80" float="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font size="15" width="100">应用名&nbsp;&nbsp;:</font><font size="15">'.$info["realname"].'</font></div>
				<div width="80" float="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font size="15" width="100">版&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;本:</font><font size="15">'.$info["version"].'</font></div>
				<div width="80" float="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font size="15" width="100">检测时间:&nbsp;</font><font size="15">'.$info["subtime"].'</font></div></div>';


		$pdf->SetFont('droidsansfallback', '', 10);

		$pdf->writeHTML($html, true, false, true, false, '');

		$pdf->AddPage();
		$pdf->SetFont('droidsansfallback', '', 10);


		$pdf->SetFont('droidsansfallback', 'B', 30);
		$pdf->Write(0, '一、检测概述', '', 0, '', true, 0, false, false, 0);

		$html = '<div style="text-align:center;">';
		if(substr($info['icon'], 0,4) == 'http'){
			$html .= '<img width="100" src="'.$info['icon'].'" /><br/>';
		}else{
			$html .= '<img width="100" src="'.__ROOT__.'/'.$info["icon"].'" /><br/>';
		}
		$html .= '<br/><font  size="15">'.$info["realname"].'</font><br/>
			<font  size="15">安全等级</font><br/><font color="red" size="30">'.ranking($info["secscore"]).'</font>
		</div>
		';
		$pdf->writeHTML($html, true, 0, true, true);

		$pdf->SetFont('droidsansfallback', 'B', 30);
		$pdf->Write(0, '二、基本信息', '', 0, '', true, 0, false, false, 0);

		$gaowei = 0;
		foreach ($detec as $k => $v) {
			if($v["result"] == 4){
				++$gaowei;
			}
		}
		$html = '<style>
			td {
				cellspacing:0px;
				border:1px solid #cbcbcb;
				font-size:15px;
			}
		</style>
		<table style="text-align: left;width:900px;">
			<tbody>
				<tr>
					<td style="width:100px;">应用名称</td>
					<td>'.$info["realname"].'</td>
					<td style="width:100px;">版本号</td>
					<td>'.$info["version"].'</td>
				</tr>
				<tr>
					<td style="width:100px;">包名</td>
					<td>'.$info["package"].'</td>
					<td style="width:100px;">检测时间</td>
					<td>'.$info["subtime"].'</td>
				</tr>
				<tr>
					<td>高危漏洞个数</td><td >'.$gaowei.'</td>
					<td>漏洞个数</td><td >'.$info["bugs"].'</td>
				</tr>
				<tr>
					<td style="width:100px;">MD5</td><td colspan="3" >'.$info["md5"].'</td>
				</tr>
				<tr>
					<td style="width:100px;">SHA-1</td><td colspan="3" >'.$info["sha1"].'</td>
				</tr>
				<tr>
					<td style="width:100px;">SHA-256</td><td colspan="3" >'.$info["sha256"].'</td>
				</tr>
				<tr>
					<td style="width:100px;">证书信息</td><td colspan="5" >'.$info["cert"].'</td>
				</tr>
			</tbody>
		</table>';
		$pdf->SetFont('droidsansfallback', '', 10);

		$pdf->writeHTML($html, true, false, true, false, '');

		$pdf->SetFont('droidsansfallback', 'B', 30);
		$pdf->Write(0, '三、检测概述', '', 0, '', true, 0, false, false, 0);

		$html =  '<style>
		td {
			cellspacing:0px;
			border:1px solid #cbcbcb;
			font-size:15px;
		}
		</style>
		<table style="text-align: left;">
				<tr><td style="text-align:center;width:100px;" >序号</td><td style="text-align:center;width:330px;">检测项目</td><td style="text-align:center;width:110px;">检测类型</td><td style="text-align:center;width:110px;">危险系数</td></tr>';
		foreach ($detec as $k => $v) {
			$index = $k + 1;
			$html .= '<tr><td style="text-align:center;">'.$index.'</td><td>'.$v["zhtestname"].'</td><td style="text-align:center;">'.$v["zhtesttype"].'</td><td style="text-align:center;">';
			if($v['result'] == 1){
				$html .= '<font color="#10CA19">'.$v['resultname'].'</font>';
			}elseif($v['result'] == 2){
				$html .= '<font color="orange">'.$v['resultname'].'</font>';
			}
			elseif($v['result'] == 3){
				$html .= '<font color="#F5470A">'.$v['resultname'].'</font>';
			}else{
				$html .= '<font color="red">'.$v['resultname'].'</font>';
			}
			$html .= '</td></tr>';
		}

		$html .= '</table>';
		$pdf->SetFont('droidsansfallback', '', 10);

		$pdf->writeHTML($html, true, false, true, false, '');

		$pdf->SetFont('droidsansfallback', 'B', 30);
		$pdf->Write(0, '四、详细检测结果', '', 0, '', true, 0, false, false, 0);

		$oldtestytpt = 0;
		$testtypenum = 1;
		foreach ($detec as $k => $v) {

			if($oldtestytpt==$v['testtype']){
			}else{
				$pdf->SetFont('droidsansfallback', 'B', 20);
				$pdf->Write(0, "4 . ".$testtypenum."  ".$v['zhtesttype'], '', 0, '', true, 0, false, false, 0);

				$testtypenum ++;
			}
			$oldtestytpt=$v['testtype'];
			$html ='<style>
			th {
				width:90px;
				border:1px solid #cbcbcb;
				font-size:15px;
				text-align:center;
			}
			td {
				cellspacing:0px;
				border:1px solid #cbcbcb;
				font-size:15px;
				width:550px;
			}
			</style>';
			$html .= "<table><tr><th>检测名称</th><td>".$v['zhtestname']."</td></tr>";
			$html .= "<tr><th>检测说明</th><td>".$v['damage']."</td></tr>";
			$html .= "<tr><th>检测结果</th><td>";
			if($v['result'] == 1){
				$html .= '<font color="#10CA19">'.$v['resultname'].'</font>';
			}elseif($v['result'] == 2){
				$html .= '<font color="orange">'.$v['resultname'].'</font>';
			}
			elseif($v['result'] == 3){
				$html .= '<font color="#F5470A">'.$v['resultname'].'</font>';
			}else{
				$html .= '<font color="red">'.$v['resultname'].'</font>';
			}

			$html .= "</td></tr>";
			$permisson = D('Permissionlist');
			if($v['result'] != 1){
				$html .= "<tr><th>检测详情</th><td>";
				if($v['testname'] == 81){
					$jsoninfo = json_decode(preg_replace('/\'/', '"', $v['info']),true);

					if($jsoninfo['ControlPower'] != null){
						$html .= "控制力得分:".$jsoninfo['ControlPower']."分<hr/>";
					}
					if($jsoninfo['DangerousPermissions'] != null){
						$html .= "<hr/>危险权限:<hr/>";
						foreach ($jsoninfo['DangerousPermissions'] as $k => $vd) {
							$s = $permisson->where(array('permission'=>$vd))->select()[0];
							$index = $k +1;
							$html .= $index.": ".$vd;
							if($s != null){
								$html .= "(".$s['perminame'].")<hr/>";
							}else{
								$html .= "<hr/>";
							}
						}
					}
					if($jsoninfo['AllPermissions'] != null){
						$html .= "所有权限:<hr/>";
						$alllen  = count($jsoninfo['AllPermissions']) - 1;
						foreach ($jsoninfo['AllPermissions'] as $k => $va) {
							$s = $permisson->where(array('permission'=>$va))->select()[0];
							$index = $k +1;
							$html .= $index.": ".$va;
							if($s != null){
								$html .= "(".$s['perminame'].")";
								if($k != $alllen){
									$html .="<hr/>";
								}
							}else{
								$html .= "<hr/>";
							}
						}
					}
					$html .= "</td></tr>";
					$html .= "<tr><th>修复建议</th><td>".$v['suggest']."</td></tr>";
				}else{
					$html .= $v['info'];
					$html .= "</td></tr>";
					$html .= "<tr><th>修复建议</th><td>".$v['suggest']."</td></tr>";
				}
				
			}
			$html .= "</table><br/><br/><br/>";

			// set core font
			$pdf->SetFont('droidsansfallback', '', 10);

			// output the HTML content
			$pdf->writeHTML($html, true, false, true, false, '');
		}

		$pdf->lastPage();
		$name = $info['package'].'_'.$info['subtime'].'.pdf';
		$pdf->Output( $name, 'D');
	}

	//管理的报告
	function makePdfBrief($info,$detec){
		Vendor('tcpdf.tcpdf');
		class MYPDF extends TCPDF {

			//需要传递背景图片进来
			public function Header() {
				if ($this->header_xobjid === false) {
					// start a new XObject Template
					$this->header_xobjid = $this->startTemplate($this->w, $this->tMargin);
					$headerfont = $this->getHeaderFont();
					$headerdata = $this->getHeaderData();
					$this->y = $this->header_margin;
					if ($this->rtl) {
						$this->x = $this->w - $this->original_rMargin;
					} else {
						$this->x = $this->original_lMargin;
					}
					if (($headerdata['logo']) AND ($headerdata['logo'] != K_BLANK_IMAGE)) {
						$imgtype = TCPDF_IMAGES::getImageFileType(K_PATH_IMAGES.$headerdata['logo']);
						if (($imgtype == 'eps') OR ($imgtype == 'ai')) {
							$this->ImageEps(K_PATH_IMAGES.$headerdata['logo'], '', '', '','7.5');
						} elseif ($imgtype == 'svg') {
							$this->ImageSVG(K_PATH_IMAGES.$headerdata['logo'], '', '', '','7.5');
						} else {
							$this->Image(K_PATH_IMAGES.$headerdata['logo'], '', '', '','7.5');
						}
						$imgy = $this->getImageRBY();
					} else {
						$imgy = $this->y;
					}
					$cell_height = $this->getCellHeight($headerfont[2] / $this->k);
					// set starting margin for text data cell
					$imglogwidth = getimagesize(K_PATH_IMAGES.$headerdata['logo']);
					//页眉logo图片的在pdf中的宽度等于 宽除以高 再除以13,目前看来最合适的比例
					$tmpwidth  = $imglogwidth[0] * ( $imglogwidth[0] / $imglogwidth[1] / 13 ); 

					if ($this->getRTL()) {
						$header_x = $this->original_rMargin + ($tmpwidth);
					} else {
						$header_x = $this->original_lMargin + ($tmpwidth);
					}
					$cw = $this->w - $this->original_lMargin - $this->original_rMargin - ($tmpwidth);
					$this->SetTextColorArray($this->header_text_color);
					// header title
					$this->SetFont($headerfont[0], 'B', $headerfont[2] + 1);
					$this->SetX($header_x);
					$this->Cell($cw, $cell_height, $headerdata['title'], 0, 1, '', 0, '', 0);
					// header string
					$this->SetFont($headerfont[0], $headerfont[1], $headerfont[2]);
					$this->SetX($header_x);
					$this->MultiCell($cw, $cell_height, $headerdata['string'], 0, '', 0, 1, '', '', true, 0, false, true, 0, 'T', false);
					// print an ending header line
					$this->SetLineStyle(array('width' => 0.85 / $this->k, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => $headerdata['line_color']));
					$this->SetY((2.835 / $this->k) + max($imgy, $this->y));
					if ($this->rtl) {
						$this->SetX($this->original_rMargin);
					} else {
						$this->SetX($this->original_lMargin);
					}
					$this->Cell(($this->w - $this->original_lMargin - $this->original_rMargin), 0, '', 'T', 0, 'C');
					$this->endTemplate();
				}
				// print header template
				$x = 0;
				$dx = 0;
				if (!$this->header_xobj_autoreset AND $this->booklet AND (($this->page % 2) == 0)) {
					// adjust margins for booklet mode
					$dx = ($this->original_lMargin - $this->original_rMargin);
				}
				if ($this->rtl) {
					$x = $this->w + $dx;
				} else {
					$x = 0 + $dx;
				}
				$this->printTemplate($this->header_xobjid, $x, 0, 0, 0, '', '', false);
				if ($this->header_xobj_autoreset) {
					// reset header xobject template at each page
					$this->header_xobjid = false;
				}
				$pdfext 	= D('Pdfext');
				$pdfinfo 	= $pdfext->where('status=1')->limit(1)->select()[0];
				$pdfextshow = $pdfext->where('id=0')->select()[0]['textpic'];
				if( $pdfinfo != null && $pdfextshow == 1 && file_exists($pdfinfo['background']) ){
					
					$background 	= __ROOT__.'/'.$pdfinfo['background'];
					$bMargin = $this->getBreakMargin();
					// get current auto-page-break mode
					$auto_page_break = $this->AutoPageBreak;
					// disable auto-page-break
					$this->SetAutoPageBreak(false, 0);
					// set bacground image
					// $img_file = K_PATH_IMAGES.'img.png';
					$this->Image($background, 5, 30, 200, 350, '', '', '', false, 300, '', false, false, 0);
					// restore auto-page-break status
					$this->SetAutoPageBreak($auto_page_break, $bMargin);
					// set the starting point for the page content
					$this->setPageMark();
				}				
			}

		}


		$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdfext 	= D('Pdfext');
		$pdfinfo 	= $pdfext->where('status=1')->limit(1)->select()[0];
		$pdfextshow = $pdfext->where('id=0')->select()[0]['textpic'];
		if($pdfinfo != null && $pdfextshow == 1){
			if(file_exists($pdfinfo['headimg'])){
				$pdf->SetHeaderData('../../../../../../..'.__ROOT__.'/'.$pdfinfo['headimg'], '25', $pdfinfo['headerup'],$pdfinfo['headerdown']);
			}else{
				$pdf->SetHeaderData('', '25', $pdfinfo['headerup'],$pdfinfo['headerdown']);
			}
		}
		
		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Nicola Asuni');
		$pdf->SetTitle($info['realname']);
		$pdf->SetSubject('TCPDF Tutorial');
		$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

		

		// set header and footer fonts
		$pdf->setHeaderFont(Array('stsongstdlight', '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array('stsongstdlight', '', PDF_FONT_SIZE_DATA));

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);



		// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
			require_once(dirname(__FILE__).'/lang/eng.php');
			$pdf->setLanguageArray($l);
		}

		$pdf->AddPage();
		$pdf->SetFont('droidsansfallback', 'B', 25);
		

		$appname = $info['realname'];
		$pdf->Write(0, $appname.'应用安全检测管理报告', '', 0, 'C', true, 0, false, false, 0);
		// $html ="<br/>";

		// $pdf->writeHTML($html, true, false, true, false, '');
		$pdf->SetFont('droidsansfallback', 'B', 25);

		if($info['type'] == 'ipa'){
			$apptypename 	= "iOS版";
		}else{
			$apptypename 	= "Android版";
		}


		$pdf->Write(0, $apptypename, '', 0, 'C', true, 0, false, false, 0);

		$html = '<style>div .position{font-size:20;} </style>			
				<div style="text-align:center;">';
		if(substr($info['icon'], 0,4) == 'http'){
			$html .= '<img width="100" src="'.$info['icon'].'" /><br/>';
			// $html .= '<img width="100" src="'.$pdf->Image($info['icon'], 15, 140, 75, 113, 'PNG', 'http://www.tcpdf.org', '', true, 150, '', false, false, 1, false, false, false).'" /><br/>';
		}else{
			$html .= '<img width="100" src="'.__ROOT__.'/'.$info["icon"].'" /><br/>';
		}
		$html .='<span width="100px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
					<font size="60">'.ranking($info["secscore"]).'</font>
				</div>
				<div width="80" float="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font size="15" width="100">应用名&nbsp;&nbsp;:</font><font size="15">'.$info["realname"].'</font></div>
				<div width="80" float="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font size="15" width="100">版&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;本:</font><font size="15">'.$info["version"].'</font></div>
				<div width="80" float="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font size="15" width="100">MD5:&nbsp;</font><font size="15">'.$info["md5"].'</font></div>
				<div width="80" float="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font size="15" width="100">检测时间:&nbsp;</font><font size="15">'.$info["subtime"].'</font></div></div>';
		$pdf->SetFont('droidsansfallback', '', 6);

		$pdf->writeHTML($html, true, false, true, false, '');

		$html = '<div style="text-align:center;">
			<img height="18px" src="'.__ROOT__.'/Public/css/icon_anquan.png"/><font class="fclowrisk">通过</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<img height="18px" src="'.__ROOT__.'/Public/css/icon_diwei.png"/><font class="fcmidrisk">低危</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<img height="18px" src="'.__ROOT__.'/Public/css/icon_zhongwei.png"/><font class="fczhongwei">中危</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<img height="18px" src="'.__ROOT__.'/Public/css/icon_gaowei.png"/><font class="fchighrisk">高危</font></div>
		<style>
			.ws8{width:66.66667%}
			.fr{float:right;}
			.pt30{padding-top:30px;}
			.pb30{padding-bottom:30px;}
			.ml40{margin-left:40px;}
			.pl40{padding-left:40px;}
			.pr30{padding-right:30px;}
			.bdl9{border-left:1px solid #999;}
			.fs24{font-size:24px;}
			.mt15{margin-top:15px;}
			.ofh{overflow:hidden;}
			li.anqun{background:url(icon_anquan.png) left center no-repeat;}
			li.diwei{background:url(icon_diwei.png) left center no-repeat;}
			li.zhongwei{background:url(icon_zhongwei.png) left center no-repeat;}
			li.gaowei{background:url(icon_gaowei.png) left center no-repeat;}
			li span{padding-right:20px;}
			.fclowrisk{color:#10CA19; font-size:16;}
			.fczhongwei{color:#F5470A; font-size:16;}
			.fcmidrisk{color:orange; font-size:16;}
			.fchighrisk{color:red; font-size:16;}
			.fcwhite{color:#FFFFFF;}
		</style>
		<div class="ws8 fr pt30 pb30"><div class="pl40 pr30 show">';
		foreach ($detec as $k => $v) {
			if(($v['showdiv'] == 1) && ($v['first'] == 1)){ 
				$html .= '<div class="fs24">'.$v["zhtesttype"].'</div>';
				$html .=  '<div class="mt15 ofh">';
			}
            $html .='<ul>';
            if($v['result'] == 1){
                $html .='<img src="'.__ROOT__.'/Public/css/icon_anquan.png"/><span class="fclowrisk">&nbsp;&nbsp;&nbsp;&nbsp;'.$v["resultname"].'&nbsp;&nbsp;</span><span class="fclowrisk">&nbsp;&nbsp;'.$v["zhtestname"].'&nbsp;&nbsp;</span>';
            }
            if($v['result'] == 2){
                $html .='<img src="'.__ROOT__.'/Public/css/icon_diwei.png"/><span class="fcmidrisk">&nbsp;&nbsp;&nbsp;&nbsp;'.$v["resultname"].'&nbsp;&nbsp;</span><span class="fcmidrisk">&nbsp;&nbsp;'.$v["zhtestname"].'&nbsp;&nbsp;</span>';
            }
            if($v['result'] == 3){
                $html .='<img src="'.__ROOT__.'/Public/css/icon_zhongwei.png"/><span class="fczhongwei">&nbsp;&nbsp;&nbsp;&nbsp;'.$v["resultname"].'&nbsp;&nbsp;</span><span class="fczhongwei">&nbsp;&nbsp;'.$v["zhtestname"].'&nbsp;&nbsp;</span>';
            }
            if($v['result'] == 4){
                $html .='<img src="'.__ROOT__.'/Public/css/icon_gaowei.png"/><span class="fchighrisk">&nbsp;&nbsp;&nbsp;&nbsp;'.$v["resultname"].'&nbsp;&nbsp;</span><span class="fchighrisk">&nbsp;&nbsp;'.$v["zhtestname"].'&nbsp;&nbsp;</span>';
            }
            $html .= "</ul>";
            if(($v['showdiv'] == 1) && ($v['end'] == 1)){
            	$html .= '</div><hr />';
        	}
		}
		$html .= '</div></div>';

		$pdf->SetFont('droidsansfallback', '', 6);
		$pdf->writeHTML($html, true, false, true, false, '');


		$pdf->lastPage();
		$name = $info['package'].'_brief_'.$info['subtime'].'.pdf';
		$pdf->Output( $name, 'D');
	}

	function addLog($userid,$action){
		if(D('User')->find($userid)){
			$info   = D('user')->find($userid);
		}
		if(D('Admins')->find($userid)){
			$info   = D('Admins')->find($userid);
		}
             
		  $name   = $info['loginemail'];
              
		$data = array(
			'userid' 		=> $userid,
			'username'		=> $name,
			'handleip'		=> $_SERVER['REMOTE_ADDR'],
			'handletime'	=> time(),
			'handlecontent' => $action,
			'date'			=> date('Y-m-d')
			);
		$log 	= D('Log');
		$log->data($data)->add();
	}

	function addUploadApkRecord($userid){
		$admin = D('Admins');
		$user  = D('User');
		if  ($info = $admin->find($userid)) {
			$count = $info['count']+1;
			$admin->data(array('count'=>$count,'userid'=>$userid))->save();
		}
		if ($info = $user->find($userid)) {
			$count = $info['count']+1;
			$user->data(array('count'=>$count,'userid'=>$userid))->save();
		}
	}
	//展示日志
	//$logPath 是.log的日志文件的路径
	function logShow($logPath){
		$Path 			= explode('/',$logPath);
		$pLen 			= count($Path); 
		$logPath        = './'.$Path[$pLen-2]."/".$Path[$pLen-1];
		$content = file_get_contents($logPath); 
		$array = explode("\n", $content); 
		for($i=0; $i<count($array); $i++) 
		{ 
			$tmp[] = explode("\t\t", $array[$i]);
		} 
		foreach ($tmp as $k => $v) {
			foreach ($v as $k1 => $v1) {
				$tmp = explode(' ', $v1);
				if(count($tmp) ==2){
					$new_array[$k][] = $tmp[0];
					$new_array[$k][] = $tmp[1];
				}else{
					$new_array[$k][] = $v1;
				}
			}
		}
		return $new_array;
	}
	//搜索功能的数组
	//$logPath 是.log的日志文件的路径
	//$search  搜索条件
	function logShowSearch($search,$arr){
		$slen 			= count($search);
		foreach ($arr as $k => $v) {
			$res = 0;
			foreach ($search as $ks => $vs) {
				foreach ($v as $k1 => $v1) {
					if(strpos($v1,$vs) !==  false){
						++$res;
					}
				}
				if($res >= $slen){
					$goalArray[] =  $arr[$k];
					break;
				}
			}
		}
		return $goalArray;
	}

	function newLogShowSearch($search,$arr){
		//搜索的条件长度
		$slen  			= count($search);
		//数组长度
		$alen 			= count($arr);
		//循环数组,进行搜索
		for ($i=0; $i < $alen; $i++) { 
			//一次循环设置计数值为0
			$res = 0;
			//搜索条件的循环$slen次
			for ($j=0; $j < $slen ; $j++) { 
				//数组中的第$i个是6个长度,默认
				for ($l=0; $l < 6; $l++) { 
					//如果满足$search[$l] 在 $arr[$i][$j] 能够找到,$res 计数器就加1
					if($j == 0 && $l == 1){
						if(strpos($arr[$i][$l],$search[$j]) !== false){
							++$res;
						}
						if($search[$j] == ''){
							++$res;
						}
					}
					if($j == 1 && $l == 3){
						if(strpos($arr[$i][$l],$search[$j]) !== false){
							++$res;
						}
						if($search[$j] == ''){
							++$res;
						}
					}
					if($j == 2 && $l == 5){
						if(strpos($arr[$i][$l],$search[$j]) !== false){
							++$res;
						}
						if($search[$j] == ''){
							++$res;
						}
					}
					if($j == 3 && $l == 2){
						if(strpos($arr[$i][$l],$search[$j]) !== false){
							++$res;
						}
						if($search[$j] == ''){
							++$res;
						}
					}
					if($j == 4 && $l == 4){
						if(strpos($arr[$i][$l],$search[$j]) !== false){
							++$res;
						}
						if($search[$j] == ''){
							++$res;
						}
					}
				}
				if($res >= $slen){
					$goalArray[] = $arr[$i];
					break;
				}

			}
		}
		return $goalArray;
	}

	/**
	* 获取当前页面完整URL地址
	*/
	function get_url() {
		return $_SERVER['PHP_SELF'];
	}
 
	/**
	* 根据评分显示abcd四个等级
	*/
	// function ranking($score){
	// 	if($score <= 100 && $score >= 90){
	// 		return '<font color="green">'.$score.'分(A)</font>';
	// 	}elseif($score <= 89 && $score >= 75){
	// 		return '<font color="#A9E2C8">'.$score.'分(B)</font>';
	// 	}elseif($score <= 74 && $score >= 60){
	// 		return '<font color="orange">'.$score.'分(C)</font>';
	// 	}else{
	// 		return '<font color="red">'.$score.'分(D)</font>';
	// 	}
	// }
	function ranking($score){
		if($score <= 100 && $score >= 90){
			return '<font color="#3d8b40">'.$score.'分(A)</font>';
		}elseif($score <= 89 && $score >= 75){
			return '<font color="#006699">'.$score.'分(B)</font>';
		}elseif($score <= 74 && $score >= 60){
			return '<font style="color:#ffbe00;">'.$score.'分(C)</font>';
		}else{
			return '<font style="color:#f44336;">'.$score.'分(D)</font>';
		}
	}


	function makeMpdfReport($info,$detec){
		Vendor('mpdf60.mpdf');
		$pdfext 	= D('Pdfext');
		$pdfinfo 	= $pdfext->where('status=1')->limit(1)->select()[0];
		$pdfextshow = $pdfext->where('id=0')->select()[0]['textpic'];
		if( $pdfinfo != null && $pdfextshow == 1 ){
			if(!file_exists($pdfinfo['compic'])){
				$headerpic		= ''.__ROOT__.'/Public/img/squarelogo.png';
			}else{
				$headerpic 		= ''.__ROOT__.'/'.$pdfinfo['compic'];
			}

			$headercontent 	= $pdfinfo['header'];
			$footercontent 	= $pdfinfo['footer'];
			$marktext 		= $pdfinfo['watermark'];
			$header = '
			<table width="100%" style="border-bottom: 1px solid #000000; vertical-align: bottom; font-size: 10pt; "><tr>
			<td width="66%"><span style="font-weight: bold;">'.$headercontent.'</span></td>
			<td width="33%" align="right"><img src="'.$headerpic.'" width="20px" /></td>
			</tr></table>';
			$mpdf->autoScriptToLang = true;
			//页底
			$mpdf->SetHTMLHeader($header);
			$footer = "<hr/><table width='100%'><tr>
				<td style='font-size:10pt;width:80%;'>{$footercontent}</td>
				<td style='font-size:10pt;width:20%;' align='right'><span>第 {PAGENO} 页</span></td>
				</tr></table>";
			$mpdf->SetHTMLFooter($footer);
		}
		// var_export($pdfextshow);
		//设置中文编码
		$mpdf 		= new \mPDF('zh-CN','A4',0,'宋体');
		$mpdf->useAdobeCJK=true; //打开这个选项比较好
		$mpdf->SetDisplayMode('fullpage');
		$mpdf->SetWatermarkText($marktext);
		$mpdf->showWatermarkText = true;
		//页眉内容
		
		if($info['type'] == 'ipa'){
			$apptypename 	= "iOS版";
		}else{
			$apptypename 	= "Android版";
		}

		//第一页
		$html = '<style>
			table.show{ border: 1px solid;border-collapse: collapse;width:100%;height:auto;}
			.show td { border: 1px solid #cbcbcb; border-collapse: collapse;}
			.show tr{ border: 1px solid #cbcbcb; border-collapse: collapse;}
			.showtd { width:20%; text-align:center;}
			showtd2 { height:auto;font-size:12pt; }
			h1 font{ font-weight:5px; }
			b{ width:5px; }
			.childtitle{ font-size:36pt;font-weight:normal; }
			div .position{ font-size:20; } 
			.xiahuaxian{ text-decoration:underline;min-width: 400px; }
			.grandtitle{ font-size:20px;font-weight:4; }
			</style>
		<h1>&nbsp;</h1><h1>&nbsp;</h1>
		<h1 align="center"><font size="20px"><b>'.$info['realname'].'</b></font>应用安全检测评估报告'.'</h1>
		<h1 align="center"><font size="20px"><b>'.$apptypename.'</b></font></h1>
		<h1>&nbsp;</h1><h1>&nbsp;</h1>
				<div style="text-align:center;">
					<div>';
		if(substr($info['icon'], 0,4) == 'http'){
			$html .= '<img width="100" src="'.$info['icon'].'" /><br/>';
		}else{
			$html .= '<img width="100" src="'.__ROOT__.'/'.$info["icon"].'" /><br/>';
		}			
		$html .= '</div>
				</div>
				<h1>&nbsp;</h1><h1>&nbsp;</h1>
				<div align="center">
					<table style="font-size:20px;margin-left:180px;">
						<tr><td>应用名</td><td><span>'.$info["realname"].'</span><hr width="300px" style="margin-top:0px;margin-bottom:-5px;"/></td></tr>
						<tr><td>版本号</td><td><span>'.$info["version"].'</span><hr width="300px" style="margin-top:0px;margin-bottom:-5px;"/></td></tr>
						<tr><td>检测时间</td><td><span>'.$info["subtime"].'</span><hr width="300px" style="margin-top:0px;margin-bottom:-5px;"/></td></tr>
					</table>
				</div>
				</div>';
		$mpdf->writeHTML($html);

		$mpdf->AddPage();
		$html = '
		<span>&nbsp;</span><p class="childtitle">一、检测概述</p><div style="text-align:center;">';
		if(substr($info['icon'], 0,4) == 'http'){
			$html .= '<img width="100" src="'.$info['icon'].'" /><br/>';
		}else{
			$html .= '<img width="100" src="'.__ROOT__.'/'.$info["icon"].'" /><br/>';
		}
		$html='<br/>
			<font  size="18pt" style="padding-top: 0.5mm;padding-bottom: 0.5mm;">'.$info["realname"].'</font><br/>
			<font  size="18pt" style="padding-top: 0.5mm;padding-bottom: 0.5mm;">安全等级</font><br/><font style="font-size:25pt">'.ranking($info["secscore"]).'</font>
		</div>';
		$gaowei = 0;
		foreach ($detec as $k => $v) {
			if($v["result"] == 4){
				++$gaowei;
			}
		}
		$html .= '<p class="childtitle">二、基本信息</p>
		<table class="show" style="text-align: left;width:100%;">
			<tr>
				<td style="width:100px;">应用名称</td>
				<td>'.$info["realname"].'</td>
				<td style="width:100px;">版本号</td>
				<td>'.$info["version"].'</td>
			</tr>
			<tr>
				<td style="width:100px;">包名</td>
				<td>'.$info["package"].'</td>
				<td style="width:100px;">检测时间</td>
				<td>'.$info["subtime"].'</td>
			</tr>
			<tr>
				<td width="110px">高危漏洞个数</td><td >'.$gaowei.'</td>
				<td>漏洞个数</td><td >'.$info["bugs"].'</td>
			</tr>
			<tr>
				<td style="width:100px;">MD5</td><td colspan="3" >'.$info["md5"].'</td>
			</tr>
			<tr>
				<td style="width:100px;">SHA-1</td><td colspan="3" >'.$info["sha1"].'</td>
			</tr>
			<tr>
				<td style="width:100px;">SHA-256</td><td colspan="3" >'.$info["sha256"].'</td>
			</tr>
			<tr>
				<td style="width:100px;">证书信息</td><td colspan="3" >'.$info["cert"].'</td>
			</tr>
		</table>';
		$html .=  '<p class="childtitle">三、检测概述</p>
		<table style="text-align: left;" class="show">
				<tr><td style="text-align:center;width:100px;" >序号</td><td style="text-align:center;width:330px;">检测项目</td><td style="text-align:center;width:110px;">检测类型</td><td style="text-align:center;width:110px;">危险系数</td></tr>';
		foreach ($detec as $k => $v) {
			$index = $k + 1;
			$html .= '<tr><td style="text-align:center;">'.$index.'</td><td>'.$v["zhtestname"].'</td><td style="text-align:center;">'.$v["zhtesttype"].'</td><td style="text-align:center;">';
			if($v['result'] == 1){
				$html .= '<font color="#10CA19">'.$v['resultname'].'</font>';
			}elseif($v['result'] == 2){
				$html .= '<font color="orange">'.$v['resultname'].'</font>';
			}
			elseif($v['result'] == 3){
				$html .= '<font color="#F5470A">'.$v['resultname'].'</font>';
			}else{
				$html .= '<font color="red">'.$v['resultname'].'</font>';
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
		$len = count($detec);
		for($k=0;$k<$len;++$k){
			if($oldtestytpt==$detec[$k]['testtype']){

			}else{
				$html .= "<p class='grandtitle'>".$testtypenum.'、  '.$detec[$k]['zhtesttype']."</p>";
				$testtypenum ++;
			}
			$oldtestytpt=$detec[$k]['testtype'];
			$html .= "<table class='show'>
				<tr><td class='showtd'>检测名称</td><td>".$detec[$k]['zhtestname']."</td></tr>";
			$html .= "<tr><td align='center'>检测说明</td><td class='showtd2'>".$detec[$k]['damage']."</td></tr>";
			$html .= "<tr><td align='center'>检测结果</td><td>";
			if($detec[$k]['result'] == 1){
				$html .= '<font color="#10CA19">'.$detec[$k]['resultname'].'</font>';
			}elseif($detec[$k]['result'] == 2){
				$html .= '<font color="orange">'.$detec[$k]['resultname'].'</font>';
			}elseif($detec[$k]['result'] == 3){
				$html .= '<font color="#F5470A">'.$detec[$k]['resultname'].'</font>';
			}else{
				$html .= '<font color="red">'.$detec[$k]['resultname'].'</font>';
			}
			$html .= "</td></tr>";
			if(trim($detec[$k]['info'],' ') != null){
				$html .= "<tr><td align='center'>检测详情</td><td class='showtd2'>".$detec[$k]['info']."</td></tr>";
			}
			if($detec[$k]['result'] != 1 && $detec[$k]['suggest'] != null){
				$html .= "<tr><td align='center'>修复建议</td><td class='showtd2'>".$detec[$k]['suggest']."</td></tr>";
			}
			$html .= "</table><br/><br/>";
		}	
		$mpdf->WriteHTML($html);
		$name = $info['package'].strtotime($info['subtime']).'.pdf';
		// $mpdf->Output($name,'D');
		$mpdf->Output();
		exit;
	}

	function showtableContent($str){
		$onerow = 36;
		$n = ceil(mb_strlen($str,'utf-8')/$onerow);
		for($i=0;$i<=$n;++$i){
			$first = ($i-1)*$onerow;
			$end   = $i*$onerow;
			if($i == 1){
				$newstr = substr($str,$first,$end,'utf-8')."<br/>";
			}else{
				$newstr .= substr($str,$first,$end,'utf-8')."<br/>";
			}
		}
		return $newstr;
	}

	function makeMpdfBrief($info,$detec){
		Vendor('mpdf60.mpdf');
		$pdfext 	= D('Pdfext');
		$pdfinfo 	= $pdfext->where('status=1')->limit(1)->select()[0];
		$pdfextshow = $pdfext->where('id=0')->select()[0]['textpic'];
		if( $pdfinfo != null && $pdfextshow == 1 ){
			if(!file_exists($pdfinfo['compic'])){
				// $headerpic		= ''.__ROOT__.'/Public/img/squarelogo.png';
				 $headerpic		= __ROOT__.'/Public/img/squarelogo.png';
			}else{
				// $headerpic 		= ''.__ROOT__.'/'.$pdfinfo['compic'];
				$headerpic 		= __ROOT__.'/'.$pdfinfo['compic'];
			}

			$headercontent 	= $pdfinfo['header'];
			$footercontent 	= $pdfinfo['footer'];
			$marktext 		= $pdfinfo['watermark'];
			$header = '
			<table width="100%" style="border-bottom: 1px solid #000000; vertical-align: bottom; font-size: 10pt; "><tr>
			<td width="66%"><span style="font-weight: bold;">'.$headercontent.'</span></td>
			<td width="33%" align="right"><img src="'.$headerpic.'" width="20px" /></td>
			</tr></table>';
			$mpdf->autoScriptToLang = true;
			//页底
			$mpdf->SetHTMLHeader($header);
			$footer = "<br/><table width='100%'><tr>
				<td style='font-size:10pt;width:80%;'>{$footercontent}</td>
				<td style='font-size:10pt;width:20%;' align='right'><span>第 {PAGENO} 页</span></td>
				</tr></table>";
			$mpdf->SetHTMLFooter($footer);
		}
		// var_export($pdfextshow);
		//设置中文编码
		$mpdf 		= new \mPDF('zh-CN','A4',0,'宋体');
		$mpdf->useAdobeCJK=true; //打开这个选项比较好
		$mpdf->SetDisplayMode('fullpage');
		$mpdf->SetWatermarkText($marktext);
		$mpdf->showWatermarkText = true;
		//页眉内容
				


		$html = '<div style="text-align:center;">
					<h1>&nbsp;&nbsp;</h1>
					<h1 style="font-size:26pt;">'.$info["realname"].'应用安全检测管理报告</h1>
					<h1 style="font-size:26pt;">Android版</h1>';
		if(substr($info['icon'], 0,4) == 'http'){
			$html .= '<img width="100" src="'.$info['icon'].'" /><br/>';
		}else{
			$html .= '<img width="100" src="'.__ROOT__.'/'.$info["icon"].'" /><br/>';
		}
		$html .='<span width="100px;">&nbsp;</span>
					<font style="font-size:50pt;">'.ranking($info["secscore"]).'</font>
				</div>
				<table style="font-size:20px;margin-left:180px;">
					<tr><td>应用名</td><td >'.$info["realname"].'</td></tr>
					<tr><td>版本号</td><td>'.$info["version"].'</td></tr>
					<tr><td>MD5</td><td>'.$info["md5"].'</td></tr>
					<tr><td>检测时间</td><td>'.$info["subtime"].'</td></tr>
				</table>';
		$mpdf->writeHTML($html);

		$html = '<br/><div style="text-align:center;">
			<img height="18px" src="'.__ROOT__.'/Public/css/icon_anquan.png"/><font class="fclowrisk">通过</font>
			<img height="18px" src="'.__ROOT__.'/Public/css/icon_diwei.png"/><font class="fcmidrisk">低危</font>
			<img height="18px" src="'.__ROOT__.'/Public/css/icon_zhongwei.png"/><font class="fczhongwei">中危</font>
			<img height="18px" src="'.__ROOT__.'/Public/css/icon_gaowei.png"/><font class="fchighrisk">高危</font></div>
		<style>
			.ws8{width:66.66667%}
			.fr{float:right;}
			.pt30{padding-top:30px;}
			.pb30{padding-bottom:30px;}
			.ml40{margin-left:40px;}
			.pl40{padding-left:40px;}
			.pr30{padding-right:30px;}
			.bdl9{border-left:1px solid #999;}
			.fs24{font-size:24px;}
			.mt15{margin-top:15px;}
			.ofh{overflow:hidden;}
			li.anqun{background:url(icon_anquan.png) left center no-repeat;}
			li.diwei{background:url(icon_diwei.png) left center no-repeat;}
			li.zhongwei{background:url(icon_zhongwei.png) left center no-repeat;}
			li.gaowei{background:url(icon_gaowei.png) left center no-repeat;}
			li span{padding-right:20px;}
			.fclowrisk{color:#10CA19; font-size:14pt;}
			.fczhongwei{color:#F5470A; font-size:14pt;}
			.fcmidrisk{color:orange; font-size:14pt;}
			.fchighrisk{color:red; font-size:14pt;}
			.fcwhite{color:#FFFFFF;}
		</style>
		<div class="fr pt30 pb30"><div class="pl40 pr30 show">';
		$dlen = count($detec);
		foreach ($detec as $k => $v) {
			if(($v['showdiv'] == 1) && ($v['first'] == 1)){ 
				$html .= '<div class="fs24">'.$v["zhtesttype"].'</div>';
				$html .=  '<div class="mt15 ofh">';
			}
            $html .='<ul>';
            if($v['result'] == 1){
                $html .='<img src="'.__ROOT__.'/Public/css/icon_anquan.png"/><span class="fclowrisk">&nbsp;&nbsp;&nbsp;&nbsp;'.$v["resultname"].'&nbsp;&nbsp;</span><span class="fclowrisk">&nbsp;&nbsp;'.$v["zhtestname"].'&nbsp;&nbsp;</span>';
            }
            if($v['result'] == 2){
                $html .='<img src="'.__ROOT__.'/Public/css/icon_diwei.png"/><span class="fcmidrisk">&nbsp;&nbsp;&nbsp;&nbsp;'.$v["resultname"].'&nbsp;&nbsp;</span><span class="fcmidrisk">&nbsp;&nbsp;'.$v["zhtestname"].'&nbsp;&nbsp;</span>';
            }
            if($v['result'] == 3){
                $html .='<img src="'.__ROOT__.'/Public/css/icon_zhongwei.png"/><span class="fczhongwei">&nbsp;&nbsp;&nbsp;&nbsp;'.$v["resultname"].'&nbsp;&nbsp;</span><span class="fczhongwei">&nbsp;&nbsp;'.$v["zhtestname"].'&nbsp;&nbsp;</span>';
            }
            if($v['result'] == 4){
                $html .='<img src="'.__ROOT__.'/Public/css/icon_gaowei.png"/><span class="fchighrisk">&nbsp;&nbsp;&nbsp;&nbsp;'.$v["resultname"].'&nbsp;&nbsp;</span><span class="fchighrisk">&nbsp;&nbsp;'.$v["zhtestname"].'&nbsp;&nbsp;</span>';
            }
            $html .= "</ul>";
            if(($v['showdiv'] == 1) && ($v['end'] == 1)){
            	$html .= '</div>';
            	if($k != -1 ){
            		$html .= '<hr />';
            	}            	
        	}
		}
		$html .= '</div></div>';

		$mpdf->writeHTML($html);
		$name = $info['package'].'_brief_'.strtotime($info['subtime']).'.pdf';
		$mpdf->Output($name,'D');
		exit;
	}

	//给出间隔的开始和结束时间
	//$starttime 	是设置的最初时间
	//$space  		时间的间隔
	//$currenttime 	当前时间
	//返回 时间段的初始和结束时间
	function timespace($starttime,$currenttime,$space){
		if(is_numeric($starttime) && is_numeric($space) && is_numeric($currenttime))
		{
			//当前时间减去最初设定时间
			//除以时间间隔,并取得其商和商加1
			$end 	= (ceil(($currenttime - $starttime) / $space) * $space)+$starttime ; 
			$start  = (floor(($currenttime - $starttime) / $space) * $space)+$starttime ;
			return array('start'=>$start,'end'=>$end);
		}
		else
		{
			return false;
		}
	}
	//下载时间间隔限制
	function downtimespace(){
		$timespace 			= D('Timespace');
		if($_SESSION['power']['downtimespaceid'] != null){
			$downspace 		= $timespace->find($_SESSION['power']['downtimespaceid'])['timespace'];
			$starttime		= intval($_SESSION['power']['dstarttime']);
			$currenttime 	= time();
			$space 			= intval($_SESSION['power']['dtp'] * $downspace);
			$bettwen  		= timespace($starttime,$currenttime,$space);
		}else{
			//如果没有限定就设置为1天内的限制
			$bettwen 		= array('start'=>strtotime(date('Y-m-d')),array('end'=>strtotime(date('Y-m-d'),strtotime('+1 day'))));
		}
		if($bettwen == false){
			$bettwen 		= array('start'=>strtotime(date('Y-m-d')),array('end'=>strtotime(date('Y-m-d'),strtotime('+1 day'))));
		}
		return $bettwen;
	}

	//上传时间间隔限制
	function uploadtimespace(){
		$timespace 			= D('Timespace');
		if($_SESSION['power']['uploadtimespaceid'] != null){
			$downspace 		= $timespace->find($_SESSION['power']['uploadtimespaceid'])['timespace'];
			$starttime		= intval($_SESSION['power']['ustarttime']);
			$currenttime 	= time();
			$space 			= intval($_SESSION['power']['utp'] * $downspace);
			$bettwen  		= timespace($starttime,$currenttime,$space);
		}else{
			//如果没有限定就设置为1天内的限制
			$bettwen 		= array('start'=>strtotime(date('Y-m-d')),array('end'=>strtotime(date('Y-m-d'),strtotime('+1 day'))));
		}
		if($bettwen == false){
			$bettwen 		= array('start'=>strtotime(date('Y-m-d')),array('end'=>strtotime(date('Y-m-d'),strtotime('+1 day'))));
		}
		return $bettwen;
	}
        
       //下载word 
    function downloadWord($content, $file=''){
    header("Cache-Control: no-cache, must-revalidate");
    header("Pragma: no-cache");
    header("Content-Type: application/octet-stream");
    header("Content-Disposition: attachment; filename=$file");
    $ext = substr(end(explode('.', $file)), 0, 3);
    switch($ext){
        case 'doc' : 
            $html = '<html xmlns:v="urn:schemas-microsoft-com:vml"xmlns:o="urn:schemas-microsoft-com:office:office"
                 xmlns:w="urn:schemas-microsoft-com:office:word" xmlns:m="http://schemas.microsoft.com/office/2004/12/omml"xmlns="http://www.w3.org/TR/REC-html40">';
            $html .= '<head></head>';
            break;
        case 'xls':
            $html = '<html xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office"xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">';
            $html .= '<head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name></x:Name><x:WorksheetOptions><x:Selected/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head>';
    }
    echo $html . '<body>'.$content .'</body></html>';
     
}





function makePdfReportss($appid){
		Vendor('tcpdf.tcpdf');
		class MYPDFF extends TCPDF {

			//需要传递背景图片进来
			public function Header() {
				if ($this->header_xobjid === false) {
					// start a new XObject Template
					$this->header_xobjid = $this->startTemplate($this->w, $this->tMargin);
					$headerfont = $this->getHeaderFont();
					$headerdata = $this->getHeaderData();
					$this->y = $this->header_margin;
					if ($this->rtl) {
						$this->x = $this->w - $this->original_rMargin;
					} else {
						$this->x = $this->original_lMargin;
					}
					if (($headerdata['logo']) AND ($headerdata['logo'] != K_BLANK_IMAGE)) {
						$imgtype = TCPDF_IMAGES::getImageFileType(K_PATH_IMAGES.$headerdata['logo']);
						if (($imgtype == 'eps') OR ($imgtype == 'ai')) {
							$this->ImageEps(K_PATH_IMAGES.$headerdata['logo'], '', '', '','7.5');
						} elseif ($imgtype == 'svg') {
							$this->ImageSVG(K_PATH_IMAGES.$headerdata['logo'], '', '', '','7.5');
						} else {
							$this->Image(K_PATH_IMAGES.$headerdata['logo'], '', '', '','7.5');
						}
						$imgy = $this->getImageRBY();
					} else {
						$imgy = $this->y;
					}
					$cell_height = $this->getCellHeight($headerfont[2] / $this->k);
					// set starting margin for text data cell
					$imglogwidth = getimagesize(K_PATH_IMAGES.$headerdata['logo']);
					//页眉logo图片的在pdf中的宽度等于 宽除以高 再除以13,目前看来最合适的比例
					$tmpwidth  = $imglogwidth[0] * ( $imglogwidth[0] / $imglogwidth[1] / 13 ); 

					if ($this->getRTL()) {
						$header_x = $this->original_rMargin + ($tmpwidth);
					} else {
						$header_x = $this->original_lMargin + ($tmpwidth);
					}
					$cw = $this->w - $this->original_lMargin - $this->original_rMargin - ($tmpwidth);
					$this->SetTextColorArray($this->header_text_color);
					// header title
					$this->SetFont($headerfont[0], 'B', $headerfont[2] + 1);
					$this->SetX($header_x);
					$this->Cell($cw, $cell_height, $headerdata['title'], 0, 1, '', 0, '', 0);
					// header string
					$this->SetFont($headerfont[0], $headerfont[1], $headerfont[2]);
					$this->SetX($header_x);
					$this->MultiCell($cw, $cell_height, $headerdata['string'], 0, '', 0, 1, '', '', true, 0, false, true, 0, 'T', false);
					// print an ending header line
					$this->SetLineStyle(array('width' => 0.85 / $this->k, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => $headerdata['line_color']));
					$this->SetY((2.835 / $this->k) + max($imgy, $this->y));
					if ($this->rtl) {
						$this->SetX($this->original_rMargin);
					} else {
						$this->SetX($this->original_lMargin);
					}
					$this->Cell(($this->w - $this->original_lMargin - $this->original_rMargin), 0, '', 'T', 0, 'C');
					$this->endTemplate();
				}
				// print header template
				$x = 0;
				$dx = 0;
				if (!$this->header_xobj_autoreset AND $this->booklet AND (($this->page % 2) == 0)) {
					// adjust margins for booklet mode
					$dx = ($this->original_lMargin - $this->original_rMargin);
				}
				if ($this->rtl) {
					$x = $this->w + $dx;
				} else {
					$x = 0 + $dx;
				}
				$this->printTemplate($this->header_xobjid, $x, 0, 0, 0, '', '', false);
				if ($this->header_xobj_autoreset) {
					// reset header xobject template at each page
					$this->header_xobjid = false;
				}
				$pdfext 	= D('Pdfext');
				$pdfinfo 	= $pdfext->where('status=1')->limit(1)->select()[0];
				$pdfextshow = $pdfext->where('id=0')->select()[0]['textpic'];
				if( $pdfinfo != null && $pdfextshow == 1 && file_exists($pdfinfo['background']) ){
					
					$background 	= __ROOT__.'/'.$pdfinfo['background'];
					$bMargin = $this->getBreakMargin();
					// get current auto-page-break mode
					$auto_page_break = $this->AutoPageBreak;
					// disable auto-page-break
					$this->SetAutoPageBreak(false, 0);
					// set bacground image
					// $img_file = K_PATH_IMAGES.'img.png';
					$this->Image($background, 5, 30, 200, 350, '', '', '', false, 300, '', false, false, 0);
					// restore auto-page-break status
					$this->SetAutoPageBreak($auto_page_break, $bMargin);
					// set the starting point for the page content
					$this->setPageMark();
				}				
			}

		}


		$pdf = new MYPDFF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdfext 	= D('Pdfext');
		$pdfinfo 	= $pdfext->where('status=1')->limit(1)->select()[0];
		$pdfextshow = $pdfext->where('id=0')->select()[0]['textpic'];
		if($pdfinfo != null && $pdfextshow == 1){
			if(file_exists($pdfinfo['headimg'])){
				$pdf->SetHeaderData('../../../../../../..'.__ROOT__.'/'.$pdfinfo['headimg'], '25', $pdfinfo['headerup'],$pdfinfo['headerdown']);
			}else{
				$pdf->SetHeaderData('', '25', $pdfinfo['headerup'],$pdfinfo['headerdown']);
			}
		}
		
        
		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Nicola Asuni');
		$pdf->SetTitle($info['realname']);
		$pdf->SetSubject('TCPDF Tutorial');
		$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

		// set header and footer fonts
		$pdf->setHeaderFont(Array('stsongstdlight', '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array('stsongstdlight', '', PDF_FONT_SIZE_DATA));

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);//PDF_MARGIN_HEADER
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
			require_once(dirname(__FILE__).'/lang/eng.php');
			$pdf->setLanguageArray($l);
		}
        
		$pdf->AddPage();

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
                                 <h2>检测工具:Fortify</h2>';
    
          $pdf->SetFont('droidsansfallback', '', 12);   
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
                             text-align:left;
                              height:35px;
                                 line-height:1.8;
                                font-size:16px;
                                 background-color: #a8000b;
                                 color: #ffffff;
                        }
                         .danger-1s{
                               text-align:left;
                              height:35px;
                                 line-height:1.8;
                                font-size:16px;
                                 background-color: #ff212f;
                                 color: #ffffff;
                         }
                         .warning-1s{
                                text-align:left;
                                height:35px;
                                 line-height:1.8;
                                font-size:16px;
                                 background-color: #FF9800;
                                 color: #ffffff;
                         }
                         .normal-1s{
                                text-align:left;  
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
                               font-size:14px;
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
                        height:25px;
                        line-height:1.8;
                           }
                       .td{
                        text-align:center;
                        height:30px;
                        line-height:1.8;
                         }  
                      .tds{
                        text-align:left;
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
                                                         <h2 style="font-size:20px;">摘要</h2>
                                                         <div class="clearfix"></div>
                                                         <p>本报告为开发人员提供源代码扫描细节和信息理解和解决源代码审计过程中发现的风险。本报告的读者主要是项目经理和开发人员。本节提供的分析过程中发现的风险进行了概述。</p>
                                                 </div>
                                                  <table class="table table-bordered" border="1">
                                                
                                                         <tbody>
                                                                 <tr>
                                                                         <td class="td">项目名</td>
                                                                         <td class="td">' . $info['name'] . '</td>
                                                                         <td class="td">检测工具</td>
                                                                         <td class="td">Fortify(16.10.0095 )</td>
                                                                 </tr>
                                                                 <tr>
                                                                         <td class="td">软件版本</td>
                                                                         <td class="td">' . $info['version'] . '</td>
                                                                         <td class="td">风险库版本</td>
                                                                         <td class="td">16.10.0095</td>
                                                                 </tr>
                                                                  <tr>
                                                                         <td class="td">编译环境</td>
                                                                         <td class="td">' .$info['env'] . '</td>
                                                                         <td class="td">代码语言</td>
                                                                         <td class="td">' . $info['lang'] . '</td>
                                                                 </tr>
                                                                  <tr>
                                                                         <td class="td">压缩包MD5</td>
                                                                         <td class="td">' .$info['md5'] . '</td>
                                                                         <td class="td">预编译命令</td>
                                                                         <td class="td">' . $info['shell'] . '</td>
                                                                 </tr>
                                                                  <tr>
                                                                         <td class="td">提交时间</td>
                                                                         <td class="td">' .$info['subtime']. '</td>
                                                                         <td class="td">测试用时</td>
                                                                         <td class="td">' . $info['spendtime'] . '</td>
                                                                 </tr>
                                                                 <tr>
                                                                         <td class="td">风险种类个数</td>
                                                                         <td class="td">' . $leicount . '</td>
                                                                         <td class="td">中危风险个数</td>
                                                                         <td class="td">' . $midcount . '</td>
                                                                 </tr>
                                                                 <tr>
                                                                         <td class="td">总风险个数</td>
                                                                         <td class="td">' . $count . '</td>
                                                                         <td class="td">高危风险个数</td>
                                                                         <td class="td">'. $hcount . '</td>
                                                                 </tr>
                                                         </tbody>
                                                 </table>
                                         </div>

                                         <div class="bottom-line"></div>';
//                           <div style="padding-left:60px;" >   <img src="' . __ROOT__ . '/Uploads/example/one.png" hight="250px" width="460px" ></div>
                            //   $pdf->SetFont('droidsansfallback', '', 12);   
//                                                        
                            if($shu){
                                   $html .='
                                             <div style="padding-left:50px;">    <img style="text-align:center" src="http://'.$_SERVER["HTTP_HOST"]. __ROOT__ . '/Uploads/example/two.png "   hight="100px" width="550px"></div>';
//                                            $mpdf->writeHTML($html);
//                                            $mpdf->AddPage(); <img src="' . __ROOT__ . '/Uploads/example/f.png "  hight="100px" width="560px">
                                     $html .=' <div class="report-group">
                                                 <div class="title">
                                                         <h2 style="font-size:20px;">风险汇总</h2>
                                                         <div class="clearfix"></div>
                                                 </div>

                                                 <div class="chart-img"  >
                                                                      <div > <img  src="http://'.$_SERVER["HTTP_HOST"]. __ROOT__ . '/Uploads/example/three.png " width="500px" ></div> 
                                                                      <div> <img style="text-align:center" src="http://'.$_SERVER["HTTP_HOST"].__ROOT__.'/Uploads/example/f.png" width="550px"/></div>

                                                  </div>

                                                 </div>
                                                  <p></p>
                                                 <table class="table table-bordered" border="1">
                                                         <thead>
                                                                 <tr class="tr">
                                                                         <th class="count" width="50%">类别</th>
                                                                         <th class="cridanger-1" width="10%" >严重数</th>
                                                                         <th class="danger-1" width="10%">高危数</th>
                                                                         <th class="warning-1" width="10%">中危数</th>
                                                                         <th class="normal-1" width="10%">低危数</th>
                                                                         <th class="count" width="10%">统计</th>
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
            $html .='<tr >
                                                                         <td class="tds" width="50%">' . $listb . '</td>
                                                                         <td class="td" width="10%">' . $crib . '</td>
                                                                         <td class="td" width="10%">' . $hib . '</td>
                                                                         <td class="td" width="10%">' . $medb . '</td>
                                                                         <td class="td" width="10%">' . $lowb . '</td>
                                                                         <td class="td" width="10%">' . $sumcount . '</td>
                                                                 </tr>';
        }

        $html.=' </tbody>
                                                 </table>
                                         </div>

                                         <div class="bottom-line"></div>

                                         <div class="report-group">
                                         <h2 class="text-center" style="font-size:20px;">风险详情</h2>';

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

            $html .= '    <h2 style="font-size:20px;">第' . $k . '类：' . $testtype . '</h2>
                              <h2 style="font-size:20px;">中文名：'.$data['zhtesttype'].'</h2>
                                                 <div class="title">
                                                         <h2 style="font-size:20px;">风险解释</h2>
                                                         <div class="clearfix"></div>
                                                         <p>'.$data['damage'].'</p>
                                                 </div>
                                                 <div class="title">
                                                         <h2 style="font-size:20px;">修复建议</h2>
                                                         <div class="clearfix"></div>
                                                         <p>'.$data['suggest'].'</p>
                                                 </div>

                                                 <div class="title">
                                                         <h2 style="font-size:20px;">概要</h2>
                                                         <div class="clearfix"></div>
                                                 </div>
                                                 <table class="table table-bordered" border="1">
                                                         <thead>
                                                                 <tr>
                                                                         <th class="count" width="45%">类别</th>
                                                                          <th class="cridanger-1" width="11%">严重数</th>
                                                                         <th class="danger-1" width="11%">高危数</th>
                                                                         <th class="warning-1" width="11%">中危数</th>
                                                                         <th class="normal-1" width="11%">低危数</th>
                                                                         <th class="count" width="11%">统计</th>
                                                                 </tr>
                                                         </thead>
                                                         <tbody>
                                                                 <tr>';
            $html.='                                        <td class="tds" width="45%">' . $testtype . '</td>
                                                               <td class="td" width="11%">' . $cribb . '</td>
                                                               <td class="td" width="11%">' . $hibb . '</td>
                                                               <td class="td" width="11%">' . $medbb . '</td>
                                                               <td class="td" width="11%">' . $lowbb . '</td>
                                                               <td class="td" width="11%">' . $sumcountb . '</td>';

            $html .='</tr>

                                                         </tbody>
                                                 </table>

                                                 <div class="title">
                                                         <h2 style="font-size:20px;">详情</h2>
                                                         <div class="clearfix"></div>
                                                 </div>
                                               
                                                

              

                                                 <div class="report-detail">';
            
                                  //   break;

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
                                                <tr >
							<th class="cri">风险名称：'.$data['zhtesttype'].'</th>
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
                             //   break;
                                
                      
                    
                    
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
		
      //  echo $html;die;
		$pdf->SetFont('droidsansfallback', '', 11);
		$pdf->writeHTML($html, true, false, true, false, '');


		$pdf->lastPage();
              
             //   $name = '源代码安全检测报表'.'.pdf';
		$name ='report'.'.pdf';
		$pdf->Output( $name, 'D');
	}    
        
    