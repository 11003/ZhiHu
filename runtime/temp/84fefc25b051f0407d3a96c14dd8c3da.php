<?php /*a:6:{s:72:"D:\phpStudy\PHPTutorial\WWW\tp51\application\index\view\index\index.html";i:1531194612;s:72:"D:\phpStudy\PHPTutorial\WWW\tp51\application\index\view\common\base.html";i:1530339540;s:74:"D:\phpStudy\PHPTutorial\WWW\tp51\application\index\view\common\header.html";i:1531188726;s:71:"D:\phpStudy\PHPTutorial\WWW\tp51\application\index\view\common\nav.html";i:1531192206;s:73:"D:\phpStudy\PHPTutorial\WWW\tp51\application\index\view\common\right.html";i:1530173984;s:74:"D:\phpStudy\PHPTutorial\WWW\tp51\application\index\view\common\footer.html";i:1531189283;}*/ ?>
<!-- 头部 -->
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <title>Title</title>
   <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
   <link rel="stylesheet" href="/static/css/bootstrap.css"/>
   <link rel="stylesheet" type="text/css" href="/static/fileinput/css/fileinput.min.css" />
   <link rel="stylesheet" type="text/css" href="/static/wangfu/css/wangEditor.min.css" />
   <script type="text/javascript" src="/static/js/jquery-3.3.1.min.js"></script>
   <script type="text/javascript" src="/static/js/nicEdit.js"></script>

</head>
<body>
<div class="container">
<!-- 导航 -->
<div class="row">
		<div class="col-md-12">
			<nav class="navbar navbar-inverse">
			  <div class="container-fluid">
			    <!-- Brand and toggle get grouped for better mobile display -->
			    <div class="navbar-header">
			      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
			        <span class="sr-only">Toggle navigation</span>
			        <span class="icon-bar"></span>
			        <span class="icon-bar"></span>
			        <span class="icon-bar"></span>
			      </button>
			      <a class="navbar-brand" href="<?php echo url('index/index'); ?>">社区问答</a>
			    </div>

			    <!-- Collect the nav links, forms, and other content for toggling -->
			    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			      <ul class="nav navbar-nav">

			        <li
			        <?php if(empty(app('request')->param('cate_id')) || ((app('request')->param('cate_id') instanceof \think\Collection || app('request')->param('cate_id') instanceof \think\Paginator ) && app('request')->param('cate_id')->isEmpty())): ?>class="active"<?php endif; ?>
			        ><a href="<?php echo url('index/index'); ?>">首页</a></li>
					<?php if(is_array($cateList) || $cateList instanceof \think\Collection || $cateList instanceof \think\Paginator): $i = 0; $__LIST__ = $cateList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
			        <li 
			        <?php if($vo['id'] == app('request')->param('cate_id')): ?>class="active"<?php endif; ?>
			        ><a href="<?php echo url('Index/index',['cate_id' => $vo['id']]); ?>"><?php echo htmlentities($vo['name']); ?></a></li>
					<?php endforeach; endif; else: echo "" ;endif; ?>
			      </ul>
			      <ul class="nav navbar-nav navbar-right">
				      <form class="navbar-form navbar-left" method="get">
				        <div class="form-group">
				          <input type="text" name="keywords" value="" class="form-control" placeholder="搜索你想要的文章">
				        </div>
				        <button type="submit" class="btn btn-default">Submit</button>
				      </form>
			        <?php if(app('session')->get('user_id')): ?>
					<li><a href="#"><?php echo htmlentities(app('session')->get('username')); ?></a></li>
			        <li class="dropdown">
			          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">操作 <span class="caret"></span></a>
			          <ul class="dropdown-menu">
			            <li><a href="<?php echo url('index/article'); ?>">发布文章</a></li>
			            <li role="separator" class="divider"></li>
			            <li><a href="<?php echo url('User/logout'); ?>">退出登录</a></li>
			          </ul>
			        </li>
			        <?php else: ?>
					<li><a href="<?php echo url('User/login'); ?>">登陆</a></li>
					<li><a href="<?php echo url('User/register'); ?>">注册</a></li>
			        <?php endif; ?>
			      </ul>
			    </div><!-- /.navbar-collapse -->
			  </div><!-- /.container-fluid -->
			</nav>
		</div>
	</div>




