<?php
namespace Admin\Controller;
use Think\Controller;
class WebController extends CommomController{
	public function index(){
		$this->display();
	}
	
	public function getinfo(){
		$username=$_SESSION['username'];
		$data=M('webinfo')->where(array('username'=>$username))->find();
		$this->ajaxReturn($data);
	}
	
	function updateweb(){
		$username=$_SESSION['username'];
		$title=I('title','');
		if($title==''){
			$this->ajaxReturn('标题不能为空');
		}
		$slogan=I('slogan','');
		$desc=I('desc','');
		$logo=I('logo','');
		$address=I('address','');
		$status=I('status',1);
		$phone=I('phone','');
		$webinfo=I('webinfo','');
		
		$data['title']=$title;
		$data['desc']=$desc;
		$data['slogan']=$slogan;
		if($logo!=''){
			$data['logo']=$logo;
			$paths=explode('/', $logo);
			if (!is_dir('./Uploads/'.$paths[0]))
			{
				$uploadok=mkdir('./Uploads/'.$paths[0]);
			}
			if(false===copy('./Temp/'.$logo,'./Uploads/'.$logo)){
				$this->ajaxReturn('上传图片失败');
			}
		}
		$data['address']=$address;
		$data['status']=$status;
		$data['phone']=$phone;
		$data['webinfo']=$webinfo;
		$data['username']=$username;
		$exist=M('webinfo')->where(array('username'=>$username))->find();
		if($exist===null){
			if(false===M('webinfo')->add($data)){
				$this->ajaxReturn('修改失败');
			}
			else{
				$this->ajaxReturn('修改成功');
			}		
		}
		if($exist===false){
			$this->ajaxReturn('修改失败');
		}
		if(false===M('webinfo')->where(array('username'=>$username))->save($data)){
			$this->ajaxReturn('修改失败');
		}else{
			$this->ajaxReturn('修改成功');	
			}
	}
	
	function uploadimg(){
		$config = array(
			'maxSize' => 3145728,// 设置附件上传大小
			 'rootPath'=>'./Temp/',
			'savePath' => '',// 设置附件上传目录
			'saveName' => array('uniqid',''),
			'exts' => array('jpg', 'gif', 'png', 'jpeg'),// 设置附件上传类型
			'autoSub' => true,
			'subName' => array('date','Ymd'),
			);
		$upload = new \Think\Upload($config);// 实例化上传类
		// 上传文件
		$info = $upload->uploadOne($_FILES['logo']);
		if(!$info) {// 上传错误提示错误信息
			$status['isok']=0;
			$status['message']=$upload->getError();
		}
		else{// 上传成功 获取上传文件信息
			$status['isok']=1;
			$status['message']=__ROOT__.'/Temp/'.$info['savepath'].$info['savename'];
			$status['logosql']=$info['savepath'].$info['savename'];
		}
		$this->ajaxReturn($status);
	}
	
	function listlogo(){
		echo parent::listimg();
	}
}

?>