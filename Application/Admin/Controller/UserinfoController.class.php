<?php
namespace Admin\Controller;
use Think\Controller;
class UserinfoController extends CommomController{
	public function index(){
		$username=$_SESSION['username'];
		$isexist=M('userinfo')->where(array('username'=>$username))->find();
		if($isexist===null){
			$this->display('index');
		}
		if($isexist===false){
			$this->error("系统出错");
		}
		if($isexist['status']==0 or $isexist['status']==3){
			$this->display('indexupdate');
		}
		if($isexist['status']==1 or $isexist['status']==2){
			$this->display('indexlist');
		}
	}
	
	function updateinfo(){
		$username=$_SESSION['username'];
		$isexist=M('userinfo')->where(array('username'=>$username))->find();
		if($isexist===false){
			$this->error("系统出错");
		}
		
		if($isexist!==null and ($isexist['status']==1 or $isexist['status']==2)){
			$this->error("请申请后再修改");
		}
		
		$realname=I('realname','');
		$personid=I('personid','');
		$address=I('address','');
		$phone=I('phone','');
		$picture1=I('picture1','');
		$picture2=I('picture2','');
		if($realname==='' or $personid==='' or $address==='' or $phone===''){
			$this->ajaxReturn('字段不能为空');
		}
		$data['realname']=$realname;
		$data['personid']=$personid;
		$data['address']=$address;
		$data['phone']=$phone;
		if($picture1!=''){
			$data['picture1']=$picture1;
			$paths=explode('/',$picture1);
			if (!is_dir('./Idcard/'.$paths[0]))
			{
				$uploadok=mkdir('./Idcard/'.$paths[0]);
			}
			if(false===copy('./Temp/'.$picture1,'./Idcard/'.$picture1)){
				$this->ajaxReturn('上传图片失败');
			}
		}
		if($picture2!=''){
			$data['picture2']=$picture2;
			$paths=explode('/',$picture2);
			if (!is_dir('./Idcard/'.$paths[0]))
			{
				$uploadok=mkdir('./Idcard/'.$paths[0]);
			}
			if(false===copy('./Temp/'.$picture2,'./Idcard/'.$picture2)){
				$this->ajaxReturn('上传图片失败');
			}
		}
		if($isexist===null){
			$data['username']=$username;
			$data['status']=0;
			if(false===M('userinfo')->add($data)){
				$this->ajaxReturn('修改失败');
			}
			else{
				$this->ajaxReturn('修改成功');
			}
		}
		if($isexist['status']==0 or $isexist['status']==3){
			$data['status']=0;
			if(false===M('userinfo')->where(array('username'=>$username))->save($data)){
				$this->ajaxReturn('修改失败');
			}
			else{
				$this->ajaxReturn('修改成功');
			}
		}
		
		$this->ajaxReturn('系统出错');
	}
	
	//得到用户信息
	function getinfo(){
		$username=$_SESSION['username'];
		$isexist=M('userinfo')->where(array('username'=>$username))->find();
		if($isexist===null or $isexist===false){
			$this->ajaxReturn('出错');
		}
		$data['realname']=$isexist['realname'];
		$data['personid']=$isexist['personid'];
		$data['address']=$isexist['address'];
		$data['phone']=$isexist['phone'];
		$data['picture1']=$isexist['picture1'];
		$data['picture2']=$isexist['picture2'];
		$this->ajaxReturn($data);
	}
	
	//列出用户信息
	function listinfo(){
		if(parent::isroot()){
			$this->display();
		}else{
			redirect(__ROOT__.'/Public/error.html');
		}
	}
	
	public function listinfos(){
		if(parent::isroot()){
			$total=M('Userinfo')->count();
			$pageSize =I('rows','');
			$page = I('page','');
			$pageStart = ($page - 1) * $pageSize;
			$rows =M('Userinfo')->limit($pageStart.','.$pageSize)->order('status desc')->select();
			foreach($rows as &$row){
				$row['picture1']="<a  target='_blank' style='color:red' href='".__ROOT__."/Idcard/".$row['picture1']."'>正面</a>";
				$row['picture2']="<a  target='_blank' style='color:red' href='".__ROOT__."/Idcard/".$row['picture2']."'>反面</a>";
				if($row['status']==0){
					$row['status']='待审核';
				}
				if($row['status']==1){
					$row['status']='已审核';
				}
				if($row['status']==2){
					$row['status']='请求修改';
				}
				if($row['status']==3){
					$row['status']='修改中';
				}
			}
			$data['total']=$total;
			$data['rows']=$rows;
			$this->ajaxReturn($data);
		}else{
			redirect(__ROOT__.'/Public/error.html');
		}
	}
	
	//审核通过用户
	public function passuser(){
		if(parent::isroot()){
			$id=I('id','');
			if($id==''){
				$this->ajaxReturn("找不到该认证信息");
			}
			$user=M('Userinfo')->where(array('id'=>$id))->find();
			$datas['status']=1;
			if(M('Userinfo')->where(array('id'=>$id))->save($datas)){
				$this->ajaxReturn("审核通过");
			}else{
				$this->ajaxReturn("系统出错");
			}
		}
		else{
			redirect(__ROOT__.'/Public/error.html');
		}
	}
	
	//审核通过用户
	public function agreeuser(){
		if(parent::isroot()){
			$id=I('id','');
			if($id==''){
				$this->ajaxReturn("找不到该认证信息");
			}
			$user=M('Userinfo')->where(array('id'=>$id))->find();
			$datas['status']=3;
			if(M('Userinfo')->where(array('id'=>$id))->save($datas)){
				$this->ajaxReturn("同意修改");
			}else{
				$this->ajaxReturn("系统出错");
			}
		}
		else{
			redirect(__ROOT__.'/Public/error.html');
		}
	}
	
	public function askforupdate(){
		$username=$_SESSION['username'];
		$isexist=M('userinfo')->where(array('username'=>$username))->find();
		if($isexist===false){
			$this->ajaxReturn('系统出错');
		}
		if($isexist===null){
			$this->ajaxReturn('找不到认证信息');
		}
		if($isexist['status']==2){
			$this->ajaxReturn('你已经申请过修改');
		}
		if($isexist['status']==1){
			$data['status']=2;
			if(false===M('userinfo')->where(array('username'=>$username))->save($data)){
				$this->ajaxReturn('系统出错');
			}
			$this->ajaxReturn('申请成功');
		}
		
		$this->ajaxReturn('不正常访问');
	}
	
}

?>