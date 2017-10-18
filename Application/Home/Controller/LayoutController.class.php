<?php
namespace Home\Controller;
use Think\Controller;

class LayoutController extends Controller {

    //判断是否是管理员
    public function ismanage(){
        if($_SESSION['power'] != 'all'){
            $this->display('Layout:show_404');
            exit;
        }
    }


    //调用内置验证码类画出验证码图片
 	public function captcha(){
        $verify = new \Think\Verify();
        $verify->length = 4;
        $verify->fontsize = 30;
        $verify->useNoise = false;
        $verify->fontttf = '4.ttf';
        $verify->entry();
    }

    //利用ajax调用该方法来检测邮箱
    public function check_email(){
        $user   = D('User');
        $email  = $_GET['email']; 
        if($user->where(array('loginemail'=>$email))->select()){
            echo "该邮箱已存在,<a href='".__MODULE__."/User/findpwd_user'>找回密码</a>";
        }else{
            echo "该邮箱可以注册";
        }
    }

    //验证验证码是否符合生成的代码
    public function verify_captcha(){
        $code  = $_REQUEST['captcha'];
        $verify =  self::check_verify($code);
        session('captcha',$code);
        $data['info']="failure";
        if($verify){
             $data['info']="success";
         
        }
        $this->ajaxReturn($data);
    }

    //验证字符串
    public function check_verify($code, $id = ''){ 
        $verify = new \Think\Verify(); 
        return $verify->check($code, $id); 
    }

    //获得用户密码,进行旧密码检查
    public function check_user_pwd(){
        $admin  = D('Admins');
        $user   = D('User');
        $id     = $_SESSION['userid'];
        $email  = $_GET['email'];
        $pwd    = md5($_GET['pwd'].'PWDAFTER');
        if($obj = $admin->find($id)){
            if($obj['loginemail'] == $email && $obj['password'] == $pwd){
                echo "OK,进去下一步";
            }
        }elseif($obj = $user->find($id)){
            if($obj['loginemail'] == $email && $obj['password'] == $pwd){
                echo "OK,进去下一步";
            }else{
                echo "密码错误";
            }
        }else{
            echo "密码错误";
        }
    }

    public function getSecurityQuestion(){
        $user  = D('User');
        $admin = D('Admins');

        $email = I('get.email');

        if($admininfo = $admin->where(array('loginemail'=>$email))->select()){
            echo $admininfo[0]['question'];
        }elseif($userinfo = $user->where(array('loginemail'=>$email))->select()){
            echo $userinfo[0]['question'];
        }else{
            echo "不存在该账户";
        }
    }

    public function uifooter(){
        $this->display();
    }
    
}