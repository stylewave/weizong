<?php

namespace Home\Controller;

use Think\Controller;

class ReportController extends CommonController {

    //基本检测
    public function base_report() {
      
        $appinfo = D('Appinfo');
        $appid = I('get.appid');
        $userid = $_SESSION['userid'];

        if ($_SESSION['power'] == 'all') {
            $result = $appinfo->find($appid);
        } else {
            $result = $appinfo->where(array('userid' => $userid, 'appid' => $appid))->select()[0];
        }
        //  dump($result);


        $detec = M('detection');
        $listcount = $detec->group('testtype')->where(array('appid' => $appid))->select();
        $loophole = array();
        $loophole['cricount'] = $detec->where(array('result' => 'critical', 'appid' => $appid))->count();
        $loophole['highcount'] = $detec->where(array('result' => 'high', 'appid' => $appid))->count();
        $loophole['midcount'] = $detec->where(array('result' => 'medium', 'appid' => $appid))->count();
        $loophole['lowcount'] = $detec->where(array('result' => 'low', 'appid' => $appid))->count();
        $loophole['count'] = $loophole['cricount'] + $loophole['highcount'] + $loophole['midcount'] + $loophole['lowcount'];
        $this->assign('loophole', $loophole);
        // dump($result);die;
        $this->assign('info', $result);
         $this->assign('d', date('Y-m-d'));
        $this->assign('listcount', $listcount);
        $this->display();
    }

    //查询详细
    public function info() {
       $id = I('post.id');
      //  $id= 534;
        $detec = M('detection');
        $data = $detec->field('at_detection.id as id,at_detection.scaid as scaid,at_detectype.zhtesttype,at_detectype.damage as damage,at_detectype.suggest as suggest,at_detection.appid as appid,at_detection.testtype as testtype,at_detection.info as info')->where(array('at_detection.id' => $id))->join('left join at_detectype on at_detectype.testtype = at_detection.testtype')->find();
  
      //   $info = $detec->where(array('id' => $id))->find()['info'];
        $data['info'] = str_replace("\t", ' ', $data['info']);
      //dump($data);die;
        $this->ajaxReturn($data);
     
       // echo $data;
        exit;
    }

    //基本检测详情
    public function basedetial_report() {
        if ($_SESSION['power']['userid'] == null) {
            $this->redirect('Index/index');
            exit();
        }
        //var_dump($_SESSION);
        $appinfo = D('Appinfo');
        $detec = D('Detection');
        $results = M('resulttype');

        $appid = (int) I('get.appid');
        $userid = $_SESSION['userid'];

        if ($_SESSION['power'] == 'all') {
            $result = $appinfo->find($appid);
        } else {
            $result = $appinfo->where(array('userid' => $userid, 'appid' => $appid))->select()[0];
        }


        if (!empty($result)) {
            $det = M('detection');
            // $list = $det->field('at_detection.id,at_detection.scaid,at_detection.appid,at_detection.testname,at_detection.testtype,at_detection.result,at_detection.info,at_resulttype.zhresult')->join('left join at_resulttype on at_resulttype.result=at_detection.result')->select();

            $lists = $det->group('testtype')->where(array('appid' => $appid))->select();


            $data = array();
            foreach ($lists as $kl => $vl) {
                $data[$kl]['id'] = $vl['id'];
                $data[$kl]['testtype'] = $vl['testtype'];
                $data[$kl]['count'] = $det->where(array('appid' => $appid, 'testtype' => $vl['testtype']))->count();
                $data[$kl]['cricount'] = $det->where(array('appid' => $appid, 'testtype' => $vl['testtype'], 'result' => 'critical',))->count();
                $data[$kl]['hicount'] = $det->where(array('appid' => $appid, 'testtype' => $vl['testtype'], 'result' => 'high',))->count();
                $data[$kl]['medcount'] = $det->where(array('appid' => $appid, 'testtype' => $vl['testtype'], 'result' => 'medium',))->count();
                $data[$kl]['lowcount'] = $det->where(array('appid' => $appid, 'testtype' => $vl['testtype'], 'result' => 'low',))->count();
                $data[$kl]['children'] = $det->where(array('at_detection.appid' => $appid, 'at_detection.testtype' => $vl['testtype']))->field('at_detection.id,at_detection.scaid,at_detection.appid,at_detection.testname,at_detection.testtype,at_detection.result,at_detection.info,at_resulttype.zhresult')->join('left join at_resulttype on at_resulttype.result=at_detection.result')->select();
                //   $data[$kl]['children'][$kl]['info']=  mb_substr($data[$kl]['children'][0]['info'], 0, 20, 'utf8');
                //  dump( $data[$kl]['children']) ;   
                foreach ($data[$kl]['children'] as $k2 => $v2) {

                    $data[$kl]['children'][$k2]['infos'] = explode(")", $data[$kl]['children'][$k2]['info'], -1)[0] . ")";
//                          dump($data[$kl]['children'][$k2]['infos']);
//                         dump($data[$kl]['children'][$k2]);
                }
                // die;
//                     echo $data[$kl]['children']['info'];
            }

            $this->assign('listview', $data);

//                  
            //  dump($data);
//                   
//                     
//                    die;    


            $loophole = array();

            $loophole['cricount'] = $detec->where(array('result' => 'critical', 'appid' => $appid))->count();
            $loophole['highcount'] = $detec->where(array('result' => 'high', 'appid' => $appid))->count();
            $loophole['midcount'] = $detec->where(array('result' => 'medium', 'appid' => $appid))->count();
            $loophole['lowcount'] = $detec->where(array('result' => 'low', 'appid' => $appid))->count();
            $loophole['count'] = $loophole['cricount'] + $loophole['highcount'] + $loophole['midcount'] + $loophole['lowcount'];

            // dump($loophole['highcount']);
            $resultlist = $results->select();
            $this->assign('resultlist', $resultlist);
            $this->assign('loophole', $loophole);
            $this->assign('info', $result);
            $this->assign('listcount', $listcount);
            $this->display();
        } else {
            $this->display('Layout:show_404');
        }
    }

