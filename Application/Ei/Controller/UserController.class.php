<?php
namespace Ei\Controller;
use Think\Controller;
class UserController extends Controller{
	
	function index(){
		$username=I('username','');
		if($username==''){
			$this->error('非法途径');
			return;
		}
		//判断是否审核
		$webinfo=M('webinfo')->where(array('username'=>$username,'status'=>1))->find();
		if($webinfo){
			
		}else{
			$this->error('网站已经关闭');
			return;
		}
		
		//判断是否存在
		$userinfo=M('userinfo')->where(array('username'=>$username,'status'=>1))->find();
		if($userinfo){
			
		}else{
			$this->error('网站正在审核中...');
			return;
		}
		
		//导航
		$nav=M('category')->field('content',true)->where(array('username'=>$username,'status'=>1,'pid'=>0))->order('`order` desc,createtime')->select();
		foreach ($nav as &$v){
			$son=M('category')->order('`order` desc')->field('content',true)->where(array('username'=>$username,'pid'=>$v['id'],'status'=>1))->select();
			//trace($son);
			if($son){
				$v['son']=$son;
			}else{
				$v['son']=[];
			}
				
		}
		//企业介绍
		$about=M('webabout')->where(array('username'=>$username,'status'=>1))->field('about',true)->order('sort desc,createtime')->select();
		
		//轮转图片
		$photo=M('photo')->where(array('username'=>$username,'status'=>1))->order('sort desc,createtime')->select();
		$this->assign('webinfo',$webinfo);
		$this->assign('nav',$nav);
		$this->assign('about',$about);
		$this->assign('photo',$photo);
		$this->assign('username',$username);

		
		//首页文章分类展示                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         
		$showpaper=M('category')->field('content',true)->where(array('username'=>$username,'status'=>1))->limit(3)->order('`order` desc,createtime')->select();
		foreach ($showpaper as &$cate){
			$cate['paper']=M('paper')->field('content,desccontent',true)->where(array('status'=>1,'cid'=>$cate['id']))->order('`order` desc,createtime,view desc')->limit(5)->select();
		}
	
		$this->assign('showpaper',$showpaper);
		
		//产品
		$product=M('product')->field('content,desccontent',true)->where(array('username'=>$username,'status'=>1))->order('`order` desc,createtime')->limit(8)->select();
		$this->assign('product',$product);
		//var_dump($product);
		$this->display('index1');
	}
	
	function about(){
		$username=I('username','');
		if($username==''){
			$this->error('非法途径');
			return;
		}
		
		//判断是否审核
		$webinfo=M('webinfo')->where(array('username'=>$username,'status'=>1))->find();
		if($webinfo){
				
		}else{
			$this->error('网站已经关闭');
			return;
		}
		
		//判断是否存在
		$userinfo=M('userinfo')->where(array('username'=>$username,'status'=>1))->find();
		if($userinfo){
				
		}else{
			$this->error('网站正在审核中...');
			return;
		}
		
		$id=I('id','');
		$content=M('webabout')->where(array('id'=>$id,'status'=>1))->find();
		if($content){
			$this->assign('content',$content);
		}else{
			$this->assign('content','没有内容');
		}
		$about=M('webabout')->where(array('username'=>$username,'status'=>1))->field('about',true)->order('sort desc,createtime')->select();
		$nav=M('category')->field('content',true)->where(array('username'=>$username,'status'=>1,'pid'=>0))->order('`order` desc,createtime')->select();
		foreach ($nav as &$v){
			$son=M('category')->order('`order` desc')->field('content',true)->where(array('username'=>$username,'pid'=>$v['id'],'status'=>1))->select();
			//trace($son);
			if($son){
				$v['son']=$son;
			}else{
				$v['son']=[];
			}
		
		}
		$this->assign('webinfo',$webinfo);
		$this->assign('nav',$nav);
		$this->assign('about',$about);
		$this->assign('id',$id);
		$this->assign('username',$username);
		$this->display();
	
	}
	
