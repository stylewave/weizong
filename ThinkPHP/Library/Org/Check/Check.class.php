<?php
namespace Org\Check;
class Check extends \Thread{
	private $appPath;
	private $appid;
	private $userid;
	private $thread;
	public function __construct($appPath,$appid,$userid,$thread){
       $this->appPath=$appPath;
       $this->appid=$appid;
       $this->userid=$userid;
       $this->thread=$thread;
	}
	public function run(){
	   echo $this->getCreatorId()."<br/>";
	   echo time()."<br/>";
	    $this->abc($this->appPath,$this->appid,$this->userid);
	}

function abc($appPath,$appid,$userid){
	 // define('SSH_USER', 'apptest');                 //登陆LINUX的用户名
  //   define('SSH_PWD', '1');                    //登陆LINUX的密码
  //   define('SSH_PORT', 22);                     //登陆LINUX的端口--SSH默认端口22
  //   define('SSH_HOST', '192.168.199.154');         //登陆LINUX的IP地址(虚拟机)
 
    if(!function_exists("ssh2_connect")){
        exit('SSH扩展没有安装或者没有安装成功');
    }
 
    //使用SSH2进行连接
    $ssh2 = ssh2_connect('192.168.199.154', '22');
    if(!$ssh2){
        exit('服务器连接不上???');
    }else{
        echo '已经成功连接上了服务器!!!<hr>';
    }
 
    // 验证用户名和密码
    ssh2_auth_password( $ssh2, 'apptest', '1' );
 
    	$command ="/Apktest/MobAppSecAss/apptest1.sh $appPath $appid $userid";
    // $command = "sleep 20";
    $stream = ssh2_exec($ssh2, $command);       
    $errorStream = ssh2_fetch_stream($stream, SSH2_STREAM_STDERR);
     
    //阻塞模式--延伸阅读：http://blog.csdn.net/linvo/article/details/5466046
    //关于文件流的阻塞与非阻塞模式
    stream_set_blocking($stream, true);
    stream_set_blocking($errorStream, true);
 
    //stream_get_contents类似于file_get_contents
    $cmd = stream_get_contents( $stream );
    $errorInfo = stream_get_contents( $errorStream );
 
    fclose( $stream );
    fclose( $errorStream );
    print_r( $cmd );        //执行脚本后的返回正确的信息
    echo '<hr>';
    var_dump( $errorInfo ); //返回脚本错误的信息
    
}

}
