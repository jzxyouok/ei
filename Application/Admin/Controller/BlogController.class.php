<?php
namespace Admin\Controller;
use Think\Controller;
class BlogController extends CommomController {
    public function listcate(){
    	$username=$_SESSION['username'];
    	$jinhan['username']=$username;
    	$jinhan['pid']=0;
    	$category=M('category')->where($jinhan)->field('content',true)->order('`order` desc,createtime')->select();
    	$this->assign('category',$category);
    	$this->display();
    }
    public function listcates(){
    	$username=$_SESSION['username'];
    	$status=I('status','');
    	$mulu=I('mulu',0);
    	if($status!=''){
    		$jinhan['status']=$status;
    	}
    	$jinhan['pid']=$mulu;
    	$jinhan['username']=$username;
    	$total=M('category')->where($jinhan)->field('content',true)->count();
    	$pageSize =I('rows','');
    	$page = I('page','');
    	$pageStart = ($page - 1) * $pageSize;
    	$rows =M('category')->where($jinhan)->order('`order` desc')->field('content',true)->limit($pageStart.','.$pageSize)->select();
    	$data['total']=$total;
    	$data['rows']=$rows;
    	$this->ajaxReturn($data);
    }
    public function listpaper(){
    	$username=$_SESSION['username'];
    	$data=M('category')->order('`order` desc')->field('content',true)->where(array('username'=>$username,'pid'=>0))->select();
    	foreach ($data as &$v){
    		$son=M('category')->order('`order` desc')->field('content',true)->where(array('username'=>$username,'pid'=>$v['id']))->select();
    	//trace($son);
    	if($son){
    		$v['son']=$son;
    	}else{
    		$v['son']=[];
    	}
    	}
    	//var_dump($data);
    	$this->assign('cate',$data);
    	$this->display();
    }
    public function listpapers(){
    	$username=$_SESSION['username'];
    	$cid=I('cid','');
    	$status=I('status','');
    	$jinhan['username']=$username;
    	if($cid!=''){
    		$jinhan['cid']=$cid;
    	}
    	if($status!=''){
    		$jinhan['status']=$status;
    	}else{
    		$jinhan['status']=array('lt',2);
    	}
    	$total=M('paper')->where($jinhan)->count();
    	$pageSize =I('rows','');
    	$page = I('page','');
    	$pageStart = ($page - 1) * $pageSize;
 		$rows =M('paper')->where($jinhan)->field('content,desccontent',true)->order('`order` desc,createtime')->limit($pageStart.','.$pageSize)->select();
    	foreach($rows as &$row){
    		$row['cid']=M('category')->where(array('id'=>$row['cid']))->getField('title');
    	}
    	$data['total']=$total;
    	$data['rows']=$rows;
    	$this->ajaxReturn($data);
    }
    public function listpapersh(){
    	$username=$_SESSION['username'];
    	$status=2;
    	$total=M('paper')->where(array('username'=>$username,'status'=>$status))->count();
    	$pageSize =I('rows','');
    	$page = I('page','');
    	$pageStart = ($page - 1) * $pageSize;
    	$rows =M('paper')->where(array('username'=>$username,'status'=>$status))->field('content,desccontent',true)->order('`order` desc')->limit($pageStart.','.$pageSize)->select();
    	foreach($rows as &$row){
    		$row['cid']=M('category')->where(array('id'=>$row['cid']))->getField('title');
    	}
    	$data['total']=$total;
    	$data['rows']=$rows;
    	$this->ajaxReturn($data);
    }
    public function listcomment(){
    	$this->display();
    } 
    public function listcomments(){
    	$total=M('Comment')->count();
    	$pageSize =I('post.rows','');
    	$page = I('post.page','');
    	$pageStart = ($page - 1) * $pageSize;
    	$rows =M('Comment')->limit($pageStart.','.$pageSize)->select();
    	foreach($rows as &$row){
    		$row['pid']=M('Paper')->where(array(id=>$row['pid']))->getField('title');
    		$row['createtime']=date('Y-m-d:H-i-s', $row['createtime']);
    		$row['content']=htmlspecialchars($row['content']);
    	}
    	$data['total']=$total;
    	$data['rows']=$rows;
    	$this->ajaxReturn($data);
    }
    
