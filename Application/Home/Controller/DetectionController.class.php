<?php

namespace Home\Controller;

use Think\Controller;

class DetectionController extends CommonController {

    public function _before_center_detection() {

        $userid = $_SESSION['userid'];
        $power = D('Userpower');
        $vocation = D('Vocationtype');
        $userpower = $power->where(array('userid' => $userid))->select()[0];
        if ($_SESSION['userid'] != null) {
            if ($userpower['vocatypeid'] != null || $userpower['vocatypeid'] != '0') {
                $userpower['zhvocationtype'] = $vocation->where(array('id' => $userpower['vocatypeid']))->select()[0]['zhvocationtype'];
            }
            $_SESSION['power'] = $userpower;
            if ($userpower == null || $_SESSION['userid'] == 1) {
                $_SESSION['power'] = 'all';
            }
            usleep(30000);
        } else {
            session(null);
            cookie(null);
            $this->redirect('User/login_user');
        }
    }

    //检测中心,取出用户检测的最近几个app信息
    public function center_detection() {
        $userid = $_SESSION['userid'];
        $appinfo = D("Appinfo");
       $detec = M('detection');
        $map['waytype'] = array('neq', 2);
        $recentSix = $appinfo->where(array('userid' => $userid))->where($map)->order('appid desc')->limit(0, 5)->select();

        if ($_SESSION['power'] == 'all') {
            $recentSix = $appinfo->order('appid desc')->where($map)->limit(0, 5)->select();
            $manRecent = $appinfo->order('appid desc')->where(array('userid' => $userid))->where($map)->limit(1)->select()[0];
            $this->assign('manRecent', $manRecent);
        }

        $det = M('detection');
        $data = array();
        foreach ($recentSix as $kl => $vl) {
            // $data[$kl]['id'] = $vl['id'];
            $data[$kl] = $vl;
            $data[$kl]['count'] = $det->where(array('appid' => $vl['appid']))->count();
             $data[$kl]['cricount'] = $det->where(array('result' => 'critical', 'appid' => $vl['appid']))->count();
            $data[$kl]['highcount'] = $det->where(array('result' => 'high', 'appid' => $vl['appid']))->count();
            $data[$kl]['midcount'] = $det->where(array('result' => 'medium', 'appid' => $vl['appid']))->count();
            $data[$kl]['lowcount'] = $det->where(array('result' => 'low', 'appid' => $vl['appid']))->count();
            $data[$kl]['listcount'] = $detec->group('testtype')->where(array('appid' => $vl['appid']))->select();
          //  $data[$kl]['count'] =  $data[$kl]['lowcount']+ $data[$kl]['midcount']+ $data[$kl]['highcount']++;
            
        }
        // dump($data);die;
        $this->assign('recent', $data);
        //$this->assign('recent',$recentSix);
        $envtype = D('Envtype');
        $showwhere['show'] = array('neq', 0);
        $envtypelist = $envtype->where($showwhere)->select();
        $this->assign('envtypelist', $envtypelist);
        $langtype = D('Langtype');
        $langtypelist = $langtype->where($showwhere)->select();
        $this->assign('langtypelist', $langtypelist);

        $Vocationtype = D('Vocationtype');
        $Vocationlist = $Vocationtype->where($showwhere)->select();
        $this->assign('vocationlist', $Vocationlist);

        $this->display();
    }

    //上传时间间隔
    public function interval() {
        $interval = 99999;
        echo $interval;
    }

