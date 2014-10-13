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
				<div class="col-md-7 column">
					
				</div>
				<div class="col-md-5 column" >
					
				</div>
			</div>
			<?php echo Form::open(array('url' => 'news/news-update-data', 'method' => 'post', 'class'=>'form-horizontal', 'id'=>'news_add_form', 'name'=>'news_add_form', 'enctype'=>'multipart/form-data'));  ?>
				<input type="hidden" name="nid" value="<?php echo $resultData[0]->nid; ?>" />
				<div class="form-group">
					<label for="title" class="col-sm-1 control-label">标题<span class="asterisk-tip">*</span></label>
					<div class="col-xs-7" id="title_mess">
						<input type="text" value="<?php echo $resultData[0]->title; ?>" class="form-control operate-form" maxlength="150" name="title" id="title" />
					</div>
				</div>
				<div class="form-group">
					<label for="subTitle" class="col-sm-1 control-label">子标题</label>
					<div class="col-xs-7" id="subTitle_mess">
						<input type="text" value="<?php echo $resultData[0]->subTitle; ?>" class="form-control operate-form" maxlength="150" name="subTitle" id="subTitle" />
					</div>
				</div>

				<!-- <div class="form-group">
					<label for="tags" class="col-sm-1 control-label">Tags</label>
					<div class="col-xs-7" id="tags_mess">
						<input type="text" class="form-control operate-form" maxlength="150" name="tags" id="tags" />
					</div>
				</div> -->

				<div class="form-group">
					<label for="user_name" class="col-sm-1 control-label">概要</label>
					<div class="col-xs-7" id="overview_mess">
						
					    <textarea name="overview" class="form-control operate-form"><?php echo $resultData[0]->overview; ?></textarea>
					</div>
				</div>

				<div class="form-group">
					<label for="user_name" class="col-sm-1 control-label">内容</label>
					<div class="col-xs-7" id="user_name_mess">
						<!-- 加载编辑器的容器 -->
					    <script id="container" name="content" type="text/plain">
					        <?php echo $resultData[0]->content; ?>
					    </script>
					    <!-- 配置文件 -->
					    <?php echo HTML::script('js/ueditor/ueditor.config.js'); ?>
					    <!-- 编辑器源码文件 -->
					    <?php echo HTML::script('js/ueditor/ueditor.all.min.js'); ?>
					    <!-- 实例化编辑器 -->
					    <script type="text/javascript">
					        var ue = UE.getEditor('container');
					    </script>
					</div>
				</div>

				<div class="col-xs-8 custom-news-col-xs-8">
					<div class="tabs tabs-vertical tabs-left">
						<ul class="nav nav-tabs col-sm-2">
							<li class="active">
								<a href="#recent11" data-toggle="tab">基本设置</a>
							</li>
							<li>
								<a href="#author11" data-toggle="tab">作者信息</a>
							</li>
							
							<li>
								<a href="#comment11" data-toggle="tab">评论设置</a>
							</li>
							<li>
								<a href="#popular11" data-toggle="tab">文章设置</a>
							</li>
						</ul>
						<div class="tab-content">
							<div id="recent11" class="tab-pane active">
								<fieldset class="tabs-fieldset">
									<label>点击数：</label>
									<input type="text" value="<?php echo $resultData[0]->readNums; ?>" name="readNums" value="100" class="form-control operate-form"/>
									<label>排序：</label>
									<input type="text" value="<?php echo $resultData[0]->sort; ?>" name="sort" class="form-control operate-form"/>
									<label>分类信息：</label>
									<select name="pid" id="pid" class="form-control operate-form">
											<option value="0" >----</option>
											
									</select> 

								</fieldset>
							</div>

							<div id="author11" class="tab-pane">
								<fieldset class="tabs-fieldset">
									<label>文章作者：</label>
									<input type="text" value="<?php echo $resultData[0]->author; ?>" name="author" class="form-control operate-form"/>

									<label>发布日期：</label>
									<input type="text" value="<?php echo $resultData[0]->publishedTime; ?>" name="publishedTime" id="publishedTime" class="form-control operate-form"/>

								</fieldset>
							</div>
							<div id="comment11" class="tab-pane">
								<fieldset class="tabs-fieldset">
									<div class="radio">
									  <label>
									    <input type="radio" <?php if($resultData[0]->isComment == 1){echo 'checked';} ?> name="isComment" id="isComment" value="1" >
									    开启评论
									  </label>
									</div>
									<div class="radio">
									  <label>
									    <input type="radio" <?php if($resultData[0]->isComment == 0){echo 'checked';} ?> name="isComment" id="isComment" value="0">
									    关闭评论
									  </label>
									</div>

								</fieldset>
							</div>
							<div id="popular11" class="tab-pane">
								<fieldset class="tabs-fieldset">
									
									<div class="checkbox">
									  <label>
									    <input type="checkbox" <?php if($resultData[0]->promote == 1){echo 'checked';} ?> onclick="onPromote(this.checked)" name="promote" value="1">推送首页幻灯片						
									  </label>
									  <input type="hidden"  name="promoteUrl" value="<?php echo $resultData[0]->promoteUrl; ?>" id="promoteUrl" value="">
									</div>
									<div id="promoteDiv" style="display:<?php if($resultData[0]->promote == 1){echo 'block';}else{echo 'none';} ?>;" class="row clearfix">
										<div  class="col-md-10 column">
											<div class="fieldset flash" id="fsUploadProgress">
												<span class="legend">Promote Image</span>
												
												<div class="progressWrapper" id="promoteUrlID" style="opacity: 1;"><div class="progressContainer blue"><a class="progressCancel" href="#" style="visibility: hidden;"> </a><div></div><div class="progressBarStatus"><img id="promoteUrlDivImg" src="<?php echo $resultData[0]->promoteUrl; ?>" height="80" width="180" alt=""></div><div class="progressBarComplete"></div></div></div>
											
											</div>
										</div>
										<div class="col-md-2 column" >
											<div style="margin-top:10px;margin-right:10px;"><span  id="spanButtonPlaceHolder"></span></div>
										</div>
									</div>
									
									
									<div class="checkbox ">
									  <label>
									    <input type="checkbox"  <?php if($resultData[0]->sticky == 1){echo 'checked';} ?> onclick="onsticky(this.checked)" name="sticky" value="1" >
									    推送新闻头条
									  </label>
									  <input type="hidden" value="<?php echo $resultData[0]->stickyUrl; ?>"  name="stickyUrl" id="stickyUrl" value="">
									</div>

									<div id="stickyDiv" style="display:<?php if($resultData[0]->sticky == 1){echo 'block';}else{echo 'none';} ?>;" class="row clearfix">
										<div  class="col-md-10 column">
											<div class="fieldset flash" id="fsUploadProgressSticky">
												<span class="legend">Sticky Image</span>
												
												<div class="progressWrapper" id="stickyUrlID" style="opacity: 1;"><div class="progressContainer blue"><a class="progressCancel" href="#" style="visibility: hidden;"> </a><div></div><div class="progressBarStatus"><img id="stickyUrlDivImg" src="<?php echo $resultData[0]->stickyUrl; ?>" height="80" width="180" alt=""></div><div class="progressBarComplete"></div></div></div>

											</div>
										</div>
										<div class="col-md-2 column" >
											<div style="margin-top:10px;margin-right:10px;"><span  id="spanButtonPlaceHolderSticky"></span></div>
										</div>
									</div>


									<div class="checkbox ">
									  <label>
									    <input type="checkbox" <?php if($resultData[0]->published == 1){echo 'checked';} ?> name="published" value="1">
									    是否发布
									  </label>
									</div>
								</fieldset>
							</div>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-2 col-xs-5 custom-news-col-sm-offset">
						 <button type="submit" class="btn btn-success custom-news-btn">修改</button>
					</div>
				</div>
			<?php echo Form::close();  ?>		
			
		</div>
	</div>
	<!-- footer html-->
	<?php echo $footer; ?>
