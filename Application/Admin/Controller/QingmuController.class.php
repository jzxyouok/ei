<?php
/**
 * 用户控制表
 * 时间：2015.8.24
 * author:一只尼玛
 * www.lenggirl.com
·*/

namespace Admin\Controller;
use Think\Controller;
class QingmuController extends CommomController {
	public function listcomment(){ 
			$shopname=M('qingmu.comment','c_')->field('shop_name')->distinct(true)->select();
			$this->assign('shopname',$shopname);
			$this->display();	
	}
	
	function listdictionary(){
				$type=M('qingmu.dictionary','c_')->field('type')->distinct(true)->select();
			$this->assign('type',$type);
			$this->display();
	}
	
	public function listcomments(){
			$shop_name=I('shop_name','');
			$url=I('url','');
			//$a=array(1=>1);
			if($shop_name!=''){
			$a['shop_name']=$shop_name;
			}
			if($url!=''){
			$a['item_url']=$url;
			}
			$total=M('qingmu.comment','c_')->where($a)->count();
			$pageSize =I('rows','5');
			$page = I('page','5');
			$pageStart = ($page - 1) * $pageSize;
			$rows =M('qingmu.comment','c_')->where($a)->limit($pageStart.','.$pageSize)->order('createtime desc')->select();
			$data['total']=$total;
			$data['rows']=$rows;
			$this->ajaxReturn($data);
	}
	
	public function listdictionarys(){
			$type=I('type','');
			$nullscore=I('nullscore',1);
			//$a=array(1=>1);
			if($type!=''){
			$a['type']=$type;
			}
			if($nullscore==0){
			$a['score']=array('EXP','IS NULL');
			}else{
			$a['score']=array('EXP','IS NOT NULL');
			}
			$total=M('qingmu.dictionary','c_')->where($a)->count();
			$pageSize =I('rows','5');
			$page = I('page','5');
			$pageStart = ($page - 1) * $pageSize;
			$rows =M('qingmu.dictionary','c_')->where($a)->limit($pageStart.','.$pageSize)->order('createtime desc')->select();
			$data['total']=$total;
			$data['rows']=$rows;
			$this->ajaxReturn($data);
	}
	
	function render(){
				$shopname=M('qingmu.comment','c_')->field('shop_name')->distinct(true)->select();
			$this->assign('shopname',$shopname);
			$this->display();
	}
	
	function listrender(){
			$url=I('url','');
			if($url!=''){
			$a['item_url']=$url;
			}
			$total=M('qingmu.result','c_')->where($a)->count();
			$pageSize =I('rows','');
			$page = I('page','');
			$pageStart = ($page - 1) * $pageSize;
			$rows =M('qingmu.result','c_')->where($a)->limit($pageStart.','.$pageSize)->order('updatetime desc')->select();
			foreach($rows as &$row){
			$row['d1']=round($row['d1'],2);
			$row['d2']=round($row['d2'],2);
			$row['d3']=round($row['d3'],2);
			$row['d4']=round($row['d4'],2);
			$row['d5']=round($row['d5'],2);
			$row['d6']=round($row['d6'],2);
			$row['d7']=round($row['d7'],2);
			}
			$data['total']=$total;
			$data['rows']=$rows;
			$this->ajaxReturn($data);
	}
	
	function updatescore(){
		$id=I('id','');
		$score=I('score','');
		$username=$_SESSION ['username'];
		$data['score']=$score;
		$data['people']=$username;
		$data['createtime']=date("Y-m-d H:i:s",strtotime('now'));
		$isok=M('qingmu.dictionary','c_')->where(array('id'=>$id))->save($data);
		if($isok){
			$this->ajaxReturn('成功');
		}else{
		$this->ajaxReturn('出错');
		}
		
		
	
	}
	
	function render1(){
	$id=I('row','');
	if($id==''){
		$this->error("找不到雷达图");
	}else{
	$data=M('qingmu.result','c_')->where(array('item_url'=>$id))->find();
	//$datas=M('qingmu.commentsb','c_')->where(array('item_url'=>$id))->select();
	$this->assign('data',$data);
	//$this->assign('datas',$datas);
	$this->display();
	}
	}
	
	function listsb(){
	$url=I('url','');
			if($url!=''){
			$a['item_url']=$url;
			}
			else{
			return;
			}
			$total=M('qingmu.commentsb','c_')->where($a)->count();
			$pageSize =I('rows','');
			$page = I('page','');
			$pageStart = ($page - 1) * $pageSize;
			$rows =M('qingmu.commentsb','c_')->where($a)->limit($pageStart.','.$pageSize)->order('createtime desc')->select();
			foreach($rows as &$row){
			$commentid=$row['comment_id'];
			$c=M('qingmu.comment','c_')->where(array('id'=>$commentid))->find();
			$row['comment_id']=$c['content'];
			}
			$data['total']=$total;
			$data['rows']=$rows;
			$this->ajaxReturn($data);
	}
	
}