    //列出所有检测的应用信息
    public function list_detection() {
        $userid = $_SESSION['userid'];
        $appinfo = D('Appinfo');
        $admin = D('admins');
        $user  =D('user');
        $map['waytype'] = array('neq', 2);

        $page = ($page == null) ? 0 : I('get.page');
        $countnum = 10;
        $star = (I('get.p', 1) - 1) * $countnum;
        $count = $appinfo->where(array('userid' => $userid))->where($map)->count();

        if ($_SESSION['power'] == 'all') {
            $count = $appinfo->where($map)->count();
        }
        // 分页
        $p = new \Think\Page($count, $countnum);
        $p->lastSuffix = false;
        $p->setConfig('header', '<br/><li class="rows">共<b>%TOTAL_ROW%</b>条记录  每页<b>' . $countnum . '</b>条  第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页</li>');
        $p->setConfig('prev', '上一页');
        $p->setConfig('last', '末页');
        $p->setConfig('first', '首页');
        $p->setConfig('next', '下一页');
        $p->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
        $page = $p->show();
    if ($_SESSION['power'] != 'all') {
        $allAppinfo = $appinfo->order('appid DESC')->where(array('userid' => $userid))->where($map)->limit($p->firstRow . ',' . $p->listRows)->select();
           foreach ($allAppinfo as $ke => $value) {
                       // $allAppinfo[$ke1]['adminlogin']= $admin->field('loginemail,realname')->where(array('userid'=>$value1['userid']))->limit($p->firstRow . ',' . $p->listRows)->select(); 
                        $allAppinfo[$ke]['userlogin']= $user->field('loginemail,realname')->where(array('userid'=>$value['userid']))->limit($p->firstRow . ',' . $p->listRows)->select(); 

                    }
        
    }
        if ($_SESSION['power'] == 'all') {
            $allAppinfo = $appinfo->order('appid DESC')->where($map)->limit($p->firstRow . ',' . $p->listRows)->select();
                  foreach ($allAppinfo as $ke1 => $value1) {
                        $allAppinfo[$ke1]['adminlogin']= $admin->field('loginemail,realname')->where(array('userid'=>$value1['userid']))->limit($p->firstRow . ',' . $p->listRows)->select(); 
                        $allAppinfo[$ke1]['userlogin']= $user->field('loginemail,realname')->where(array('userid'=>$value1['userid']))->limit($p->firstRow . ',' . $p->listRows)->select(); 

                    }
          
        }
        
     // $data= array();
        foreach ($data as $ke1 => $value1) {
            $data[$ke1]['adminlogin']= $admin->field('loginemail,realname')->where(array('userid'=>$value1['userid']))->limit($p->firstRow . ',' . $p->listRows)->select(); 
            $data[$ke1]['userlogin']= $user->field('loginemail,realname')->where(array('userid'=>$value1['userid']))->limit($p->firstRow . ',' . $p->listRows)->select();  
        }
        
       
          
        $vocationtype = D('Vocationtype');
        $vocationtypeinfo = $vocationtype->select();
        $this->assign('userid', $userid);
        $this->assign('vocationtype', $vocationtypeinfo);
        $this->assign('star', $star);
        $this->assign('pageshow', $page);
        $this->assign('applist', $allAppinfo);
//        dump($allAppinfo);
//        die;
        $this->display();
    }

    public function _empty() {
        $userid = $_SESSION['userid'];
        $url = get_url();
        addLog($userid, "手动输入不存在的地址,有嫌疑!地址:" . $url);
        $this->display('Layout:show_404');
    }

