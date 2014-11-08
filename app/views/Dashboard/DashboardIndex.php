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
					<a href="javascript:void(0);">控制面板</a> 
				</li>
				<li class="active">
					网站配置
				</li>
			</ul>	

			<div class="row clearfix">
				<div class="col-md-7 column">
					
				</div>
				<div class="col-md-5 column" >
					
				</div>
			</div>
			<?php echo Form::open(array('url' => 'dashboard/dashboard-config-data', 'method' => 'post', 'class'=>'form-horizontal', 'id'=>'partner_add_form'));  ?>
				<input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />
				<div class="form-group">
					<label for="companyName" class="col-sm-2 control-label">公司名称：</label>
					<div class="col-xs-7" id="companyName_mess">
						<input type="text" value="<?php if(isset($content['companyName'])){echo $content['companyName'];} ?>" class="form-control operate-form" maxlength="32" name="companyName" id="companyName" />
					</div>
				</div>

				<div class="form-group">
					<label for="companyMobile" class="col-sm-2 control-label">公司电话：</label>
					<div class="col-xs-7" id="companyMobile_mess">
						<input type="text" value="<?php if(isset($content['companyMobile'])){echo $content['companyMobile'];} ?>" class="form-control operate-form" maxlength="20" name="companyMobile" id="companyMobile" />
					</div>
				</div>

				<div class="form-group">
					<label for="companyAddress" class="col-sm-2 control-label">公司地址：</label>
					<div class="col-xs-7" id="companyAddress_mess">
						<input type="text" value="<?php if(isset($content['companyAddress'])){echo $content['companyAddress'];} ?>" class="form-control operate-form" maxlength="20" name="companyAddress" id="companyAddress" />
					</div>
				</div>

				<div class="form-group">
					<label for="companyEmailFrom" class="col-sm-2 control-label">发件人：</label>
					<div class="col-xs-7" id="companyEmailFrom_mess">
						<input type="text" value="<?php if(isset($content['companyEmailFrom'])){echo $content['companyEmailFrom'];} ?>" class="form-control operate-form" maxlength="50" name="companyEmailFrom" id="companyEmailFrom" />
					</div>
				</div>

				<div class="form-group">
					<label for="companyEmail" class="col-sm-2 control-label">公司邮箱：</label>
					<div class="col-xs-7" id="companyEmail_mess">
						<input type="text" value="<?php if(isset($content['companyEmail'])){echo $content['companyEmail'];} ?>" class="form-control operate-form" maxlength="80" name="companyEmail" id="companyEmail" />
					</div>
				</div>
				<div class="form-group">
					<label for="companyInfo" class="col-sm-2 control-label">公司简介：</label>
					<div class="col-xs-7" id="companyInfo_mess">
						<textarea class="form-control" rows="6" name="companyInfo" id="companyInfo"><?php if(isset($content['companyInfo'])){echo $content['companyInfo'];} ?></textarea>
						
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
<?php echo HTML::script('js/jquery-ui.min.js'); ?>


<?php echo HTML::script('js/swfupload/swfupload.js'); ?>

<?php echo HTML::script('js/swfupload/js/swfupload.queue.js'); ?>
<?php echo HTML::script('js/swfupload/js/fileprogress.js'); ?>
<?php echo HTML::script('js/swfupload/js/handlers.js'); ?>

<script type="text/javascript">
$("#partner_add_form").validate({
	//debug:true,
	rules:{		
		brandName : {
			required : true,
			
		},
		sort : {
			number: true
		}

		
		
	},
	messages:{
		brandName : {
			required : "请填写伙伴名称"
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
