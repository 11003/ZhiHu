<?php 
namespace app\index\controller;
use app\common\controller\Base;  //导入公共控制器
use app\common\model\User as ComUserModel; //导入自定义模型并取别名
use app\common\validate\User as UserValidate;  //导入自定义验证模型并取别名
use think\facade\Request;  //导入请求静态代理
use think\facade\Session;  //导入SESSION静态代理


class User extends Base
{
	//注册页面
	public function register()
	{
		return $this->fetch('register',['title'=>'注册页面']);
	}


	//处理用户提交的注册信息,并写到zh_user表中
	public function insert()
	{
		if(Request::isAjax()){

			$data = input('post.');

			//密码加密
			if($data['password']){
            	$data['password']=md5($data['password']);
        	}
			//开始验证: $res 中保存错误信息,成功返回true
			$res=$this->validate($data,'app\common\validate\User');
			if(true !== $res){  //验证失败
				return ['status'=> -1, 'message'=>$res];
			}else{   //验证成功
				if(ComUserModel::insert($data)){
					return ['status'=>1, 'message'=>'恭喜,注册成功~~'];
				}else{
					return ['status'=>0, 'message'=>'注册失败~~'];			
				}
			}
		}else{
			$this->error('请求类型错误','register');
		}
	}

	//登陆页面
	public function login()
	{
		$this->Logined();
		return $this->fetch('login',['title'=>'登陆页面']);
	}

	//处理用户提交的登陆信息
	public function loginCheck()
	{
		if(Request::isAjax()){

			$data = input('post.');  //要验证的数据
			
			$rule = ['email|邮箱'=>'require|email','password|密码'=>'require|alphaNum'];  //自定义的验证器

			//开始验证: $res 中保存错误信息,成功返回true
			$res=$this->validate($data,$rule);

			//传值
			$user=ComUserModel::where('email','=',$data['email'])->find();
			if($user){
				if($user['password'] == md5($data['password'])){
					Session::set('user_id',$user['id']);
	                Session::set('username',$user['name']);
	                return ['status'=>1, 'message'=>'恭喜,登陆成功~~'];
				}else{
					return ['status'=>0, 'message'=>'登陆失败~~'];			
				}
			}
		}else{
			return $this->error('页面类型错误','register');
		}
	}

	//用户退出登陆
	public function logout()
	{
		// Session::delete('id');
		// Session::delete('name');
		Session::clear();
		$this->success('退出成功','User/login');
	}
}