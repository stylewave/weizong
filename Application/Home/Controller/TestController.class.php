<?php
namespace Home\Controller;
use Think\Controller;

class TestController extends Controller{

    // private $userid='10179';

	//检测同域不同项目的apk信息
	//$filePath的路径为参数
	public function test(){	
		$filePath = I('get.filePath');

		if(!file_exists($filePath)){
			echo 'FILE_NOT_EXIST';
		}else{
			// $userid = $this->$userid;
			$userid = 10179;
			if(false === checkApkInfo($filePath) && substr($filePath,-3) == 'apk'){
	            addLog($userid,'上传了一个假的APK');
	            echo 'APK_IS_FALSE';
	            exit;
	        }
	        $parameter  = 0;
	        $data = array(
	        	'apppath'	=> $filePath,
	        	'userid'	=> $userid,
	        	'subtime'   => date('YmdHis',time()),
	        	'vocation'	=> $parameter,
	        	);
	        // var_export($data);die;
	        if(substr($filePath,-3) == 'apk'){
		        $appupload 	= D('Appupload');
		        $appid 		= $appupload->add($data);
		        $appinfo 	= D('Appinfo');
		        $info 		= $appinfo->where(array('appid'=>$appid)->select()[0];
		        addUploadApkRecord($userid);
		        addLog($userid,"上传APK,APK名称为 {$info['realname']}");
		        //获取app的信息
		        system("/Apktest/MobAppSecAss/apptest_info_apk.sh {$filePath} {$appid} {$userid} {$parameter} >/dev/null &");
				system("/Apktest/MobAppSecAss/start_apptest '/Apktest/MobAppSecAss/apptest_apk.sh'  {$filePath} {$appid} {$userid} {$parameter} >/dev/null &");
				echo $appid;
			}elseif(substr($filePath,-3) == 'ipa'){
		        $appupload 	= D('Appupload');
		        $appid 		= $appupload->add($data);
		        $appinfo 	= D('Appinfo');
		        $info 		= $appinfo->where(array("appid"=>$appid))->select()[0];
		        addUploadApkRecord($userid);
		        addLog($userid,"上传IPA,IPA名称为 {$info['realname']}");
				system("/Apktest/MobAppSecAss/apptest_ipa.sh {$filePath} {$appid} {$userid} {$parameter} >/dev/null &");
				echo $appid;
			}
		}
	}

	//获取apk检测信息 需要参数appid
	public function apkTestInfo(){
		$appid 			= I('get.appid');
		$detecView 		= D('DetecView');
		$appinfo 		= D('Appinfo');
		$map['appid']=$appid;
		$map['userid']=$this->userid;
		$result			= $appinfo->where(array('appid'=>$appid))->select()[0];
		$detecInfo 		= $detecView->where(array('appid'=>$appid))->select();
		$new_detectInfo=array();
		foreach ($detecInfo as $k => $v) {
			if($v['result'] > 1){
				$new_detecInfo[$k] = $v;
			}
		}
		$appDetialInfo		= array('appInfo'=>$result,'appDanger'=>$new_detecInfo);
		$this->ajaxReturn( $new_detecInfo);
	}

	//下载pdf 需要appid的参数
	public function downPdf(){
		$appid 			= I('get.appid');
		$detecView 		= D('DetecView');
		$appinfo 		= D('Appinfo');
		$map['appid']=$appid;
		$map['userid']='10179';
		$info			= $appinfo->where($map)->select()[0];
		if(empty($info)){
           echo "禁止访问！";
		   return;	
		} 
		if(!empty($info)){
			if(!file_exists($info['icon']) && substr($info['icon'],0,4) !== 'http'){
				$info['icon'] = UPLOAD_PATH.'icon/default.png';
			}
		}
		addLog($info['userid'],"下载 {$info['realname']} 的PDF检测报告");
		$detec 		= $detecView->where(array('appid'=>$appid)->select();
		makePdfReport($info,$detec);
	}

	//查询检测进度 需要对应的appid参数
	public function testProgress(){
		$appid   			= I('get.appid');
		$appstatus 			= D('Appstatus');
		$appProgress		= $appstatus->find($appid);
		// var_export($appProgress);
		echo $appProgress['testperc'];
	}

	public function ddddpdf(){

		$appinfo  	= D("Appinfo");
		$detec 	  	= D('DetecView');
		$applist 	= $appinfo->select();
		$detecInfo = $deteclist = array();
		foreach ($applist as $k => $v) {
			if(substr($v['icon'],0,4) != 'http' && !file_exists($v['icon'])){
				$applist[$k]['icon']  = UPLOAD_PATH."icon/default.png";
			}
			$deteclist[] = $detec->where(array('appid'=>$v['appid']))->select()[0];
			$detectInfo[] = $detec->where(array('appid'=>$v['appid']))->select()[0];
		}
		foreach ($applist as $key => $value) {
			makePdfReport($applist[$key],$deteclist[$key]);
				//做一个计数器
			$oldtesttype = 0;
			foreach ($detectInfo[$key] as $k => $v) {
				//当计数器的值等于数组中的值时，消掉testtype标志
				if($oldtesttype == $v['testtype']){
					unset($detectInfo[$key][$k]['testtype']);
				}else{
					//否则令计数器等于该标志值，作为下一次判断的值
					$oldtesttype = $detectInfo[$key][$k]['testtype'];
					//设置是否显示div的头部
					$detectInfo[$key][$k]['showdiv'] = 1;
					$detectInfo[$key][$k]['first'] = 1;
					//设置是否显示div的尾部
					$detectInfo[$key][$k-1]['showdiv'] = 1;
					$detectInfo[$key][$k-1]['end']= 1;
				}
			}
			//老版本
			makePdfBrief($applist[$key],$detectInfo[$key]);

			sleep(40);
		}
		


	}
}