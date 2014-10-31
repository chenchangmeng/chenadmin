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
		<div class="col-xs-10 column">	
			<ul class="breadcrumb">
				<li>
					<a href="javascript:void(0);">当前位置</a> 
				</li>
				<li>
					<a href="javascript:void(0);">内容管理</a> 
				</li>
				<li class="active">
					会员列表
				</li>
			</ul>	

			<div class="row clearfix">
				<div class="col-xs-8 column">
					<form class="navbar-form navbar-left navbar-custom"  role="search" action="javascript:searchMember()">
						<div class="form-group">
							 <label for="title" class="control-label">邮箱名称：</label>
							 <input class="form-control search-input"  type="text" maxlength="50" name="email" id="email" /><br />
							 <label for="memberType" class="control-label">会员类别：</label>
							 <select name="memberType" id="memberType" class="form-control search-select">
							 	<option value="">----</option>
							 	<?php foreach ($memberTypeData as $key => $value) { ?>
							 		<option value="<?php echo $value->memberType; ?>"><?php echo $value->memberType; ?></option>
							 	<?php } ?>
							 </select>
							 <label for="fromType" class="control-label">来源：</label>
							 <select name="fromType" id="fromType" class="form-control search-select">
							 	<option value="">----</option>
							 	<option value="importExcel">importExcel</option>
							 	<option value="registerWeb">registerWeb</option>
							 </select>&nbsp;
							  <button type="submit" class="btn btn-primary" ><em class='glyphicon glyphicon-search'></em>查找</button>	
						</div>

					</form>

				</div>
				<div class="col-xs-4 column" >
					<div class="navbar-cus-a">
						<a href="<?php echo URL::to(''); ?>"  class="btn btn-primary btn-custom">
							<em class='glyphicon glyphicon-plus'></em>添加新会员
						</a>
						<a href="<?php echo URL::to('member/member-import'); ?>"  class="btn btn-primary btn-custom">
							<em class='glyphicon glyphicon-import'></em>导入
						</a>
						<a href="<?php echo URL::to('member/member-export'); ?>"   class="btn btn-primary btn-custom">
							<em class='glyphicon glyphicon-export'></em>导出
						</a>
					</div>

				</div>
			</div>

			<div id="list_content_div">
				<table class="table">
					<thead>
						<tr>
							<th>
								邮箱名称
							</th>
							<th>
								会员分类
							</th>
							<th>
								来源
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
						<?php foreach($memberData as $value){ ?>
							<?php echo $i == 1 ? "<tr class='active'>" : "<tr>"; ?>	
								<td><?php echo $value->email; ?></td>
								<td><?php echo $value->memberType; ?></td>
								<td><?php echo $value->fromType; ?></td>
								<td><?php echo $value->created_at; ?></td>
								<td><a href="">删除</a></td>
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

pagelist.mUrl = "<?php echo URL::to('member/member-page'); ?>";

function searchMember(){
	pagelist.filter.email = $("#email").val();
	pagelist.filter.fromType = $("#fromType").val();
	pagelist.filter.memberType = $("#memberType").val();
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

function DeletePartner(id){
	if(confirm("确定要删除该内容吗？")){
		window.location.href = "<?php echo URL::to('partner/partner-delete/'); ?>/" + id;
	}
}

</script>
</html>