    public function seecomment(){
    	$id=I('id','');
    	if($id==''){
    		$this->error("没有这个评论");
    	}else{
    		$data=M('Comment')->where(array(id=>$id))->find();
    		$data['pid']=M('Paper')->where(array(id=>$data['pid']))->getField('title');
    		$this->assign($data);
    		$this->display();
    	}	
    }
    
    
    public function deletecomment(){
    	$id=I('id','');
    	if($id==''){
    		$this->ajaxReturn("不存在该评论");
    	}
    	if(!M('Comment')->where(array('id'=>$id))->find()){
    		$this->ajaxReturn("找不到该评论");
    	}
    	
    	if(M('Comment')->where(array('id'=>$id))->delete()){
    		$this->ajaxReturn("删除成功");
    	}else{
    		$this->ajaxReturn("删除失败");
    	}
    }
    
    public function addcate(){
    	$username=$_SESSION['username'];
    	$jinhan['username']=$username;
    	$jinhan['pid']=0;
    	$category=M('category')->where($jinhan)->field('content',true)->order('`order` desc,createtime')->select();
    	$this->assign('category',$category);
    	$this->display();
    }
    public function addcates(){
    	$username=$_SESSION['username'];
    	$title=I('title','');
    	$mulu=I('mulu',0);
    	if(is_numeric($mulu)){
    		$data['pid']=$mulu;
    	}
    	if($title==''){
    		$this->ajaxReturn('标题不能为空');
    	}
    	$content=I('content','');
    	$order=I('order',0);
    	$status=I('status',0);
    	$data['title']=$title;
    	$data['content']=$content;
    	$data['order']=$order;
    	$data['status']=$status;
    	$data['username']=$username;
    	$data['createtime']=date("Y-m-d H:i:s",strtotime('now'));
    	if(M('category')->add($data)){
    		$this->ajaxReturn("增加成功");
    	}else{
    		$this->ajaxReturn("增加失败");
    	}	
    }
    
    public function updatecate(){
    	$username=$_SESSION['username'];
    	$id=I('id','');
    	if($id==''){
    		$this->ajaxReturn("找不到该目录");
    	}
    	$data=M('category')->where(array('id'=>$id,'username'=>$username))->find();
    	if($data){
    		$this->assign('data',$data);
    		$jinhan['username']=$username;
    		$jinhan['pid']=0;
    		$category=M('category')->where($jinhan)->field('content',true)->order('`order` desc,createtime')->select();
    		$this->assign('category',$category);
    	//	var_dump($category);
    		$this->display();
    	}else{
    		$this->ajaxReturn("找不到该目录");
    	}
    }
    public function updatecates(){
    	$username=$_SESSION['username'];
    	$id=I('id','');
    	if($id==''){
    		$this->ajaxReturn("找不到该目录");
    	}
    	$title=I('title','');
    	if($title==''){
    		$this->ajaxReturn('标题不能为空');
    	}
    	$mulu=I('mulu',0);
       	if(is_numeric($mulu) and $id!=$mulu){
    		$data['pid']=$mulu;
    	}
    	$content=I('content','');
    	$order=I('order',0);
    	$status=I('status',0);
    	$data['title']=$title;
    	$data['content']=$content;
    	$data['order']=$order;
    	$data['status']=$status;
    	$data['updatetime']=date('Y-m-d H:i:s',strtotime('now'));
    	if(false===M('category')->where(array('id'=>$id,'username'=>$username))->save($data)){
    		$this->ajaxReturn("修改失败");
    	}else{
    		$this->ajaxReturn('修改成功');
    	}
    }
    
