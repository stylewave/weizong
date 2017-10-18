<?php
namespace Home\Controller;
use Think\Controller;
class PersonalController extends CommonController {

	//个人信息
	public function info_personal(){
		$userid 			= $_SESSION['userid'];
		$admin  			= D('Admins');
		$user   			= D('User');
		$userpower 			= D('Userpower');
		//获取个人的用户信息
		$info = (count($admin->find($userid)) > 0 ) ? ($admin->find($userid)) : ($user->find($userid));
		$this->assign('info',$info);
		$this->display();
	}

	//用户个人信息修改
	public function editinfo_personal(){
		$admin 			= D('Admins');
		$user 			= D('User');
		$uid 			= $_SESSION['userid'];
		if($_SESSION['power']['usertypeid'] > 1){
			$this->redirect('Layout/show_404');
		}
		if(IS_GET){
			if( $uid < 10000 ){				
				$info = $admin->find($uid);
			}else{				
				$info = $user->find($uid);
			}
			$this->assign('info',$info);
			$this->show();
		}elseif(IS_POST){
			$info 		= $user->field('loginemail')->find($uid); 
			addLog($uid,"修改用户 {$info['loginemail']} 的个人信息");
			$data = array(
				'userid'	=> $uid,
				'job'		=> I('post.job'),
				'realname'	=> I('post.username'),
				'phone'		=> I('post.phone'),
				'address'	=> I('post.address'),
				'dvrtype'	=> $_POST['dvrtype'],
				);
			if( $uid < 10000 ){				
				if($admin->save($data) !== false ){
					$this->redirect('Personal/info_personal',array('tip'=>'UPDATE_SUCCESS'));
				}else{
					$this->redirect('Personal/info_personal',array('tip'=>'UPDATE_FALSE'));
				}
			}else{				
				if($user->save($data) !== false ){
					$this->redirect('Personal/info_personal',array('tip'=>'UPDATE_SUCCESS'));
				}else{
					$this->redirect('Personal/info_personal',array('tip'=>'UPDATE_FALSE'));
				}
			}

		}			
	}

	//用户个人修改自己的密码
	public function editpass_personal(){
		$admin 			= D('Admins');
		$user 			= D('User');
		$userid  		= $_SESSION['userid'];
		if(IS_GET){
			if(strlen($userid) < 3){				
				$info 	= $admin->find($userid);
			}else{				
				$info 	= $user->find($userid);
			}
			$this->assign('info',$info);
			$this->display();
		}elseif(IS_POST){
			$oldPwd 		= md5(I('post.pwd').'PWDAFTER');
			$newPwd 		= md5(I('post.pwd2').'PWDAFTER');
			$userExist 		= $user->field('loginemail')->where(array('userid'=>$userid,'password'=>$oldPwd))->select();
			$adminExist 	= $admin->field('loginemail')->where(array('userid'=>$userid,'password'=>$oldPwd))->select();
			if( $userExist || $adminExist ){
				$data   = array('userid'=>$userid,'password'=>$newPwd);
				$info   = !empty($admin->find($userid)) ? ($admin->find($userid)) : ($user->find($userid));
		 
				if( $userid < 10000 ){
					if(false !== $admin->save($data)){
						addLog($userid ,"修改用户 {$info['loginemail']} 的个人密码成功");
						$this->redirect('Personal/info_personal',array('tip'=>'UPDATE_SUCCESS'));
					}else{
						addLog($userid ,"修改用户 {$info['loginemail']} 的个人密码失败");
						$this->redirect('Personal/editpass_personal',array('tip'=>'UPDATE_FALSE'));
					}
				}else{
					if(false !== $user->save($data)){
						addLog($userid ,"修改用户 {$info['loginemail']} 的个人密码成功");
						$this->redirect('Personal/info_personal',array('tip'=>'UPDATE_SUCCESS'));
					}else{
						addLog($userid ,"修改用户 {$info['loginemail']} 的个人密码失败");
						$this->redirect('Personal/editpass_personal',array('tip'=>'UPDATE_FALSE'));
					}
				}
			}else{
				addLog($userid ,"修改用户 {$info['loginemail']} 的个人密码时原密码错误");
				$this->redirect('Personal/editpass_personal',array('tip'=>'UPDATE_FALSE'));
			}
		}
	}

	//个人详细信息
	public function detial_personal(){
		if($_SESSION['power'] == 'all'){
			$userid 			= I('get.userid');
			$user 				= D('User');
			$detial  			= $user->find($userid);
			addLog($_SESSION['userid'] ,"查看 {$detial['loginemail']} 的用户详细信息");
			$this->assign('info',$detial);
			$this->display();
		}else{
			$this->display('Layout/show_404');
		}
		
	}

