<style type="text/css">
li [class^="icon-"],li [class*=" icon-"],.nav-list li [class^="icon-"],.nav-list li [class*=" icon-"]{
	width:auto
}

.nav-list{
	margin:0;
	padding:0;
	list-style:none
}

.nav-list .open>a,.nav-list .open>a:hover,.nav-list .open>a:focus{
	background-color:#fafafa
}

.nav-list>li>a,.nav-list .nav-header{
	margin:0
}

.nav-list>li{
	display:block;
	padding:0;
	margin:0;
	border:0;
	border-top:1px solid #fcfcfc;
	border-bottom:1px solid #e5e5e5;
	position:relative
}

.nav-list>li:first-child{
	border-top:0
}

.nav-list li>a:focus{
	outline:0
}

.nav-list>li>a{
	display:block;
	height:38px;
	line-height:36px;
	padding:0 16px 0 7px;
	background-color:#f9f9f9;
	color:#585858;
	text-shadow:none!important;
	font-size:15px;
	text-decoration:none
}

.nav-list>li>a>[class*="icon-"]:first-child{
	display:inline-block;
	vertical-align:middle;
	min-width:30px;
	text-align:center;
	font-size:18px;
	font-weight:normal;
	margin-right:2px
}

.nav-list>li>a:focus{
	background-color:#f9f9f9;
	color:#1963aa
}

.nav-list>li>a:hover{
	background-color:#FFF;
	color:#1963aa
}

.nav-list>li>a:hover:before{
	display:block;
	content:"";
	position:absolute;
	top:-1px;
	bottom:0;
	left:0;
	width:3px;
	max-width:3px;
	overflow:hidden;
	background-color:#3382af
}

.nav-list>li a>.arrow{
	display:inline-block;
	width:14px!important;
	height:14px;
	line-height:14px;
	text-shadow:none;
	font-size:18px;
	position:absolute;
	right:18px;
	top:11px;
	padding:0;
	color:#666
}

.nav-list>li a:hover>.arrow,.nav-list>li.active>a>.arrow,.nav-list>li.open>a>.arrow{
	color:#1963aa
}

.nav-list>li.separator{
	height:3px;
	background-color:transparent;
	position:static;
	margin:1px 0;
	-webkit-box-shadow:none;
	box-shadow:none
}

.nav-list>li.open>a{
	background-color:#fafafa;
	color:#1963aa
}

.nav-list>li.active{
	background-color:#fff
}

.nav-list>li.active>a,.nav-list>li.active>a:hover,.nav-list>li.active>a:focus,.nav-list>li.active>a:active{
	background-color:#fff;
	color:#2b7dbc;
	font-weight:bold;
	font-size:15px
}

.nav-list>li.active>a>[class*="icon-"]{
	font-weight:normal
}

.nav-list>li.active>a:hover:before{
	display:none
}

.nav-list>li.active:after{
	display:inline-block;
	content:"";
	position:absolute;
	right:-2px;
	top:-1px;
	bottom:0;
	z-index:1;
	border:2px solid #2b7dbc;
	border-width:0 2px 0 0
}

.nav-list>li.open{
	border-bottom-color:#e5e5e5
}

.nav-list>li.active .submenu{
	display:block
}

.nav-list>li .submenu{
	display:none;
	list-style:none;
	margin:0;
	padding:0;
	position:relative;
	background-color:#fff;
	border-top:1px solid #e5e5e5
}

.nav-list>li .submenu>li{
	margin-left:0;
	position:relative
}

.nav-list>li .submenu>li>a{
	display:block;
	position:relative;
	color:#616161;
	padding:7px 0 9px 37px;
	margin:0;
	border-top:1px dotted #e4e4e4
}

.nav-list>li .submenu>li>a:focus{
	text-decoration:none
}

.nav-list>li .submenu>li>a:hover{
	text-decoration:none;
	color:#4b88b7
}

.nav-list>li .submenu>li.active>a{
	color:#2b7dbc
}

.nav-list>li .submenu>li a>[class*="icon-"]:first-child{
	display:none;
	font-size:12px;
	font-weight:normal;
	width:18px;
	height:auto;
	line-height:12px;
	text-align:center;
	position:absolute;
	left:10px;
	top:11px;
	z-index:1;
	background-color:#FFF
}

.nav-list>li .submenu>li.active>a>[class*="icon-"]:first-child,.nav-list>li .submenu>li:hover>a>[class*="icon-"]:first-child{
	display:inline-block
}

.nav-list>li .submenu>li.active>a>[class*="icon-"]:first-child{
	color:#c86139
}

.nav-list>li>.submenu>li:before{
	content:"";
	display:inline-block;
	position:absolute;
	width:7px;
	left:20px;
	top:17px;
	border-top:1px dotted #9dbdd6
}

.nav-list>li>.submenu>li:first-child>a{
	border-top:1px solid #fafafa
}

.nav-list>li>.submenu:before{
	content:"";
	display:block;
	position:absolute;
	z-index:1;
	left:18px;
	top:0;
	bottom:0;
	border:1px dotted #9dbdd6;
	border-width:0 0 0 1px
}