    //搜索应用名、包名、md5、提交时间、版本号、安全等级
    public function searchapp_detection() {
        $condition = I('get.condition');
        $sort = I('get.sort');


        $map['waytype'] = array('neq', 2);
        // $map['status']  = array('neq',0);
        if (substr($condition, 0, 4) == 'time') {
            $condition = 'subtime';
        } elseif (substr($condition, 0, 5) == 'appid') {
            $condition = 'appid';
        } elseif (substr($condition, 0, 7) == 'version') {
            $condition = 'version';
        } else {
            $condition = 'appid';
        }
        if (substr($sort, 0, 3) == 'ASC') {
            $sort = 'ASC';
        } elseif (substr($condition, 0, 4) == 'DESC') {
            $sort = 'DESC';
        } else {
            $sort = 'ASC';
        }
        $sortcondition = $condition . " " . $sort;
        if ($sortcondition == ' ') {
            $sortcondition = 'appid DESC';
        }
        $appName = I('get.appname');
        // $appPackage		= I('get.package');
        $appMd5 = I('get.md5');
        // $appStarttime 	= I('get.starttime');
        // $appEndtime 	= I('get.endtime');
        $appVersion = I('get.version');
        $vocation = I('get.vocation');

        $appinfo = D("Appinfo");

        $data = array();

        if ($appName != null) {
            $data['name'] = array(array('like', "%" . strtoupper($appName) . "%"), array('like', "%" . $appName . "%"), array('like', "%" . strtolower($appName) . "%"), "OR");
        }
        if ($appMd5 != null) {
            $data['MD5'] = array('like', "%" . $appMd5 . "%");
        }
        // if($appStarttime != null || $appEndtime != null){
        // 	if( ($appStarttime == $appEndtime) || ($appStarttime == null && $appEndtime != null) || (($appStarttime != null && $appEndtime == null))){
        // 		$data['subtime'] = array('like',"%".$appSubtime."%"); 
        // 	}elseif($appStarttime != null && $appEndtime != null){
        // 		if($appStarttime > $appEndtime){
        // 			$data['subtime'] = array(array('egt',$appEndtime),array('elt',$appStarttime),'AND');
        // 		}else{
        // 			$data['subtime'] = array(array('elt',$appEndtime),array('egt',$appStarttime),'AND');
        // 		}
        // 	}
        // }
        if ($appVersion != null) {
            $data['version'] = array('like', "%" . $appVersion . "%");
        }
        // if($_SESSION['power']['usertypeid'] == 3 && $vocation != null){
        // 	$data['vocation'] = $vocation;
        // }

        $userid = $_SESSION['userid'];
        $page = ($page == null) ? 0 : I('get.page');
        $countnum = 10;
        $star = (I('get.p', 1) - 1) * $countnum;
        if ($_SESSION['power']['usertypeid'] < 3) {
            $count = $appinfo->where($data)->where($map)->where(array('userid' => $userid))->count();
        }
        if ($_SESSION['power'] == 'all') {
            $count = $appinfo->where($data)->where($map)->count();
        }
        if ($count == 0) {
            $this->redirect('Detection/list_detection', array('tip' => 'SEARCH_FALSE'));
        }
        $p = new \Think\Page($count, $countnum);
        $p->lastSuffix = false;
        $p->setConfig('header', '<br/><li class="rows">共<b>%TOTAL_ROW%</b>条记录  每页<b>' . $countnum . '</b>条  第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页</li>');
        $p->setConfig('prev', '上一页');
        $p->setConfig('last', '末页');
        $p->setConfig('first', '首页');
        $p->setConfig('next', '下一页');
        $p->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
        $page = $p->show();
        if ($_SESSION['power']['usertypeid'] < 3) {
            $allAppinfo = $appinfo->order($sortcondition)->where($data)->where($map)->where(array('userid' => $userid))->limit($p->firstRow . ',' . $p->listRows)->select();
        }
        if ($_SESSION['power'] == 'all') {
            $allAppinfo = $appinfo->order($sortcondition)->where($data)->where($map)->limit($p->firstRow . ',' . $p->listRows)->select();
        }


        $this->assign('sort', $sort);
        $this->assign('condition', $condition);
        // $this->assign('appname',$appName);
        // $this->assign('appPackage',$appPackage);
        // $this->assign('appMd5',$appMd5);
        // $this->assign('appSubtime',$appSubtime);
        // $this->assign('appVersion',$appVersion);
        // $this->assign('appLevel',$appLevel);

        $this->assign('star', $star);
        $this->assign('pageshow', $page);
        $this->assign('applist', $allAppinfo);
        $this->display();
    }

    /*
     * 上传APP的方法测试
     */

