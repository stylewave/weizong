<?php
namespace Home\Controller;
use Think\Controller;
class ManageController extends CommonController {


	//理出所用日志
	public function log_manage(){
		R('Layout/ismanage');
		$log = D('Log');
		$logday 		= $log->field('handletime')->order('date ASC')->group('handletime')->select();
		//日志翻页
		$count 			= $log->count();
		$page 			= ($page == null) ? 0 : I('get.page');
		$countnum		= 20;
		$p 				= new \Think\Page($count,$countnum);
		$p->lastSuffix=false;
		$p->setConfig('header','<br/><li class="rows">共<b>%TOTAL_ROW%</b>条记录  每页<b>'.$countnum.'</b>条  第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页</li>');
		$p->setConfig('prev','上一页');
		$p->setConfig('last','末页');
		$p->setConfig('first','首页');
		$p->setConfig('next','下一页');
		$p->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
		$page 			= $p->show();
		$logToday 	= $log->field('at_log.*,at_user.realname')->limit($p->firstRow.','.$p->listRows)->join('left join at_user on at_user.userid = at_log.userid')->order('handletime desc')->select();
              //  dump($logToday);die;
		$this->assign('logday',$logday);

		$this->assign('pageshow',$page);
		$this->assign('logToday',$logToday);
		$this->display();
	}

	public function searchlog_manage(){
		R('Layout/ismanage');
		$log 						= D('Log');
		$data 						= array();
		if(I('get.loginemail') != null){
			$data['username'] 		= I('get.loginemail');
		}
		if(I('get.ip') != null){
			$data['handleip'] 		= array('like',"%".I('get.ip')."%");
		}
		if(I('get.action') != null){
			$data['handlecontent'] 	= array('like',"%".I('get.action')."%");
		}
		$logday 					= $log->field('handletime')->order('date ASC')->group('handletime')->select();
		$starttime 					= strtotime(urldecode(I('get.starttime')));
		$endtime 					= strtotime(urldecode(I('get.endtime')));
		$where['handletime']		= array(array('egt',$starttime),array('elt',$endtime),'AND');

		$count 						= $log->where($data)->where($where)->count();
		$page 						= ($page == null) ? 0 : I('get.page');

		$countnum					= 20;
		$p 							= new \Think\Page($count,$countnum);
		$p->lastSuffix=false;
		$p->setConfig('header','<br/><li class="rows">共<b>%TOTAL_ROW%</b>条记录  每页<b>'.$countnum.'</b>条  第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页</li>');
		$p->setConfig('prev','上一页');
		$p->setConfig('last','末页');
		$p->setConfig('first','首页');
		$p->setConfig('next','下一页');
		$p->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
		$page 				= $p->show();

		$searchlog 			= $log->field('at_log.*,at_user.realname')->where($data)->where($where)->limit($p->firstRow.','.$p->listRows)->join('left join at_user on at_user.userid = at_log.userid')->order('handletime desc')->select();
		$this->assign('pageshow',$page);
		$this->assign('logday',$logday);
		$this->assign('searchlog',$searchlog);
		$this->display();
	}

	//列出所有的用户
	public function info_manage(){
	
		R('Layout/ismanage');
		$user 			= D('User');
		$count    		= $user->count();
		$page 			= ($page == null) ? 0 : I('get.page');
		$countnum=10;
		$p 				= new \Think\Page($count,$countnum);
		$p->lastSuffix=false;
		$p->setConfig('header','<br/><li class="rows">共<b>%TOTAL_ROW%</b>条记录  每页<b>'.$countnum.'</b>条  第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页</li>');
		$p->setConfig('prev','上一页');
		$p->setConfig('last','末页');
		$p->setConfig('first','首页');
		$p->setConfig('next','下一页');
		$p->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
		$page 			= $p->show();
		$appUser 		= $user->field('at_user.userid as userid,at_user.loginemail as loginemail,at_userpower.userpayid as userpayid,at_paytpe.zhpaytype as zhpaytype,at_usertype.zhusertype as zhusertype,at_usertype.id as usertypeid,at_user.realname as realname,at_user.lasttime as lasttime,at_user.ip as ip,at_vocationtype.zhvocationtype as zhvocationtype')->join('LEFT JOIN at_userpower ON at_user.userid = at_userpower.userid')->join('LEFT JOIN at_usertype ON at_userpower.usertypeid = at_usertype.id')->join('LEFT JOIN at_paytpe ON at_paytpe.id=at_userpower.userpayid')->join('LEFT JOIN at_vocationtype ON at_userpower.vocatypeid = at_vocationtype.id')->limit($p->firstRow.','.$p->listRows)->select();
		$this->assign('pageshow',$page);
		$this->assign('userlist',$appUser);
		$this->show();
	}


