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
			if($shop_name==''){
			$total=M('qingmu.comment','c_')->count();
			}else{
			$total=M('qingmu.comment','c_')->where(array('shop_name'=>$shop_name))->count();
			}
			$pageSize =I('rows','5');
			$page = I('page','5');
			$pageStart = ($page - 1) * $pageSize;
			if($shop_name==''){
			$rows =M('qingmu.comment','c_')->limit($pageStart.','.$pageSize)->order('createtime desc')->select();
			}else{
			$rows =M('qingmu.comment','c_')->where(array('shop_name'=>$shop_name))->limit($pageStart.','.$pageSize)->order('createtime desc')->select();
			}
			$data['total']=$total;
			$data['rows']=$rows;
			$this->ajaxReturn($data);
	}
	
	public function listdictionarys(){
			$type=I('type','');
			if($type==''){
			$total=M('qingmu.dictionary','c_')->count();
			}else{
			$total=M('qingmu.dictionary','c_')->where(array('type'=>$type))->count();
			}
			$pageSize =I('rows','5');
			$page = I('page','5');
			$pageStart = ($page - 1) * $pageSize;
			if($type==''){
			$rows =M('qingmu.dictionary','c_')->limit($pageStart.','.$pageSize)->order('score desc')->select();
			}else{
			$rows =M('qingmu.dictionary','c_')->where(array('type'=>$type))->limit($pageStart.','.$pageSize)->order('score desc')->select();
			}
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
	
			$total=M('qingmu.result','c_')->count();
			$pageSize =I('rows','');
			$page = I('page','');
			$pageStart = ($page - 1) * $pageSize;
			$rows =M('qingmu.result','c_')->limit($pageStart.','.$pageSize)->order('updatetime desc')->select();
			foreach($rows as &$row){
			$row['d1']=round($row['d1'],2);
			$row['d2']=round($row['d1'],2);
			$row['d3']=round($row['d1'],2);
			$row['d4']=round($row['d1'],2);
			$row['d5']=round($row['d1'],2);
			$row['d6']=round($row['d1'],2);
			$row['d7']=round($row['d1'],2);
			}
			$data['total']=$total;
			$data['rows']=$rows;
			$this->ajaxReturn($data);
	}
	
	
	
	
}