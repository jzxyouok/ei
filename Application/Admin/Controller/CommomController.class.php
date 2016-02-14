<?php

/**
 * 权限继承控制表
 * 时间：2015.8.24
 * author:一只尼玛
 * www.lenggirl.com
 ·*/
namespace Admin\Controller;

use Think\Controller;

class CommomController extends Controller {
	public function _initialize() {
		if (C ( 'NEEDLOGIN' ) == 1) {
			if (! isset ( $_SESSION [C ( 'USER_AUTH_KEY' )] )) {
				$this->redirect ( "Public/login" );
				return false;
			} elseif (in_array ( $_SESSION ['username'], C ( 'ADMIN_AUTH_KEY' ) )) {
				return true;
			} else {
				return true;
			}
		} else {
			return true;
		}
	}
	
	public function isroot(){
		if(in_array ( $_SESSION ['username'], C ( 'ADMIN_AUTH_KEY' ))){
			return true;
		}else{
			return false;
		}
	}
	
	public function _empty(){
		redirect(__ROOT__.'/Public/404.html');
	}
	
	public function listimg(){
		$dir = './Uploads/20160212/';
		$data='';
		if (is_dir($dir)) {
			if ($dh = opendir($dir)) {
				while (($file = readdir($dh)) !== false) {
					if ($file!="." && $file!="..") {
						$data=$data.'<img src="'.__ROOT__.'/Uploads/20160212/'.$file.'"/>';
					}
				}
				closedir($dh);
			}
		}
		return $data;
	}
}