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
					分支机构修改
				</li>
			</ul>	

			<div class="row clearfix">
				<div class="col-md-7 column">
					
				</div>
				<div class="col-md-5 column" >
					
				</div>
			</div>
			<?php echo Form::open(array('url' => 'branch/branch-update-data', 'method' => 'post', 'class'=>'form-horizontal', 'id'=>'branch_update_form'));  ?>
			<input type="hidden" id="id" name="id" value="<?php echo $resultData[0]->id; ?>" />
				<div class="form-group">
					<label for="branchName" class="col-sm-1 control-label">名称：</label>
					<div class="col-xs-7" id="branchName_mess">
						<input value="<?php echo $resultData[0]->branchName; ?>" type="text" class="form-control operate-form" maxlength="32" name="branchName" id="branchName" />
					</div>
				</div>

				<div class="form-group">
					<label for="real_name" class="col-sm-1 control-label"></label>
					<input type="hidden"  name="branchUrl" id="branchUrl" value="<?php echo $resultData[0]->branchImgUrl; ?>">
					<div class="col-xs-7" id="real_name_mess">
						<div id="branchDiv" class="row clearfix">
							<div  class="col-md-10 column">
								<div class="fieldset partner" id="fsUploadProgress">
									<span class="legend">Branch Logo</span>
												<div class="progressWrapper" id="branchUrlID" style="opacity: 1;"><div class="progressContainer blue"><a class="progressCancel" href="#" style="visibility: hidden;"> </a><div></div><div class="progressBarStatus"><img id="branchUrlDivImg" src="<?php echo $resultData[0]->branchImgUrl; ?>" height="80" width="180" alt=""></div><div class="progressBarComplete"></div></div></div>

								</div>
							</div>
							<div class="col-md-2 column" >
								<div style="margin-top:10px;margin-right:10px;"><span  id="spanButtonPlaceHolder"></span></div>
								
							</div>
						</div>
					</div>
				</div>

				<div class="form-group">
					<label for="code" class="col-sm-1 control-label">邮编：</label>
					<div class="col-xs-7" id="code_mess">
						<input value="<?php echo $resultData[0]->code; ?>" type="text" class="form-control operate-form" maxlength="20" name="code" id="code" />
					</div>
				</div>

				<div class="form-group">
					<label for="mobile" class="col-sm-1 control-label">电话：</label>
					<div class="col-xs-7" id="mobile_mess">
						<input value="<?php echo $resultData[0]->mobile; ?>" type="text" class="form-control operate-form" maxlength="20" name="mobile" id="mobile" />
					</div>
				</div>

				<div class="form-group">
					<label for="fax" class="col-sm-1 control-label">传真：</label>
					<div class="col-xs-7" id="fax_mess">
						<input value="<?php echo $resultData[0]->fax; ?>" type="text" class="form-control operate-form" maxlength="20" name="fax" id="fax" />
					</div>
				</div>

				<div class="form-group">
					<label for="email" class="col-sm-1 control-label">邮箱：</label>
					<div class="col-xs-7" id="email_mess">
						<input value="<?php echo $resultData[0]->email; ?>" type="text" class="form-control operate-form" maxlength="80" name="email" id="email" />
					</div>
				</div>

				<div class="form-group">
					<label for="url" class="col-sm-1 control-label">官网：</label>
					<div class="col-xs-7" id="url_mess">
						<input value="<?php echo $resultData[0]->url; ?>" type="text" class="form-control operate-form" maxlength="80" name="url" id="url" />
					</div>
				</div>


				<div class="form-group">
					<label for="sort" class="col-sm-1 control-label">排序：</label>
					<div class="col-xs-7" id="sort_mess">
						<input value="<?php echo $resultData[0]->sort; ?>" type="text" class="form-control operate-form" maxlength="3" name="sort" id="sort" />
					</div>
				</div>

				<div class="form-group">
					<label for="address" class="col-sm-1 control-label">地址：</label>
					<div class="col-xs-7" id="address_mess">
						<input value="<?php echo $resultData[0]->address; ?>" type="text" class="form-control operate-form" maxlength="120" name="address" id="address" />
					</div>
				</div>
												
				<div class="form-group">
					<div class="col-sm-offset-2 col-xs-5">
						 <button type="submit" class="btn btn-success custom-news-btn">修改</button>
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
		upload_url: "<?php echo URL::to('branch/branch-deal-img');  ?>",
		post_params: {"typeImg" : "branchUrl"},
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
$("#branch_update_form").validate({
	//debug:true,
	rules:{		
		branchName : {
			required : true,
			
		},
		email : {
			email: true
		},
		url : {
			url: true
		},
		sort : {
			number: true
		}

		
		
	},
	messages:{
		branchName : {
			required : "请填写分支机构名称"
		},
		email : {
			email: "请填写正确的邮箱地址"
		},
		url : {
			url: "请填写正确的官网Url"
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
