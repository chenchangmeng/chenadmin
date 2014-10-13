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
		<div class="col-xs-10 column">	
			<ul class="breadcrumb">
				<li>
					<a href="javascript:void(0);">当前位置</a> 
				</li>
				<li>
					<a href="javascript:void(0);">产品和服务</a> 
				</li>
				<li class="active">
					<?php echo $pData->name; ?>
				</li>
			</ul>	

			<div class="row clearfix">
				<div class="col-xs-12 column">

					<!-- 加载编辑器的容器 -->
					<label for="content" class="control-label"><h4><?php echo $pData->name; ?>详细信息：</h4></label>
					<?php echo Form::open(array('url' => '', 'method' => 'post',  'id'=>'career_add_form', 'name'=>'career_add_form'));  ?>
					    <input type="hidden" id="tid" name="tid" value="<?php echo $pData->tid;  ?>" />
					    <input type="hidden" id="newFlag" name="newFlag" value="<?php echo $newFlag; ?>" />
					    <script id="productInfo" name="productInfo" type="text/plain">
					        <?php if(isset($pBasicData->productInfo)){echo $pBasicData->productInfo;}  ?>
					    </script>
					    <!-- 配置文件 -->
					    <?php echo HTML::script('js/ueditor/ueditor.config-career.js'); ?>
					    <!-- 编辑器源码文件 -->
					    <?php echo HTML::script('js/ueditor/ueditor.all.min.js'); ?>
					    <!-- 实例化编辑器 -->
					    <script type="text/javascript">
					        var ue = UE.getEditor('productInfo');
					    </script>
					<?php echo Form::close();  ?>
				</div>
				<div class="col-xs-6 column">
					<div class="checkbox">
					  <label>
					    <input type="checkbox" onclick="onPromote(this.checked)" <?php if(isset($pBasicData->isPromote) && $pBasicData->isPromote == 1){echo "checked";}  ?> name="isPromote" id="isPromote" value="1">推送首页幻灯片						
					  </label>
					  <input type="hidden"  name="promoteUrl" id="promoteUrl" value="<?php if(isset($pBasicData->promoteUrl)){echo $pBasicData->promoteUrl;} ?>">
					</div>
					<div id="promoteDiv" style="display:<?php if(isset($pBasicData->isPromote) && $pBasicData->isPromote == 1){echo "block";}else{echo "none";}  ?>;" class="row clearfix">
						<div  class="col-md-10 column">
							<div class="fieldset flash" id="fsUploadProgress">
								<span class="legend">Promote Image</span>
								<div class="progressWrapper" id="promoteUrlID" style="opacity: 1;"><div class="progressContainer blue"><a class="progressCancel" href="#" style="visibility: hidden;"> </a><div></div><div class="progressBarStatus"><img id="promoteUrlDivImg" src="<?php if(isset($pBasicData->promoteUrl)){echo $pBasicData->promoteUrl;} ?>" height="<?php if(isset($pBasicData->promoteUrl) && $pBasicData->promoteUrl != ""){echo '80';}else{echo '0';} ?>" width="180" alt=""></div><div class="progressBarComplete"></div></div></div>

							</div>
						</div>
						<div class="col-md-2 column" >
							<div style="margin-top:10px;margin-right:10px;"><span  id="spanButtonPlaceHolder"></span></div>
							
						</div>
					</div>
				</div>
				<div class="col-xs-6 column">
					<div class="checkbox ">
						<label>
						    <input type="checkbox" onclick="onRecommend(this.checked)" name="isRecommend" id="isRecommend"  <?php if(isset($pBasicData->isRecommend) && $pBasicData->isRecommend == 1){echo "checked";}  ?> value="1" >
						    推送新闻头条
						</label>
						<input type="hidden"  name="recommendUrl" id="recommendUrl" value="<?php if(isset($pBasicData->recommendUrl)){echo $pBasicData->recommendUrl;} ?>">
					</div>

					<div id="recommendDiv" style="display:<?php if(isset($pBasicData->isRecommend) && $pBasicData->isRecommend == 1){echo "block";}else{echo "none";} ?>;" class="row clearfix">
						<div  class="col-md-10 column">
							<div class="fieldset flash" id="fsUploadProgressSticky">
								<span class="legend">Recommend Image</span>
								<div class="progressWrapper" id="recommendUrlID" style="opacity: 1;"><div class="progressContainer blue"><a class="progressCancel" href="#" style="visibility: hidden;"> </a><div></div><div class="progressBarStatus"><img id="recommendUrlDivImg" src="<?php if(isset($pBasicData->recommendUrl)){echo $pBasicData->recommendUrl;} ?>" height="<?php if(isset($pBasicData->recommendUrl)&&$pBasicData->recommendUrl != ""){echo '80';}else{echo '0';} ?>" width="180" alt=""></div><div class="progressBarComplete"></div></div></div>

							</div>
						</div>
						<div class="col-md-2 column" >
							<div style="margin-top:10px;5px;overflow:hidden;text-align:center;"><span  id="spanButtonPlaceHolderRecommend"></span></div>
							
						</div>
					</div>
				</div>

				<div class="col-xs-8 column" style="padding-top:10px;padding-left:12px;">
					<div class="tabs tabs-product">	
						<ul class="nav nav-tabs">
							<li class="active"><a href="#productDescription" data-toggle="tab">功能介绍</a></li>
							<li><a href="#productApply" data-toggle="tab">行业应用 </a></li>
							<li><a href="#productReviews" data-toggle="tab">用户案例</a></li>
						</ul>	
					</div>	
				</div>
				<div class="col-xs-4 column" style="padding-left:102px;padding-top:10px;">
					<a href="javascript:void(0);" onclick="saveInfo()" class="btn btn-primary btn-custom">
						<em class='glyphicon glyphicon-saved'></em>保存
					</a>
					<a href="<?php echo URL::to('product/product-info').'/'.$pData->tid.'/'.$pData->vid; ?>"  class="btn btn-primary btn-custom">
						<em class='glyphicon glyphicon-plus'></em>添加产品属性
					</a>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<div class="tabs tabs-product">
						
						<div class="tab-content">
							<div class="tab-pane active" id="productDescription">
								<?php
									if(isset($detailData[1])){
										foreach ($detailData[1] as $key => $value) {
								?>
								<section class="toggle ">
									<label>
										<?php echo $value->infoName;  ?>
										<span style="margin-left:50px;">创建时间：<?php echo $value->created_at; ?></span>&nbsp;&nbsp;
										<span><a href="<?php echo URL::to('product/product-info-update/'.$value->id.'/'.$pData->tid.'/'.$pData->vid); ?>" ><em class="glyphicon glyphicon-edit"></em>编辑</a></span>&nbsp;
										<span><a href="javascript:void(0);" onclick="DeleteProductInfo(<?php echo $value->id; ?>, <?php echo $pData->tid; ?>, <?php echo $pData->vid; ?>)"><em class='glyphicon glyphicon-remove'></em>删除</a></span>
									</label>
									<div class="toggle-content" style="margin-left:15px;">
										<?php echo $value->infoContent;  ?>										
									</div>
								</section>
								<?php
											# code...
										}
									}

								?>
							</div>
							<div class="tab-pane" id="productApply">
								<?php
									if(isset($detailData[2])){
										foreach ($detailData[2] as $key => $value) {
								?>
								<section class="toggle ">
									<label>
										<?php echo $value->infoName;  ?>
										<span style="margin-left:50px;">创建时间：<?php echo $value->created_at; ?></span>&nbsp;&nbsp;
										<span><a href="<?php echo URL::to('product/product-info-update/'.$value->id.'/'.$pData->tid.'/'.$pData->vid); ?>" ><em class="glyphicon glyphicon-edit"></em>编辑</a></span>&nbsp;
										<span><a href="javascript:void(0);" onclick="DeleteProductInfo(<?php echo $value->id; ?>, <?php echo $pData->tid; ?>, <?php echo $pData->vid; ?>)"><em class='glyphicon glyphicon-remove'></em>删除</a></span>
									</label>
									<div class="toggle-content" style="margin-left:15px;">
										<?php echo $value->infoContent;  ?>										
									</div>
								</section>
								<?php
											# code...
										}
									}

								?>
								
							</div>
							<div class="tab-pane" id="productReviews">
								<?php
									if(isset($detailData[3])){
										foreach ($detailData[3] as $key => $value) {
								?>
								<section class="toggle ">
									<label>
										<?php echo $value->infoName;  ?>
										<span style="margin-left:50px;">创建时间：<?php echo $value->created_at; ?></span>&nbsp;&nbsp;
										<span><a href="<?php echo URL::to('product/product-info-update/'.$value->id.'/'.$pData->tid.'/'.$pData->vid); ?>" ><em class="glyphicon glyphicon-edit"></em>编辑</a></span>&nbsp;
										<span><a href="javascript:void(0);" onclick="DeleteProductInfo(<?php echo $value->id; ?>, <?php echo $pData->tid; ?>, <?php echo $pData->vid; ?>)"><em class='glyphicon glyphicon-remove'></em>删除</a></span>
									</label>
									<div class="toggle-content" style="margin-left:15px;">
										<?php echo $value->infoContent;  ?>										
									</div>
								</section>
								<?php
											# code...
										}
									}

								?>	
							</div>
						</div>
					</div>
				</div>
			</div>
			
			
		</div>
	</div>
	<!-- footer html-->
	<?php echo $footer; ?>