	//管理员修改用户密码
	public function modifypass_personal(){
		if($_SESSION['power'] == 'all'){
			$user 				= D('User');
			$userpower 			= D('Userpower');
			$userid 			= I('get.uid');
			$update 			= I('get.update');
			$info 				= $user->find($userid);
			if(IS_POST){
				$data 				= array(
					'userid' 		=> I('get.uid'),
					'password'		=> md5(I('post.pwd2').'PWDAFTER'),
					); 
				if($user->data($data)->save() !== false){
					$info = $user->find($userid);
					addLog($_SESSION['userid'] ,"管理员修改 {$info['loginemail']} 的密码成功");
					$this->redirect('Manage/info_manage',array('tip'=>'UPDATE_SUCCESS'));
				}else{
					addLog($_SESSION['userid'] ,"管理员修改 {$info['loginemail']} 的密码失败");
					$this->redirect('Manage/info_manage',array('tip'=>'UPDATE_FLASE'));
				}
				
			}else{
				$power 		= D('UserpowerView');
				$userpower  = $power->where(array("userid"=>$userid))->select()[0];
				$this->assign('userpower',$userpower);
				$this->assign('info',$info);
				$this->display();
			}
		}else{
			$this->display('Layout/show_404');
		}
	}

	//管理员修改个人信息
	public function modifyinfo_personal(){
		if($_SESSION['power'] == 'all'){
			$user 				= D('User');
			$userpower 			= D('Userpower');
			$userid 			= I('get.uid');
			$update 			= I('get.update');
			$info 				= $user->find($userid);
			if(IS_POST){
				$data  				= array(
					'job'			=> I('post.job'),
					'realname'		=> I('post.username'),
					'phone'			=> I('post.phone'),
					'address'		=> I('post.address'),
					'dvrtype'		=> I('post.dvrtype'),
					'userid'		=> $userid	
				);
				$result = $user->data($data)->where(array('userid'=>$userid))->save();
				if($result !== false){
					addLog($_SESSION['userid'] ,"管理员修改 {$info['loginemail']} 的信息成功");
					$this->redirect('Manage/info_manage',array('tip'=>'UPDATE_SUCCESS'));
				}else{
					addLog($_SESSION['userid'] ,"管理员修改 {$info['loginemail']} 的信息失败");
					$this->redirect('Manage/info_manage',array('tip'=>'UPDATE_FLASE'));
				}
			}else{
				$power 		= D('UserpowerView');
				$userpower  = $power->where(array("userid"=>$userid))->select()[0];
				$this->assign('userpower',$userpower);
				$this->assign('info',$info);
				$this->display();
			}
		}else{
			$this->display('Layout/show_404');
		}
	}

	//管理员修改权限
	public function modifypower_personal(){
		if($_SESSION['power'] == 'all'){
			$user 				= D('User');
			$userpower 			= D('Userpower');
			$userid 			= I('get.uid');
			$update 			= I('get.update');
			$info 				= $user->find($userid);
			if(IS_POST){
				$data  				= array(
					'uploadlimit'		=> I('post.uploadlimit'),
					'downlimit'			=> I('post.downlimit'),
					'userpayid'			=> I('post.payid'),
					'usertypeid'		=> I('post.usertype'),
					'downlimittype' 	=> I('post.downlimittype'),
					'uploadlimittype'	=> I('post.uploadlimittype')
				);

				if(I('post.uploadlimittype') == 1){
					$data['utp']				= I('post.uparmar');
					$data['ustarttime']			= time();
					$data['uploadtimespaceid']	= I('post.utimespace');
				}
				if(I('post.downlimittype') == 1){
					$data['dtp']				= I('post.dparmar');
					$data['dstarttime']			= time();
					$data['downtimespaceid']	= I('post.dtimespace');
				}

				if(I('post.usertype') == 3){
					$data['vocatypeid']  = I('post.uservocatype');
					$data['comtypeid'] 	 = '0';	
				}
				if(I('post.usertype') == 2){
					$data['comtypeid']  = I('post.usercompany');
					$data['vocatypeid'] = '0';

				}
				$result = $userpower->data($data)->where(array("userid"=>$userid))->save();
				if($result !== false){
					addLog($_SESSION['userid'] ,"管理员修改 {$info['loginemail']} 的限制成功");
					$this->redirect('Manage/info_manage',array('tip'=>'UPDATE_SUCCESS'));
				}else{
					addLog($_SESSION['userid'] ,"管理员修改 {$info['loginemail']} 的限制失败");
					$this->redirect('Manage/info_manage',array('tip'=>'UPDATE_FLASE'));
				}
			}else{
				// $power 				= D('UserpowerView');
				$userpower  		= $userpower->where(array("userid"=>$userid))->select()[0];
				
				$usertype  			= D("Usertype");
				$utypemap['id']		= array(array('neq',4),array('neq',0),'AND');
				$usertypelist 		= $usertype->where($utypemap)->select();
				$vocationtype 		= D('vocationtype');
				$vocationtypelist 	= $vocationtype->select();
				$company 			= D('Companytype');
				$companylist 		= $company->select();
				$userpay 			= D('Paytpe');
				$userpaylist		= $userpay->select();
				$timespace  		= D('Timespace');
				$timespacelist 		= $timespace->order('id asc')->select();
				$limittype 			= D('Limitype');
				$limittypelist 		= $limittype->select();
				//时间限制类型
				$this->assign('limittypelist',$limittypelist);
				//时间间隔类型
				$this->assign('timespacelist',$timespacelist);
				//用户付费类型
				$this->assign('userpaylist',$userpaylist);
				//部门列表
				$this->assign('companylist',$companylist);
				//行业列表
				$this->assign('vocationtypelist',$vocationtypelist);
				//用户类型列表
				$this->assign('usertypelist',$usertypelist);
				//特定用户的权限
				$this->assign('userpower',$userpower);
				//对应用户的信息
				$this->assign('info',$info);
				$this->display();
			}
		}else{
			$this->display('Layout/show_404');
		}
	}

