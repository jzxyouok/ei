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
		$username=$_SESSION['username'];
		$id=I('id','');
		$status=I('status','');
		if($id=="" or $status==""){
			$this->ajaxReturn('请以正常途径访问');
		}
		$data['status']=$status;
		$isok=M('webabout')->where(array('username'=>$username,'id'=>$id))->save($data);
		if($isok){
			$this->ajaxReturn('修改成功');
		}else{
			$this->ajaxReturn('修改失败');
		}
	}
	
	//删除1
	function deleteabout(){
		$username=$_SESSION['username'];
		$id=I('id','');
		if($id==""){
			$this->ajaxReturn('请以正常途径访问');
		}
		$data['status']=2;
		$isok=M('webabout')->where(array('username'=>$username,'id'=>$id))->save($data);
		if($isok){
			$this->ajaxReturn('删除成功，真正删除请到回收站');
		}else{
			$this->ajaxReturn('删除失败|请点击右侧');
		}
	}
	
	//删除2
	function deleteabouts(){
		$username=$_SESSION['username'];
		$id=I('id','');
		if($id==""){
			$this->ajaxReturn('请以正常途径访问');
		}
		$data['id']=$id;
		$isok=M('webabout')->where(array('username'=>$username))->delete($data);
		if($isok){
			$this->ajaxReturn('永久删除成功');
		}else{
			$this->ajaxReturn('删除失败');
		}
	}
	
	function addabout(){
		$this->display();
	}
	function addabouts(){
		$username=$_SESSION['username'];
		$about=I('about','','');
		$sort=I('sort',0);
		$title=I('title','');
		$status=I('status',1);
		$data['username']=$username;
		$data['sort']=$sort;
		$data['title']=$title;
		$data['status']=$status;
		$data['about']=$about;
		$data['createtime']=date("Y-m-d H:i:s",strtotime('now'));
			if(false===M('webabout')->add($data)){
				$this->ajaxReturn('系统出错');
				return;
			}else{
				$this->ajaxReturn('增加成功');
				return;
			}
	}
	
	function updateabout(){
		$id=I('id','');
		if($id==''){
			$this->error('没有参数');
		}
		$data=M('webabout')->where(array('id'=>$id))->find();
		if($data){
			$this->assign('data',$data);
			$this->display();
		}else{
			$this->error("找不到该单页");
		}
	}
	
	function updateabouts(){
		$id=I('id','');
		if($id==''){
			$this->error('没有参数');
			return;
		}
		$username=$_SESSION['username'];
		$data=M('webabout')->where(array('id'=>$id,'username'=>$username))->find();
		if($data){
		$about=I('about','','');
		$sort=I('sort',0);
		$title=I('title','');
		$status=I('status',1);
		$data['sort']=$sort;
		$data['title']=$title;
		$data['status']=$status;
		$data['about']=$about;
		$data['updatetime']=date("Y-m-d H:i:s",strtotime('now'));
			if(false===M('webabout')->where(array('id'=>$id,'username'=>$username))->save($data)){
				$this->ajaxReturn('系统出错');
				return;
			}else{
				$this->ajaxReturn('修改成功');
				return;
			}
		}else{
			$this->error("找不到该单页");
		}
	}
	
	
}

?>