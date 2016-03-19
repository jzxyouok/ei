<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller{
	
	function index(){
		$webinfo=M('webinfo')->where(array('username'=>C('HOMEUSER')))->find();
		$nav=M('category')->where(array('username'=>C('HOMEUSER'),'status'=>1))->order('`order` desc')->select();
		$about=M('webabout')->where(array('username'=>C('HOMEUSER'),'status'=>1))->field('about',true)->order('sort desc')->select();
		$photo=M('photo')->where(array('username'=>C('HOMEUSER'),'status'=>1))->order('sort desc')->select();
		$this->assign('webinfo',$webinfo);
		$this->assign('nav',$nav);
		$this->assign('about',$about);
		$this->assign('photo',$photo);
		$user=M('user')->where(array('status'=>1))->select();
		$userweb=array();
		foreach ($user as $u){
			$temp=M('webinfo')->where(array('username'=>$u['username']))->find();
			if($temp){
				$userweb[]=$temp;
			}
		}
		$this->assign('user',$userweb);
		$this->display('index1');
	}
	
	function about(){
		$id=I('id','');
		$content=M('webabout')->where(array('id'=>$id,'status'=>1))->find();
		if($content){
			$this->assign('content',$content);
		}else{
			$this->assign('content','没有内容');
		}
		$about=M('webabout')->where(array('username'=>C('HOMEUSER'),'status'=>1))->field('about',true)->order('sort desc')->select();
		$nav=M('category')->where(array('username'=>C('HOMEUSER'),'status'=>1))->order('`order` desc')->select();
		$webinfo=M('webinfo')->where(array('username'=>C('HOMEUSER')))->find();
		$this->assign('webinfo',$webinfo);
		$this->assign('nav',$nav);
		$this->assign('about',$about);
		$user=M('user')->where(array('status'=>1))->select();
		$userweb=array();
		foreach ($user as $u){
			$temp=M('webinfo')->where(array('username'=>$u['username']))->find();
			if($temp){
				$userweb[]=$temp;
			}
		}
		$this->assign('user',$userweb);
		$this->display();
	
	}
	
	function page(){
		$id=I('id','');
		/*
		 * 
		 * */
		$about=M('webabout')->where(array('username'=>C('HOMEUSER'),'status'=>1))->field('about',true)->order('sort desc')->select();
		$nav=M('category')->where(array('username'=>C('HOMEUSER'),'status'=>1))->order('`order` desc')->select();
		$webinfo=M('webinfo')->where(array('username'=>C('HOMEUSER')))->find();
		$this->assign('webinfo',$webinfo);
		$this->assign('nav',$nav);
		$this->assign('about',$about);
		/*
		 * */
		$paper=M('paper')->where(array('cid'=>$id,'status'=>1))->field('content',true)->order('`order` desc,view desc')->select();
		$this->assign('papers',$paper);
		$cates=M('category')->where(array('id'=>$id))->find();
// 		var_dump($paper);
		$this->assign('cates',$cates);
		$this->display();
	}
/* 	function _empty() {
		redirect(__ROOT__.'/Public/404.html');
	}
	function error404() {
		redirect(__ROOT__.'/Public/404.html');
	} */
}

?>