	//删除对应的APP记录以及上传的文件
	public function delApkinfo_manage(){
		//R('Layout/ismanage');
		$appid 			= I('get.appid');
		$model			= new \Think\Model();
		$model->startTrans();
              
		$delAppid['appid'] 		= array('eq',$appid);
		$info 			= $model->table(C('DB_PREFIX').'appinfo')->where($delAppid)->select()[0];
		$file 			= $model->table(C('DB_PREFIX').'appupload')->where($delAppid)->select()[0];
		$delInfo 		= $model->table(C('DB_PREFIX').'appinfo')->where($delAppid)->delete();
		$delStatus 		= $model->table(C('DB_PREFIX').'appstatus')->where($delAppid)->delete();
		$delUpload 		= $model->table(C('DB_PREFIX').'appupload')->where($delAppid)->delete();
		$detection 		= $model->table(C('DB_PREFIX').'detection')->where($delAppid)->delete();
		$path = "__ROOT__/".$file['apppath'];
		
		// if($delInfo && $delStatus && $detection){ ipa 目前没有信息
		if($delInfo ){
			$model->commit();
			unlink($file['apppath']);
			addLog($_SESSION['userid'] ,"删除APP名称为 {$info['realname']} 的所有信息");		
			echo 'true';
		}else{
			$model->rollback();
			addLog($_SESSION['userid'] ,"试图删除APP名称为 {$info['realname']} 的所有信息,但是没有成功!");
			echo 'false';
		}	
	}

	//删除用户
	public function deluser_manage(){
		R('Layout/ismanage');
		$userid 		= I('get.uid');
		$user 			= D('User');
		$info 			= $user->find($userid);
		if($user->delete($userid)){
			addLog($_SESSION['userid'] ,"删除用户:{$info['loginemail']}");
			echo 'true';
		}else{
			addLog($_SESSION['userid'] ,"试图删除用户:{$info['loginemail']},但是没有成功!");
			echo 'false';
		}
	}

	//增加用户
	public function adduser_manage(){
		R('Layout/ismanage');
		if(IS_POST){
			$pwd 	 			= md5(I('post.pwd2').'PWDAFTER');
			$email    			= I('post.email');
			$user 				= D('User');
			$power 				= D('Userpower');
			$name 	  			= I('post.username');
			$phone 				= I('post.phone');
			$address 			= I('post.address');
			$job 				= I('post.job');
			$usertypeid 		= I('post.typeid');
			$vocatypeid			= I('post.vocatypeid');
			$userpayid 			= I('post.payid');
			$companyid 			= I('post.companyid');
			// var_export($_POST);die;
			if( count($user->where(array('loginemail'=>$email))->select()) < 1 ){
				$data = array(
					'loginemail'	=>$email,
					'password'		=>$pwd,
					'realname'		=>$name,
					'regtime'		=>time(),
					'job'			=>$job,
					'phone'			=>$phone,
					'address'		=>$address
				);
				if($id = $user->data($data)->add()){
					$info = $user->find($id);
					//管理员添加用户成功后,再往权限表中添加该用户的权限
					$powerdata = array(
						'userid'		=>$id,
						'usertypeid'	=>$usertypeid,
						'downlimit'		=>3,
						'userpayid'		=>$userpayid
					);
					if($usertypeid == 3){
						$powerdata['vocatypeid'] = $vocatypeid;
						$powerdata['comtypeid']  = '0';
					}
					if($usertypeid == 2){
						$powerdata['vocatypeid'] = '0';
						$powerdata['comtypeid']  = $companyid;
					}
					$power->data($powerdata)->add();

					addLog($_SESSION['userid'] ,"增加用户{$info['loginemail']}");
					$this->redirect('Manage/info_manage',array('tip'=>'ADDUSER_SUCCESS'));
				}
			}else{
				addLog($_SESSION['userid'] ,"试图增加用户{$email},但是没有成功!");
				$this->redirect('Manage/info_manage',array('tip'=>'ADDUSER_FALSE'));
			}
		}else{
			$paytype			= D('Paytpe');
			$paytypewhere['id'] = array('gt',0);
			$paytypelist 		= $paytype->where($utypewhere)->select();
			$this->assign('paytypelist',$paytypelist);
			$vocation 			= D('Vocationtype');
			$vocationtype 		= $vocation->select();
			$this->assign('vocationtype',$vocationtype);
			$company 			= D('Companytype');
			$companylist 		= $company->select();
			$this->assign('company',$companylist);
			$this->display();
		}
	}

