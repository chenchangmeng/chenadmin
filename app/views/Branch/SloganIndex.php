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
					名人名言列表
				</li>
			</ul>	

			<div class="row clearfix">
				<div class="col-xs-8 column">

				</div>
				<div class="col-xs-4 column" >
					<div class="navbar-cus-a">
						<a href="<?php echo URL::to('branch/slogan-add'); ?>"  class="btn btn-primary btn-custom">
							<em class='glyphicon glyphicon-plus'></em>添加名人名言
						</a>
					</div>

				</div>
			</div>

			<div id="list_content_div">
				<table class="table">
					<thead>
						<tr>
							<th>
								姓名
							</th>
							<th>
								Img
							</th>
							<th>
								职位
							</th>
							<th>
								公司
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
						<?php foreach($sloganData as $value){ ?>
							<?php echo $i == 1 ? "<tr class='active'>" : "<tr>"; ?>	
								<td>
										<?php echo $value->name; ?></a>
								</td>
								<td>
									<?php if($value->sloganUrl){ ?>
										<img src="<?php echo $value->sloganUrl; ?>" width="80" height="40" title="<?php echo $value->slogan; ?>" />
									<?php } ?>
								</td>
								<td><?php echo $value->position; ?></td>
								<td><?php echo $value->company; ?></td>
								<td><?php echo $value->created_at; ?></td>
								<td>
									<a href="<?php echo URL::to('branch/slogan-update/'.$value->id); ?>"><em class="glyphicon glyphicon-edit"></em>编辑</a>/
									<a href="javascript:void(0);" onclick="DeleteSlogan(<?php echo $value->id; ?>)"><em class='glyphicon glyphicon-remove'></em>删除</a>
								</td>
								
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
</body>
<script type="text/javascript"> 
function trim(str){ //删除左右两端的空格    
     return str.replace(/(^\s*)|(\s*$)/g, "");    
} 

function DeleteSlogan(id){
	if(confirm("确定要删除该内容吗？")){
		window.location.href = "<?php echo URL::to('branch/slogan-delete/'); ?>/" + id;
	}
}

</script>
</html>
