<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller{
	
	function index(){
		$webinfo=M('webinfo')->where(array('username'=>C('HOMEUSER')))->find();
		$nav=M('category')->field('content',true)->where(array('username'=>C('HOMEUSER'),'status'=>1,'pid'=>0))->order('`order` desc,createtime')->select();
		foreach ($nav as &$v){
			$son=M('category')->order('`order` desc')->field('content',true)->where(array('username'=>C('HOMEUSER'),'pid'=>$v['id'],'status'=>1))->select();
			//trace($son);
			if($son){
				$v['son']=$son;
			}else{
				$v['son']=[];
			}
			
		}
	//	trace($nav);
		$about=M('webabout')->where(array('username'=>C('HOMEUSER'),'status'=>1))->field('about',true)->order('sort desc,createtime')->select();
		$photo=M('photo')->where(array('username'=>C('HOMEUSER'),'status'=>1))->order('sort desc,createtime')->select();
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
		
		//首页展示                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         
		$showpaper=M('category')->field('content',true)->where(array('username'=>C('HOMEUSER'),'status'=>1))->limit(3)->order('`order` desc,createtime')->select();
		foreach ($showpaper as &$cate){
			$cate['paper']=M('paper')->field('content,desccontent',true)->where(array('status'=>1,'cid'=>$cate['id']))->order('`order` desc,createtime,view desc')->limit(5)->select();
		}
		$this->assign('user',$userweb);
		$this->assign('showpaper',$showpaper);
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
		$about=M('webabout')->where(array('username'=>C('HOMEUSER'),'status'=>1))->field('about',true)->order('sort desc,createtime')->select();
		$nav=M('category')->field('content',true)->where(array('username'=>C('HOMEUSER'),'status'=>1,'pid'=>0))->order('`order` desc,createtime')->select();
		foreach ($nav as &$v){
			$son=M('category')->order('`order` desc')->field('content',true)->where(array('username'=>C('HOMEUSER'),'pid'=>$v['id'],'status'=>1))->select();
			//trace($son);
			if($son){
				$v['son']=$son;
			}else{
				$v['son']=[];
			}
			
		}
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
		$this->assign('id',$id);
		$this->display();
	
	}
	
	function page(){
		$id=I('id','');
		/*
		 * 
		 * */
		$about=M('webabout')->where(array('username'=>C('HOMEUSER'),'status'=>1))->field('about',true)->order('sort desc,createtime')->select();
		$nav=M('category')->field('content',true)->where(array('username'=>C('HOMEUSER'),'status'=>1,'pid'=>0))->order('`order` desc,createtime')->select();
		foreach ($nav as &$v){
			$son=M('category')->order('`order` desc')->field('content',true)->where(array('username'=>C('HOMEUSER'),'pid'=>$v['id'],'status'=>1))->select();
			//trace($son);
			if($son){
				$v['son']=$son;
			}else{
				$v['son']=[];
			}
				
		}
		//面包屑
		$temp=M('category')->field('content',true)->where(array('username'=>C('HOMEUSER'),'id'=>$id,'status'=>1))->find();
		$temp1=M('category')->field('content',true)->where(array('username'=>C('HOMEUSER'),'id'=>$temp['pid'],'status'=>1))->find();
		$this->assign('mc',$temp1);
		//兄弟菜单
		$temp2=M('category')->field('content',true)->where(array('username'=>C('HOMEUSER'),'pid'=>$temp['pid'],'status'=>1))->select();
		$this->assign('sd',$temp2);
		
		$webinfo=M('webinfo')->where(array('username'=>C('HOMEUSER')))->find();
		$this->assign('webinfo',$webinfo);
		$this->assign('nav',$nav);
		$this->assign('about',$about);
		/*
		 * */
		//第几页
		$pageno=I('pageno',1);
		//每页数目
		$size=3;
		//开始
		$last=($pageno-1)*$size;
		//总数
		$total=M('paper')->where(array('cid'=>$id,'status'=>1))->count();
		if($total==0){
			$this->assign('page',1);
			$this->assign('pageno',1);
		}else{
		//页数
		$page=ceil($total/$size);
	//	trace($page);
		$paper=M('paper')->where(array('cid'=>$id,'status'=>1))->limit($last.','.$size)->field('content',true)->order('`order` desc,view desc,createtime')->select();
		$this->assign('papers',$paper);
		$this->assign('page',$page);
		$this->assign('pageno',$pageno);
		}
		$cates=M('category')->where(array('id'=>$id))->find();
// 		var_dump($paper);
		$this->assign('cates',$cates);
		$this->assign('id',$id);
		$this->display();
	}
/* 	function _empty() {
		redirect(__ROOT__.'/Public/404.html');
	}
	function error404() {
		redirect(__ROOT__.'/Public/404.html');
	} */
	
	function article(){
		$id=I('id','');
		/*
		 * */
		$about=M('webabout')->where(array('username'=>C('HOMEUSER'),'status'=>1))->field('about',true)->order('sort desc,createtime')->select();
		$nav=M('category')->field('content',true)->where(array('username'=>C('HOMEUSER'),'status'=>1,'pid'=>0))->order('`order` desc,createtime')->select();
		foreach ($nav as &$v){
			$son=M('category')->order('`order` desc')->field('content',true)->where(array('username'=>C('HOMEUSER'),'pid'=>$v['id'],'status'=>1))->select();
			//trace($son);
			if($son){
				$v['son']=$son;
			}else{
				$v['son']=[];
			}
				
		}
		$webinfo=M('webinfo')->where(array('username'=>C('HOMEUSER')))->find();
		$this->assign('webinfo',$webinfo);
		$this->assign('nav',$nav);
		$this->assign('about',$about);
		/*
		 * */
		$article=M('paper')->where(array('id'=>$id))->find();
		
	//目录名
		$catname=M('category')->field('content,desccontent',true)->where(array('id'=>$article['cid']))->find();
		$article['catname']=$catname['title'];
		
		M('paper')->where(array('id'=>$id))->setInc('view');
		$articlen=M('paper')->field('content,desccontent',true)->where(array('cid'=>$article['cid'],'id'=>array('gt',$id)))->find();
		$articlep=M('paper')->field('content,desccontent',true)->where(array('cid'=>$article['cid'],'id'=>array('lt',$id)))->find();
		$many=M('paper')->field('content,desccontent',true)->where(array('cid'=>$article['cid'],'id'=>array('neq',$id)))->order('view desc')->limit(5)->select();
		$this->assign('article',$article);
		$this->assign('articlep',$articlep);
		$this->assign('articlen',$articlen);
		$this->assign('many',$many);
		$this->assign('id',$id);
		$this->display();
	}
}

?>