<?php
namespace app\common\model;
use think\Model;
class ArticleCategory extends Model 
{
	protected $pk = 'id';
	protected $table = 'zh_article_category';
	protected $autoWriteTimestamp = true;
	protected $createtime = 'create_time';
	protected $updatetime = 'update_time';
	protected $dateFormat = 'Y年m月d日'; //时间字段取出后的默认时间格式

	
	//开启自动设置
	protected $auto = [];
	//仅新增有效
	protected $insert = ['create_time','status'=>1,'is_top'=>0,'is_host'=>0];
	//仅更新的时间设置
	protected $update = ['update_time'];

}