    public function save() {
        // dump($_POST);die;

        $id = I('post.id', 0, 'intval');

        $detection = M('detection');
        $data['result'] = I('post.newresult');
        $old = I('post.oldresult');
        //  $data['info']= I('post.reason');
        // dump($data);die;
        $datas = $detection->where(array('id'=>$id))->find();
        $arr = $detection->where(array('id' => $id))->data($data)->save();
        if ($arr) {
            echo 'SUCCESS';
//              @addLog(array(
//                'userid' => $_SESSION['userid'],
//                'username' => $$datas['testtype'].','.$datas['scaid'],
//                'handlecontent' => '由'.$old.'改为'.$data['result']
//            ));
            addLog($_SESSION['userid'], "{$datas['testtype']},{$datas['scaid']}:(由{$old}改为{$data['result']})");
            exit;
            $this->success('修改成功');
        } else {
            exit;
            $this->error('修改失败');
        }
    }

    public function delete() {
        $id = I('post.id', 0, 'intval');
        $appid = I('post.appid', 0, 'intval');
        //   dump($_POST);die;
        $detection = M('detection');
        $arr = $detection->where(array('id' => $id))->delete();
        if ($arr) {
            $this->redirect('Report/basedetial_report', array('appid' => $appid));
        } else {
            $this->error('修改失败');
        }
        //  dump($_POST);
    }

    // 获取类型
    public function getType() {
        //$Type=D('Type');
        //$list=$Type->where('bug_num!=0')->order('pid ASC,id ASC')->field('id,pid,name,bug_num')->select();

        $det = M('detection');
        $l = $det->query("select distinct(testtype) as testtype from at_detection ");
        $where['testtype'] = $testtype;
        $list = $det->select();
        $lists = $det->group('testtype')->select();

        foreach ($l as $k => $v) {

            foreach ($list as $val) {
                if ($v['testtype'] == $val['testtype']) {

                    $new[$val['id']] = $val;
                }
            }
        }

        $oneDiv = $det->query("select distinct(testtype) from at_detection");
        foreach ($oneDiv as $k => $oneRow) {
            echo $oneRow['testtype'] . '<br/>';
        }


        return $new;
    }

    public function tes() {
        $det = M('detection');
        $list = $det->field('testtype')->group('testtype')->select();
        dump($list);
    }