    public function deletecate(){
    	$username=$_SESSION['username'];
    	$id=I('id','');
    	if($id==''){
    		$this->ajaxReturn("不存在该目录");
    	}
    	if(!M('category')->where(array('id'=>$id,'username'=>$username))->find()){
    		$this->ajaxReturn("找不到该目录");
    	}else if(M('paper')->where(array('cid'=>$id))->select()){
    			$this->ajaxReturn("目录下有文章");
    		}else{
    			
    		}
    	if(M('category')->where(array('id'=>$id,'username'=>$username))->delete()){
    			$this->ajaxReturn("删除成功");
    		}else{
    			$this->ajaxReturn("删除失败");
    		}
    }
    
    public function addpaper(){
    $username=$_SESSION['username'];
    	$data=M('category')->order('`order` desc')->field('content',true)->where(array('username'=>$username,'pid'=>0))->select();
    	foreach ($data as &$v){
    		$son=M('category')->order('`order` desc')->field('content',true)->where(array('username'=>$username,'pid'=>$v['id']))->select();
    	//trace($son);
    	if($son){
    		$v['son']=$son;
    	}else{
    		$v['son']=[];
    	}
    	}
    	$this->assign('cate',$data);
    	$this->display();
    }
    public function addpapers(){
    	$username=$_SESSION['username'];
    	$title=I('title','');
    	if($title==''){
    		$this->ajaxReturn('标题不能为空');
    	}	
    	$author=I('author','');
    	if($author==''){
    		$this->ajaxReturn('作者不能为空');
    	}
    	$cid=I('cid','');
    	if($cid==''){
    		$this->ajaxReturn('目录不能为空');
    	}
    	$photo=I('photo','');
    	$data['photo']=$photo;
    	$paths=explode('/', $photo);
    	if (!is_dir('./Uploads/'.$paths[0]))
    	{
    		$uploadok=mkdir('./Uploads/'.$paths[0]);
    	}
    	if(false===copy('./Temp/'.$photo,'./Uploads/'.$photo)){
    		$this->ajaxReturn('上传图片失败');
    	}
    	$content=I('content','','');
    	$desccontent=I('desccontent','');
    	$view=I('view',0);
    	$order=I('order',0);
    	$status=I('status',0);
    	$data['title']=$title;
    	$data['cid']=$cid;
    	$data['author']=$author;
    	$data['content']=$content;
    	$data['desccontent']=$desccontent;
    	$data['view']=$view;
    	$data['order']=$order;
    	$data['status']=$status;
    	$data['createtime']=date('Y-m-d H:i:s',strtotime('now'));
    	$data['username']=$username;
    	if(M('paper')->add($data)){
    		$this->ajaxReturn("增加成功");
    	}else{
    		$this->ajaxReturn("增加失败");
    	}
    }
    
    public function updatepaper(){
    	$id=I('id','');
    	$username=$_SESSION['username'];
    	if($id==''){
    		$this->ajaxReturn('找不到该文章') ;   	}
    	$data=M('paper')->where(array('id'=>$id,'username'=>$username))->find();
    	if($data){
	    	$data1=M('category')->order('`order` desc')->field('content',true)->where(array('username'=>$username,'pid'=>0))->select();
	    	foreach ($data1 as &$v){
	    		$son=M('category')->order('`order` desc')->field('content',true)->where(array('username'=>$username,'pid'=>$v['id']))->select();
	    	//trace($son);
	    	if($son){
	    		$v['son']=$son;
	    	}else{
	    		$v['son']=[];
	    	}
	    	}
	    	$this->assign('cate',$data1);
    		$this->assign('tcate',$data);
    		$this->assign('username',$username);
    		$this->display();
    	}else{
    		$this->ajaxReturn('找不到该文章') ;
    	}
    }
    
