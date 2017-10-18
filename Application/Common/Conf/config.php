<?php
return array(
	//'配置项'=>'配置值'
	//'配置项'=>'配置值'
	'DB_TYPE'               =>  'mysql',     // 数据库类型
    'DB_HOST'               =>  'localhost', // 服务器地址
    'DB_NAME'               =>  'db_sca',          // 数据库名
    'DB_USER'               =>  'root',      // 用户名
    'DB_PWD'                =>  'root',          // 密码
    'DB_PORT'               =>  '3306',        // 端口
    'DB_PREFIX'             =>  'at_',    // 数据库表前缀

    // 'SHOW_ERROR_MSG'        =>  true,    // 显示错误信息
    // 显示页面Trace信息
    // 'SHOW_PAGE_TRACE'       =>  true, 

    'MODULE_ALLOW_LIST'     =>  array('Home'), 
    'DEFAULT_MODULE'        =>  'Home',
    'MULTI_MODULE'          =>  true,

    // 配置邮件发送服务器
    'MAIL_HOST'             =>'smtp.yeah.net',//smtp服务器的名称
    'MAIL_SMTPAUTH'         =>TRUE, //启用smtp认证
    'MAIL_USERNAME'         =>'***',//你的邮箱名
    'MAIL_FROM'             =>'***',//发件人地址
    'MAIL_FROMNAME'         =>'发件人姓名',//发件人姓名
    'MAIL_PASSWORD'         =>'***',//邮箱密码
    'MAIL_CHARSET'          =>'utf-8',//设置邮件编码
    'MAIL_ISHTML'           =>TRUE, // 是否HTML格式邮件
    //去掉html缓存
    'TMPL_CACHE_ON' => false,

);