    //应用统计
    public function appstatistics() {
        // $appid = 1276;
        $appid = I('get.appid');
        $appinfo = D('Appinfo');
        $detec = D('Detection');
        //应用分数
        $score = 10;
        //检测大分类
        //$highCondition['result']	= array('eq',4);
        $criCondition['result'] = array('eq', 'critical');
        $highCondition['result'] = array('eq', 'high');
        $where['appid'] = array('eq', $appid);
//		$midCondition['result']		= array('eq',3);
//		$lowCondition['result']		= array('eq',2);
        $midCondition['result'] = array('eq', 'medium');
        $lowCondition['result'] = array('eq', 'low');

        //应用的漏洞高中低数
        $cri = intval($detec->where($criCondition)->where($where)->count());
        $high = intval($detec->where($highCondition)->where($where)->count());
        $mid = intval($detec->where($midCondition)->where($where)->count());
        $low = intval($detec->where($lowCondition)->where($where)->count());
        //   echo  $cri ;die;
        //  dump($low);die;
        //各类检测个数

        $zhtesttype = $detec->field('appid,at_detection.testtype,at_detectype.testtype as zhtesttype')->where(array('appid' => $appid))->join('left join at_detectype on at_detectype.id = at_detection.testtype')->group('testtype ASC')->select();


        // $testtyperound = array();
        foreach ($zhtesttype as $k => $v) {
            $map['testtype'] = $v['testtype'];
            $map['appid'] = array('eq', $appid);
            //$testtypeStatistics[$k]['name'] = $v['zhtesttype'];
            $data['round'][$k]['name'] = $v['testtype'];
            //  $data['round'][$k]['name'] = substr($v['testtype'],0,10);
            $data['round'][$k]['value'] = $detec->where($map)->count();
        }
        // dump($data);die;
        //  dump($testtyperound);
        $testtypeStatistics = array();
        foreach ($zhtesttype as $k => $v) {
            $map['testtype'] = $v['testtype'];
            $map['appid'] = array('eq', $appid);
            //$testtypeStatistics[$k]['name'] = $v['zhtesttype'];
            $testtypeStatistics[$k]['name'] = $v['testtype'];
            $testtypeStatistics[$k]['cricount'] = $detec->where($criCondition)->where($map)->count();
            $testtypeStatistics[$k]['highcount'] = $detec->where($highCondition)->where($map)->count();
            $testtypeStatistics[$k]['midcount'] = $detec->where($midCondition)->where($map)->count();
            $testtypeStatistics[$k]['lowcount'] = $detec->where($lowCondition)->where($map)->count();
        }
        //score 分数 high、mid、low统计,testtypeStatistics中name检测的名称,highcount、midcount、lowcount是该项高中低漏洞的统计数量
        //echo "<pre>";
        //  dump($testtypeStatistics);

        $data['score'] = $score;

        $data['pie'][] = $cri;
        $data['pie'][] = $high;
        $data['pie'][] = $mid;
        $data['pie'][] = $low;

        foreach ($testtypeStatistics as $key => $val) {
            $data['bar']['xaxis'][] = $val['name'];
            //  $data['bar']['xaxis'][]= $this->cut_str($val['name'],6,0,'utf-8');
            //   $data['bar']['cri'][]=1;
            $data['bar']['cri'][] = $val['cricount'];
            $data['bar']['height'][] = $val['highcount'];
            $data['bar']['mid'][] = $val['midcount'];
            $data['bar']['low'][] = $val['lowcount'];
        }

        // dump($data);die;
        $this->ajaxReturn($data);
    }

    //判断用户下载的报告数量
    public function downlimit() {
        set_time_limit(0);
        $app = D('Appinfo');
        $userid = $_SESSION['userid'];
        $down = D('Downlimit');
        $timespace = D('Timespace');
        //单位时间限制
        if ($_SESSION['power']['downlimittype'] == '1') {
            //查询数据表中的开始时间和时间间隔

            $bettwen = downtimespace();
            $map['downtime'] = array(array('gt', $bettwen['start']), array('lt', $bettwen['end']), 'AND');
        } elseif ($_SESSION['power']['downlimittype'] == '2') {
            //总数限制
            $map['downtime'] = array('lt', time());
        }
        if ($_SESSION['power']['userpayid'] == '1') {
            $count = 99999999;
        } else {
            $count = $down->where($map)->where(array('userid' => $userid))->count();
        }
      

        if ($count < $_SESSION['power']['downlimit'] || $_SESSION['power'] == 'all') {
            $this->ajaxReturn(array('info' => 'true'));
        } else {
            $this->ajaxReturn(array('info' => 'false'));
        }
    }

