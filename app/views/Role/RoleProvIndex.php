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
					<a href="javascript:void(0);">用户管理</a> 
				</li>
				<li class="active">
					授权
				</li>
			</ul>	

			<div class="row clearfix">
				<div class="col-xs-12 column">
					<?php echo Form::open(array('url' => 'role/role-prov-data', 'method' => 'post', 'class'=>'form-horizontal', 'id'=>''));  ?>
					<input type="hidden" name="roleId" value="<?php echo $roleId; ?>" />
					<input type="hidden" name="provIDS" id="provIDS" value="<?php echo $roleProvData['provIDS']; ?>" />
					<input type="hidden" name="unProvIDS" id="unProvIDS" value="<?php echo $roleProvData['unProvIDS']; ?>" />
					<table class="table">
						<?php $i = 0; ?>
						<?php foreach ($roleProvData['tempData'] as $key => $value) { ?>
							<?php echo $i == 1 ? "<tr class='active'>" : "<tr>"; ?>	
								<td>
									<div class="checkbox">
									    <label>
									      <input type="checkbox" <?php if($value['roleProv'] == 1){echo 'checked';} ?> name="ids[]" value="<?php echo $value['id']; ?>"/>
											<?php echo $value['provNodeName'];?>
									    </label>
									</div>
								</td>
							</tr>
						<?php $i = 1 - $i; ?>
					<?php } ?>
					<tr>
						<td>
							<div class="form-group">
								<div class="col-sm-offset-2 col-xs-5">
									 <button type="submit" class="btn btn-success custom-news-btn">授权</button>
								</div>
							</div>
						</td>
					</tr>
					</table>
					<?php echo Form::close();  ?>	
				</div>
				
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

</script>
</html>
