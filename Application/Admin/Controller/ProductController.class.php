<?php
namespace Admin\Controller;
use Think\Controller;
class ProductController extends CommomController {
    public function listcate(){
    	$username=$_SESSION['username'];
    	$jinhan['username']=$username;
    	$jinhan['pid']=0;
    	$pcategory=M('pcategory')->where($jinhan)->field('content',true)->order('`order` desc,createtime')->select();
    	$this->assign('pcategory',$pcategory);
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
    	$total=M('pcategory')->where($jinhan)->field('content',true)->count();
    	$pageSize =I('rows','');
    	$page = I('page','');
    	$pageStart = ($page - 1) * $pageSize;
    	$rows =M('pcategory')->where($jinhan)->order('`order` desc')->field('content',true)->limit($pageStart.','.$pageSize)->select();
    	$data['total']=$total;
    	$data['rows']=$rows;
    	$this->ajaxReturn($data);
    }
    public function listproduct(){
        	$username=$_SESSION['username'];
    	$data=M('pcategory')->order('`order` desc')->field('content',true)->where(array('username'=>$username,'pid'=>0))->select();
    	foreach ($data as &$v){
    		$son=M('pcategory')->order('`order` desc')->field('content',true)->where(array('username'=>$username,'pid'=>$v['id']))->select();
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
    public function listproducts(){
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
    	$total=M('product')->where($jinhan)->count();
    	$pageSize =I('rows','');
    	$page = I('page','');
    	$pageStart = ($page - 1) * $pageSize;
    	$rows =M('product')->where($jinhan)->field('content,desccontent,price',true)->order('`order` desc')->limit($pageStart.','.$pageSize)->select();

    	foreach($rows as &$row){
    		$row['cid']=M('pcategory')->where(array('id'=>$row['cid']))->getField('title');
    	}
    	$data['total']=$total;
    	$data['rows']=$rows;
    	$this->ajaxReturn($data);
    }
    public function listproductsh(){
    	$username=$_SESSION['username'];
    	$status=2;
    	$total=M('product')->where(array('username'=>$username,'status'=>$status))->count();
    	$pageSize =I('rows','');
    	$page = I('page','');
    	$pageStart = ($page - 1) * $pageSize;
    	$rows =M('product')->where(array('username'=>$username,'status'=>$status))->field('content,desccontent,price',true)->order('`order` desc')->limit($pageStart.','.$pageSize)->select();
    	foreach($rows as &$row){
    		$row['cid']=M('pcategory')->where(array('id'=>$row['cid']))->getField('title');
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
    		$row['pid']=M('product')->where(array(id=>$row['pid']))->getField('title');
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
    		$data['pid']=M('product')->where(array(id=>$data['pid']))->getField('title');
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
    	$pcategory=M('pcategory')->where($jinhan)->field('content',true)->order('`order` desc,createtime')->select();
    	$this->assign('pcategory',$pcategory);
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
    		$this->ajaxReturn('产品分类标题不能为空');
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
    	if(M('pcategory')->add($data)){
    		$this->ajaxReturn("增加成功");
    	}else{
    		$this->ajaxReturn("增加失败");
    	}	
    }
    
    public function updatecate(){
    	$username=$_SESSION['username'];
    	$id=I('id','');
    	if($id==''){
    		$this->ajaxReturn("找不到该类目");
    	}
    	$data=M('pcategory')->where(array('id'=>$id,'username'=>$username))->find();
    	if($data){
    		$this->assign('data',$data);
    		$jinhan['username']=$username;
    		$jinhan['pid']=0;
    		$pcategory=M('pcategory')->where($jinhan)->field('content',true)->order('`order` desc,createtime')->select();
    		$this->assign('pcategory',$pcategory);
    		$this->display();
    	}else{
    		$this->ajaxReturn("找不到该类目");
    	}
    }
    public function updatecates(){
    	$username=$_SESSION['username'];
    	$id=I('id','');
    	if($id==''){
    		$this->ajaxReturn("找不到该类目");
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
    	if(false===M('pcategory')->where(array('id'=>$id,'username'=>$username))->save($data)){
    		$this->ajaxReturn("修改失败");
    	}else{
    		$this->ajaxReturn('修改成功');
    	}
    }
    
    public function deletecate(){
    	$username=$_SESSION['username'];
    	$id=I('id','');
    	if($id==''){
    		$this->ajaxReturn("不存在该类目");
    	}
    	if(!M('pcategory')->where(array('id'=>$id,'username'=>$username))->find()){
    		$this->ajaxReturn("找不到该类目");
    	}else if(M('product')->where(array('cid'=>$id))->select()){
    			$this->ajaxReturn("类目下有产品");
    		}else{
    			
    		}
    	if(M('pcategory')->where(array('id'=>$id,'username'=>$username))->delete()){
    			$this->ajaxReturn("删除成功");
    		}else{
    			$this->ajaxReturn("删除失败");
    		}
    }
    
    public function addproduct(){
    $username=$_SESSION['username'];
    	$data=M('pcategory')->order('`order` desc')->field('content',true)->where(array('username'=>$username,'pid'=>0))->select();
    	foreach ($data as &$v){
    		$son=M('pcategory')->order('`order` desc')->field('content',true)->where(array('username'=>$username,'pid'=>$v['id']))->select();
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
    public function addproducts(){
    	$username=$_SESSION['username'];
    	$title=I('title','');
    	if($title==''){
    		$this->ajaxReturn('标题不能为空');
    	}	
    	$price=I('price','');
    	if($price==''){
    		$this->ajaxReturn('价格不能为空');
    	}
    	$cid=I('cid','');
    	if($cid==''){
    		$this->ajaxReturn('类目不能为空');
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
    	$data['price']=$price;
    	$data['content']=$content;
    	$data['desccontent']=$desccontent;
    	$data['view']=$view;
    	$data['order']=$order;
    	$data['status']=$status;
    	$data['createtime']=date('Y-m-d H:i:s',strtotime('now'));
    	$data['username']=$username;
    	if(M('product')->add($data)){
    		$this->ajaxReturn("增加成功");
    	}else{
    		$this->ajaxReturn("增加失败");
    	}
    }
    
    public function updateproduct(){
    	$id=I('id','');
    	$username=$_SESSION['username'];
    	if($id==''){
    		$this->ajaxReturn('找不到该产品') ;   	}
    	$data=M('product')->where(array('id'=>$id,'username'=>$username))->find();
    	if($data){
    		$data1=M('pcategory')->order('`order` desc')->field('content',true)->where(array('username'=>$username,'pid'=>0))->select();
	    	foreach ($data1 as &$v){
	    		$son=M('pcategory')->order('`order` desc')->field('content',true)->where(array('username'=>$username,'pid'=>$v['id']))->select();
	    	//trace($son);
	    	if($son){
	    		$v['son']=$son;
	    	}else{
	    		$v['son']=[];
	    	}
	    	}
	    	$this->assign('cate',$data1);
    		$this->assign($data);
    		$this->display();
    	}else{
    		$this->ajaxReturn('找不到该产品') ;
    	}
    }
    
    public function updateproducts(){
    	$username=$_SESSION['username'];
    	$id=I('id','');
    	$title=I('title','');
    	if($title==''){
    		$this->ajaxReturn('标题不能为空');
    	}
    	$price=I('price','');
    	if($price==''){
    		$this->ajaxReturn('价格不能为空');
    	}
    	$cid=I('cid','');
    	if($cid==''){
    		$this->ajaxReturn('类目不能为空');
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
    	$data['price']=$price;
    	$data['content']=$content;
    	$data['desccontent']=$desccontent;
    	$data['view']=$view;
    	$data['order']=$order;
    	$data['status']=$status;
    	$data['updatetime']=date('Y-m-d H:i:s',strtotime('now'));
    	if(M('product')->where(array('id'=>$id,'username'=>$username))->save($data)){
    		$this->ajaxReturn("修改成功");
    	}else{
    		$this->ajaxReturn("修改失败");
    	}
  }
  public function deleteproducth(){
  	$id=I('id','');
  	if($id==''){
  		$this->ajaxReturn("不存在该产品");
  	}
  	$username=$_SESSION['username'];
  	$data['status']=2;
  	if(M('product')->where(array('id'=>$id,'username'=>$username))->save($data)){
  		$this->ajaxReturn('已送到回收站');
  	}else{
  		$this->ajaxReturn('删除失败');
  	}
  }
  public function deleteproduct(){
  	$id=I('id','');
  	$username=$_SESSION['username'];
  	if($id==''){
  		$this->ajaxReturn("不存在该产品");
  	}
  	if(!M('product')->where(array('id'=>$id,'username'=>$username))->find()){
  		$this->ajaxReturn("找不到该产品");
  	}
  	
  	if(M('product')->where(array('id'=>$id,'username'=>$username))->delete()){
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
  	if(M('pcategory')->where(array('id'=>$id,'username'=>$username))->save($data)){
  		$this->ajaxReturn('修改成功');
  	}else{
  		$this->ajaxReturn('修改失败');
  	}
  }
  function updateproductstatus(){
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
  	if(M('product')->where(array('id'=>$id,'username'=>$username))->save($data)){
  		$this->ajaxReturn('修改成功');
  	}else{
  		$this->ajaxReturn('修改失败');
  	}
  }
  function recoverproduct(){
  	$username=$_SESSION['username'];
  	$id=I('id','');
  	if($id==''){
  		$this->ajaxReturn('没有这个东西');
  	}
  	$data['updatetime']=date('Y-m-d H:i:s',strtotime('now'));
  	$data['status']=0;
  	if(M('product')->where(array('id'=>$id,'username'=>$username))->save($data)){
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