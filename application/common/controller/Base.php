<?php
namespace app\common\controller;
use think\Controller;
use think\facade\Session;
use app\common\model\ArticleCategory;
class Base extends Controller
{
	protected function initialize()
    {
        //显示导航
        $this->showNav();
    }

    //检查是否已登录
    protected function Logined()
    {
        if(Session::has('user_id')){
            $this->error('您已经登陆过了!!','Index/index');
        }
    }

    //检查是否未登录
    protected function isLogin()
    {
    	if(!Session::has('user_id')){
    		$this->error('客官,您忘记登录了!~','Index/index');
    	}
    }

    //显示导航栏
    protected function showNav()
    {
        $cateList = ArticleCategory::all(function($query){
            $query->where('status',1)->order('sort','asc');
        });
        $this->assign('cateList',$cateList);
    }
}