    public function updatepapers(){
    	$username=$_SESSION['username'];
    	$id=I('id','');
    	$title=I('title','');
    	if($title==''){
    		$this->ajaxReturn('标题不能为空');
    	}
    	$author=I('author','');
    	if($author==''){
    		$this->ajaxReturn('作者不能为空');
    	}
    	$cid=I('cid','');
    	if($cid==''){
    		$this->ajaxReturn('目录不能为空');
    	}
    	$photo=I('photo','');
    	if($photo!=''){
    	$data['photo']=$photo;
    	$paths=explode('/', $photo);
    	if (!is_dir('./Uploads/'.$paths[0]))
    	{
    		$uploadok=mkdir('./Uploads/'.$paths[0]);
    	}
    	if(false===copy('./Temp/'.$photo,'./Uploads/'.$photo)){
    		$this->ajaxReturn('上传图片失败');
    	}
    	}
    	$content=I('content','','');
    	$desccontent=I('desccontent','');
    	$view=I('view',0);
    	$order=I('order',0);
    	$status=I('status',0);
    	$data['title']=$title;
    	$data['cid']=$cid;
    	$data['author']=$author;
    	$data['content']=$content;
    	$data['desccontent']=$desccontent;
    	$data['view']=$view;
    	$data['order']=$order;
    	$data['status']=$status;
    	$data['updatetime']=date('Y-m-d H:i:s',strtotime('now'));
    	if(M('paper')->where(array('id'=>$id,'username'=>$username))->save($data)){
    		$this->ajaxReturn("修改成功");
    	}else{
    		$this->ajaxReturn("修改失败");
    	}
  }
  public function deletepaperh(){
  	$id=I('id','');
  	if($id==''){
  		$this->ajaxReturn("不存在该文章");
  	}
  	$username=$_SESSION['username'];
  	$data['status']=2;
  	if(M('paper')->where(array('id'=>$id,'username'=>$username))->save($data)){
  		$this->ajaxReturn('已送到回收站');
  	}else{
  		$this->ajaxReturn('删除失败');
  	}
  }
  public function deletepaper(){
  	$id=I('id','');
  	$username=$_SESSION['username'];
  	if($id==''){
  		$this->ajaxReturn("不存在该文章");
  	}
  	if(!M('paper')->where(array('id'=>$id,'username'=>$username))->find()){
  		$this->ajaxReturn("找不到该文章");
  	}
  	
  	if(M('paper')->where(array('id'=>$id,'username'=>$username))->delete()){
  		$this->ajaxReturn("删除成功");
  	}else{
  		$this->ajaxReturn("删除失败");
  	}
  }
  
  /**/
  function updatestatus(){
  	$username=$_SESSION['username'];
  	$id=I('id','');
  	$status=I('status','');
  	if($id==''){
  		$this->ajaxReturn('没有这个东西');
  	}
  	if($status!=1 and $status!=0){
  		$this->ajaxReturn('状态问题');
  	}
  	$data['updatetime']=date('Y-m-d H:i:s',strtotime('now'));
  	$data['status']=$status;
  	if(M('category')->where(array('id'=>$id,'username'=>$username))->save($data)){
  		$this->ajaxReturn('修改成功');
  	}else{
  		$this->ajaxReturn('修改失败');
  	}
  }
  function updatepaperstatus(){
  	$username=$_SESSION['username'];
  	$id=I('id','');
  	$status=I('status','');
  	if($id==''){
  		$this->ajaxReturn('没有这个东西');
  	}
  	if($status!=1 and $status!=0){
  		$this->ajaxReturn('状态问题');
  	}
  	$data['updatetime']=date('Y-m-d H:i:s',strtotime('now'));
  	$data['status']=$status;
  	if(M('paper')->where(array('id'=>$id,'username'=>$username))->save($data)){
  		$this->ajaxReturn('修改成功');
  	}else{
  		$this->ajaxReturn('修改失败');
  	}
  }
  function recoverpaper(){
  	$username=$_SESSION['username'];
  	$id=I('id','');
  	if($id==''){
  		$this->ajaxReturn('没有这个东西');
  	}
  	$data['updatetime']=date('Y-m-d H:i:s',strtotime('now'));
  	$data['status']=0;
  	if(M('paper')->where(array('id'=>$id,'username'=>$username))->save($data)){
  		$this->ajaxReturn('恢复成功');
  	}else{
  		$this->ajaxReturn('恢复失败');
  	}
  }
  function rubbish(){
  	$this->display();
  }
}
?>