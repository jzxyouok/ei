<?php
return array (
		// '配置项'=>'配置值'
		/* 1.数据库设置 */
		'DB_TYPE' => 'mysql', // 数据库类型
		'DB_HOST' => localhost, // 服务器地址
		'DB_NAME' => 'lenggirl', // 数据库名
		'DB_PREFIX' => 'think_',
		'DB_USER' => root, // 用户名
		'DB_PWD' => 6833066, // 密码
		'DB_PORT' => 3306, // 端口
		                                  
		// 数据库表前缀URL访问模式,可选参数0、1、2、3,代表以下四种模式：
		                                  // 0 (普通模式); 1 (PATHINFO 模式); 2 (REWRITE 模式); 3 (兼容模式) 默认为PATHINFO 模式
		'URL_MODEL' => '1',
		
		'USER_AUTH_KEY' => 'userid', // 用户会话标识
		'NEEDLOGIN' => 1, // 1表示登陆开启，其他表示关闭
		'ADMIN_AUTH_KEY' => array (
				'hunterhug' 
		), // 超级管理员
		'REGISTER' => 1
		
)
;