<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>laravel</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">
	<?php echo HTML::style('css/bootstrap.css'); ?>
	<?php echo HTML::style('css/style.css'); ?>

	<?php echo HTML::script('js/jquery.min.js'); ?>
	<?php echo HTML::script('js/bootstrap.min.js'); ?>
	<?php echo HTML::script('js/scripts.js'); ?>
	<?php echo HTML::script('js/ajax.js'); ?>
	<?php echo HTML::script('js/page.js'); ?>
</head>

<body>
<div class="container">
	<!-- header html -->
	<?php echo $header; ?>

	<!-- body html -->
	<div class="row clearfix" style="margin-top:10px;">
		<!-- menu html -->
		<?php echo $menu; ?>

		<!-- content html -->
		<div class="col-xs-10 column" style="">	
			<ul class="breadcrumb">
				<li>
					<a href="javascript:void(0);">当前位置</a> 
				</li>
				<li>
					<a href="javascript:void(0);">内容管理</a> 
				</li>
				<li class="active">
					用户列表
				</li>
			</ul>	

			<div class="row clearfix">
				<div class="col-xs-8 column">
					<form class="navbar-form navbar-left navbar-custom"  role="search" action="javascript:searchNews()">
						<div class="form-group">
							 <label for="title" class="control-label">名称：</label>
							 <input class="form-control search-input" style="width:68%;" type="text" maxlength="32" name="title" id="title" />&nbsp;
							  <button type="submit" class="btn btn-primary" ><em class='glyphicon glyphicon-search'></em>查找</button>
							  <br />
							 <label for="published" class="control-label">状态：</label>
							 <select name="published" id="published" class="form-control search-select">
							 	<option value="">----</option>
							 	<option value="1">发布</option>
							 	<option value="0">未发布</option>
							 </select>
							 <label for="promote" class="control-label">推荐幻灯片：</label>
							 <select name="promote" id="promote" class="form-control search-select">
							 	<option value="">----</option>
							 	<option value="1">是</option>
							 	<option value="0">否</option>
							 </select>&nbsp;
							 <label for="sticky" class="control-label">推荐头条：</label>
							 <select name="sticky" id="sticky" class="form-control search-select">
							 	<option value="">----</option>
							 	<option value="1">是</option>
							 	<option value="0">否</option>
							 </select>

							
						</div>

					</form>

				</div>
				<div class="col-xs-4 column" >
					<div class="navbar-cus-a">
						<a href="<?php echo URL::to('news/news-add'); ?>"  class="btn btn-primary btn-custom">
							<em class='glyphicon glyphicon-plus'></em>添加新闻
						</a>
					</div>

				</div>
			</div>

			<div id="list_content_div">
				<table class="table">
					<thead>
						<tr>
							<th>
								标题
							</th>
							<th>
								发布人
							</th>
							<th>
								状态
							</th>
							<th>
								推荐幻灯片
							</th>
							<th>
								推荐头条
							</th>
							<th>
								创建时间
							</th>
							<th>
								操作
							</th>
						</tr> 
					</thead>
					<tbody>
						<?php $i = 0; ?>
						<?php foreach($newsData as $value){ ?>
							<?php echo $i == 1 ? "<tr class='active'>" : "<tr>"; ?>	
								<td><a href="#" title="<?php echo $value->title; ?>"><?php echo $value->showTitle; ?></a></td>
								<td><?php echo $value->userName; ?></td>
								<td><?php echo $value->showPublish; ?></td>
								<td><?php echo $value->showPromote; ?></td>
								<td><?php echo $value->showSticky; ?></td>
								<td><?php echo $value->created_at; ?></td>
								<td>
									<a href="#">查看</a>/
									<a href="<?php echo URL::to('news/news-update/'.$value->nid); ?>"><em class="glyphicon glyphicon-edit"></em>编辑</a>/
									<a href="javascript:void(0);" onclick="DeleteNews(<?php echo $value->nid; ?>)"><em class='glyphicon glyphicon-remove'></em>删除</a>
								</td>
							</tr>
							<?php $i = 1 - $i; ?>
						<?php }  ?>
					</tbody>
				</table>
			</div>
			<div id="page_div" class="table-page">
				<table class="">
					<tr>
						<td colspan="12" class="tr bn">
							<span id="page_statistics">
							当前<input type="text" class="table-page-input" onkeypress="pagelist.changePage(event)" id="page" maxlength="10" size="1" value="1" />页 共<?php echo $pages; ?>页, <?php echo $total; ?>条记录
							</span>&nbsp;&nbsp;
							<span id="page-link">
								<a href="javascript:pagelist.firstPage()">第一页</a>
								<a href="javascript:pagelist.lastPage()">上一页</a>
								<a href="javascript:pagelist.nextPage()">下一页</a>
								<a href="javascript:pagelist.endPage()">最末页</a>
								<select id="pageSize" class="table-page-select" onchange="pagelist.changePageSize(this.value)">
									<option value="10">10</option>
									<option value="20">20</option>
									<option value="30">30</option>
								</select>
							</span>
						</td>
					</tr>
				</table>
			</div>
			
		</div>
	</div>
	<!-- footer html-->
	<?php echo $footer; ?>
</div>
</body>
<script type="text/javascript"> 

pagelist.filter["page"] = 1; //当前页
pagelist.pageCount = <?php echo $pages; ?>; //总页数

pagelist.mUrl = "<?php echo URL::to('news/news-page'); ?>";

function searchNews(){
	pagelist.filter.title = $("#title").val();
	pagelist.filter.published = $("#published").val();
	pagelist.filter.promote = $("#promote").val();
	pagelist.filter.sticky = $("#sticky").val();
	pagelist.filter.page = 1;
	pagelist.loadPage();
}

//翻页回调函数
pagelist.pageCallback = function(data){
	//console.log(data);
	data = eval("("+ data +")");
	//console.log(data);
	document.getElementById("list_content_div").innerHTML = data.html;
	document.getElementById("page_statistics").innerHTML = '当前<input type="text"  class="table-page-input" onkeypress="pagelist.changePage(event)" id="page" maxlength="10" size="1" value="'+
	data.filter.page + '" />页 共' + data.page_count + '页, ' + data.result_counts + '条记录';

	//if (typeof data.filter == "object") {
		//pagelist.filter = data.filter;
		pagelist.pageCount = data.page_count;
	//}
	//console.log(pagelist.filter["page"]);
}

function trim(str){ //删除左右两端的空格    
     return str.replace(/(^\s*)|(\s*$)/g, "");    
} 

function DeleteNews(nid){
	if(confirm("确定要删除该内容吗？")){
		window.location.href = "<?php echo URL::to('news/news-delete/'); ?>/" + nid;
	}
}

</script>
</html>
