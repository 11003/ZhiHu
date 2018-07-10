<?php
namespace app\index\model;
use think\Model;
use think\Session;
class User extends Model
{

	//登陆逻辑	
	public function login($data)
	{
		$user=db('zh_user')->where('email','=',$data['email'])->find();
		if($user){
			if($user['password'] == sha1($data['password'])){
				Session::set('user_id',$user['id']);
                Session::set('username',$user['name']);
                return 1;
			}else{
				return 0;
			}
		}
	}
}