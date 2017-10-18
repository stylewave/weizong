<?php
namespace Home\Controller;
use Think\Controller;
class EmptyController extends CommonController {
	public function _empty(){
		$userid 			= $_SESSION['userid'];
		$url 				= get_url(); 
		if($url == __ROOT__ || $url == __ROOT__.'/' || $url == __ROOT__."/index.php"){
			if($_SESSION['userid'] == null){
				$this->redirect('User/login_user');
				exit;
			}else{
				$this->redirect('Detection/center_detection');
				exit;
			}
		}
		addLog($userid ,"手动输入不存在的地址,有嫌疑!地址:".$url);

		$this->display('Layout:show_404');
	}

}