    public function upload_app() {
//        $this->ajaxReturn($_POST);
//        dump($_POST);
//        die;
        $parameter = I('post.action');
        $test = I('post.test');

        //加固服务
        // $reinforce 			= I('get.reinforce');
        //检测服务
        // $piracinfo			= I('get.detecservice');
        //项目名，＊
        $proname = I('post.projectname');
        $vocation = I('post.vocation');
        //软件版本，＊
        $version = I('post.version');
        //开发语言，＊
        $lang = I("post.lang");
        //编译环境，＊
        $env = I('post.makeenv');

        //编译命令
        $mekecommand = I('post.mekecommand');

        $appupload = D('Appupload');
        $appinfo = D('Appinfo');


        $info = I('post.git');
        $userid = $_SESSION['userid'];
        // $this->ajaxReturn(array('info'=>$proname));
        // exit;
        if (empty($proname)) {

            echo 'b';
            // $this->ajaxReturn(array('info'=>'项目名不可为空'));
            exit;
        }
        if (empty($version)) {
            echo 'version';
            //  $this->ajaxReturn(array('info'=>'软件版本不可为空'));
            exit;
        }
        if (empty($lang)) {
            echo 'lang';
            //  $this->ajaxReturn(array('info'=>'开发语言不可为空'));
            exit;
        }
        if (empty($env)) {

            echo 'env';
            // $this->ajaxReturn(array('info'=>'编译环境不可为空'));
            exit;
        }

        if ($_SESSION['power']['uploadlimittype'] == '1') {
            $bettwen = downtimespace();
            $map['subtime'] = array(array('gt', $bettwen['start']), array('lt', $bettwen['end']), 'AND');
        } elseif ($_SESSION['power']['downlimittype'] == '2') {
            //总数限制
            $map['subtime'] = array('lt', time());
        }
        $uploadlimit = $appupload->where($map)->where(array('userid' => $userid))->count();
        //上传限制
        if ($_SESSION['power']['uploadlimit'] <= $uploadlimit) {
            // echo 'USER_UPLOAD_LIMIT';
            $this->ajaxReturn(array('info' => 'USER_UPLOAD_LIMIT'));
            exit;
        }
        $lastUploadTime = $appupload->where(array('userid' => $userid))->limit(0, 1)->order('appid DESC')->select()[0]['subtime'];
        if ($lastUploadTime == null) {
            $lastUploadTime = 0;
        } {
            if ($info) {
                $path = $info;
                //   $path = UPLOAD_PATH.$info['uploadfile']['savepath'].$info['uploadfile']['savename'];
                // $md5 = $info['uploadfile']['md5'];


                $data = array(
                    'apppath' => $path,
                    //'apppath'     => $info,
                    'userid' => $userid,
                    'subtime' => time()
                );

                $appupload->startTrans();
                $id = $appupload->add($data);
                //增加上传记录的函数
                addUploadApkRecord($userid);

                if ($id) {
                    //$path          = getcwd()."/Uploads/".$info['uploadfile']['savepath'].$info['uploadfile']['savename'];
                    $path = $info;
                    $appid = $id;

                    $md5 = md5_file($path);
                    $mysize = sprintf("%.3f", (filesize($path) / (1024 * 1024))) . 'MB';
                    {

                        if ($appinfo->find($id)) {
                            // $infores = $appinfo->where(array('appid'=>$id))->data(array('userid'=>$userid,'version'=>$version,'MD5'=>$md5,'size'=>$mysize,'env'=>$env,'lang'=>$lang,'name'=>$proname,'shell'=>$mekecommand,'subtime'=>time()))->save();
                            $infores = $appinfo->where(array('appid' => $id))->data(array('userid' => $userid, 'version' => $version, 'MD5' => $md5, 'size' => $mysize, 'env' => $env, 'lang' => $lang, 'name' => $vocation . $proname, 'shell' => $mekecommand, 'subtime' => time()))->save();
                        } else {
                            $infores = $appinfo->data(array(
                                        'appid' => $id,
                                        'name' => $vocation . $proname,
                                        // 'name'=>$proname, 
                                        'userid' => $userid,
                                        'version' => $version,
                                        'env' => $env,
                                        'MD5' => $md5,
                                        'size' => $mysize,
                                        'lang' => $lang,
                                        'shell' => $mekecommand,
                                        'subtime' => date('Y-m-d H:i:s')
                                    ))->add();
                        }

                        addLog($userid, "上传文件,文件的名称为 {$info['uploadfile']['savename']}");

                         //  system("/Apktest/MobAppSecAss/apptest_info_apk.sh {$filePath} {$appid} {$userid} {$parameter} >/dev/null &");
                        //   system("/Apktest/MobAppSecAss/start_apptest '/Apktest/MobAppSecAss/apptest_apk.sh'  {$filePath} {$appid} {$userid} {$parameter} >/dev/null &");
			  
                        // system("/Apktest/MobAppSecAss/start_apptest '/Apktest/MobAppSecAss/apptest_apk.sh'  {$path} {$appid} {$userid} {$parameter} >/dev/null &");
                    }
                    // $this->ajaxReturn(array('id' => $id,'infores' => $infores));

                    if ((false !== $id) && (false !== $infores)) {
                        $appupload->commit();
                        echo 'UPLOAD_SUCCESS';
                        exit;

                        //$this->ajaxReturn(array('info'=>'UPLOAD_SUCCESS'));
                    } else {
                        $appupload->rollback();
                        $this->error('提交失败');
                        //$this->ajaxReturn(array('info'=>'UPLOAD_FALSE'));
                    }
                }
            } else {
                exit;
                $this->ajaxReturn(array('info' => 'EXT_NOT_ALLOW'));
            }
        }
    }