    //pdf报告
    public function down_report() {
        $appid = I('get.appid');
        $app = D('Appinfo');
        $userid = $_SESSION['userid'];
        $down = D('Downlimit');
        //单位时间限制
        if ($_SESSION['power']['downlimittype'] == '1') {
            // $map['downtime'] 		= array('gt',strtotime(date('Ymd',time())));
            $bettwen = downtimespace();
            $map['downtime'] = array(array('gt', $bettwen['start']), array('lt', $bettwen['end']), 'AND');
        } elseif ($_SESSION['power']['downlimittype'] == '2') {
            //总数限制
            $map['downtime'] = array('lt', time());
        }

        if ($_SESSION['power'] == 'all') {
            $info = $app->where(array('appid' => $appid))->select()[0];
        } else {
            //找到下载的应用的信息
            $info = $app->where(array('userid' => $userid, 'appid' => $appid))->select()[0];
            //下载统计次数
            // $count			= $down->field('appid')->where($map)->where(array('userid'=>$userid))->count();
        }
        if (!empty($info)) {
            if (!file_exists($info['icon']) && substr($info['icon'], 0, 4) !== 'http') {
                $info['icon'] = UPLOAD_PATH . 'icon/default.png';
            }
            addLog($_SESSION['userid'], "下载 {$info['realname']} 的PDF检测报告");
            $detec = D('Detection');
            $detectInfo = $detec->where(array('appid' => $appid))->select();
            //做一个计数器
            $oldtesttype = 0;
            foreach ($detectInfo as $k => $v) {
                //当计数器的值等于数组中的值时，消掉testtype标志
                if ($oldtesttype == $v['testtype']) {
                    unset($detectInfo[$k]['testtype']);
                } else {
                    //否则令计数器等于该标志值，作为下一次判断的值
                    $oldtesttype = $detectInfo[$k]['testtype'];
                    //设置是否显示div的头部
                    $detectInfo[$k]['showdiv'] = 1;
                    $detectInfo[$k]['first'] = 1;
                    //设置是否显示div的尾部
                    $detectInfo[$k - 1]['showdiv'] = 1;
                    $detectInfo[$k - 1]['end'] = 1;
                }
            }
            //老版本
            makePdfBrief($info, $detectInfo);
            $down->data(array('userid' => $userid, 'appid' => $appid, 'downtime' => time()))->add();
            // makeMpdfBrief($info,$detectInfo);
        } else {
            addLog($userid, "越权查看");
            $this->display('Layout:show_404');
        }
    }

