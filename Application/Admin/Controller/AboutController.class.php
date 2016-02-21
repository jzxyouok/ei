<?php
namespace Admin\Controller;
use Think\Controller;
class AboutController extends CommomController{
	function index(){
		$this->display();
	}
	public function indexs(){
		$username=$_SESSION['username'];
		$status=I('status',1);
		if(false==is_numeric($status)){
			$this->display();
			return;
		}
	//	$total=M('webabout')->where("username='".$username."' AND status!=3")->count();
		$total=M('webabout')->where(array('username'=>$username,'status'=>$status))->count();
		$page = I('page',1);
		$pageStart = ($page - 1) * $pageSize;
		$rows =M('webabout')->limit($pageStart.','.$pageSize)->where(array('username'=>$username,'status'=>$status))->order('createtime desc')->field('about,username',true)->select();
		$data['total']=$total;
		foreach ($rows as &$row){
			if($row['status']==1){
				$row['status']='已开启';
			}elseif($row['status']==0){
				$row['status']='已关闭';
			}else{
				$row['status']='回收站';
			}
		}
		$data['rows']=$rows;
		$this->ajaxReturn($data);
		$this->display();
	}
	
	function help(){
		$this->display();
	}
	
	//更新状态
	function updatestatus(){
		
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