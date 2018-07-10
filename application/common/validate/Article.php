<?php 
namespace app\common\validate;

use think\Validate;

class Article extends Validate
{
	//经过分析,用户注册需要提供:用户名,邮箱,手机号和密码
	protected $rule = [
		'title|标题' => 'require|max:20',
		'content|内容' => 'require'
	];
}