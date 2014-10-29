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
		<div class="col-md-10 column">	
			<ul class="breadcrumb">
				<li>
					<a href="javascript:void(0);">当前位置</a> 
				</li>
				<li>
					<a href="javascript:void(0);">用户管理</a> 
				</li>
				<li class="active">
					用户列表
				</li>
			</ul>	

			<div class="row clearfix">
				<div class="col-md-8 column">
					
				</div>
				<div class="col-md-4 column" >
					<?php echo Form::token(); ?>
					<div class="form-group" style="float:rtght;margin-bottom:-5px;">
						<div class="col-xs-7" style="">
							<input type="text" name="roleName" maxlength="50" class="form-control" id="roleName">					
						</div>
						
					</div>
					<a href="javascript:void(0);" style="float:rtght;" onclick="postRole()" class="btn btn-primary btn-custom">
						<em class='glyphicon glyphicon-plus'>添加角色</em>
					</a>
				</div>
				
			</div>

			<div id="list_content_div">
				<table class="table">
					<thead>
						<tr>
							<th>
								角色名
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
						<?php foreach($roleData as $value){ ?>
							<?php echo $i == 1 ? "<tr class='active'>" : "<tr>"; ?>	
								<td id="roleContent_<?php echo $value->roleId; ?>">
									<a href="javascript:void(0);" onclick='modifyRoleName(<?php echo $value->roleId; ?>,"<?php echo $value->roleName; ?>")'><?php echo $value->roleName; ?></a>
								</td>
								<td><?php echo $value->created_at; ?></td>
								<td><a href="javascript:void(0);" onclick="DeleteRole(<?php echo $value->roleId; ?>)">删除</a></td>
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

pagelist.mUrl = "<?php echo URL::to('role/role-page'); ?>";

//翻页回调函数
pagelist.pageCallback = function(data){
	//alert(data);
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

function modifyRoleName(id, name){
	$("#roleContent_" + id).html("<input type='text' id='input_id_"+id+"' maxlength='50' class='form-control-cus-input' onblur='updateRoleName("+id+",this.value)' value='"+name+"' />");
	$("#input_id_" + id).focus();
}

var _this = this;
var reg = /^[\u4E00-\u9FA5 a-zA-Z]+$/;

function updateRoleName(id, name){
	// console.log(name);
	// console.log(_this.reg.test(name));
	var reg = /^[\u4E00-\u9FA5 a-zA-Z0-9]+$/;
	if(reg.test(name) && id != ""){
		$.ajax({
			type : "post",
			url : "<?php echo URL::to('role/role-update'); ?>",
			async : false,
			data : {id:id,name:name},
			success : function(data){
				pagelist.loadPage();
			}
		});
	}else{
		alert('请输入正确格式的角色名称!');
	}
}


function postRole(){
	//var _token = $("input[name='_token']").val();
	var roleName = trim($("input[name='roleName']").val());
	
	var reg = /^[\u4E00-\u9FA5 a-zA-Z]+$/;
	if(reg.test(roleName) ){
		$.ajax({
			type : "POST",
			url : "<?php echo URL::to('role/role-add'); ?>",
			async : false,
			data : { roleName:roleName},
			success : function(data){
				if(data == "succ"){
					pagelist.filter["page"] = 1;
					pagelist.loadPage();
				}else{
					alert("添加失败！");
				}
				$("#roleName").val("");
			}
		});
	}else{
		alert('请输入正确格式的角色名称!');
	}
}

function DeleteRole(id){
	if(confirm("确定要删除该内容吗？")){
		window.location.href = "<?php echo URL::to('role/role-delete/'); ?>/" + id;
	}
}
</script>
</html>