    /*
     * 上传APP的方法
     */

    public function upload_apk() {
        $parameter = I('get.action');
        $test = I('get.test');

        //加固服务
        // $reinforce 			= I('get.reinforce');
        //检测服务
        // $piracinfo			= I('get.detecservice');
        //项目名，＊
        $proname = I('get.projectname');
        $vocation = I('get.vocation');
        //软件版本，＊
        $version = I('get.version');
        //开发语言，＊
        $lang = I("get.lang");
        //编译环境，＊
        $env = I('get.makeenv');
        //编译命令
        $mekecommand = I('get.mekecommand');

        $appupload = D('Appupload');
        $appinfo = D('Appinfo');

        $upload = new \Think\Upload();
        // $upload->exts   =  array();
       // $upload->exts = array('zip', 'gz', 'tar', 'tgz', 'bz2', 'Z', 'rar');
         $upload->exts = array('zip', 'gz');
        $upload->rootPath = UPLOAD_PATH;
        $upload->subName = array('date', 'Ymd');
       // $upload->maxSize   = 3145728000000 ;// 设置附件上传大小
        $info = $upload->upload();
       
        $userid = $_SESSION['userid'];
        // $this->ajaxReturn(array('info'=>$proname));
        // exit;
        if (empty($proname)) {
            $this->ajaxReturn(array('info' => '项目名不可为空'));
            exit;
        }
        if (empty($version)) {
            $this->ajaxReturn(array('info' => '软件版本不可为空'));
            exit;
        }
        if (empty($lang)) {
            $this->ajaxReturn(array('info' => '开发语言不可为空'));
            exit;
        }
        if (empty($env)) {
            $this->ajaxReturn(array('info' => '编译环境不可为空'));
            exit;
        }

        if ($_SESSION['power']['uploadlimittype'] == '1') {
            $bettwen = downtimespace();
            $map['subtime'] = array(array('gt', $bettwen['start']), array('lt', $bettwen['end']), 'AND');
        } elseif ($_SESSION['power']['downlimittype'] == '2') {
            //总数限制
            $map['subtime'] = array('lt', time());
        }
        $uploadlimit = $appupload->where($map)->where(array('userid' => $userid))->count();
        //上传限制
        if ($_SESSION['power']['uploadlimit'] <= $uploadlimit) {
            // echo 'USER_UPLOAD_LIMIT';
            $this->ajaxReturn(array('info' => 'USER_UPLOAD_LIMIT'));
            exit;
        }
        $lastUploadTime = $appupload->where(array('userid' => $userid))->limit(0, 1)->order('appid DESC')->select()[0]['subtime'];
        if ($lastUploadTime == null) {
            $lastUploadTime = 0;
        } {
            if ($info) {
                $path = UPLOAD_PATH . $info['uploadfile']['savepath'] . $info['uploadfile']['savename'];
                // $md5 = $info['uploadfile']['md5'];


                $data = array(
                    'apppath' => $path,
                    'userid' => $userid,
                    'subtime' => time()
                );

                $appupload->startTrans();
                $id = $appupload->add($data);
                //增加上传记录的函数
                addUploadApkRecord($userid);

                if ($id) {
                    $path = getcwd() . "/Uploads/" . $info['uploadfile']['savepath'] . $info['uploadfile']['savename'];
                    $appid = $id;
                    $md5 = md5_file($path);
                    $mysize = sprintf("%.3f", (filesize($path) / (1024 * 1024))) . 'MB';
                    {

                        if ($appinfo->find($id)) {
                            // $infores = $appinfo->where(array('appid'=>$id))->data(array('userid'=>$userid,'version'=>$version,'MD5'=>$md5,'size'=>$mysize,'env'=>$env,'lang'=>$lang,'name'=>$proname,'shell'=>$mekecommand,'subtime'=>time()))->save();
                            $infores = $appinfo->where(array('appid' => $id))->data(array('userid' => $userid, 'version' => $version, 'MD5' => $md5, 'size' => $mysize, 'env' => $env, 'lang' => $lang, 'name' => $vocation . $proname, 'shell' => $mekecommand, 'subtime' => time()))->save();
                        } else {
                            $infores = $appinfo->data(array(
                                        'appid' => $id,
                                        'name' => $vocation . $proname,
                                        // 'name'=>$proname, 
                                        'userid' => $userid,
                                        'version' => $version,
                                        'env' => $env,
                                        'MD5' => $md5,
                                        'size' => $mysize,
                                        'lang' => $lang,
                                        'shell' => $mekecommand,
                                        'subtime' => date('Y-m-d H:i:s')
                                    ))->add();
                        }
                
                        addLog($userid, "上传文件,文件的名称为 {$info['uploadfile']['savename']}");
                         //$filePath = getcwd()."/".$path;
                         $filePath = $path;
                            //system("bash /var/www/html/sca/Uploads/20160810/scripts/generatejava.sh  {$filePath} {$appid} {$userid} {$parameter} >/tmp/jiexi.log &");
			system("python /Apktest/start_shell  \"bash  /home/apptest/scripts/generatejava.sh {$filePath} {$appid} {$userid}  \"");
                         //  system("bash /home/apptest/scripts/generatejava.sh /var/www/html/sca/Uploads/20160810/57ab341f3815b.zip  1 1 ");
                         
                        //  system("/Apktest/MobAppSecAss/apptest_info_apk.sh {$filePath} {$appid} {$userid} {$parameter} >/dev/null &");
                         // system("/Apktest/MobAppSecAss/start_apptest '/Apktest/MobAppSecAss/apptest_apk.sh'  {$filePath} {$appid} {$userid} {$parameter} >/dev/null &");
			  

                        // system("/Apktest/MobAppSecAss/start_apptest '/Apktest/MobAppSecAss/apptest_apk.sh'  {$path} {$appid} {$userid} {$parameter} >/dev/null &");
                    }
                    if ((false !== $id) && (false !== $infores)) {
                        $appupload->commit();
                        $this->ajaxReturn(array('info' => 'UPLOAD_SUCCESS'));
                    } else {
                        $appupload->rollback();
                        $this->ajaxReturn(array('info' => 'UPLOAD_FALSE'));
                    }
                }
            } else {
                 
                 //  $this->ajaxReturn(array('info' => $upload->error()));
                $this->ajaxReturn(array('info' => 'EXT_NOT_ALLOW'));
            }
        }
    }

