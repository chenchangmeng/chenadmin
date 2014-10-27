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
			<?php echo Form::open(array('url' => 'member/deal-member-import', 'method' => 'post', 'class'=>'form-horizontal', 'id'=>'member_import_form', 'enctype'=>'multipart/form-data'));  ?>
				<div class="form-group">
					<label for="excelFile" class="col-sm-2 control-label">Excel File<span class="asterisk-tip">*</span>：</label>
					<div class="col-xs-7" id="excelFile_mess">
						<input type="file" class="form-control operate-form"   name="excelFile" id="excelFile" />
					</div>
				</div>					
				<div class="form-group">
					<div class="col-sm-offset-2 col-xs-5">
						 <button type="submit" class="btn btn-success custom-news-btn">导入数据</button>
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
