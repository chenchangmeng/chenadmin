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
					<a href="javascript:void(0);">内容管理</a> 
				</li>
				<li class="active">
					<?php echo $tagMenu;  ?>修改
				</li>
			</ul>	

			<div class="row clearfix">
				<div class="col-md-7 column">
					
				</div>
				<div class="col-md-5 column" >
					
				</div>
			</div>
			<?php echo Form::open(array('url' => 'customer/customer-update-data', 'method' => 'post', 'class'=>'form-horizontal', 'id'=>'customer_update_form'));  ?>
				<input type="hidden" name="otid" id="otid" value="<?php echo $tid;  ?>" />
				<input type="hidden" name="id" id="id" value="<?php echo $currData[0]->id; ?>" />
				<div class="form-group">
					<label for="name" class="col-sm-2 control-label">客户名称<span class="asterisk-tip">*</span>：</label>
					<div class="col-xs-7" id="name_mess">
						<input type="text" value="<?php echo $currData[0]->name; ?>" class="form-control operate-form" maxlength="50" name="name" id="name" />
					</div>
				</div>

				<div class="form-group">
					<label for="real_name" class="col-sm-2 control-label"></label>
					<input type="hidden"  name="customerUrl" id="customerUrl" value="<?php echo $currData[0]->customerUrl; ?>">
					<div class="col-xs-7" id="customer_mess">
						<div id="partnetDiv" class="row clearfix">
							<div  class="col-md-10 column">
								<div class="fieldset customer" id="fsUploadProgress">
									<span class="legend">Customer Logo</span>
									<div class="progressWrapper" id="customerUrlID" style="opacity: 1;"><div class="progressContainer blue"><a class="progressCancel" href="#" style="visibility: hidden;"> </a><div></div><div class="progressBarStatus"><img id="customerUrlDivImg" src="<?php echo $currData[0]->customerUrl; ?>" height="80" width="180" alt=""></div><div class="progressBarComplete"></div></div></div>													

								</div>
							</div>
							<div class="col-md-2 column" >
								<div style="margin-top:10px;margin-right:10px;"><span  id="spanButtonPlaceHolder"></span></div>
								
							</div>
						</div>
					</div>
				</div>

				<?php
					if(isset($childData) && !empty($childData)){
				?>
					<div class="form-group">
						<label for="typeId" class="col-sm-2 control-label">行业分类：</label>
						<div class="col-xs-7" id="typeId_mess">
							<select name="typeId" id="typeId" class="form-control operate-form">
									<option value="" >--请选择--</option>
									<?php foreach ($childData as $key => $value) { ?>
										<option <?php if($value->tid == $currData[0]->tid){echo "selected";} ?> value="<?php echo $value->tid; ?>" ><?php echo $value->name; ?></option>
									<?php }  ?>
									
							</select> 
						</div>
					</div>
				<?php
					}else{
				?>
					<div class="form-group">
						<label for="typeId" class="col-sm-2 control-label">行业分类：</label>
						<div class="col-xs-7" id="typeId_mess">
							<select name="typeId" id="typeId" class="form-control operate-form">
									<option value="<?php echo $tid; ?>" ><?php echo $tagMenu;  ?></option>		
							</select> 
						</div>
					</div>

				<?php 

					}
				?>

				<div class="form-group">
					<label for="url" class="col-sm-2 control-label">Url：</label>
					<div class="col-xs-7" id="url_mess">
						<input type="text" value="<?php echo $currData[0]->url; ?>" class="form-control operate-form" maxlength="150" name="url" id="url" />
					</div>
				</div>

				<div class="form-group">
					<label for="sort" class="col-sm-2 control-label">排序：</label>
					<div class="col-xs-7" id="sort_mess">
						<input type="text" value="<?php echo $currData[0]->sort; ?>" class="form-control operate-form" maxlength="3" name="sort" id="sort" />
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
var swfu;

window.onload = function() {
	var settings = {
		flash_url : "<?php echo HTML::swf('js/swfupload/Flash/swfupload.swf'); ?>",
		//flash_url : "http://192.168.2.70/swf/demos/swfupload/swfupload.swf",
		upload_url: "<?php echo URL::to('customer/customer-deal-img');  ?>",
		post_params: {"typeImg" : "customerUrl"},
		file_size_limit : "1 MB",
		file_types : "*.jpg;*.png;*.gif;*.jpeg;",
		file_types_description : "All Files",
		file_upload_limit : 10,
		file_queue_limit : 10,
		custom_settings : {
			progressTarget : "fsUploadProgress",
			cancelButtonId : "btnCancel"
		},
		//debug: true,

		// Button settings
		//button_image_url: "http://192.168.2.70/swf/demos/simpledemo/images/TestImageNoText_65x29.png",
		button_image_url: "<?php echo HTML::imageUrl('js/swfupload/TestImageNoText_65x29.png'); ?>",
		button_width: "65",
		button_height: "29",
		button_placeholder_id: "spanButtonPlaceHolder",
		button_text: '<span class="theFont">上传</span>',
		button_text_style: ".theFont { font-size: 16; }",
		button_text_left_padding: 12,
		button_text_top_padding: 3,
		
		// The event handler functions are defined in handlers.js
		file_queued_handler : fileQueued,
		file_queue_error_handler : fileQueueError,
		file_dialog_complete_handler : fileDialogComplete,
		upload_start_handler : uploadStart,
		upload_progress_handler : uploadProgress,
		upload_error_handler : uploadError,
		upload_success_handler : uploadSuccess,
		upload_complete_handler : uploadComplete,
		queue_complete_handler : queueComplete	// Queue plugin event
	};

	swfu = new SWFUpload(settings);
}
</script>



<script type="text/javascript">
$("#customer_update_form").validate({
	//debug:true,
	rules:{		
		name : {
			required : true
		},
		typeId : {
 			required : true
		},
		url : {
			url: true
		},
		sort : {
			number: true
		}

		
		
	},
	messages:{
		name : {
			required : "请填写客户名称"
		},
		typeId : {
 			required : "请选择行业分类"
		},
		url : {
			url: "请填写正确的链接"
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
