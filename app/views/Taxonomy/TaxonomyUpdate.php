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
					<a href="javascript:void(0);">分类配置</a> 
				</li>
				<li class="active">
					<?php echo $currTermData[0]->name;  ?>修改
				</li>
			</ul>	

			<div class="row clearfix">
				<div class="col-md-7 column">
					
				</div>
				<div class="col-md-5 column" >
					
				</div>
			</div>
			<?php echo Form::open(array('url' => 'taxonomy/taxonomy-update-data', 'method' => 'post', 'class'=>'form-horizontal', 'id'=>'taxonomy_add_form'));  ?>
				<input type="hidden" name="vid" id="vid" value="<?php echo $vocaData[0]->vid; ?>" />
				<input type="hidden" name="tid" id="tid" value="<?php echo $currTermData[0]->tid; ?>" />
				<input type="hidden" name="path" value="<?php echo $currTermData[0]->path; ?>" />
				<input type="hidden" name="currPid" value="<?php echo $currTermData[0]->pid; ?>" />
				<div class="form-group">
					<label for="name" class="col-sm-2 control-label">名称：</label>
					<div class="col-xs-7" id="name_mess">
						<input type="text" class="form-control operate-form" maxlength="32" name="name" id="name" value="<?php echo $currTermData[0]->name;  ?>" />
					</div>
				</div>

				<div class="form-group">
					<label for="enName" class="col-sm-2 control-label">英文全名：</label>
					<div class="col-xs-7" id="enName_mess">
						<input type="text" class="form-control operate-form" maxlength="80" name="enName" id="enName" value="<?php echo $currTermData[0]->enName;  ?>" />
					</div>
				</div>
				<div class="form-group">
					<label for="user_name" class="col-sm-2 control-label">描述：</label>
					<div class="col-xs-7" id="user_name_mess">
						<!-- 加载编辑器的容器 -->
					    <script id="container" name="content" type="text/plain">
					        <?php echo $currTermData[0]->description;  ?>
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
				<div class="form-group">
					<label for="pid" class="col-sm-2 control-label">父分类：</label>
					<div class="col-xs-7" id="role_id_mess">
						<select name="pid" id="pid" class="form-control operate-form">
							<option value="0" >--<?php echo $vocaData[0]->name; ?>--</option>
							<?php foreach ($termData as  $value) {  ?>
								<option <?php if($currTermData[0]->pid == $value->tid){echo "selected";} if($value->isChild == 1 || $value->tid == $currTermData[0]->tid){echo "disabled";}  ?> value="<?php echo $value->tid . '@' . $value->path; ?>">
									<?php echo $value->path_level . $value->name; ?>
								</option>
							<?php }  ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="weight" class="col-sm-2 control-label">排序：</label>
					<div class="col-xs-7" id="weight_mess">
						<input type="text" value="<?php echo $currTermData[0]->weight; ?>" name="weight" id="weight" class="form-control operate-form">
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
<script type="text/javascript">
$("#taxonomy_add_form").validate({
	//debug:true,
	rules:{		
		name : {
			required : true,
			remote :{
				url : "<?php echo URL::to('taxonomy/taxonomy-name-unique');  ?>",
				type : "post",
				data :{
					tid : function(){
						return $("#tid").val();
					},
					vid : function(){
						return $("#vid").val();
					},
					name : function(){
						return $("#name").val();
					}
				}
			}
		},
		weight : {
			number: true
		}		
	},
	messages:{
		name : {
			required : "请填名称",
			remote : "分类名称已存在"
		},
		weight : {
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
