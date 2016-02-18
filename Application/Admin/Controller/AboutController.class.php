<?php
namespace Admin\Controller;
use Think\Controller;
class AboutController extends CommomController{
	public function index(){
		$username=$_SESSION['username'];
		$isexist=M('webabout')->where(array('username'=>$username))->find();
		if($isexist){
			$this->assign('about',$isexist['about']);
		}
		$this->display();
	}
	
	function help(){
		$this->display();
	}
	
	function updateabout(){
		$username=$_SESSION['username'];
		$about=I('about','');
		$isexist=M('webabout')->where(array('username'=>$username))->find();
		if($isexist===false){
			$this->ajaxReturn('系统出错');
		}
		
	}
	
	
}

?>