	public function _empty(){
		$userid 			= $_SESSION['userid'];
		$url 				= get_url(); 
		addLog($userid ,"手动输入不存在的地址,有嫌疑!地址:".$url);
		$this->display('Layout:show_404');
	}


	//pdf水印,页眉,页脚,水印表
	public function pdfext_list(){
		R('Layout/ismanage');
		$pdfExt 		= D('Pdfext');
		$map['id']		= array('neq',0);
		$count 			= $pdfExt->where($map)->count();
		$page 			= ($page == null) ? 0 : I('get.page');
		$countnum		= 20;
		$p 				= new \Think\Page($count,$countnum);
		$p->lastSuffix=false;
		$p->setConfig('header','<br/><li class="rows">共<b>%TOTAL_ROW%</b>条记录  每页<b>'.$countnum.'</b>条  第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页</li>');
		$p->setConfig('prev','上一页');
		$p->setConfig('last','末页');
		$p->setConfig('first','首页');
		$p->setConfig('next','下一页');
		$p->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
		$page 				= $p->show();
		$choiceShowPdfext 	= $pdfExt->where($map)->select()[0];
		if($choiceShowPdfext){
			$pdfExtlist 	= $pdfExt->where($map)->limit($p->firstRow.','.$p->listRows)->order('id DESC')->select();
			$this->assign('pdfexton','false');
		}
		foreach ($pdfExtlist as $k => $v) {
			if(!file_exists($v['background']) || $v['background'] == null){
				$pdfExtlist[$k]['background']  = "不存在";
			}
			if(!file_exists($v['headimg']) || $v['headimg'] == null){
				$pdfExtlist[$k]['headimg']  = "不存在";
			}
		}
		//是否显示水印
		$pdfIsOrNotShowWartermark 		= $pdfExt->where('id=0')->select()[0];
		$this->assign('showWartermark',$pdfIsOrNotShowWartermark);

		$this->assign('pdfextlist',$pdfExtlist);
		$this->display();
	}

	public function pdfext_expandswitch(){
		R('Layout/ismanage');
		$pdfExt 	= D('Pdfext');
		$result 	= $pdfExt->where('id=0')->data(array('textpic'=>I('post.expandswitch')))->save();
		if($result !== false){
			$this->redirect('Manage/pdfext_list',array('tip'=>'EXPANDSWITCH_SUCCESS'));
		}else{
			$this->redirect('Manage/pdfext_list',array('tip'=>'EXPANDSWITCH_FALSE'));
		}

	}

