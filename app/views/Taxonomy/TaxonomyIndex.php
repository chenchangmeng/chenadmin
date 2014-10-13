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
						<a href="<?php echo URL::to('taxonomy/taxonomy-add/'.$vid); ?>"  class="btn btn-primary btn-custom">
							<em class='glyphicon glyphicon-plus'></em>添加子分类
						</a>
					</div>
				</div>
			</div>
			<div id="list_content_div">
				<table class="table">
					<thead>
						<tr>
							<th>
								分类名称(<?php echo $vocaData[0]->name; ?>)
							</th>
							<th>
								操作
							</th>
						</tr> 
					</thead>
					<tbody>
						<?php $i = 0; ?>
						<?php foreach($termData as $value){ ?>
							<?php echo $i == 1 ? "<tr class='active'>" : "<tr>"; ?>	
								<td><?php echo  $value->path_level . $value->name; ?></td>
								<td>
									<a href="<?php echo URL::to('taxonomy/taxonomy-update/'.$value->vid.'/'.$value->tid); ?>"><em class="glyphicon glyphicon-edit"></em>编辑</a>/
									<a href="javascript:void(0);" onclick="deleteTerm(<?php echo $value->vid; ?>, <?php echo $value->tid; ?>)"><em class='glyphicon glyphicon-remove'></em>删除</a>

								</td>
							</tr>
							<?php $i = 1 - $i; ?>
						<?php }  ?>
					</tbody>
				</table>
			</div>
			<div style="color:red;"><em class='glyphicon glyphicon-warning-sign'></em>Deleting a term will delete all its children if there are any. This action cannot be undone.</div>
			
			
		</div>
	</div>
	<!-- footer html-->
	<?php echo $footer; ?>
</div>
</body>
<script type="text/javascript"> 
function trim(str){ //删除左右两端的空格    
     return str.replace(/(^\s*)|(\s*$)/g, "");    
} 

function deleteTerm(vid, tid){
	if(confirm("确定要删除该分类吗？如果该分类有子分类，也将会被全部删除!")){
		$.ajax({
			type : "post",
			url : "<?php echo URL::to('taxonomy/taxonomy-delete-data'); ?>",
			async : false,
			data : {vid:vid, tid:tid},
			success : function(data){
				//pagelist.loadPage();
				window.location.href = window.location.href;
			}
		});
	}
	
}
</script>
</html>