</div>
</body>
<?php echo HTML::script('js/swfupload/swfupload.js'); ?>

<?php echo HTML::script('js/swfupload/js/swfupload.queue.js'); ?>
<?php echo HTML::script('js/swfupload/js/fileprogress.js'); ?>
<?php echo HTML::script('js/swfupload/js/handlers.js'); ?>

<?php echo HTML::script('js/theme.plugins.js'); ?>
<?php echo HTML::script('js/theme.js'); ?>


<script type="text/javascript">
var swfu;

window.onload = function() {
	var settings = {
		flash_url : "<?php echo HTML::swf('js/swfupload/Flash/swfupload.swf'); ?>",
		//flash_url : "http://192.168.2.70/swf/demos/swfupload/swfupload.swf",
		upload_url: "<?php echo URL::to('product/product-deal-img');  ?>",
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
		upload_url: "<?php echo URL::to('product/product-deal-img');  ?>",
		post_params: {"typeImg" : "recommendUrl"},
		file_size_limit : "1 MB",
		file_types : "*.jpg;*.png;*.gif;*.jpeg;",
		file_types_description : "All Files",
		file_upload_limit : 10,
		file_queue_limit : 10,
		custom_settings : {
			progressTarget : "fsUploadProgressSticky",
			cancelButtonId : "btnCancel"
		},
		//debug: true,

		// Button settings
		//button_image_url: "http://192.168.2.70/swf/demos/simpledemo/images/TestImageNoText_65x29.png",
		button_image_url: "<?php echo HTML::imageUrl('js/swfupload/TestImageNoText_65x29.png'); ?>",
		button_width: "65",
		button_height: "29",
		button_placeholder_id: "spanButtonPlaceHolderRecommend",
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

function saveInfo(){
	var  ll = document.getElementById("ueditor_textarea_productInfo");
	console.log(ll);
	if(ll){
		var v = ll.value;
		console.log(v);
		var tid = document.getElementById("tid").value;
		
		var isPromoteFlag = document.getElementById("isPromote");
		var isPromote = 0;
		if(isPromoteFlag.checked){
			isPromote = 1;
		}
		var promoteUrl = document.getElementById("promoteUrl").value;
		
		var isRecommendFlag = document.getElementById("isRecommend");
		var isRecommend = 0;
		if(isRecommendFlag.checked){
			isRecommend = 1;
		}
		var recommendUrl = document.getElementById("recommendUrl").value;

		var newFlag = document.getElementById("newFlag").value;
		if(v.length > 0){

			$.ajax({
				type : "post",
				url : "<?php echo URL::to('product/product-basic-data'); ?>",
				async : false,
				data : {newFlag:newFlag,tid:tid,v:v,isPromote:isPromote,promoteUrl:promoteUrl,isRecommend:isRecommend,recommendUrl:recommendUrl},
				success : function(data){
					if(data == "success"){
					   alert("保存信息成功");
					}else{
					   window.location.href = window.location.href;
					}
				}
			});

		}else{
			alert("请填写详细信息");
		}
	}else{
		alert("请填写详细信息");
	}
}

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

function onRecommend(bool){
	if(bool){
		document.getElementById('recommendDiv').style.display = "block";
	}else{
		document.getElementById('recommendUrlDivImg').src = "";
		document.getElementById('recommendUrlDivImg').height = 0;
		document.getElementById('recommendUrl').value = "";
		document.getElementById('recommendDiv').style.display = "none";
	}
}


function trim(str){ //删除左右两端的空格    
     return str.replace(/(^\s*)|(\s*$)/g, "");    
} 


function DeleteProductInfo(id, tid, vid){
	if(confirm("确定要删除该属性吗？")){
		window.location.href = "<?php echo URL::to('product/product-info-delete/'); ?>/" + id + "/" + tid + "/" + vid;
	}
}

</script>
</html>
