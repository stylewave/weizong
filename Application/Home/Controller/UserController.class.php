<?php
namespace Home\Controller;
use Think\Controller;

class UserController extends Controller {

	//用户注册
    public function register_user(){
        if($_SESSION['power'] != null){
            $this->redirect('Detection/center_detection');
            exit;
        }
    	if(IS_POST){
    		$user 	= D('User');
            $question = I('post.question');
            $question = ($question[0] == '自己编辑问题') ? $question[1] : $question[0];
            $pwd = md5(I('post.pwd2').'PWDAFTER');
    		$data  	= array(
    			'loginemail'  	               => I('post.email'),
    			'password'	  	               => $pwd,
    			'realname'		               => I('post.username'),
    			'job'			               => I('post.job'),
    			'phone'			               => I('post.phone'),
    			'address'		               => I('post.address'),
    			'dvrtype'		               => I('post.dvrtype'),
    			'question'		               => $question,
    			'answer'		               => md5(I('post.answer')),
    			'regtime'		               => date('Y-m-d H:i:s',time()),
    			'status'		               => 0,
    			);

            if($user->where( array( 'loginemail'=>I('post.email') ) )->select()){
                $this->redirect('User/register_user',array('tip'=>"EMAIL_EXISTED"));
            }

    		if($id = $user->data($data)->add()){
                //注册成功,给用户赋初始化权限
                //用户类型为个人(1),行业为空(0),付费类型为免费(1)
                //上传和下载限制均为3
                $userpower      = D('Userpower');
                $powerdata = array(
                    'userid'            => $id,
                    'usertypeid'        => 1,
                    'vocatypeid'        => 0,
                    'userpayid'         => 1,
                    'uploadlimit'       => 3,
                    'downlimit'         => 3,
                    'uploadlimittype'   => 2,
                    'downlimittype'     => 2,
                    'dstarttime'        => time(),
                    'ustarttime'        => time()
                    );
                $userpower->data($powerdata)->add();

                $this->redirect('User/login_user',array('tip'=>'REGISTER_SUCCESS'));
    		}
	    }else{

	        $this->display();
	    }

    }

    //用户登录网站
    public function login_user(){
        if($_SESSION['power'] != null){
            $this->redirect('Detection/center_detection');
            exit;
        }
    	if(IS_POST){
    		$user 	                             = D('User');
    		$admin 	                             = D('Admins'); 
            //提交的密码经过MD5加密，所以不用再次加密
            $pwd        = md5(I('post.pwd').'PWDAFTER');
          //  var_dump($pwd);die;
    		$data      = array(
    			'loginemail'                     =>I('post.email'),
    			'password'	                     =>$pwd,
    			);
            $updata    = array(
                'ip'                             =>get_client_ip(),
                'lasttime'                       =>date('Y-m-d H:i:s',time()),
                ); 

               // var_dump($data);die;
			//var_dump($_SESSION['captcha']);die;	
    		$loginemail = I('post.email');
            if($_SESSION['captcha'] == I('post.captcha')){
                unset($_SESSION['captcha']);
                if($user->where(array('loginemail'=>$loginemail))->select() || $admin->where(array('loginemail'=>$loginemail))->select() ){
                    if($admininfo = $admin->where($data)->select()){
    	                $_SESSION['userid']              = $admininfo['0']['userid'];
                        $updata['userid']                = $admininfo['0']['userid'];
                        $email                           = $admininfo['0']['loginemail'];
                        $admin->save($updata);
                        addLog($_SESSION['userid'],"用户 $email 登录");
                        $this->redirect('Detection/center_detection');
            	   }else{
                		if($userinfo  = $user->where($data)->select()){
                            $_SESSION['userid']              = $userinfo['0']['userid'];
                            $updata['userid']                = $userinfo['0']['userid'];
                            $email                           = $userinfo['0']['loginemail'];
                            $user->save($updata);
                            addLog($_SESSION['userid'],"用户 $email 登录");
                			$this->redirect('Detection/center_detection');
                		}else{
                            $this->redirect('User/login_user?tip=ERROR_UM_PD');
                        }
                    }
                }else{
                    $this->redirect('User/login_user?tip=ERROR_UM_PD');
                }
            }
	   }else{

            $this->display();
        }

    }

