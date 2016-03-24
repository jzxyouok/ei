<?php
/**
 * 用户控制表
 * 时间：2015.8.24
 * author:一只尼玛
 * www.lenggirl.com
·*/

namespace Admin\Controller;
use Think\Controller;
class UserController extends CommomController {
	//列出用户
	public function listuser(){ 
		
		if(parent::isroot()){
			$this->display();
		}else{
			redirect(__ROOT__.'/Public/error.html');
		}		
	}
	
	//列出冻结用户
	/*public function listcolduser(){
		if(parent::isroot()){
			$this->display();
		}else{
			redirect(__ROOT__.'/Public/error.html');
		}
	}*/
	
// 	public function listusers(){
// 		if(parent::isroot()){
// 			$total=M('User')->where("status !=3")->count();
// 			$pageSize =I('rows','');
// 			$page = I('page','');
// 			$pageStart = ($page - 1) * $pageSize;
// 			$rows =M('User')->where("status !=3")->limit($pageStart.','.$pageSize)->order('createtime desc')->select();
// 			$data['total']=$total;
// 			$data['rows']=$rows;
// 			$this->ajaxReturn($data);
// 		}else{
// 			redirect(__ROOT__.'/Public/error.html');
// 		}
// 	}
	
	function lock(){
		if(parent::isroot()){
			$id=I('id','');
			$data['status']=0;
			if(M('User')->where(array('id'=>$id))->save($data)){
				$this->ajaxReturn('锁定成功');
			}else{
				$this->ajaxReturn('锁定失败');
			}
		}else{
			redirect(__ROOT__.'/Public/error.html');
		}
	}
	
	function uplock(){
		if(parent::isroot()){
			$id=I('id','');
			$data['status']=1;
			if(M('User')->where(array('id'=>$id))->save($data)){
				$this->ajaxReturn('解锁成功');
			}else{
				$this->ajaxReturn('解锁失败');
			}	
		}else{
			redirect(__ROOT__.'/Public/error.html');
		}
	}
	public function listusers(){
		if(parent::isroot()){
			$status=I('status',1);
			if($status!=0 and $status!=1){
				$status=1;
			}
			$total=M('User')->where(array('status'=>$status))->count();
			$pageSize =I('rows','');
			$page = I('page','');
			$pageStart = ($page - 1) * $pageSize;
			$rows =M('User')->where(array('status'=>$status))->limit($pageStart.','.$pageSize)->order('createtime desc')->select();
			$data['total']=$total;
			$data['rows']=$rows;
			$this->ajaxReturn($data);
		}else{
			redirect(__ROOT__.'/Public/error.html');
		}
	}
	
/*	public function listcoldusers(){
		if(parent::isroot()){
			$total=M('User')->where(array('status'=>0))->count();
			$pageSize =I('rows','');
			$page = I('page','');
			$pageStart = ($page - 1) * $pageSize;
			$rows =M('User')->limit($pageStart.','.$pageSize)->where(array('status'=>0))->order('createtime desc')->select();
			$data['total']=$total;
			$data['rows']=$rows;
			$this->ajaxReturn($data);
		}else{
			redirect(__ROOT__.'/Public/error.html');
		}
	}*/
	
	//更改用户信息
	public function updateuser(){
		if(parent::isroot()){
			$userid=I('id','');
			if($userid==''){
				$this->error("找不到该用户");
			}
			$User = M("User"); // 实例化User对象
			$data = $User->where(array('id'=>$userid))->find();
			if($data){
				$this->assign($data);
				$this->display();
			}else{
				$this->error("找不到该用户");
			}
		}else{
			redirect(__ROOT__.'/Public/error.html');
		}
	}
	
