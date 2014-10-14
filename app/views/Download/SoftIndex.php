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
					<a href="javascript:void(0);">支持与下载</a> 
				</li>
				<li class="active">
					软件管理
				</li>
			</ul>	

			<div class="row clearfix">
				<div class="col-xs-12 column">
					<!-- 加载编辑器的容器 -->
					<label for="content" class="control-label"><h4>简介：</h4></label>
					<?php echo Form::open(array('url' => '', 'method' => 'post',  'id'=>'soft_add_form', 'name'=>'soft_add_form'));  ?>
					    <input type="hidden" id="softBasicId" name="softBasicId" value="<?php echo $softBasicData[0]->id; ?>" />
					    <script id="softInfo" name="softInfo" type="text/plain">
					        <?php echo $softBasicData[0]->content; ?>
					    </script>
					    <!-- 配置文件 -->
					    <?php echo HTML::script('js/ueditor/ueditor.config-career.js'); ?>
					    <!-- 编辑器源码文件 -->
					    <?php echo HTML::script('js/ueditor/ueditor.all.min.js'); ?>
					    <!-- 实例化编辑器 -->
					    <script type="text/javascript">
					        var ue = UE.getEditor('softInfo');
					    </script>
					<?php echo Form::close();  ?>
				</div>

				<div class="col-xs-8 column" style="padding-top:10px;padding-left:12px;">	
					<h4>软件信息：</h4>				
				</div>
				<div class="col-xs-4 column" style="padding-left:102px;padding-top:10px;">
					<a href="javascript:void(0);" onclick="saveInfo()" class="btn btn-primary btn-custom">
						<em class='glyphicon glyphicon-saved'></em>保存
					</a>
					<a href="<?php echo URL::to('branch/branch-add'); ?>"  class="btn btn-primary btn-custom">
						<em class='glyphicon glyphicon-plus'></em>添加软件
					</a>
				</div>
			</div>

			<div id="list_content_div">
				<table class="table">
					<thead>
						<tr>
							<th style="padding-left:0px;">
								软件名称
							</th>
							<th>
								软件版本
							</th>
							<th>
								软件类型
							</th>
							
							<th>
								发布时间
							</th>
							<th>
								操作
							</th>
						</tr> 
					</thead>
					<tbody>
						<?php $i = 0; ?>
						<?php foreach($softData as $value){ ?>
							<?php echo $i == 1 ? "<tr class='active'>" : "<tr>"; ?>	
								
								
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

pagelist.mUrl = "<?php echo URL::to('partner/partner-page'); ?>";

function searchPartner(){
	//pagelist.filter.brandName = $("#brandName").val();
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

function saveInfo(){
	var  ll = document.getElementById("ueditor_textarea_softInfo");

	if(ll){
		var v = ll.value;
		var id = document.getElementById("softBasicId").value;
		if(v.length > 0){

			$.ajax({
				type : "post",
				url : "<?php echo URL::to('download/download-basic-data'); ?>",
				async : false,
				data : {id:id,content:v},
				success : function(data){
					if(data == "success"){
					   alert("保存信息成功");
					}else{
					   window.location.href = window.location.href;
					}
				}
			});

		}else{
			alert("请填写简介信息");
		}
	}else{
		alert("请填写简介信息");
	}
}

function DeleteBranch(id){
	if(confirm("确定要删除该内容吗？")){
		window.location.href = "<?php echo URL::to('branch/branch-delete/'); ?>/" + id;
	}
}

</script>
</html>
