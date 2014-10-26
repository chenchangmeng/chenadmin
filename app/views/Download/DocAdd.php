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
					手册添加
				</li>
			</ul>	

			<div class="row clearfix">
				<div class="col-md-7 column">
					
				</div>
				<div class="col-md-5 column" >
					
				</div>
			</div>
			<?php echo Form::open(array('url' => 'download/doc-add-data', 'method' => 'post', 'class'=>'form-horizontal', 'id'=>'doc_add_form'));  ?>
				<div class="form-group">
					<label for="docName" class="col-sm-2 control-label">手册名称<span class="asterisk-tip">*</span>：</label>
					<div class="col-xs-7" id="docName_mess">
						<input type="text" class="form-control operate-form"  maxlength="80" name="docName" id="docName" />
					</div>
				</div>
				<div class="form-group">
					<label for="docDownloadName" class="col-sm-2 control-label">文件名称：</label>
					<div class="col-xs-7" id="docDownloadName_mess">
						
						<select name="docDownloadName" id="docDownloadName" class="form-control operate-form">
								<option value="" >--请选择--</option>
								<?php foreach ($docFile as $key => $value) {
								?>
									<option value="<?php echo $value; ?>" ><?php echo $value; ?></option>
								<?php
								} ?>
								
						</select> 
					</div>
				</div>

				<div class="form-group">
					<label for="docType" class="col-sm-2 control-label">分类：</label>
					<div class="col-xs-7" id="docType_mess">
						<select name="docType" id="docType" class="form-control operate-form">
								<option value="" >--请选择--</option>
								<?php foreach ($docMenu as $key => $value) {
								?>
									<option value="<?php echo $value->tid; ?>" ><?php echo $value->path_level.$value->name; ?></option>
								<?php
								} ?>
								
						</select> 
					</div>
				</div>
				
				<div class="form-group">
					<label for="sort" class="col-sm-2 control-label">排序：</label>
					<div class="col-xs-7" id="sort_mess">
						<input type="text" class="form-control operate-form" maxlength="3" name="sort" id="sort" >
					</div>
				</div>
					
				<div class="form-group">
					<div class="col-sm-offset-2 col-xs-5">
						 <button type="submit" class="btn btn-success custom-news-btn">添加</button>
					</div>
				</div>
			<?php echo Form::close();  ?>		
			
		</div>
	</div>
	<!-- footer html-->
	<?php echo $footer; ?>
</div>

<script type="text/javascript">

$("#doc_add_form").validate({
	//debug:true,
	rules:{		
		docName : {
			required : true,
			
		},
		docDownloadName : {
			required : true,
			
		},
		docType : {
			required : true,
		},
		sort : {
			number: true
		}

		
		
	},
	messages:{
		docName : {
			required : "请填手册名称"
		},
		docDownloadName : {
			required : "请选择文件名称"
		},
		docType : {
			required : "请选择分类",
		},
		sort: {
			number: "请填写数字"
		}
	},
	errorClass : "error-message",
	errorPlacement: function(error, element) {  
	    error.insertAfter("#" + element.context.attributes.name.nodeValue + "_mess");
	    //console.log(element.context.attributes.name.nodeValue);
	}
});
</script>
</body>
</html>