.nav-list>li.active>.submenu>li:before{
	border-top-color:#8eb3d0
}

.nav-list>li.active>.submenu:before{
	border-left-color:#8eb3d0
}

.nav-list li .submenu{
	overflow:hidden
}

.nav-list li.active>a:after{
	display:block;
	content:"";
	position:absolute!important;
	right:0;
	top:4px;
	border:8px solid transparent;
	border-width:14px 10px;
	border-right-color:#2b7dbc
}

.nav-list li.open>a:after{
	display:none
}

.nav-list li.active.open>.submenu>li.active.open>a.dropdown-toggle:after{
	display:none
}

.nav-list li.active>.submenu>li.active>a:after{
	display:none
}

.nav-list li.active.open>.submenu>li.active>a:after{
	display:block
}

.nav-list li.active.no-active-child>a:after{
	display:inline-block!important
}

.nav-list a .badge,.nav-list a .label{
	font-size:12px;
	padding-left:6px;
	padding-right:6px;
	position:absolute;
	top:9px;
	right:11px;
	opacity:.88
}

.nav-list a .badge [class*="icon-"],.nav-list a .label [class*="icon-"]{
	vertical-align:middle;
	margin:0
}

.nav-list a.dropdown-toggle .badge,.nav-list a.dropdown-toggle .label{
	right:28px
}

.nav-list a:hover .badge,.nav-list a:hover .label{
	opacity:1
}