	//空操作
	public function _empty(){
		$userid 			= $_SESSION['userid'];
		$url 				= get_url(); 
		addLog($userid ,"手动输入不存在的地址,有嫌疑!地址:".$url);
		$this->display('Layout:show_404');
	}

	//用户的反馈信息
	public function feedbacklist_personal(){
		$feedback 			= D('Feedback');
		$userid 			= $_SESSION['userid'];
		$page 	 		 	= ($page == null) ? 0 : I('get.page');
		$countnum		 	= 15;
		$star 			 	= (I('get.p',1)-1)*$countnum;
		$count 			 	= $feedback->where(array(array("userid"=>$userid)))->count();

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

		$feedbacklist 		= $feedback->field('at_feedback.id,ap.appid as appid,ap.version,at_feedback.testname, ap.realname as realname,ar1.id as oldresult,ar1.resultname as oldresultname,at_feedback.subtime,ar2.id as newresult,ar2.resultname as newresultname,ad.zhtestname as zhtestname,af.feedbackstatus,af.id as status')->join('left join at_appinfo as ap on ap.appid = at_feedback.appid')->join('left join at_resulttype as ar1 on ar1.id = at_feedback.oldresult')->join('left join at_resulttype as ar2 on ar2.id = at_feedback.newresult')->join('left join at_detecname as ad on ad.id = at_feedback.testname')->join('left join at_feedbackstatus as af on af.id = at_feedback.status')->order('at_feedback.status ASC,at_feedback.subtime DESC')->where(array('at_feedback.userid'=>$userid))->limit($p->firstRow.','.$p->listRows)->select();
		$this->assign('feedbacklist',$feedbacklist);
		$this->display();
	}
	
	//撤销反馈申请
	public function feedbackcancel_personal(){
		$feedback 			= D('Feedback');
		$userid 			= $_SESSION['userid'];
		$feedbackid 		= I('get.feedbackid');
		$feedbackinfo 		= $feedback->find($feedbackid);
		if($feedbackinfo['userid'] == $userid){
			$result = $feedback->delete($feedbackid);
			if($result !== false){
				$this->ajaxReturn(array('info'=>'true'));
			}else{
				$this->ajaxReturn(array('info'=>'false'));
			}
		}else{
			$this->ajaxReturn(array('info'=>'false'));
		}
	}

	//查看反馈结果
	public function feedbackresult_personal(){
		$feedback 			= D('Feedback');
		$userid 			= $_SESSION['userid'];
		$feedbackid 		= I('get.feedbackid');
		$feedbackinfo 		= $feedback->field('at_feedback.id,ap.version,at_feedback.userid,ap.appid as appid,at_feedback.testname,at_feedback.reason, ap.realname as realname,ar1.id as oldresult,ar1.resultname as oldresultname,ar2.id as newresult,ar2.resultname as newresultname,ad.zhtestname as zhtestname,af.feedbackstatus,af.id as status,at_feedback.processreply')->join('left join at_appinfo as ap on ap.appid = at_feedback.appid')->join('left join at_resulttype as ar1 on ar1.id = at_feedback.oldresult')->join('left join at_resulttype as ar2 on ar2.id = at_feedback.newresult')->join('left join at_detecname as ad on ad.id = at_feedback.testname')->join('left join at_feedbackstatus as af on af.id = at_feedback.status')->where(array('at_feedback.id'=>$feedbackid))->where(array('at_feedback.id'=>$feedbackid))->select()[0];
		if($feedbackinfo['userid'] == $userid){
			$this->assign('feedbackinfo',$feedbackinfo);
			$this->display();
		}else{
			$this->redirect('Personal/feedbacklist_personal',array('tip'=>'FEEDBACK_ASCRIPTION_USER_ERROR'));
		}
	}
}