	//设置页眉,背景图片,页眉图片 更新pdf
	public function pdfext_set(){
		R('Layout/ismanage');
		$pdfExt 				= D('Pdfext');
		if(IS_POST){
			$pdfextid 			= I('get.pdfextid');
			$pdfexthead 		= I('post.headerup');
			$pdfextfoot 		= I('post.headerdown');
        	if($_FILES['background'] == null && $_FILES['headimg'] == null){
        		$data = array(
        			'headerup'		=> $pdfexthead,
	        		'headerdown'	=> $pdfextfoot,
	        		'textpic'		=> 0
        			);
        		$result  = $pdfExt->where(array('id'=>$pdfextid))->save($data);
        		if($result){
	        		$this->redirect('Manage/pdfext_list',array('tip'=>'PDFEXT_UPDATE_SUCCESS'));
	        	}else{
	        		$this->redirect('Manage/pdfext_list',array('tip'=>'PDFEXT_UPDATE_FALSE'));
	        	}
	        }elseif($_FILES['background'] != null || $_FILES['headimg'] == null){
	        	$upload             = new \Think\Upload();
				$upload->maxSize 	= 5097152;
		        $upload->exts       = array('jpg', 'gif','jpeg','png');	
		        $upload->rootPath   = UPLOAD_PATH;
		        $upload->subName   	= "pdf";
		        $upload->saveRule 	= 'uniqid';
	        	$info 				= $upload->upload();
	        	$data =array(
	        		'headerup'		=> $pdfexthead,
	        		'headerdown'	=> $pdfextfoot,
	        		'textpic'		=> 0
	        	);
	        	if($_FILES['background']['error'] == '0'){
	        		$backpath = UPLOAD_PATH.$info['background']['savepath'].$info['background']['savename'];
	        		$image = new \Think\Image();
	        		$image->open($backpath);
	        		$image->thumb(1182,1772,\Think\Image::IMAGE_THUMB_FIXED)->save($backpath);
	        		$data['background'] = $backpath; 

	        	}
	        	if($_FILES['headimg']['error'] == '0'){
	        		$headimgpath = UPLOAD_PATH.$info['headimg']['savepath'].$info['headimg']['savename'];
	        		$image = new \Think\Image();
	        		$image->open($headimgpath);
	        		$image->thumb(103,103,\Think\Image::IMAGE_THUMB_SCALE)->save($headimgpath);
	        		$data['headimg'] = $headimgpath; 
	        	}

	        	$result = $pdfExt->where(array('id'=>$pdfextid))->save($data);
	        	if($result){
	        		$this->redirect('Manage/pdfext_list',array('tip'=>'PDFEXT_UPDATE_SUCCESS'));
	        	}else{
	        		$this->redirect('Manage/pdfext_list',array('tip'=>'PDFEXT_UPDATE_FALSE'));
	        	}
	        }
	    }else{
	    	$id 			= I('get.pdfextid');
	    	$pdfextinfo 	= $pdfExt->where(array('id'=>$id))->select()[0];
	    	$this->assign('pdfextinfo',$pdfextinfo);
	    	$this->display();
	    }
	}
	//增加pdf扩展
	public function pdfext_add(){
		R('Layout/ismanage');
		$pdfExt 			= D('Pdfext');
		if(IS_POST){
			$pdfexthead 		= I('post.headerup');
			$pdfextfoot 		= I('post.headerdown');
			$pdfextpic 			= I('post.headimg');
			$pdfextback			= I('post.background');

        	if($_FILES['background'] == null && $_FILES['headimg'] == null){
        		$data = array(
        			'headerup'		=> $pdfexthead,
	        		'headerdown'	=> $pdfextfoot,
	        		'status'		=> 0,
	        		'textpic'		=> 0
        			);
        		$result  = $pdfExt->data($data)->add();
        		if($result){
	        		$this->redirect('Manage/pdfext_list',array('tip'=>'PDFEXT_ADD_SUCCESS'));
	        	}else{
	        		$this->redirect('Manage/pdfext_list',array('tip'=>'PDFEXT_ADD_FALSE'));
	        	}
	        }elseif($_FILES['background'] != null || $_FILES['headimg'] == null){
	        	$upload             = new \Think\Upload();
				$upload->maxSize 	= 5097152;
		        $upload->exts       = array('jpg', 'gif','jpeg','png');	
		        $upload->rootPath   = UPLOAD_PATH;
		        $upload->subName   	= "pdf";
		        $upload->saveRule 	= 'uniqid';
	        	$info 				= $upload->upload();
	        	$data =array(
	        		'headerup'		=> $pdfexthead,
	        		'headerdown'	=> $pdfextfoot,
	        		'status'		=> 0,
	        		'textpic'		=> 0
	        	);
	        	if($_FILES['background']['error'] == '0'){
	        		$backpath = UPLOAD_PATH.$info['background']['savepath'].$info['background']['savename'];
	        		$image = new \Think\Image();
	        		$image->open($backpath);
	        		$image->thumb(1182,1772,\Think\Image::IMAGE_THUMB_FIXED)->save($backpath);
	        		$data['background'] = $backpath; 

	        	}
	        	if($_FILES['headimg']['error'] == '0'){
	        		$headimgpath = UPLOAD_PATH.$info['headimg']['savepath'].$info['headimg']['savename'];
	        		$image = new \Think\Image();
	        		$image->open($headimgpath);
	        		$image->thumb(103,103,\Think\Image::IMAGE_THUMB_SCALE)->save($headimgpath);
	        		$data['headimg'] = $headimgpath; 
	        	}


	        	$result  = $pdfExt->data($data)->add();
	        	if($result){
	        		$this->redirect('Manage/pdfext_list',array('tip'=>'PDFEXT_ADD_SUCCESS'));
	        	}else{
	        		$this->redirect('Manage/pdfext_list',array('tip'=>'PDFEXT_ADD_FALSE'));
	        	}
	        }
        }else{
			$this->display();
		}
	}
	//设置PDF 显示的内容
	public function pdfext_setcontent(){
		R('Layout/ismanage');
		$pdfext 	= D('Pdfext');
		$pdfextid 	= I('get.pdfextid');
		$map['id']	= array('neq',0);
		$pdfextlist = $pdfext->where($map)->select();
		$plen = $pdfext->where($map)->count();
		$s = 0;
		foreach ($pdfextlist as $k => $v) {
			$res = $pdfext->where(array('id'=>$v['id']))->data(array('status'=>0))->save();
			if($res !== false){
				++$s;
			}
		}
		$result = $pdfext->where(array('id'=>$pdfextid))->data(array('status'=>1))->save();
		if($result !== false && $s == $plen){
			$this->redirect('Manage/pdfext_list',array('tip'=>'PDFEXT_SETCONTENT_SUCCESS'));
		}else{
			$this->redirect('Manage/pdfext_list',array('tip'=>'PDFEXT_SETCONTENT_FALSE'));
		}

	}
	//删除pdf拓展
	public function pdfext_del(){
		R('Layout/ismanage');
		$pdfExt 	= D('Pdfext');
		$pdfextid 	= I('get.pdfextid');
		if($_SESSION['power']  == 'all'){
			$result = $pdfExt->where(array('id'=>$pdfextid))->delete();
			if($result){
				$this->redirect('Manage/pdfext_list',array('tip'=>'PDFEXT_DELETE_SUCCESS'));
			}else{
				$this->redirect('Manage/pdfext_list',array('tip'=>'PDFEXT_DELETE_FALSE'));
			}
		}else{
			$this->redirect('Manage/pdfext_list',array('tip'=>'PDFEXT_DELETE_FLASE'));
		}
	}

