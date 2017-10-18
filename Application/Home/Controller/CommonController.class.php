<?php
namespace Home\Controller;
use Think\Controller;

class CommonController extends Controller {
//	public function __construct(){
//		parent::__construct();
//		
//		$user 	= D('Userpower');
//		$userid = $_SESSION['userid'];
//		if($userid <= 10005 && $userid  >= 10001){
//			$power = $user->where('userid='.$userid)->select()[0];
//			if($power){
//				$_SESSION['power'] = $power;
//			}
//		}
//		if($_SESSION['userid'] == null){
//			$this->redirect('User/login_user');
//			exit;
//		}
//		$url = get_url();
//		if($url == __ROOT__ || $url == __ROOT__.'/' || $url == __ROOT__."/index.php"){
//			if($_SESSION['userid'] == null){
//				$this->redirect('User/login_user');
//				exit;
//			}else{
//				if($_SESSION['userid'] != null){
//					$this->redirect('Detection/center_detection');
//				}else{
//					echo "<script>";
//					echo "top.location.href = '".U('User/login_user')."'";
//					echo '</script>';
//				}
//			}		
//		}
//		
//	}
}