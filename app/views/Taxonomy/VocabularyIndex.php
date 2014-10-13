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

	<!-- dialog -->
	<?php echo HTML::style('css/ui-lightness/jquery-ui-1.10.4.custom.css'); ?>
	<?php echo HTML::script('js/jquery-ui-1.10.4.custom.js'); ?>
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
					<a href="javascript:void(0);">分类管理</a> 
				</li>
				<li class="active">
					分类列表
				</li>
			</ul>	

			<div class="row clearfix">
				<div class="col-xs-6 column">

				</div>
				<div class="col-xs-6 column" >
					<div class="navbar-cus-a">
						<a href="javascript:void(0);" onclick="addVocabulary()"  class="btn btn-primary btn-custom">
							<em class='glyphicon glyphicon-plus'></em>添加根分类
						</a>
					</div>

				</div>
			</div>
			<div id="list_content_div">
				<table class="table">
					<thead>
						<tr>
							<th>
								分类名称
							</th>
							<th>
								操作
							</th>
							<th>
								
							</th>
							<th>
								
							</th>
						</tr> 
					</thead>
					<tbody>
						<?php $i = 0; ?>
						<?php foreach($vocaData as $value){ ?>
							<?php echo $i == 1 ? "<tr class='active'>" : "<tr>"; ?>	
								<td><?php echo $value->name; ?></td>
								<td><a>修改根分类</a></td>
								<td><a href="<?php echo URL::to('taxonomy/taxonomy-index/'. $value->vid); ?>">查看分类列表</a></td>
								<td><a href="<?php echo URL::to('taxonomy/taxonomy-add/'. $value->vid); ?>">添加分类</a></td>
							</tr>
							<?php $i = 1 - $i; ?>
						<?php }  ?>
					</tbody>
				</table>
			</div>
			
			
		</div>
	</div>
	<!-- footer html-->
	<?php echo $footer; ?>
</div>
<!-- add vocubulary -->
<div id="addVobularyDialog" style="display:none;" class="form-horizontal">
	<div class="form-group" >
		<label for="vocabularyName" class="col-sm-3 control-label">分类名：</label>
		<div class="col-xs-5" >
			<input type="text" name="vocabularyName" maxlength="50" class="form-control" id="vocabularyName">					
		</div>
	</div>
	<div class="form-group" >
		<label for="vocabularyDescription" class="col-sm-3 control-label">描述：</label>
		<div class="col-xs-5" >
			<input type="text" name="vocabularyDescription" maxlength="50" class="form-control" id="vocabularyDescription">					
		</div>
	</div>
</div>
</body>
<script type="text/javascript"> 
function trim(str){ //删除左右两端的空格    
     return str.replace(/(^\s*)|(\s*$)/g, "");    
} 


function addVocabulary(){

	$("#addVobularyDialog").dialog({
		//autoOpen: false,
		width: 550,
		title: "添加根分类",
		buttons: [
			{
				text: "添加",
				click: function() {
					postVocabularyDt();
					$( this ).dialog( "close" );
				}
			},
			{
				text: "取消",
				click: function() {
					$( this ).dialog( "close" );
				}
			}
		]
	});

}

function postVocabularyDt(){
	var vocabularyName = $("#vocabularyName").val();
	var vocabularyDescription = $("#vocabularyDescription").val();

	$.ajax({
		type : "post",
		url : "<?php echo URL::to('taxonomy/vocabulary-add-data'); ?>",
		async : false,
		data : {vocabularyName:vocabularyName,vocabularyDescription:vocabularyDescription},
		success : function(data){
			//pagelist.loadPage();
			window.location.href = window.location.href;
			console.log(data);
		}
	});
}
</script>
</html>