	public function updateusers(){
		if(parent::isroot()){
			$userid=I('id','');
			if($userid==''){
				$this->ajaxReturn("找不到该用户");
			}
			
			$nickname=I('nickname','');
			if($nickname==''){
				$this->ajaxReturn("昵称不能为空");
			}
				
			$User = M("User"); // 实例化User对象
			$data['id'] = $userid;
			$data['nickname'] = $nickname;
			$data['status']=I('status','1');	
			$data['updatetime']=date("Y-m-d H:i:s",strtotime('now'));
			$email=I('email','',FILTER_VALIDATE_EMAIL);
			if($email==''){
				$this->ajaxReturn('邮箱格式错误');
			}
			$data['email']=$email;
			$changep=I('changep','');
			//更改密码
			if($changep=='y'){
				$password1=I('password1','');
				if($password1==''){
					$this->ajaxReturn("密码不能为空");
				}
				$data['password']=md5($password1);	
			}
			
			if(false!==$User->save($data)){
				$this->ajaxReturn("修改成功");
			}else{
				$this->ajaxReturn("修改失败");
			}
		}
		else{
			redirect(__ROOT__.'/Public/error.html');
		}
	}
	
	//增加用户
	public function adduser(){
		if(parent::isroot()){
		$this->display();}
		else{
			redirect(__ROOT__.'/Public/error.html');
		}
	}
	public function addusers(){
		if(parent::isroot()){
			$nickname=I('nickname','');
			$username=I('username','');
			$status=I('status','1');
			if($username==''){
				$this->ajaxReturn("用户名不能为空");
			}
			if($nickname==''){
				$this->ajaxReturn("昵称不能为空");
			}
			$email=I('email','',FILTER_VALIDATE_EMAIL);
			if($email==''){
				$this->ajaxReturn('邮箱格式错误');
			}
			$password1=I('password1','');
			$password2=I('password2','');
			if($password1==''||$password2==''){
				$this->ajaxReturn("密码不能为空");
			}else if($password1!=$password2){
				$this->ajaxReturn("两次密码不一致");
			}
			
			if(M('User')->where(array(username=>$username))->find()){
				$this->ajaxReturn("该用户已存在");
			}else{
				$data['username']=$username;
				$data['nickname']=$nickname;
				$data['password']=md5($password2);
				$data['email']=$email;
				$data['status']=$status;
				$data['lastloginip']=get_client_ip();
				$data['createtime']=date("Y-m-d H:i:s",strtotime('now'));
				if(M('User')->add($data)){
					$this->ajaxReturn("添加成功");
				}else{
					$this->ajaxReturn("添加失败");
				}
			}
		}
		else{
			redirect(__ROOT__.'/Public/error.html');
		}
	}
	
	public function validuser(){
		$username=I('username','');
		if(M('User')->where(array(username=>$username))->find()){
			$this->ajaxReturn("用户已存在");
		}else{
			$this->ajaxReturn("用户不存在");
		}
	}
	//删除用户
	public function deleteuser(){
		if(parent::isroot()){
			$id=I('id','');
			if($id==''){
				$this->ajaxReturn("找不到用户");
			}
			$user=M('User')->where(array('id'=>$id))->find();
			if(in_array($user['username'], C('ADMIN_AUTH_KEY'))){
				$this->ajaxReturn("神一样的存在，不能删除");
			}
			$datas['status']=3;
			if(M('User')->where(array('id'=>$id))->save($datas)){
				$this->ajaxReturn("成功删除");
			}else{
				$this->ajaxReturn("删除失败");
			}
		}
		else{
			redirect(__ROOT__.'/Public/error.html');
		}
	}
	
	function updatepasswd(){
		$this->display();
	}
	function updatepasswds(){
		$username=$_SESSION['username'];
		$opassword=I('opassword','');
		if($opassword==''){
			$this->ajaxReturn('原始密码不能为空');
		}
		$valid=M('user')->where(array('username'=>$username,'password'=>md5($opassword)))->find();
		if($valid===null||$valid===false){
			$this->ajaxReturn('原始密码错误');
		}
		
		$password1=I('password1','');
		$password2=I('password2','');
		if($password1==''||$password2==''){
			$this->ajaxReturn('密码不能为空');
		}
		if($password1!=$password2){
			$this->ajaxReturn('两次密码不一致');
		}
		$data['password']=md5($password1);
		if(false===M('user')->where(array('username'=>$username,'password'=>md5($opassword)))->save($data)){
			$this->ajaxReturn('修改密码失败');
		}
		else{
			$this->ajaxReturn('修改成功');
		}
	}
	
	
}
