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
					<a href="javascript:void(0);">产品和服务</a> 
				</li>
				<li class="active">
					<?php echo $tagMenu;  ?>属性添加
				</li>
			</ul>	

			<div class="row clearfix">
				<div class="col-md-7 column">
					
				</div>
				<div class="col-md-5 column" >
					
				</div>
			</div>
			<?php echo Form::open(array('url' => 'product/product-info-data', 'method' => 'post', 'class'=>'form-horizontal', 'id'=>'product_add_form'));  ?>
				<input type="hidden" name="tid" id="tid" value="<?php echo $tid; ?>" />
				<input type="hidden" name="vid" id="vid" value="<?php echo $vid; ?>" />
				<div class="form-group">
					<label for="productName" class="col-sm-2 control-label">产品与服务：</label>
					<div class="col-xs-7" id="productName_mess">
						<input type="text" class="form-control operate-form" disabled="disabled" value="<?php echo $tagMenu;  ?>" maxlength="80" name="productName" id="productName" />
					</div>
				</div>
				<div class="form-group">
					<label for="infoName" class="col-sm-2 control-label">属性名称<span class="asterisk-tip">*</span>：</label>
					<div class="col-xs-7" id="infoName_mess">
						<input type="text" class="form-control operate-form" maxlength="80" name="infoName" id="infoName" />
					</div>
				</div>

				<div class="form-group">
					<label for="type" class="col-sm-2 control-label">分类：</label>
					<div class="col-xs-7" id="type_mess">
						<select name="type" id="type" class="form-control operate-form">
								<option value="" >--请选择--</option>
								<option value="1" >功能介绍</option>
								<option value="2" >行业应用</option>
								<option value="3" >用户案例</option>
								
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
					<label for="infoContent" class="col-sm-2 control-label">详细信息：</label>
					<div class="col-xs-7" id="infoContent_mess">
						<script id="infoContent" name="infoContent" type="text/plain">

					    </script>
					     <!-- 配置文件 -->
					    <?php echo HTML::script('js/ueditor/ueditor.config.js'); ?>
					    <!-- 编辑器源码文件 -->
					    <?php echo HTML::script('js/ueditor/ueditor.all.min.js'); ?>
					 
					    <!-- 实例化编辑器 -->
					    <script type="text/javascript">					    	
					        var ue_1 = UE.getEditor('infoContent');
					    </script>
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

<script type="text/javascript">
$("#product_add_form").validate({
	//debug:true,
	rules:{		
		infoName : {
			required : true,
			
		},
		type : {
			required : true,
		},
		sort : {
			number: true
		}

		
		
	},
	messages:{
		infoName : {
			required : "请填写属性名称"
		},
		type : {
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
