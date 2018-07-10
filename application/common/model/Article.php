<?php
namespace app\common\model;
use think\Model;
use think\facade\Env;
class Article extends Model 
{
	protected $pk = 'id';
	protected $table = 'zh_article';
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


	//文件上传
	protected static function init(){
		Article::event('before_insert',function($data){
			if($_FILES['img_title']['tmp_name']){
				$files = request()->file();
				foreach($files as $file){
					// 移动到框架应用根目录/public/uploads/ 目录下
            		$info = $file->rule('date')->move(Env::get('root_path') . 'public' .  DIRECTORY_SEPARATOR . 'uploads');
            		if($info){
            			//获取上次路径
		                $filename = '.\uploads'.'\\'.date('Ymd').'\\'.$info->getFilename();
		                //剪切图片大小
		                $image = \think\Image::open($info);
						$image->thumb(400,400,1)->save($filename);
						//传入数据库
						$data['img_title'] = $filename;
		            }else{
		                // 上传失败获取错误信息
		                echo json_encode($file->getError(),true);
		            }
				}
			}
		});
	}

}