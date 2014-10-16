<style type="text/css">
.nav{margin-left:0;margin-bottom:20px;list-style:none;}
.nav>li>a{display:block;}
.nav>li>a:hover,.nav>li>a:focus{text-decoration:none;background-color:#eeeeee;}
.nav>li>a>img{max-width:none;}
.nav>.pull-right{float:right;}
/*padding:3px 15px;*/
.nav-header{display:block;font-size:17px;font-weight:bold;line-height:20px;color:#999999;text-shadow:0 1px 0 rgba(255, 255, 255, 0.5);text-transform:uppercase;}
.nav li+.nav-header{margin-top:9px;}
.nav-list{padding-left:15px;padding-right:15px;margin-bottom:0;}
.nav-list>li>a,.nav-list .nav-header{margin-left:-15px;margin-right:-15px;text-shadow:0 1px 0 rgba(255, 255, 255, 0.5);}
.nav-list>li>a{padding:3px 15px;padding-left: 22px;}
.nav-list>.active>a,.nav-list>.active>a:hover,.nav-list>.active>a:focus{color:#ffffff;text-shadow:0 -1px 0 rgba(0, 0, 0, 0.2);background-color:#0088cc;}
.nav-list [class^="icon-"],.nav-list [class*=" icon-"]{margin-right:2px;}
.nav-list .divider{*width:100%;height:1px;margin:9px 1px;*margin:-5px 0 5px;overflow:hidden;background-color:#e5e5e5;border-bottom:1px solid #ffffff;}
em{
	margin-right:5px;
}
.sidebar{
	background: #f5f5f5;
	border-width: 0px 1px 0px 0px;
	margin: 0px;
}
</style>
<div class="col-xs-2 column sidebar" style="padding-left:2px;padding-top:4px;padding-right:0px;" >
	<ul class="nav nav-list">

		<li class="nav-header">
			<em class="glyphicon glyphicon-dashboard"></em>关于ETA
		</li>
		<li class="<?php if($CCName == 'BranchController'){echo 'active';} ?>">
			<a href="<?php echo URL::to('branch/branch-index'); ?>">ETA公司</a>
		</li>
		<li class="<?php if($CCName == 'PartnerController'){echo 'active';} ?>">
			<a href="<?php echo URL::to('partner/partner-index'); ?>">合作伙伴</a>
		</li>
		<li class="<?php if($CCName == 'CareerController'){echo 'active';} ?>">
			<a href="<?php echo URL::to('career/career-index'); ?>">招聘信息</a>
		</li>
		
		<li class="nav-header">
			<em class="glyphicon glyphicon-book"></em>内容管理
		</li>
		<li class="<?php if($CCName == 'NewsController'){echo 'active';} ?>">
			<a href="<?php echo URL::to('news/news-index'); ?>">新闻列表</a>
		</li>

		<li class="nav-header">
			<em class="glyphicon glyphicon-th-list"></em>产品
		</li>
		<?php foreach ($productMenu as $key => $value) { ?>
			<li class="<?php if($CCName == 'ProductController_'.$value['tid']){echo 'active';} ?>">
				<a href="<?php echo $value['url']; ?>"><?php echo $value['name']; ?></a>
			</li>
		<?php } ?>

		<li class="nav-header">
			<em class="glyphicon glyphicon-list-alt"></em>服务
		</li>
		<?php foreach ($serviceMenu as $key => $value) { ?>
			<?php 
				if(isset($serviceMenu[$key]['child']) && !empty($serviceMenu[$key]['child'])){
			?>
					<li class="">
						<span style="margin-left:6px;"><?php echo $value['name']; ?></spam>
					</li>
			<?php	
					foreach ($serviceMenu[$key]['child'] as $kkey => $kvalue) {
			?>
						<li class="<?php if($CCName == 'ProductController_'.$kvalue['tid']){echo 'active';} ?>">
							<a href="<?php echo $kvalue['url']; ?>" style="padding-left:30px;"><?php echo $kvalue['name']; ?></a>
						</li>
			<?php
					}
				}else{
			?>
					<li class="<?php if($CCName == 'ProductController_'.$value['tid']){echo 'active';} ?>">
						<a href="<?php echo $value['url']; ?>"><?php echo $value['name']; ?></a>
					</li>
			<?php
				}
			?>			
		<?php } ?>
		<li class="nav-header">
			<em class="glyphicon glyphicon-download-alt"></em>支持与下载
		</li>
		<li class="<?php if($CCName == 'DownloadController_soft'){echo 'active';} ?>">
			<a href="<?php echo URL::to('download/soft-info/soft'); ?>">软件管理</a>
		</li>
		<li class="<?php if($CCName == 'DownloadController_doc'){echo 'active';} ?>">
			<a href="<?php echo URL::to('download/doc-info/doc'); ?>">手册管理</a>
		</li>

		<li class="nav-header">
			<em class="glyphicon glyphicon-tower"></em>行业客户
		</li>
		<?php foreach ($customerMenu as $key => $value) { ?>
			<li class="<?php if($CCName == 'CustomerController_'.$value['tid']){echo 'active';} ?>">
				<a href="<?php echo $value['url']; ?>"><?php echo $value['name']; ?></a>
			</li>
		<?php } ?>
		
		<li class="nav-header">
			<em class="glyphicon glyphicon-user"></em>用户管理
		</li>
		<li class="<?php if($CCName == 'UserController'){echo 'active';} ?>">
			<a href="<?php echo URL::to('user/user-index'); ?>">用户列表</a>
		</li>
		<li class="">
			<a href="javascript:void(0);">我的信息</a>
		</li>
		<li class="">
			<a href="javascript:void(0);">我的密码</a>
		</li>
		<li class="nav-header">
			<em class="glyphicon glyphicon-cog"></em>分类配置
		</li>
		<li class="<?php if($CCName == 'TaxonomyController_4'){echo 'active';} ?>">
			<a href="<?php echo URL::to('taxonomy/taxonomy-index/4'); ?>">产品配置</a>
		</li>
		<li class="<?php if($CCName == 'TaxonomyController_10'){echo 'active';} ?>">
			<a href="<?php echo URL::to('taxonomy/taxonomy-index/10'); ?>">产品属性</a>
		</li>
		<li class="<?php if($CCName == 'TaxonomyController_6'){echo 'active';} ?>">
			<a href="<?php echo URL::to('taxonomy/taxonomy-index/6'); ?>">服务配置</a>
		</li>
		<li class="<?php if($CCName == 'TaxonomyController_11'){echo 'active';} ?>">
			<a href="<?php echo URL::to('taxonomy/taxonomy-index/11'); ?>">服务属性</a>
		</li>
		<li class="<?php if($CCName == 'TaxonomyController_5'){echo 'active';} ?>">
			<a href="<?php echo URL::to('taxonomy/taxonomy-index/5'); ?>">客户配置</a>
		</li>
		<li class="<?php if($CCName == 'TaxonomyController_8'){echo 'active';} ?>">
			<a href="<?php echo URL::to('taxonomy/taxonomy-index/8'); ?>">软件类型</a>
		</li>
		<li class="<?php if($CCName == 'TaxonomyController_9'){echo 'active';} ?>">
			<a href="<?php echo URL::to('taxonomy/taxonomy-index/9'); ?>">文档类型</a>
		</li>
		
		<li class="<?php if($CCName == 'TaxonomyController'){echo 'active';} ?>">
			<a href="<?php echo URL::to('taxonomy/vocabulary-index'); ?>">词根</a>
		</li>
		
	</ul>
</div>