.nav-list .submenu .submenu a .badge,.nav-list .submenu .submenu a .label{
	top:6px
}
</style>
<?php echo HTML::script('js/ace.min.js'); ?>
<div class="col-xs-2 column sidebar" style="padding-left:2px;padding-top:4px;padding-right:0px;height:525px;" >
	<ul class="nav nav-list">
		<li class="<?php if($currentC == 'DashboardController'){echo 'active';} ?>">
			<a href="<?php echo URL::to('dashboard/dashboard-index'); ?>">
				<em class="glyphicon glyphicon-dashboard"></em>
				<span class="menu-text"> 控制台 </span>
			</a>
		</li>
		<?php if($currNode['EtaController'] == 1){ ?>
		<li class="<?php if($currentC == 'EtaController'){echo 'active';} ?>">
			<a href="javascript:void(0);" class="dropdown-toggle">
				<em class="glyphicon glyphicon-comment"></em>
				<span class="menu-text"> 关于ETA </span>

				<b class="arrow icon-angle-down"></b>
			</a>
			<ul class="submenu">

				<li>
					<a href="<?php echo URL::to('branch/branch-index'); ?>">
						<i class="icon-double-angle-right"></i>
						ETA公司
					</a>
				</li>
				<li>
					<a href="<?php echo URL::to('partner/partner-index'); ?>">
						<i class="icon-double-angle-right"></i>
						合作伙伴
					</a>
				</li>
				<li>
					<a href="<?php echo URL::to('career/career-index'); ?>">
						<i class="icon-double-angle-right"></i>
						招聘信息
					</a>
				</li>
				<li>
					<a href="<?php echo URL::to('branch/slogan-index'); ?>">
						<i class="icon-double-angle-right"></i>
						名人名言
					</a>
				</li>

			</ul>
		</li>
		<?php } ?>
		<?php if($currNode['NewsController'] == 1){ ?>
		<li class="<?php if($CCName == 'NewsController'){echo 'active';} ?>">
			<a href="<?php echo URL::to('news/news-index'); ?>">
				<em class="glyphicon glyphicon-book"></em>
				<span class="menu-text"> 新闻管理 </span>
			</a>
		</li>
		<?php } ?>
		<?php if($currNode['ProductController'] == 1){ ?>
		<li class="<?php if($currentC == 'ProductController'){echo 'active';} ?>">
			<a href="javascript:void(0);" class="dropdown-toggle">
				<em class="glyphicon glyphicon-th-list"></em>
				<span class="menu-text">产品与服务</span>

				<b class="arrow icon-angle-down"></b>
			</a>

			<ul class="submenu">
				<?php foreach ($productMenu as $key => $value) { ?>
					<li>
						<a href="<?php echo $value['url']; ?>"><i class="icon-double-angle-right"></i><?php echo $value['name']; ?></a>
					</li>
				<?php } ?>	

				<?php foreach ($serviceMenu as $key => $value) { ?>
					<?php 
						if(isset($serviceMenu[$key]['child']) && !empty($serviceMenu[$key]['child'])){
					?>
							<li class="">
								<a href="javascript:void(0);">
									<i class="icon-double-angle-right"></i><?php echo $value['name']; ?>
								</a>
							</li>
					<?php	
							foreach ($serviceMenu[$key]['child'] as $kkey => $kvalue) {
					?>
								<li class="<?php if($CCName == 'ProductController_'.$kvalue['tid']){echo 'active';} ?>">
									<a href="<?php echo $kvalue['url']; ?>" style="padding-left:45px;">
										<i class="icon-double-angle-right"></i><?php echo $kvalue['name']; ?>
									</a>
								</li>
					<?php
							}
						}else{
					?>

							<li class="<?php if($CCName == 'ProductController_'.$value['tid']){echo 'active';} ?>">
								<a href="<?php echo $value['url']; ?>">
									<i class="icon-double-angle-right"></i><?php echo $value['name']; ?>
								</a>
							</li>
					<?php
						}
					?>			
				<?php } ?>			
			</ul>
		</li>
		<?php } ?>
		<?php if($currNode['DownloadController'] == 1){ ?>
		<li  class="<?php if($currentC == 'DownloadController'){echo 'active';} ?>">
			<a href="javascript:void(0);" class="dropdown-toggle">
				<em class="glyphicon glyphicon-download-alt"></em>
				<span class="menu-text"> 支持与下载 </span>

				<b class="arrow icon-angle-down"></b>
			</a>

			<ul class="submenu">
				<li>
					<a href="<?php echo URL::to('download/soft-info/soft'); ?>">
						<i class="icon-double-angle-right"></i>
						软件管理
					</a>
				</li>

				<li>
					<a href="<?php echo URL::to('download/doc-info/doc'); ?>">
						<i class="icon-double-angle-right"></i>
						手册管理
					</a>
				</li>
			</ul>
		</li>
		<?php } ?>
		<?php if($currNode['CustomerController'] == 1){ ?>
		<li  class="<?php if($currentC == 'CustomerController'){echo 'active';} ?>">
			<a href="javascript:void(0);" class="dropdown-toggle">
				<em class="glyphicon glyphicon-tower"></em>
				<span class="menu-text"> 行业客户 </span>

				<b class="arrow icon-angle-down"></b>
			</a>

			<ul class="submenu">
				<?php foreach ($customerMenu as $key => $value) { ?>
					<li class="<?php if($CCName == 'CustomerController_'.$value['tid']){echo 'active';} ?>">
						<a href="<?php echo $value['url']; ?>"><?php echo $value['name']; ?></a>
					</li>
				<?php } ?>
			</ul>
		</li>
		<?php } ?>
		<?php if($currNode['MemberController'] == 1){ ?>
		<li  class="<?php if($currentC == 'MemberController'){echo 'active';} ?>">
			<a href="javascript:void(0);" class="dropdown-toggle">
				<em class="glyphicon glyphicon-envelope"></em>
				<span class="menu-text"> 会员管理 </span>

				<b class="arrow icon-angle-down"></b>
			</a>

			<ul class="submenu">
				<li>
					<a href="<?php echo URL::to('member/member-info'); ?>">
						<i class="icon-double-angle-right"></i>
						会员列表
					</a>
				</li>
				<li>
					<a href="<?php echo URL::to('member/member-index'); ?>">
						<i class="icon-double-angle-right"></i>
						邮件列表
					</a>
				</li>
				<li>
					<a href="<?php echo URL::to('member/member-import'); ?>">
						<i class="icon-double-angle-right"></i>
						导入
					</a>
				</li>
				<li>
					<a href="<?php echo URL::to('member/member-export'); ?>">
						<i class="icon-double-angle-right"></i>
						导出
					</a>
				</li>
				<li>
					<a href="<?php echo URL::to('member/member-send-email'); ?>">
						<i class="icon-double-angle-right"></i>
						邮件群发
					</a>
				</li>
			</ul>
		</li>
		<?php } ?>
		<?php if($currNode['UserController'] == 1){ ?>
		<li  class="<?php if($currentC == 'UserController'){echo 'active';} ?>">
			<a href="javascript:void(0);" class="dropdown-toggle">
				<em class="glyphicon glyphicon-user"></em>
				<span class="menu-text"> 用户管理 </span>

				<b class="arrow icon-angle-down"></b>
			</a>

			<ul class="submenu">
				<li>
					<a href="<?php echo URL::to('user/user-index'); ?>">
						<i class="icon-double-angle-right"></i>
						用户列表
					</a>
				</li>
				<li>
					<a href="<?php echo URL::to('user/user-update/'.$userInfo->id); ?>">
						<i class="icon-double-angle-right"></i>
						我的信息
					</a>
				</li>
				<li>
					<a href="<?php echo URL::to('user/user-update-pass'); ?>">
						<i class="icon-double-angle-right"></i>
						我的密码
					</a>
				</li>
				<li>
					<a href="<?php echo URL::to('role/role-index'); ?>">
						<i class="icon-double-angle-right"></i>
						角色列表
					</a>
				</li>
			</ul>
		</li>
		<?php } ?>
		<?php if($currNode['TaxonomyController'] == 1){ ?>
		<li  class="<?php if($currentC == 'TaxonomyController'){echo 'active';} ?>">
			<a href="javascript:void(0);" class="dropdown-toggle">
				<em class="glyphicon glyphicon-cog"></em>
				<span class="menu-text"> 分类配置 </span>

				<b class="arrow icon-angle-down"></b>
			</a>

			<ul class="submenu">
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
		</li>
		<?php } ?>
	</ul><!-- /.nav-list -->
</div>