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

	<?php echo HTML::style('css/theme-element.css'); ?>

	<?php echo HTML::style('css/jquery-ui.css'); ?>

	<?php echo HTML::script('js/jquery.min.js'); ?>
	<?php echo HTML::script('js/jquery.validate.js'); ?>
	<?php echo HTML::script('js/bootstrap.min.js'); ?>
	<?php echo HTML::script('js/scripts.js'); ?>
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
					<a href="javascript:void(0);">产品和服务</a> 
				</li>
				<li class="active">
					会员导入
				</li>
			</ul>	

			<div class="row clearfix">
				<div class="col-md-7 column">
					
				</div>
				<div class="col-md-5 column" >
					
				</div>
			</div>
			<?php echo Form::open(array('url' => 'member/deal-member-export', 'method' => 'post', 'class'=>'form-horizontal', 'id'=>'member_import_form'));  ?>
				<div class="form-group">
					<label for="email" class="col-sm-2 control-label">Email：</label>
					<div class="col-xs-7" id="email_mess">
						<input type="text" class="form-control operate-form" maxlength="80" name="email" id="email" />
					</div>
				</div>	
				<div class="form-group">
					 <label for="memberType" class="col-sm-2 control-label">会员类别：</label>
					 <div class="col-xs-7" id="memberType_mess">
						 <select name="memberType" id="memberType" class="form-control operate-form">
						 	<option value="">----</option>
						 	<?php foreach ($memberTypeData as $key => $value) { ?>
						 		<option value="<?php echo $value->memberType; ?>"><?php echo $value->memberType; ?></option>
						 	<?php } ?>
						 </select>
					</div>
				</div>
				<div class="form-group">
					<label for="fromType" class="col-sm-2 control-label">来源：</label>
					<div class="col-xs-7" id="fromType_mess">
						<select name="fromType" id="fromType" class="form-control operate-form">
						 	<option value="">----</option>
						 	<option value="importExcel">importExcel</option>
						 	<option value="registerWeb">registerWeb</option>
						</select>
					</div>
				</div>				
				<div class="form-group">
					<div class="col-sm-offset-2 col-xs-5">
						 <button type="submit" class="btn btn-success custom-news-btn">导出数据</button>
					</div>
				</div>
			<?php echo Form::close();  ?>		
			
		</div>
	</div>
	<!-- footer html-->
	<?php echo $footer; ?>
</div>
</body>
</html>