	//应用反馈列表
	public function feedbacklist_manage(){
		R('Layout/ismanage');
		$feedback 		 	= D('Feedback');


		$page 	 		 	= ($page == null) ? 0 : I('get.page');
		$countnum		 	= 15;
		$star 			 	= (I('get.p',1)-1)*$countnum;
		$count 			 	= $feedback->count();

		// 分页
		$p 				 	= new \Think\Page($count,$countnum);
		$p->lastSuffix 		=false;
	    $p->setConfig('header','<br/><li class="rows">共<b>%TOTAL_ROW%</b>条记录  每页<b>'.$countnum.'</b>条  第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页</li>');
	    $p->setConfig('prev','上一页');
	    $p->setConfig('last','末页');
	    $p->setConfig('first','首页');
	    $p->setConfig('next','下一页');
	    $p->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
		$page 			 	= $p->show();

		$feedbacklist 		= $feedback->field('at_feedback.id,au.loginemail as loginemail,aa.loginemail as aloginemail,ap.appid as appid,at_feedback.testname,ap.version,at_feedback.processtime,ap.realname as realname,ar1.id as oldresult,ar1.resultname as oldresultname,ar2.id as newresult,ar2.resultname as newresultname,ad.zhtestname as zhtestname,af.feedbackstatus,af.id as status')->join('left join at_appinfo as ap on ap.appid = at_feedback.appid')->join('left join at_resulttype as ar1 on ar1.id = at_feedback.oldresult')->join('left join at_resulttype as ar2 on ar2.id = at_feedback.newresult')->join('left join at_detecname as ad on ad.id = at_feedback.testname')->join('left join at_feedbackstatus as af on af.id = at_feedback.status')->join('left join at_user as au on au.userid = at_feedback.userid')->join('left join at_admins as aa on aa.userid = at_feedback.userid')->order('at_feedback.status ASC,at_feedback.processtime DESC')->limit($p->firstRow.','.$p->listRows)->select();
		$this->assign('pageshow',$page);
		$this->assign('feedbacklist',$feedbacklist);
		$this->display();
	}