    //增加监测
    public function addMonitor() {
        $appid = I('post.appid');
        $appinfo = D('Appinfo');
        $apppiracy = D('Apppiracy');
        $appservice = D('Appservice');

        if (is_null($appid)) {
            $this->ajaxReturn(array('info' => 'false'));
        }
        $appdata = $appinfo->field('status,package,certmd5,realname,icon,type,version')->find($appid);

        $data = array(
            'appid' => $appid,
            'status' => 0,
            'package' => $appdata['package'],
            'realname' => $appdata['realname'],
            'icon' => $appdata['icon'],
            'type' => $appdata['type'],
            'version' => $appdata['version'],
            'certMD5' => $appdata['certmd5']
        );

        $apppiracy->startTrans();
        if ($apppiracy->where(array('appid' => $appid))->select()) {
            $this->ajaxReturn(array('info' => 'false', 'error' => '存在数据'));
        }

        $res = $apppiracy->data($data)->add();
        $service = $appservice->field('id,servicelist')->where(array('appid' => $appid))->select()[0];
        if (in_array('3', explode(',', $service['servicelist']))) {
            $this->ajaxReturn(array('info' => 'false', 'error' => $service['servicelist']));
        }

        $servicelist = $service['servicelist'] . ',3';
        if ($service['id'] == null) {
            $ss = $appservice->data(array('appid' => $appid, 'servicelist' => '1,3'))->add();
        } else {
            $ss = $appservice->where(array('id' => $service['id']))->save(array('servicelist' => $servicelist));
        }

        if ($res !== false && $ss !== false) {
            $apppiracy->commit();
            $this->ajaxReturn(array('info' => 'success'));
        } else {
            $apppiracy->rollback();
            $this->ajaxReturn(array('info' => 'false'));
        }
    }