	function page(){
		$username=I('username','');
		if($username==''){
			$this->error('非法途径');
			return;
		}
		
		//判断是否审核
		$webinfo=M('webinfo')->where(array('username'=>$username,'status'=>1))->find();
		if($webinfo){
		
		}else{
			$this->error('网站已经关闭');
			return;
		}
		
		//判断是否存在
		$userinfo=M('userinfo')->where(array('username'=>$username,'status'=>1))->find();
		if($userinfo){
		
		}else{
			$this->error('网站正在审核中...');
			return;
		}
		$id=I('id','');
		/*
		 * 
		 * */
		$about=M('webabout')->where(array('username'=>$username,'status'=>1))->field('about',true)->order('sort desc,createtime')->select();
		$nav=M('category')->field('content',true)->where(array('username'=>$username,'status'=>1,'pid'=>0))->order('`order` desc,createtime')->select();
		foreach ($nav as &$v){
			$son=M('category')->order('`order` desc')->field('content',true)->where(array('username'=>$username,'pid'=>$v['id'],'status'=>1))->select();
			//trace($son);
			if($son){
				$v['son']=$son;
			}else{
				$v['son']=[];
			}
		
		}
		//面包屑
		$temp=M('category')->field('content',true)->where(array('username'=>$username,'id'=>$id,'status'=>1))->find();
		$temp1=M('category')->field('content',true)->where(array('username'=>$username,'id'=>$temp['pid'],'status'=>1))->find();
		$this->assign('mc',$temp1);
		//兄弟菜单
		$temp2=M('category')->field('content',true)->where(array('username'=>$username,'pid'=>$temp['pid'],'status'=>1))->select();
		$this->assign('sd',$temp2);
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
		$cates=M('category')->where(array('id'=>$id,'status'=>1))->find();
// 		var_dump($paper);
		$this->assign('cates',$cates);
		$this->assign('id',$id);
		$this->assign('username',$username);
		$this->display();
	}
/* 	function _empty() {
		redirect(__ROOT__.'/Public/404.html');
	}
	function error404() {
		redirect(__ROOT__.'/Public/404.html');
	} */
	
	function article(){
		$username=I('username','');
		if($username==''){
			$this->error('非法途径');
			return;
		}
		
		//判断是否审核
		$webinfo=M('webinfo')->where(array('username'=>$username,'status'=>1))->find();
		if($webinfo){
		
		}else{
			$this->error('网站已经关闭');
			return;
		}
		
		//判断是否存在
		$userinfo=M('userinfo')->where(array('username'=>$username,'status'=>1))->find();
		if($userinfo){
		
		}else{
			$this->error('网站正在审核中...');
			return;
		}
		$id=I('id','');
		/*
		 * */
		$about=M('webabout')->where(array('username'=>$username,'status'=>1))->field('about',true)->order('sort desc,createtime')->select();
		$nav=M('category')->field('content',true)->where(array('username'=>$username,'status'=>1,'pid'=>0))->order('`order` desc,createtime')->select();
		foreach ($nav as &$v){
			$son=M('category')->order('`order` desc')->field('content',true)->where(array('username'=>$username,'pid'=>$v['id'],'status'=>1))->select();
			//trace($son);
			if($son){
				$v['son']=$son;
			}else{
				$v['son']=[];
			}
		
		}
		$this->assign('webinfo',$webinfo);
		$this->assign('nav',$nav);
		$this->assign('about',$about);
		/*
		 * */
		$article=M('paper')->where(array('id'=>$id))->find();
		
		//目录名
		$catname=M('category')->field('content,desccontent',true)->where(array('id'=>$article['cid'],'status'=>1))->find();
		$article['catname']=$catname['title'];
		
		M('paper')->where(array('id'=>$id))->setInc('view');
		$articlen=M('paper')->field('content,desccontent',true)->where(array('cid'=>$article['cid'],'id'=>array('gt',$id),'status'=>1))->find();
		$articlep=M('paper')->field('content,desccontent',true)->where(array('cid'=>$article['cid'],'id'=>array('lt',$id),'status'=>1))->find();
		$many=M('paper')->field('content,desccontent',true)->where(array('cid'=>$article['cid'],'id'=>array('neq',$id),'status'=>1))->order('view desc')->limit(5)->select();
		$this->assign('article',$article);
		$this->assign('articlep',$articlep);
		$this->assign('articlen',$articlen);
		$this->assign('many',$many);
		$this->assign('id',$id);
		$this->assign('username',$username);
		$this->display();
	}
	
