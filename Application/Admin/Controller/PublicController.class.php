<?php
/**
 * 公共控制表，不需权限
 * 时间：2015.8.24
 * author:一只尼玛
 * www.lenggirl.com
·*/
namespace Admin\Controller;
use Think\Controller;
class PublicController extends Controller {
    public function index(){
        $this->display('mlogin');
    }

    //登录页
    public function login(){
        $this->display('mlogin');
    }

    //登出
    public function logout(){
        if($_SESSION[C('USER_AUTH_KEY')]) {
            session_destroy();
            $this->redirect("Public/login");
        }else {
            $this->error('已经登出！',U('Public/login'));
        }
    }

    //验证登陆表单
    public function checkLogin(){
        $username=I('username','');
        $password=I('password','');
        $verify_code=I('verify','');
        if($username==''||$password==''||$verify_code==''){
            $this->redirect("Public/login");
        }
        if(!$this->_verifyCheck($verify_code)){
            $this->ajaxReturn('验证码错误！！');
        }
        $user=M('user')->where(array('username'=>$username))->find();
        if(!$user||md5($password)!=$user['password']){
            $this->ajaxReturn("用户名或密码错误！！！");
        }
		if(in_array($user['username'],C('ADMIN_AUTH_KEY'))){ //以用户名来判断是否是超级管理员，绕过验证，不用用户组来判断的原因是用户组有时候是中文    ，而且常删除或更改。
        }else{
			 if($user['status']!=1){  //status为0时表示锁定
			 $this->ajaxReturn("用户不存在或被锁定！！！");}
		}
            $data['lastloginip'] =  get_client_ip();
            $data['lastlogintime']=date("Y-m-d H:i:s",strtotime('now'));
            if(M("user")->where(array('id'=>$user['id']))->save($data)){
                M("user")->where(array('id'=>$user['id']))->setInc("loginnum");
            }
            session(C('USER_AUTH_KEY'),$user['id']);
            session('nickname',$user['nickname']);
            session('username',$user['username']);
            session('lastlogintime',$user['lastlogintime']);
            $this->ajaxReturn('登陆成功');
    }

    //验证码
    public function verify(){
        $config = array(    
            'fontSize'    =>    20,     // 验证码字体大小    
            'length'      =>    4,      // 验证码位数    
            'useNoise'    =>   false,  // 关闭验证码杂点
            'imageH'    =>  50,          // 验证码图片高度
            'imageW'    =>  200,          // 验证码图片宽度
        );
        $Verify =new \Think\Verify($config);
        $Verify->entry();
    }

    //验证验证码
    private function _verifyCheck($code, $id = ''){
        $verify = new \Think\Verify();
        return $verify->check($code, $id);
    }
    
    //修改密码
    public function changepass(){  //不能用post
    	$password=I('password','1','md5');
    	$username=I('session.uname');
    	$newpassword=I('newpassword','','md5');
    	$user=M('User')->where(array('username'=>$username))->find();
    	if(!$user){
    		$this->ajaxReturn("找不到该用户");
    	}
    	if($password!==$user['password']){
    		$this->ajaxReturn("原始密码错误");
    	}else{
    		$data['password']=$newpassword;//密码和原来一样返回0
    		if(false===M('User')->where(array('username'=>$username))->save($data)){
    			$this->ajaxReturn("修改失败");
    		}else{
    			$this->ajaxReturn("修改成功");
    		}
    	} 
    }
    
    
    //注册
    function register(){
    	$this->display();
    }
    public function registers(){
    	if(C('REGISTER')!==1){
    		$this->ajaxReturn('注册功能关闭');
    	}
    	$verify_code=I('verify','');
    	if(!$this->_verifyCheck($verify_code)){
    		$this->ajaxReturn('验证码错误！！');
    	}
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
    			$this->ajaxReturn("注册成功");
    		}else{
    			$this->ajaxReturn("注册失败");
    		}
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
    
    function forgetpasswd(){
    	$this->display();
    }
    
    function forgetpasswd2(){
    	$verify_code=I('verify','');
    	if(!$this->_verifyCheck($verify_code)){
    		$this->ajaxReturn('验证码错误！！','eval');
    		return;
    	}
    	$username=I('username','');
    	if(strlen($username)>64){
    		$this->ajaxReturn('用户名太长','eval');
    		return;
    	}
    	$isexist=M('usersafe')->where(array('username'=>$username))->find();
    	if($isexist===false){
    		$this->ajaxReturn('系统出错','eval');
    		return;
    	}
    	if($isexist===null){
    		$this->ajaxReturn('用户不存在或未设置密保','eval');
    		return;
    	}
    	$this->assign('user',$username);
    	$this->assign('q1',$isexist['question1']);
    	$this->assign('q2',$isexist['question2']);
    	$this->assign('q3',$isexist['question3']);
    	$this->display();
    }
    
    function updatepasswd(){
    	$verify_code=I('verify','');
    	if(!$this->_verifyCheck($verify_code)){
    		$this->ajaxReturn('验证码错误！！','eval');
    		return;
    	}
    	$username=I('username','');
        if(strlen($username)>64){
    		$this->error('用户名太长');
    		return;
    	}
    	$isexist=M('usersafe')->where(array('username'=>$username))->find();
    	if($isexist===false){
    		$this->ajaxReturn('系统出错1');
    		return;
    	}
    	if($isexist===null){
    		$this->ajaxReturn('请以正常途径访问');
    	}
    	$q1=I('question1','');
    	$q2=I('question2','');
    	$q3=I('question3','');
    	$a1=I('q1','');
    	$a2=I('q2','');
    	$a3=I('q3','');
    	$data['username']=$username;
    	$data['question1']=$q1;
    	$data['question2']=$q2;
    	$data['question3']=$q3;
    	$data['answer1']=$a1;
    	$data['answer2']=$a2;
    	$data['answer3']=$a3;
    	if(M('usersafe')->where($data)->select()){
    		$passwd1=I('password1','');
    		$passwd2=I('password2','');
    		if($passwd1!=$passwd1){
    			$this->ajaxReturn('两次密码不一致');
    		}
    		if($passwd1=='' or $passwd2==''){
    			$this->ajaxReturn('密码不能为空');
    		}
    		
    		$new['password']=md5($passwd1);
    		if(M('user')->where(array('username'=>$username))->save($new)===false){
    			$this->ajaxReturn('修改失败');
    		}else{
    			$this->ajaxReturn('修改成功');
    		}
    	}else{
    		$this->ajaxReturn('回答错误');
    	}
    	
    }
    
}

?>