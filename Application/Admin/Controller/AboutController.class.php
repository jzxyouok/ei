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
			return;
		}
		$data['about']=$about;
		$data['username']=$username;
		if($isexist==null){
			$data['createtime']=date("Y-m-d H:i:s",strtotime('now'));
			if(false===M('webabout')->add($data)){
				$this->ajaxReturn('系统出错');
				return;
			}else{
				$this->ajaxReturn('修改成功');
				return;
			}
		}
		$data['updatetime']=date("Y-m-d H:i:s",strtotime('now'));
		if(false===M('webabout')->where(array('username'=>$username))->save($data)){
			$this->ajaxReturn('系统出错');
			return;
		}
		$this->ajaxReturn('修改成功');
	}
	
	
}

?>