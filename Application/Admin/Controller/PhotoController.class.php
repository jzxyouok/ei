<?php
namespace Admin\Controller;
use Think\Controller;
class PhotoController extends CommomController{
	public function index(){
		$username=$_SESSION['username'];
		$img=M('photo')->where(array('username'=>$username))->order('status desc,sort desc,createtime')->select();
		$this->assign('img',$img);
		$this->display();
	}
	
	public function updatephoto(){
		$username=$_SESSION['username'];
		$id=I('id','');
		$isexist=M('photo')->where(array('id'=>$id,'username'=>$username))->find();
		if($isexist){
			$this->assign('data',$isexist);
		}
		$this->display();
	}
	
	public function openphoto(){
		$username=$_SESSION['username'];
		$id=I('id','');
		$isexist=M('photo')->where(array('id'=>$id,'username'=>$username))->find();
		if($isexist){
			$data['status']=1;
			if(false===M('photo')->where(array('id'=>$id,'username'=>$username))->save($data)){
				$this->ajaxReturn('开启失败');
			}else{
				$this->ajaxReturn('成功');
			}
		}else{
			$this->ajaxReturn('找不到这个图片');
		}
	}
	
	public function closephoto(){
		$username=$_SESSION['username'];
		$id=I('id','');
		$isexist=M('photo')->where(array('id'=>$id,'username'=>$username))->find();
		if($isexist){
			$data['status']=0;
			if(false===M('photo')->where(array('id'=>$id,'username'=>$username))->save($data)){
				$this->ajaxReturn('关闭失败');
			}else{
				$this->ajaxReturn('成功');
			}
		}else{
			$this->ajaxReturn('找不到这个图片');
		}
	}
	
	public function deletephoto(){
		$username=$_SESSION['username'];
		$id=I('id','');
		$isexist=M('photo')->where(array('id'=>$id,'username'=>$username))->find();
		if($isexist){
			if(false===M('photo')->where(array('id'=>$id,'username'=>$username))->delete()){
				$this->ajaxReturn('删除失败');
			}else{
				$this->ajaxReturn('成功');
			}
		}else{
			$this->ajaxReturn('找不到这个图片');
		}
	}
	
	function addphoto(){
		$username=$_SESSION['username'];
		$num=M('photo')->where(array('username'=>$username))->count();
		if($num>5){
			$this->ajaxReturn('图片已经超过六张，请先删除或者修改');
		}
		$title=I('title','');
		if($title==''){
			$this->ajaxReturn('标题不能为空');
		}
		$desc=I('desc','');
		$url=I('url','');
		$sort=I('sort','');
		$storeplace=I('storeplace','');
		if($storeplace==''){
			$this->ajaxReturn('照片不能为空');
		}
		
		$data['title']=$title;
		$data['desc']=$desc;
		$data['url']=$url;
		$data['sort']=$sort;
		$data['storeplace']=$storeplace;
		$paths=explode('/', $storeplace);
		if (!is_dir('./Uploads/'.$paths[0]))
		{
			$uploadok=mkdir('./Uploads/'.$paths[0]);
		}
			if(false===copy('./Temp/'.$storeplace,'./Uploads/'.$storeplace)){
			$this->ajaxReturn('上传图片失败');
		}
		$data['username']=$username;
		$data['createtime']=date("Y-m-d H:i:s",strtotime('now'));

			if(false===M('photo')->add($data)){
				$this->ajaxReturn('修改失败');
			}
			else{
				$this->ajaxReturn('修改成功');
			}
		
		}
			
		function updatephotos(){
			$username=$_SESSION['username'];
			$id=I('id','');
			if($id==''){
				$this->ajaxReturn('不存在图片');
			}
			$title=I('title','');
			if($title==''){
				$this->ajaxReturn('标题不能为空');
			}
			$desc=I('desc','');
			$url=I('url','');
			$sort=I('sort','');
			$storeplace=I('storeplace','');
			$data['title']=$title;
			$data['desc']=$desc;
			$data['url']=$url;
			$data['sort']=$sort;
			if($storeplace==''){
			
			}
			else{
			$data['storeplace']=$storeplace;
			$paths=explode('/', $storeplace);
			if (!is_dir('./Uploads/'.$paths[0]))
			{
				$uploadok=mkdir('./Uploads/'.$paths[0]);
			}
			if(false===copy('./Temp/'.$storeplace,'./Uploads/'.$storeplace)){
				$this->ajaxReturn('上传图片失败');
			}
			}
			//$data['createtime']=date("Y-m-d H:i:s",strtotime('now'));
		
			if(false===M('photo')->where(array('id'=>$id,'username'=>$username))->save($data)){
				$this->ajaxReturn('修改失败');
			}
			else{
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
}

?>