</div>
<?php echo HTML::script('js/jquery.min.js'); ?>
<?php echo HTML::script('js/jquery.validate.js'); ?>
<?php echo HTML::script('js/bootstrap.min.js'); ?>
<?php echo HTML::script('js/scripts.js'); ?>

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
		upload_url: "<?php echo URL::to('news/news-deal-img');  ?>",
		post_params: {"typeImg" : "promoteUrl"},
		file_size_limit : "1 MB",
		file_types : "*.jpg;*.png;*.gif;*.jpeg;",
		file_types_description : "All Files",
		file_upload_limit : 10,
		file_queue_limit : 10,
		custom_settings : {
			progressTarget : "fsUploadProgress",
			cancelButtonId : "btnCancel"
		},
		debug: false,

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

	// var settings_2 = settings;
	// settings_2.button_placeholder_id = "spanButtonPlaceHolderSticky";
	// //settings_2.custom_settings.progressTarget = "fsUploadProgressSticky";
	// settings_2.post_params= {"typeImg" : "stickyUrl"};
	// settings_2.custom_settings = {
	// 		progressTarget : "fsUploadProgressSticky",
	// 		cancelButtonId : "btnCancel"
	// };
	var settings_2 = {
		flash_url : "<?php echo HTML::swf('js/swfupload/Flash/swfupload.swf'); ?>",
		//flash_url : "http://192.168.2.70/swf/demos/swfupload/swfupload.swf",
		upload_url: "<?php echo URL::to('news/news-deal-img');  ?>",
		post_params: {"typeImg" : "stickyUrl"},
		file_size_limit : "1 MB",
		file_types : "*.jpg;*.png;*.gif;*.jpeg;",
		file_types_description : "All Files",
		file_upload_limit : 10,
		file_queue_limit : 10,
		custom_settings : {
			progressTarget : "fsUploadProgressSticky",
			cancelButtonId : "btnCancel"
		},
		debug: false,

		// Button settings
		//button_image_url: "http://192.168.2.70/swf/demos/simpledemo/images/TestImageNoText_65x29.png",
		button_image_url: "<?php echo HTML::imageUrl('js/swfupload/TestImageNoText_65x29.png'); ?>",
		button_width: "65",
		button_height: "29",
		button_placeholder_id: "spanButtonPlaceHolderSticky",
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
	swfu_2 = new SWFUpload(settings_2);

	//console.log(swfu);
 };


