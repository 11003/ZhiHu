<?php
namespace app\index\controller;
use app\common\controller\Base;  //导入公共控制器
use think\facade\Request;  //导入请求静态代理
use think\facade\Session;  //导入SESSION静态代理
use app\common\model\ArticleCategory;	//导入文章所属栏目
use app\common\model\Article;	//导入文章

class Index extends Base
{
    //默认首页
    public function index()
    {
		//全局查询
		$map = [];	//把所有查询条件封装的这个数组里面
		//条件1
		$map[]=['status','=',1];	//这里的逗号不允许省略的
		//实现搜索功能
		$keywords = Request::param('keywords');	//获取搜索字段
		if(!empty($keywords)){
			//条件2
			$map[]=['title','like','%'.$keywords.'%'];
		}

        //分类信息显示 input('cate_id')
        $cateId = Request::param('cate_id');
        //如果分类cate_id存在就分配数据
        if(isset($cateId)){
			//条件3
			$map[]=['cate_id','=',$cateId];		//没加“=”，点击栏目就会出现“未定义数组下标: 1”
            //$res = ArticleCategory::find($cateId);
            $res = ArticleCategory::get($cateId);
			$artList = Article::order('create_time','desc')
				->where($map)
				->paginate(4);
		    $this->assign('cateName',$res->name);
        }else{
			$artList = Article::order('create_time','desc')
				->where($map)
				->paginate(4);
			$this->assign('cateName','全部文章');
		}
		$this->assign('empty','<h3>没有内容</h3>');
        $this->assign('artList',$artList);
        return $this->fetch('index',['title'=>'注册']);

    }

    //发布文章
    public function article()
	{
    	//1.登录才允许发布文章
    	$this->isLogin();
    	//2.设置页面标题
    	//3.获取下一级栏目的信息
    	$cateList = ArticleCategory::all();
    	//4.判断栏目是否存在
    	if(count($cateList) > 0){
    		//将查询到的栏目信息返回给模板
    		$this->assign('cateList',$cateList);
    	}else{
    		$this->error('请先添加栏目','Index/index');
    	}
    	//4.发布界面渲染   
        return $this->fetch('article',['title'=>'发布文章']);
    }  

    //添加文章
    public function insert()
    {
    	if(Request::isPost()){
    		$data = Request::post();
    		$res = $this->validate($data,'app\common\validate\Article');
    		if($res !== true){
    			//验证失败
    			echo '<script>alert("'.$res.'");location.back();</script>';
    		}else{
    			//验证成功
    			//获取上传的图片
    			$article = new Article;
    			$save = $article->save($data);
    			if($save){
    				//上传成功
    				$this->success('文章发布成功', 'Index/index');
    			}else{
    				echo '<script>alert("文章发布失败");location.back();</script>';
    			}
    		}
    	}else{
    		$this->error('请求类型错误');
    	}
    }

	//详细页
	public function detail()
	{
		$artid=Request::param('artid');
		$artres = Article::get(function($query) use ($artid){
			$query->where('id','=',$artid);
		});
		if(!is_null($artres)){
			$this->assign('artres',$artres);
		}
		$this->assign('title','详细页');
		return $this->fetch('detail');
	}
}