    //邮箱激活提示页面
    public function emailActive_user(){
        $url                                     = urldecode(I('get.web'));
        $this->assign('url',$url);
        $this->display();
    }


    //利用邮箱激活用户状态
    public function active_user(){
        if(IS_GET){
            $user                                = D('User');
            $id                                  = I('get.id');
            $token                               = I('get.token');
            $email                               = I('get.email');
            $tmp                                 = array_combine($email, $token);

            if($_SESSION['emailToken'] == $tmp){
                if($user->save(  array('userid'=>$id, 'status'=>1 ))){
                    addLog($id,"用户激活账户成功");
                    $this->redirect('User/login_user',array('active'=>'EMAIL_ACTIVE'));
                }
            }
        }
    }   
    //找回密码,通过邮箱或者通过问题
    public function findpwd_user(){
        if($_SESSION['power'] != null){
            $this->redirect('Detection/center_detection');
            exit;
        }
        if(IS_POST){
            $email                                          = I('post.email');
            $user                                           = D('User');
            $token                                          = md5(time().rand(0,100000000));
            if(I('get.action') == 'question'){
                $answer = md5(I('post.answer'));
                $securityemail =  I('post.securityemail');
                $_SESSION['token']['resetEmailPasswordToken']   = array($securityemail=>$token);
                if($info = $user->where(array('loginemail'=>$securityemail,'answer'=>$answer))->select()){
                    addLog($info[0]['userid'],"用户密保找回密码");
                    $this->redirect('User/resetpwd_user',array('email'=>$securityemail,'token'=>$token));
                }else{
                     $this->redirect('User/findpwd_user',array('tip'=>'ANSWER_EMAIL_ERROR'));
                }
            }
        }else{

            $this->display();  
        } 
    }


    //通过获得的token确定该值是服务器发送的
    //使用loginemail来找到原来的记录，并修改
    public function resetpwd_user(){
        if($_SESSION['power'] != null){
            $this->redirect('Detection/center_detection');
            exit;
        }
        $user                       = D('User');
        if(count($_GET)==0){
            $this->display('Layout/show_404');
        }

        if(IS_GET){
            $email                  = I('get.email');
            $token                  = I('get.token');
            // var_export($_SESSION['token']['$resetEmailPasswordToken']);
            if($_SESSION['token']['resetEmailPasswordToken'][$email] == $token){
                if($info_user = $user->where(array('loginemail'=>$email))->select()){
                    addLog($info_user[0]['userid'],"用户 {$info_user[0]['loginemail']} 重置密码");
                    $this->assign('info_user',$info_user);
                    $this->display();
                }
            }
        }elseif(IS_POST){
            if($userinfo = $user->where(array('loginemail'=>I('get.email')))->select()){
                $id = $userinfo[0]['userid'];
            }
            $pwd = md5(I('post.pwd2').'PWDAFTER');
            $data    = array(
                'userid'            => $id ,
                'password'          =>$pwd
                );
            // die(var_export($data));
            $info = $user->save($data);
            if($info !== false){
                $this->redirect('User/login_user',array('tip'=>'RESET_PWD_SUCCESS'));
            }else{
                $this->redirect('User/findpwd_user',array('tip'=>'RESET_PWD_FALSE'));
            }
        }
    }

    public function logout_user(){
        if($_SESSION['userid'] != null){
            addLog($_SESSION['userid'],"退出登录");
        }
        session(null);cookie(null);        
        $this->redirect('User/login_user');
    }

    public function _empty(){
        $userid             = $_SESSION['userid'];
        $url                = get_url(); 
        addLog($userid ,"手动输入不存在的地址,有嫌疑!地址:".$url);
        $this->display('Layout:show_404');
    }

}