</script>

<script type="text/javascript">
$("#news_update_form").validate({
	debug:true,
	rules:{		
		title : {
			required : true,
		}		
	},
	messages:{
		title : {
			required : "请填写标题"
		}
	},
	errorClass : "error-message",
	errorPlacement: function(error, element) {  
	    error.insertAfter("#" + element.context.attributes.name.nodeValue + "_mess");
	    //console.log(element.context.attributes.name.nodeValue);
	}
});


$( "#publishedTime" ).datepicker({
	inline: true,
	dateFormat : "yy-mm-dd"
});


function onPromote(bool){
	if(bool){
		document.getElementById('promoteDiv').style.display = "block";
	}else{
		document.getElementById('promoteUrlDivImg').src = "";
		document.getElementById('promoteUrlDivImg').height = 0;
		document.getElementById('promoteUrl').value = "";
		document.getElementById('promoteDiv').style.display = "none";
	}
}

function onsticky(bool){
	if(bool){
		document.getElementById('stickyDiv').style.display = "block";
	}else{
		document.getElementById('stickyUrlDivImg').src = "";
		document.getElementById('stickyUrlDivImg').height = 0;
		document.getElementById('stickyUrl').value = "";
		document.getElementById('stickyDiv').style.display = "none";
	}
}
</script>
</body>
</html>