	function product(){
		$id=I('id',0);
		$username=I('username','');
		if($username==''){
			$this->error('非法途径');
			return;
		}
	
		//判断是否审核
		$webinfo=M('webinfo')->where(array('username'=>$username,'status'=>1))->find();
		if($webinfo){
	
		}else{
			$this->error('网站已经关闭');
			return;
		}
	
		//判断是否存在
		$userinfo=M('userinfo')->where(array('username'=>$username,'status'=>1))->find();
		if($userinfo){
	
		}else{
			$this->error('网站正在审核中...');
			return;
		}
		/*
		 *
		 * */
		$about=M('webabout')->where(array('username'=>$username,'status'=>1))->field('about',true)->order('sort desc,createtime')->select();
		$nav=M('category')->field('content',true)->where(array('username'=>$username,'status'=>1,'pid'=>0))->order('`order` desc,createtime')->select();
		foreach ($nav as &$v){
			$son=M('category')->order('`order` desc')->field('content',true)->where(array('username'=>$username,'pid'=>$v['id'],'status'=>1))->select();
			//trace($son);
			if($son){
				$v['son']=$son;
			}else{
				$v['son']=[];
			}
	
		}
		
		$pnav=M('pcategory')->field('content',true)->where(array('username'=>$username,'status'=>1,'pid'=>0))->order('`order` desc,createtime')->select();
		foreach ($pnav as &$k){
			$kson=M('pcategory')->order('`order` desc')->field('content',true)->where(array('username'=>$username,'pid'=>$k['id'],'status'=>1))->select();
			//trace($son);
			if($kson){
				$k['son']=$kson;
			}else{
				$k['son']=[];
			}
		
		}
		
		$this->assign('webinfo',$webinfo);
		$this->assign('nav',$nav);
		//trace($pnav);
		$this->assign('pnav',$pnav);
		$this->assign('about',$about);
		/*
		 * */
		//第几页
		$pageno=I('pageno',1);
		//每页数目
		$size=8;
		//开始
		$last=($pageno-1)*$size;
		//总数
		if($id!=0){
			$jinhan['cid']=$id;
			//面包屑
			$temp=M('pcategory')->field('content',true)->where(array('username'=>$username,'id'=>$id,'status'=>1))->find();
			$temp1=M('pcategory')->field('content',true)->where(array('username'=>$username,'id'=>$temp['pid'],'status'=>1))->find();
			$this->assign('mc',$temp);
			$this->assign('mcf',$temp1);
		}
		$jinhan['username']=$username;
		$jinhan['status']=1;
		$total=M('product')->where($jinhan)->count();
		if($total==0){
			$this->assign('page',1);
			$this->assign('pageno',1);
		}else{
			//页数
			$page=ceil($total/$size);
			//	trace($page);
			$paper=M('product')->where($jinhan)->limit($last.','.$size)->field('content',true)->order('`order` desc,view desc,createtime')->select();
			$this->assign('papers',$paper);
			$this->assign('page',$page);
			$this->assign('pageno',$pageno);
		}
		$this->assign('username',$username);
		$this->assign('id',$id);
		$this->display('product1');
	}
	
	function pc(){
		$username=I('username','');
		if($username==''){
			$this->error('非法途径');
			return;
		}
	
		//判断是否审核
		$webinfo=M('webinfo')->where(array('username'=>$username,'status'=>1))->find();
		if($webinfo){
	
		}else{
			$this->error('网站已经关闭');
			return;
		}
	
		//判断是否存在
		$userinfo=M('userinfo')->where(array('username'=>$username,'status'=>1))->find();
		if($userinfo){
	
		}else{
			$this->error('网站正在审核中...');
			return;
		}
		$id=I('id','');
		/*
		 * */
		$about=M('webabout')->where(array('username'=>$username,'status'=>1))->field('about',true)->order('sort desc,createtime')->select();
		$nav=M('category')->field('content',true)->where(array('username'=>$username,'status'=>1,'pid'=>0))->order('`order` desc,createtime')->select();
		foreach ($nav as &$v){
			$son=M('category')->order('`order` desc')->field('content',true)->where(array('username'=>$username,'pid'=>$v['id'],'status'=>1))->select();
			//trace($son);
			if($son){
				$v['son']=$son;
			}else{
				$v['son']=[];
			}
	
		}
		$this->assign('webinfo',$webinfo);
		$this->assign('nav',$nav);
		$this->assign('about',$about);
		/*
		 * */
		$article=M('product')->where(array('id'=>$id,'status'=>1))->find();
	
		//目录名
		$catname=M('pcategory')->field('content,desccontent',true)->where(array('id'=>$article['cid'],'status'=>1))->find();
		$article['catname']=$catname['title'];
	
		M('paper')->where(array('id'=>$id))->setInc('view');
		$articlen=M('product')->field('content,desccontent',true)->where(array('cid'=>$article['cid'],'id'=>array('gt',$id),'status'=>1))->find();
		$articlep=M('product')->field('content,desccontent',true)->where(array('cid'=>$article['cid'],'id'=>array('lt',$id),'status'=>1))->find();
		$many=M('product')->field('content,desccontent',true)->where(array('cid'=>$article['cid'],'id'=>array('neq',$id),'status'=>1))->order('view desc')->limit(5)->select();
		$this->assign('article',$article);
		$this->assign('articlep',$articlep);
		$this->assign('articlen',$articlen);
		$this->assign('many',$many);
		$this->assign('id',$id);
		$this->assign('username',$username);
		$this->display();
	}
}

?>