	//应用反馈详细
	public function feedbackdetial_manage(){
		R('Layout/ismanage');
		$feedback 			= D('Feedback');
		$feedbackid 		= I('get.feedbackid');
		$feedbackinfo 		= $feedback->field('at_feedback.id,au.loginemail as loginemail,au.realname as uname,ap.appid as appid,at_feedback.testname,at_feedback.reason,at_feedback.subtime,at_feedback.processtime,at_feedback.processreply,ap.realname as realname,ar1.id as oldresult,ar1.resultname as oldresultname,ar2.id as newresult,ar2.resultname as newresultname,ad.zhtestname as zhtestname,af.feedbackstatus,af.id as status')->join('left join at_appinfo as ap on ap.appid = at_feedback.appid')->join('left join at_resulttype as ar1 on ar1.id = at_feedback.oldresult')->join('left join at_resulttype as ar2 on ar2.id = at_feedback.newresult')->join('left join at_detecname as ad on ad.id = at_feedback.testname')->join('left join at_feedbackstatus as af on af.id = at_feedback.status')->join('left join at_user as au on au.userid = at_feedback.userid')->where(array('at_feedback.id'=>$feedbackid))->select()[0];
		$this->assign('pageshow',$page);
		$this->assign('feedbackinfo',$feedbackinfo);
		$this->display();
	}
	//应用反馈同意
	public function feedbackagree_manage(){
		R('Layout/ismanage');
		$detecion 			= D('Detection');
		$feedback 			= D('Feedback');
		if($_SESSION['power'] != 'all'){
			$this->redirect('Manage/feedbacklist_manage',array('tip'=>'PERMISSION_DENIED'));
			exit;
		}
		if(IS_GET){
			$feedbackid 		= I('get.feedbackid');
			$newresult 			= I('get.newresult');
			$appid 				= I('get.appid');
			$testname 			= I('get.testname');
			$feedback->startTrans();
			if($feedbackid != null && $newresult != null && $appid != null && $testname != null){
				$updatareulst 		= $detecion->where(array('appid'=>$appid,'testname'=>$testname))->data(array('result'=>$newresult))->save();
				
				$updatefeedback 	= $feedback->where(array('id'=>$feedbackid))->data(array('processtime'=>time(),'status'=>2,'processreply'=>'同意修改,如不满意!请联系客服.电话:400-8937800 邮箱:linsuyi@86itese.com'))->save();

				if($updatefeedback !== false && $updatareulst !== false){
					$feedback->commit();
					$sql 		= " call finishdetc({$appid})";
					$feedback->query($sql);
					$this->redirect('Manage/feedbacklist_manage',array('tip'=>'FEEDBACK_AGREE'));
				}else{
					$feedback->rollback();
					$this->redirect('Manage/feedbacklist_manage',array('tip'=>'FEEDBACK_UPDATE_FALSE'));
				}
			}else{
				$this->redirect('Manage/feedbacklist_manage',array('tip'=>'FEEDBACK_UPDATE_FALSE'));
			}
		}
		if(IS_POST){
			$feedbackid 		= I('post.feedbackid');
			$agreeReason 		= I('post.reason');
			$newresult 			= I('post.newresult');
			$appid 				= I('post.appid');
			$testname 			= I('post.testname');			
			$feedback->startTrans();
			if($feedbackid != null && $newresult != null && $appid != null && $testname != null){
				$data = array(
					'processtime'	=> time(),
					'status' 		=> 2,
					'processreply'  => $agreeReason
				);
				$updatareulst 		= $detecion->where(array('appid'=>$appid,'testname'=>$testname))->data(array('result'=>$newresult))->save();
				$updatefeedback 	= $feedback->where(array('id'=>$feedbackid))->data($data)->save();
				if($updatefeedback !== false && $updatareulst !== false){
					$feedback->commit();
					$sql 		= " call finishdetc({$appid})";
					$feedback->query($sql);
					$this->ajaxReturn(array('info'=>'true'));
				}else{
					$feedback->rollback();
					$this->ajaxReturn(array('info'=>'false'));
				}
			}else{
				$this->ajaxReturn(array('info'=>'false'));
			}
		}
	}
	//应用反馈拒绝
	public function feedbackreject_manage(){
		R('Layout/ismanage');
		$feedback 			= D('Feedback');
		if($_SESSION['power'] != 'all'){
			$this->redirect('Manage/feedbacklist_manage',array('tip'=>'PERMISSION_DENIED'));
			exit;
		}
		if(IS_GET){
			$feedback 			= D('Feedback');
			$feedbackid 		= I('get.feedbackid');
			if($feedbackid != null){
				$updatefeedback = $feedback->data(array('processtime'=>time(),'status'=>3,'processreply'=>'不同意修改,如不满意!请联系客服.电话:400-8937800 邮箱:linsuyi@86itese.com'))->where(array('id'=>$feedbackid))->save();
				if($updatefeedback !== false){
					$this->redirect('Manage/feedbacklist_manage',array('tip'=>'FEEDBACK_REJECT'));
				}else{
					$this->redirect('Manage/feedbacklist_manage',array('tip'=>'FEEDBACK_UPDATE_FALSE'));
				}
			}else{
				$this->redirect('Manage/feedbacklist_manage',array('tip'=>'FEEDBACK_UPDATE_FALSE'));
			}
		}
		if(IS_POST){
			$feedbackid 		= I('post.feedbackid');
			$data = array(
				'processtime'	=> time(),
				'status' 		=> 3,
				'processreply'  => I('post.reason')
			);
			$updatefeedback 	= $feedback->where(array('id'=>$feedbackid))->data($data)->save();
			if($updatefeedback !== false){
				// $this->$this->redirect('Manage/feedbacklist_manage',array('tip'=>'FEEDBACK_REJECT'));
				$this->ajaxReturn(array('info'=>'true'));
			}else{
				// $this->redirect('Manage/feedbacklist_manage',array('tip'=>'FEEDBACK_UPDATE_FALSE'));
				$this->ajaxReturn(array('info'=>'false'));
			}
		}
	}
	//删除该应用反馈
	public function feedbackdel_manage(){
		R('Layout/ismanage');
		$feedback 			= D('Feedback');
		if($_SESSION['power'] != 'all'){
			$this->redirect('Manage/feedbacklist_manage',array('tip'=>'PERMISSION_DENIED'));
			exit;
		}
		$feedbackid 		= I('get.feedbackid');
		if($feedbackid != null){
			$updatefeedback = $feedback->delete($feedbackid);
			if($updatefeedback !== false){
				$this->redirect('Manage/feedbacklist_manage',array('tip'=>'FEEDBACK_DELETE_SUCCESS'));
			}else{
				$this->redirect('Manage/feedbacklist_manage',array('tip'=>'FEEDBACK_DELETE_FALSE'));
			}
		}else{
			$this->redirect('Manage/feedbacklist_manage',array('tip'=>'FEEDBACK_DELETE_FALSE'));
		}
	}
}