    //下载技术报告
    public function downtech_report() {
        $appid = I('get.appid');
        $app = D('Appinfo');
        $userid = $_SESSION['userid'];
        $down = D('Downlimit');
        //单位时间限制
        if ($_SESSION['power']['downlimittype'] == '1') {
            $bettwen = downtimespace();
            $map['downtime'] = array(array('gt', $bettwen['start']), array('lt', $bettwen['end']), 'AND');
        } elseif ($_SESSION['power']['downlimittype'] == '2') {
            //总数限制
            $map['downtime'] = array('lt', time());
        }

        if ($_SESSION['power'] == 'all') {
            $info = $app->where(array('appid' => $appid))->select()[0];
        } elseif ($_SESSION['power']['usertypeid'] == '3') {
            //找到下载的应用的信息
            $info = $app->where(array('appid' => $appid))->where(array('vocation' => $_SESSION['power']['vocatypeid']))->select()[0];
            //下载统计次数
            $count = $down->where($map)->where(array('vocation' => $_SESSION['power']['vocatypeid']))->count();
        } else {
            $info = $app->where(array('userid' => $userid, 'appid' => $appid))->select()[0];
            $count = $down->field('appid')->where($map)->where(array('userid' => $userid))->count();
        }
        if ($count < $_SESSION['power']['downlimit'] || $_SESSION['power'] == 'all') {
            if (!empty($info)) {
                if (!file_exists($info['icon']) && substr($info['icon'], 0, 4) != 'http') {
                    $info['icon'] = UPLOAD_PATH . 'icon/default.png';
                }
                addLog($_SESSION['userid'], "下载 {$info['realname']} 的PDF检测技术报告");
                $detec = D('Detection');
                $detectInfo = $detec->where(array('appid' => $appid))->select();
                //老版本
                makePdfReport($info, $detectInfo);
                $down->data(array('userid' => $userid, 'appid' => $appid, 'downtime' => time()))->add();
                // makeMpdfReport($info,$detectInfo);
            } else {
                addLog($userid, "越权查看");
                $this->display('Layout:show_404');
            }
        } else {
            if ($_SESSION['power']['downlimittype'] == '1') {
                header("Content-type: text/html; charset=utf-8");
                echo "<script type='text/javascript'>alert('您的报告每天只能下载  " . $_SESSION['power']['downlimit'] . "  次,请明天再来!');history.go(-1);</script>";
            } elseif ($_SESSION['power']['downlimittype'] == '2') {
                header("Content-type: text/html; charset=utf-8");
                echo "<script type='text/javascript'>alert('您的报告下载次数完毕,请联系管理员!');history.go(-1);</script>";
            }
        }
    }

    /**
     * 截取字符串
     */
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

    /**
     * 对比相同包名的app信息,版本对比工具
     */
    public function compare_report() {
        $appid = I('get.appid');
        $userid = $_SESSION['userid'];

        $Appinfo = M('Appinfo');
        //thinkphp 调用存储过程,在call的前面加一个空格就行
        $sql = " call versioncom({$userid},{$appid})";
        $compare = $Appinfo->query($sql);
        $len = count($compare);
        if ($len == 1) {
            echo 'false';
            exit;
        } elseif ($len == 2) {
            $newsql = " call deteccom2({$compare[0]['appid']},{$compare[1]['appid']})";
        } elseif ($len == 3) {
            $newsql = " call deteccom3({$compare[0]['appid']},{$compare[1]['appid']},{$compare[2]['appid']})";
        }
        $compareResult = $Appinfo->query($newsql);
        //做一个计数器
        $oldtesttype = 0;
        $result_1 = $result_2 = $result_3 = array('low' => 0, 'mid' => 0, 'high' => 0);
        foreach ($compareResult as $k => $v) {
            //当计数器的值等于数组中的值时，消掉testtype标志
            if ($oldtesttype == $v['testtype']) {
                unset($compareResult[$k]['testtype']);
            } else {
                //否则令计数器等于该标志值，作为下一次判断的值
                $oldtesttype = $compareResult[$k]['testtype'];
                //设置是否显示div的头部
                $compareResult[$k]['showdiv'] = 1;
                $compareResult[$k]['first'] = 1;
                //设置是否显示div的尾部
                $compareResult[$k - 1]['showdiv'] = 1;
                $compareResult[$k - 1]['end'] = 1;
            }
            if ($v['result_1'] == 2) {
                ++$result_1['low'];
            } elseif ($v['result_1'] == 3) {
                ++$result_1['mid'];
            } elseif ($v['result_1'] == 4) {
                ++$result_1['high'];
            }
            if ($v['result_2'] == 2) {
                ++$result_2['low'];
            } elseif ($v['result_2'] == 3) {
                ++$result_2['mid'];
            } elseif ($v['result_2'] == 4) {
                ++$result_2['high'];
            }
            if ($v['result_3'] == 2) {
                ++$result_3['low'];
            } elseif ($v['result_3'] == 3) {
                ++$result_3['mid'];
            } elseif ($v['result_3'] == 4) {
                ++$result_3['high'];
            }
        }

        unset($compareResult['-1']);
        $Appinfo = D('Appinfo');
        $appinfo = $Appinfo->where(array('appid' => $appid))->select()[0];
        if (!file_exists($appinfo['icon']) && substr($appinfo['icon'], 0, 4) != 'http') {
            $appinfo['icon'] = UPLOAD_PATH . 'icon/default.png';
        }
        $this->assign('result_1', $result_1);
        $this->assign('result_2', $result_2);
        $this->assign('result_3', $result_3);
        $this->assign('appinfo', $appinfo);
        $this->assign('compareResult', $compareResult);
        $this->display();
    }