    //增加加固
    public function addReinfo() {
        $appid = I('post.appid');
        $appinfo = D('Appinfo');
        $appupload = D('Appupload');
        $appreinforce = D('Appreinforce');
        $appservice = D('Appservice');
        if (is_null($appid)) {
            $this->ajaxReturn(array('info' => 'false'));
        }

        $appdata = $appupload->field('apppath')->find($appid);
        $appreinforce->startTrans();

        $service = $appservice->field('id,servicelist')->where(array('appid' => $appid))->select()[0];
        if (in_array('2', explode(',', $service['servicelist']))) {
            $this->ajaxReturn(array('info' => 'false', 'error' => $service['servicelist']));
        }
        if ($appreinforce->find($appid)) {
            $reinfores = $appreinforce->where(array('appid' => $appid))->save(array('status' => 0));
        } else {
            $reinfores = $appreinforce->data(array('appid' => $appid, 'status' => 0, 'reinforcepath' => $appdata['apppath']))->add();
        }
        $servicelist = $service['servicelist'] . ',2';
        if ($service['id'] == null) {
            $ss = $appservice->data(array('appid' => $appid, 'servicelist' => '1,2'))->add();
        } else {
            $ss = $appservice->where(array('id' => $service['id']))->save(array('servicelist' => $servicelist));
        }


        if ($ss !== false && $reinfores !== false) {
            $appreinforce->commit();
            $this->ajaxReturn(array('info' => 'success'));
        } else {
            $appreinforce->rollback();
            $this->ajaxReturn(array('info' => 'false'));
        }
    }

    public function reinforce_detection() {
        $appinfo = D('Appinfo');
        $appid = I('get.appid');
        $info = $appinfo->find($appid);
        if (!file_exists($info['icon'])) {
            $info['icon'] = UPLOAD_PATH . '/icon/default.png';
        }

        $this->assign('info', $info);
        $this->display();
    }

}
