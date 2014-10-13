<style type="text/css">
.top-header{
	color:#ffffff;
	background: #0088cc;
	line-height: 22px;
	margin-right: 0px;
}

.top-header a{
	color:#ffffff;
	text-decoration: none;
}

 .navbar-brand {
	font-size: 24px;
	text-shadow: none;
	padding-top: 10px;
	padding-bottom: 10px;
}

.middle-header{
	color:#ffffff;
	background: #f5f5f5;
	margin-right: 0px;
}
</style>




<div class="row clearfix top-header">
	<div class="col-xs-4 column">
	</div>
	<div class="col-xs-8 column" >
		<div style="float:right;">
			<span><a href="#">前台首页</a></span>
			<span><a href="#">修改密码</a></span>
			<span><a href="<?php echo URL::current();  ?>">刷新</a></span>
			<span><a href="<?php echo URL::to('dealLoginOut');  ?>">退出系统</a></span>
		</div>
	</div>
</div>
<div class="row clearfix middle-header">
	<div class="col-xs-4 column ">
		<a href="#" class="navbar-brand">
			<small>
				<em class="glyphicon glyphicon-home"></em>
				ETA Admin
			</small>
		</a>
	</div>
	<div class="col-xs-8 column" style="padding-right:0px;">
		<div class="btn-group" style="margin-top:8px;float:right;">
			 <a class="btn btn-default" href="">
			 	<em class="glyphicon glyphicon-user"></em> 用户信息
			 </a> 
			 <a class="btn btn-default" href="<?php echo URL::to('news/news-add'); ?>">
			 	<em class='glyphicon glyphicon-plus'></em> 添加新闻
			 </a> 
			 <a class="btn btn-default" href="<?php echo URL::to('taxonomy/taxonomy-add/4'); ?>">
			 	<em class='glyphicon glyphicon-plus'></em> 添加产品
			 </a> 
			 <a class="btn btn-default" href="<?php echo URL::to('taxonomy/taxonomy-add/6'); ?>">
			 	<em class='glyphicon glyphicon-plus'></em> 添加服务
			</a>
		</div>
	</div>
</div>