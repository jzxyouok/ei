<?php
namespace Admin\Controller;
use Think\Controller;
class BlogController extends CommomController {
    public function listcate(){
    	$this->display();
    }
    public function listcates(){
    	$username=$_SESSION['username'];
    	$status=I('status','');
    	if($status!=''){
    		$jinhan['status']=$status;
    	}
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
    	$this->display();
    }
    public function listpapers(){
    	$total=M('Paper')->count();
    	$pageSize =I('rows','');
    	$page = I('page','');
    	$pageStart = ($page - 1) * $pageSize;
    	$rows =M('Paper')->limit($pageStart.','.$pageSize)->select();
    	foreach($rows as &$row){
    		$row['cid']=M('Category')->where(array(id=>$row['cid']))->getField('title');
    		$row['createtime']=date('Y-m-d:H-i-s', $row['createtime']);
    		$row['updatetime']=date('Y-m-d:H-i-s', $row['updatetime']);
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
    	$this->display();
    }
    public function addcates(){
    	$username=$_SESSION['username'];
    	$title=I('title','');
    	if($title==''){
    		$this->ajaxReturn('标题不能为空');
    	}
    	$content=I('content','','');
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
    	$data=M('category')->where(array('username'=>$username))->select();
    	$this->assign('cate',$data);
    	$this->display();
    }
    public function addpapers(){
    	$title=I('title','');
    	if($title==''){
    		$this->error('标题不能为空');
    	}
    	$author=I('author','');
    	if($author==''){
    		$this->error('作者不能为空');
    	}
    	$cid=I('cid','');
    	if($cid==''){
    		$this->error('目录不能为空');
    	}
    	$content=I('content','','');
    	$view=I('view','1');
    	$order=I('order','1');
    	$status=I('status','1');
    	$data['title']=$title;
    	$data['cid']=$cid;
    	$data['author']=$author;
    	$data['content']=$content;
    	$data['view']=$view;
    	$data['order']=$order;
    	$data['status']=$status;
    	$data['createtime']=time();
    	$data['updatetime']=time();
    	if(M('Paper')->add($data)){
    		$this->success("增加成功");
    	}else{
    		$this->error("增加失败");
    	}
    }
    
    public function updatepaper(){
    	$id=I('id','');
    	if($id==''){
    		$this->error('找不到该文章') ;   	}
    	$data=M('Paper')->where(array(id=>$id))->find();
    	if($data){
    		$data['createtime']=date('Y-m-d:H:i:s',$data['createtime']);
    		$data['updatetime']=date('Y-m-d:H:i:s',$data['updatetime']);
    		$cate=M('Category')->field('id,title')->select();
    		$this->assign('cate',$cate);
    		$this->assign($data);
    		$this->display();
    	}else{
    		$this->error('找不到该文章') ;
    	}
    }
    
    public function updatepapers(){
    	$id=I('id','');
    	if($id==''){
    		$this->error('找不到该文章') ;   	
    	}
    	if(M('Paper')->where(array(id=>$id))->find()){
    		$title=I('title','');
    		if($title==''){
    		$this->error('标题不能为空');
    		}
    		$author=I('author','');
    		if($author==''){
    		$this->error('作者不能为空');
    		}
    		$cid=I('cid','');
    		if($cid==''){
    		$this->error('目录不能为空');
    		}
	    	$content=I('content','','');
	    	$view=I('view','1');
	    	$order=I('order','1');
	    	$status=I('status','1');
	    	$data['title']=$title;
	    	$data['cid']=$cid;
	    	$data['author']=$author;
	    	$data['content']=$content;
	    	$data['view']=$view;
	    	$data['order']=$order;
	    	$data['status']=$status;
	    	$data['updatetime']=time();
	    	if(M('Paper')->where(array(id=>$id))->save($data)){
	    		$this->success("更新成功",U('Blog/updatepaper?id='.$id));
	    	}else{
	    		$this->error("更新失败");
	    	}
    }else{
    	$this->error('找不到该文章') ;
    }
  }
  
  public function deletepaper(){
  	$id=I('id','');
  	if($id==''){
  		$this->ajaxReturn("不存在该文章");
  	}
  	if(!M('Paper')->where(array('id'=>$id))->find()){
  		$this->ajaxReturn("找不到该文章");
  	}
  	
  	if(M('Paper')->where(array('id'=>$id))->delete()){
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
}
?>