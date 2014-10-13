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
					职位信息添加
				</li>
			</ul>	

			<div class="row clearfix">
				<div class="col-md-7 column">
					
				</div>
				<div class="col-md-5 column" >
					
				</div>
			</div>
			<?php echo Form::open(array('url' => 'career/career-update-data', 'method' => 'post', 'class'=>'form-horizontal', 'id'=>'career_update_form'));  ?>
				<input type="hidden" name="id" id="id" value="<?php echo $resultData[0]->id; ?>" />
				<div class="form-group">
					<label for="careerName" class="col-sm-2 control-label">职位名称<span class="asterisk-tip">*</span>：</label>
					<div class="col-xs-7" id="careerName_mess">
						<input type="text" value="<?php echo $resultData[0]->careerName; ?>" class="form-control operate-form" maxlength="80" name="careerName" id="careerName" />
					</div>
				</div>
				<div class="form-group">
					<label for="subTitle" class="col-sm-2 control-label">状态：</label>
					<div class="col-xs-7" id="careerName_mess">
					    <input type="radio" <?php if($resultData[0]->status == 1){echo "checked";} ?>  name="status" id="status_1" value="1" >
					    开启
					    <input type="radio" <?php if($resultData[0]->status == 0){echo "checked";} ?>  name="status" id="status_2" value="0" >
					    禁用
					</div>
				</div>
				<div class="form-group">
					<label for="sort" class="col-sm-2 control-label">排序：</label>
					<div class="col-xs-7" id="sort_mess">
						<input type="text" value="<?php echo $resultData[0]->sort; ?>" class="form-control operate-form" maxlength="3" name="sort" id="sort" >
					</div>
				</div>
				<div class="form-group">
					<label for="careerDetailContent" class="col-sm-2 control-label">职位信息：</label>
					<div class="col-xs-7" id="careerDetailContent_mess">
						<script id="careerDetailContent" name="careerDetailContent" type="text/plain">
							<?php echo $resultData[0]->careerInfo; ?>
					    </script>
					     <!-- 配置文件 -->
					    <?php echo HTML::script('js/ueditor/ueditor.config.js'); ?>
					    <!-- 编辑器源码文件 -->
					    <?php echo HTML::script('js/ueditor/ueditor.all.min.js'); ?>
					 
					    <!-- 实例化编辑器 -->
					    <script type="text/javascript">
					    	//window.UEDITOR_CONFIG.initialFrameWidth = 400;
					    	//window.UEDITOR_CONFIG.zIndex = 800;
					    	window.UEDITOR_CONFIG.toolbars = [[
					            'fullscreen',  'undo', 'redo', '|',
					            'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'superscript', 
					            'subscript', 'removeformat', 'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|', 
					            'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', 'selectall',
					             'cleardoc', '|',
					            'rowspacingtop', 'rowspacingbottom', 'lineheight', '|',
					            'customstyle', 'paragraph', 'fontfamily', 'fontsize', '|',
					            'directionalityltr', 'directionalityrtl', 'indent', '|',
					            'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', '|', 'touppercase', 
					            'tolowercase', '|',
					            'link', '|', 
					            'horizontal', 'date', 'spechars',   '|', 'preview', 
					        ]];
					        var ue_1 = UE.getEditor('careerDetailContent');
					    </script>
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

<script type="text/javascript">
$("#career_update_form").validate({
	//debug:true,
	rules:{		
		careerName : {
			required : true,
			
		},
		sort : {
			number: true
		}

		
		
	},
	messages:{
		careerName : {
			required : "请填写职位名称"
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
