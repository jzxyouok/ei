<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller{
	
	function index(){
		$this->display();
	}
	function _empty() {
		redirect(__ROOT__.'/Public/404.html');
	}
	function error404() {
		redirect(__ROOT__.'/Public/404.html');
	}
}

?>