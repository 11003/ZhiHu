<?php
namespace app\common\model;
use think\Model;
class User extends Model 
{
	protected $pk = 'id';
	protected $table = 'zh_user';
	protected $autoWriteTimestamp = true;
	protected $createtime = 'create_time';
	protected $updatetime = 'update_time';
	protected $dateFormat = 'Y年m月d日'; //时间字段取出后的默认时间格式

	//用户状态获取器
	public function getStatusAttr($value)
	{
		$status = ['1'=>'启用', '0'=>'禁用'];
		return $status[$value];
	}

	//用户类型获取器
	public function getIsAdminAttr($value)
	{
		$status = ['1'=>'管理员', '0'=>'注册会员'];
		return $status[$value];
	}

	//用户密码修改器
	public function setPasswordAttr($value)
	{
		return md5($value);
	}

}