    public function _empty() {
        $userid = $_SESSION['userid'];
        $url = get_url();
        addLog($userid, "手动输入不存在的地址,有嫌疑!地址:" . $url);
        $this->display('Layout:show_404');
    }

    public function feedback() {
        $feedback = D('Feedback');
        if (IS_POST) {
            $data = array(
                'appid' => I('post.appid'),
                'userid' => $_SESSION['userid'],
                'testname' => I('post.testname'),
                'oldresult' => I('post.oldresult'),
                'newresult' => I('post.newresult'),
                'subtime' => time(),
                'status' => 1,
                'reason' => I('post.reason')
            );
            $id = $feedback->data($data)->add();
            if ($id !== false) {
                $this->redirect('Report/basedetial_report', array('appid' => I('post.appid'), 'tip' => 'FEEDBACK_SUCCESS'));
            }
        } else {
            $this->redirect('Report/basedetial_report', array('appid' => I('post.appid'), 'tip' => 'FEEDBACK_FALSE'));
        }
    }

    public function report_word() {
        $this->display();
    }
    public function  aa(){
        $date = time();
        $appid= I('get.appid');
        $url ="http://192.168.199.15/sca/index.php/Report/report_pdf/appid/$appid";
        
        $a =system("python /Apktest/start_shell \"bash /var/www/html2pdf2.sh  {$url} /var/www/html/sca/reprot{$date}.pdf \" ");
        $this->redirect('http://192.168.199.15/sca/reprot'.$date.'.pdf');
       // echo  'http://192.168.199.15/sca/reprot'.$date.'.pdf';
        //  return 
        //  dump($a);
       //  $appid = I('get.appid');
       // $res = system("wkhtmltopdf  http://192.168.199.15/sca/index.php/Report/report_pdf  webank2.pdf");
      //   $res = system("wkhtmltopdf  ".U('Report/report_pdf',array('appid'=>$appid))."  weban.pdf");
        // $res = system("xvfb-run --server-args='-screen 0, 1024x768x24' wkhtmltopdf ".U('Report/report_pdf',array('appid'=>$appid))." rep2.pdf --ignore-load-errors");
       // dump($res);
//        require('html2fpdf.php');  
//  
//        $pdf=new HTML2FPDF();  
//        $pdf->AddPage();  
//        $fp = fopen("sample.html","r");  
//        $strContent = fread($fp, filesize("sample.html"));  
//        fclose($fp);  
//        $pdf->WriteHTML($strContent);  
//        $pdf->Output("sample.pdf");  
//        echo "PDF file is generated successfully!";  
        
        
//            $apikey = 'abcde12345';
//
//            $url = urlencode('http://192.168.199.15/sca/index.php/Report/report_pdf');
//            $result = file_get_contents("http://api.htm2pdf.co.uk/urltopdf?apikey=$apikey&url=$url");
//
//            file_put_contents('/tmp/mypdf.pdf',$result);

        
//        $appid = I('get.appid');
//        var_export("xvfb-run --server-args='-screen 0, 1024x768x24' /usr/bin/wkhtmltopdf ".U('Report/report_pdf',array('appid'=>$appid))." reportpdf.pdf");
//        $res = system("xvfb-run --server-args='-screen 0, 1024x768x24' /usr/bin/wkhtmltopdf ".U('Report/report_pdf',array('appid'=>$appid))." reportpdf.pdf --ignore-load-errors");
//        var_dump($res);
     }
    public function bb(){
        $appid = I('get.appid');
       Vendor('tcpdf.tcpdf');
                
		$pdf = new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Nicola Asuni');
		//$pdf->SetTitle($info['realname']);
		$pdf->SetSubject('TCPDF Tutorial');
		$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

	
		// set header and footer fonts
		$pdf->setHeaderFont(Array('stsongstdlight', '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array('stsongstdlight', '', PDF_FONT_SIZE_DATA));

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		// set auto page breaks
		//$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
                   $pdf->SetAutoPageBreak(TRUE, 20000); 
		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        //$mpdf->watermark_font = 'GB'; 
        //$mpdf->SetWatermarkText('中国水印',0.1);
       // $url = "U('Report/report_pdf',array('appid'=>$appid))";
        $url ='http://192.168.199.15/sca/index.php/Report/report_pdf';
        $strContent = file_get_contents($url); 
        //print_r($strContent);die;
        $pdf->showWatermarkText = true;
      //  $mpdf->SetAutoFont();
        //$mpdf->SetHTMLHeader( '头部' );
        //$mpdf->SetHTMLFooter( '底部' );
        $pdf->WriteHTML($strContent);
        $pdf->Output('ss.pdf');
        //$mpdf->Output('tmp.pdf',true);
        //$mpdf->Output('tmp.pdf','d');
        //$mpdf->Output();
        exit;
    }

        public function report_pdf($appid) {
           // $appid = I('get.appid');
             $det = M('detection');
             $appinfo = D('Appinfo');
            // $list = $det->field('at_detection.id,at_detection.scaid,at_detection.appid,at_detection.testname,at_detection.testtype,at_detection.result,at_detection.info,at_resulttype.zhresult')->join('left join at_resulttype on at_resulttype.result=at_detection.result')->select();
           // $appid = 1284;  
             $info = $appinfo->where(array('appid' => $appid))->find();
            $lists = $det->group('testtype')->where(array('appid' => $appid))->select();

   //, 'at_detection.result'=>'high' 、,'result'=>'high'
            $data = array();
            foreach ($lists as $kl => $vl) {
                $data[$kl]['id'] = $vl['id'];
                $data[$kl]['testtype'] = $vl['testtype'];
                $data[$kl]['count'] = $det->where(array('appid' => $appid, 'testtype' => $vl['testtype']))->count();
                $data[$kl]['cricount'] = $det->where(array('appid' => $appid, 'testtype' => $vl['testtype'], 'result' => 'critical',))->count();
                $data[$kl]['hicount'] = $det->where(array('appid' => $appid, 'testtype' => $vl['testtype'], 'result' => 'high',))->count();
                $data[$kl]['medcount'] = $det->where(array('appid' => $appid, 'testtype' => $vl['testtype'], 'result' => 'medium',))->count();
                $data[$kl]['lowcount'] = $det->where(array('appid' => $appid, 'testtype' => $vl['testtype'], 'result' => 'low',))->count();
                $data[$kl]['children'] = $det->where(array('at_detection.appid' => $appid, 'at_detection.testtype' => $vl['testtype']))->field('at_detection.id,at_detection.scaid,at_detection.appid,at_detection.testname,at_detection.testtype,at_detection.result,at_detection.info,at_resulttype.zhresult')->join('left join at_resulttype on at_resulttype.result=at_detection.result')->select();
                $data[$kl]['datalist'] = $det->field('at_detection.id as id,at_detection.scaid as scaid,at_detectype.zhtesttype,at_detectype.damage as damage,at_detectype.suggest as suggest,at_detection.appid as appid,at_detection.testtype as testtype,at_detection.info as info')->where(array('at_detection.id' => $vl['id']))->join('left join at_detectype on at_detectype.testtype = at_detection.testtype')->find();
 
               //   $data[$kl]['children'][$kl]['info']=  mb_substr($data[$kl]['children'][0]['info'], 0, 20, 'utf8');
                //  dump( $data[$kl]['children']) ;   
                foreach ($data[$kl]['children'] as $k2 => $v2) {
                    $data[$kl]['children'][$k2]['countb'] = $det->where(array('appid' => $appid, 'testtype' => $v2['testtype']))->count();
                    $data[$kl]['children'][$k2]['cricountb'] = $det->where(array('appid' => $appid, 'testtype' => $v2['testtype'], 'result' => 'critical',))->count();
                    $data[$kl]['children'][$k2]['hicountb'] = $det->where(array('appid' => $appid, 'testtype' => $v2['testtype'], 'result' => 'high',))->count();
                    $data[$kl]['children'][$k2]['medcountb'] = $det->where(array('appid' => $appid, 'testtype' => $v2['testtype'], 'result' => 'medium',))->count();
                    $data[$kl]['children'][$k2]['lowcountb'] = $det->where(array('appid' => $appid, 'testtype' => $v2['testtype'], 'result' => 'low',))->count();
                    $data[$kl]['children'][$k2]['infos'] = explode(")", $data[$kl]['children'][$k2]['info'], -1)[0] . ")";
                    $u = strip_tags($data[$kl]['children'][$k2]['info']);
                    $u = htmlspecialchars($u);
//                             $u = str_replace("\r", "<br>", $u);
                    $u = str_replace("\n", "<br>", $u);
                    $u = str_replace("\t", "&nbsp;&nbsp;", $u);
                    $u = str_replace("  ", "&nbsp;", $u);
                    // $u = str_replace(" ", "&nbsp;", $u);
                   $data[$kl]['children'][$k2]['infoss'] = str_replace("\r\n", '<br>', $u);

//                          dump($data[$kl]['children'][$k2]['infos']);
//                         dump($data[$kl]['children'][$k2]);
                }
            }
            
            $count = $det->where(array('appid' => $appid))->count();
            $hcount = $det->where(array('appid' => $appid, 'result' => 'high'))->count();
            $midcount = $det->where(array('result' => 'medium', 'appid' => $appid))->count();
            $listcount = $det->group('testtype')->where(array('appid' => $appid))->select();
            $leicount = count($listcount);
            $this->assign('count',$count);
            $this->assign('hcount',$hcount);
            $this->assign('midcount',$midcount);
            $this->assign('leicount',$leicount);
           // dump($info);die;
            $this->assign('datalist',$data);
            $this->assign('info',$info);
           //dump($data);die;
        $this->display();
        }

    public function words() {

        $detection = D("detection");
        $detec = $detection->select();
        $data = aaaaaaaa;
        // $content= file_get_contents("http://192.168.199.15/sca/index.php/Report/report_word");
        //  echo $content;die;
        //  $this->makeMpdfReports($data,$detec);
        $this->word($data, $data);
        // downloadWord($data,'abc.doc');
        //  docsave(./dtat.doc,$data);
    }

    function word($data, $fileName = '') {
        $data = '
  
               <html xmlns="http://www.w3.org/1999/xhtml">
                 <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="icon" href="__PUBLIC__/img/fav_icon_32.ico" />
        <link type="text/css" rel="stylesheet" href="__PUBLIC__/css/style.css" />
        <link rel="stylesheet" type="text/css" href="__PUBLIC__/css/font-awesome.css"/>
        <link rel="stylesheet" type="text/css" href="__PUBLIC__/css/bootstrap.css"/>
        <link rel="stylesheet" type="text/css" href="__PUBLIC__/css/dropzone/basic.min.css"/>
        <link rel="stylesheet" type="text/css" href="__PUBLIC__/css/dropzone/dropzone.min.css"/>

        <!--[if !IE]> -->
        <!-- <script src="__PUBLIC__/js/jquery-2.1.4.min.js"></script> -->
        <![endif]-->
        <!--  IE8只能支持jQuery1.9 -->
        <!--[if IE]> -->
        <script src="__PUBLIC__/js/jquery-1.9.1.min.js"></script>
        <!-- <![endif]-->
        <script src="__PUBLIC__/js/md5.js"></script>
        <script type="text/javascript" src="__PUBLIC__/js/swfupload/swfupload.js"></script>

        <script type="text/javascript" src="__PUBLIC__/js/jquery.swfupload.js"></script>
        <script type="text/javascript" src="__PUBLIC__/js/script.js"></script>
        <script type="text/javascript" src="__PUBLIC__/js/RegExp.js"></script>
        <script type="text/javascript" src="__PUBLIC__/js/bootstrap.min.js"></script>
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
                                        <table class="table table-bordered">
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

                                        <div class="chart-img">图表图片</div>

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

                                </div>

                        </div>

    </div>
</body>


                     </html>';

        if (empty($fileName))
            $fileName = date('YmdHis') . '.doc';
        $fp = fopen($fileName, 'wb');
        fwrite($fp, $data);
        fclose($fp);
        die('success');
    }

}