<div class="row">
	<div class="col-md-8  col-sm-8">
		<div class="page-header">
		  <h2><?php echo htmlentities($cateName); ?></h2>	
		</div>
		
		<div class="row">
			<?php if(is_array($artList) || $artList instanceof \think\Collection || $artList instanceof \think\Paginator): $i = 0; $__LIST__ = $artList;if( count($__LIST__)==0 ) : echo "$empty" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
			<div class="col-md-4">
				<a href="<?php echo url('Index/detail?artid='.$vo['id']); ?>"><img src="/<?php echo htmlentities($vo['img_title']); ?>" class="img-rounded" style="width: 230px;height: 150px"></a>
			</div>
			<div class="col-md-8">
				<h4><a href="<?php echo url('Index/detail?artid='.$vo['id']); ?>" class="lead"><?php echo htmlentities($vo['title']); ?></a></h4>
				<p>发布者:<mark><?php echo htmlentities(app('session')->get('username')); ?></mark></p>
				<p>时间:<?php echo htmlentities($vo['create_time']); ?></p>
				<p>阅读量:<?php echo htmlentities($vo['pv']); ?></p>
				<div class="lead"><?php echo htmlentities($vo['content']); if(strlen($vo['content'])>20){echo '...<a href="#">[全文]</a>';}?></div>
				<hr>
			</div>
		<?php endforeach; endif; else: echo "$empty" ;endif; ?>
		</div>
		<div class="page"><?php echo $artList->render(); ?></div>
	</div>




<!-- 右侧 -->
		<div class="col-md-4  col-sm-4">
			<div class="page-header">
			  <h2>热门浏览</h2>
			</div>
			<div class="list-group">
			  <a href="#" class="list-group-item active">
			    Cras justo odio
			  </a>
			  <a href="#" class="list-group-item">Dapibus ac facilisis in</a>
			  <a href="#" class="list-group-item">Morbi leo risus</a>
			  <a href="#" class="list-group-item">Porta ac consectetur ac</a>
			  <a href="#" class="list-group-item">Vestibulum at eros</a>
			</div>
		</div>
	
<!-- 尾部 -->
	</div>
</div>
<script type="text/javascript" src="/static/js/bootstrap.js"></script>
<script type="text/javascript" src="/static/fileinput/js/fileinput.min.js"></script>
<script type="text/javascript" src="/static/fileinput/js/locales/zh.js"></script>
<script type="text/javascript" src="/static/wangfu/js/wangEditor.min.js"></script>

<script>
initFileInput("file-0","<?php echo url('Index/insert'); ?>");
//初始化fileinput控件（第一次初始化）
function initFileInput(ctrlName, uploadUrl) {    
    var control = $('#' + ctrlName); 

    control.fileinput({
        language: 'zh', //设置语言
        uploadUrl: uploadUrl, //上传的地址
        allowedFileExtensions : ['jpg', 'png','gif'],//接收的文件后缀
        showUpload: false, //是否显示上传按钮
        showCaption: false,//是否显示标题
        browseClass: "btn btn-primary", //按钮样式
        previewFileIcon: "<i class='glyphicon glyphicon-king'></i>", 
        maxFileCount: 4,
        dropZoneEnabled: true,

        initialPreviewConfig: {
            caption: ctrlName,
            width : '120px',
            url : uploadUrl,
            key : 101,
            success: function(){

            }
        }
    });
}

//监听事件
$("file-0").on("fileuploaded",function(event, data, previewId, index){

});


</script>
</body>
</html>