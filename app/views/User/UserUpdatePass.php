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
					<a href="javascript:void(0);">用户管理</a> 
				</li>
				<li class="active">
					修改密码
				</li>
			</ul>	

			<div class="row clearfix">
				<div class="col-md-7 column">
					
				</div>
				<div class="col-md-5 column" >
					
				</div>
			</div>
			<?php echo Form::open(array('url' => 'user/user-update-pass-data', 'method' => 'post', 'class'=>'form-horizontal', 'id'=>'user_update_pass_form'));  ?>
				<div class="form-group">
					<label for="password" class="col-sm-2 control-label">原密码<span class="asterisk-tip">*</span>：</label>
					<div class="col-xs-7" id="password_mess">
						<input type="password" class="form-control operate-form" maxlength="32" name="password" id="password" />
					</div>
				</div>
				<div class="form-group">
					 <label for="newPassword" class="col-sm-2 control-label">新密码<span class="asterisk-tip">*</span>：</label>
					<div class="col-xs-7" id="newPassword_mess">
						<input type="password" class="form-control operate-form"  maxlength="32" name="newPassword" id="newPassword" />
					</div>
				</div>
				<div class="form-group">
					 <label for="confirmPassword" class="col-sm-2 control-label">确认新密码<span class="asterisk-tip">*</span>：</label>
					<div class="col-xs-7" id="confirmPassword_mess">
						<input type="password" class="form-control operate-form"  maxlength="32" name="confirmPassword" id="confirmPassword" />
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
$("#user_update_pass_form").validate({
	//debug:true,
	rules:{		
		password : {
			required : true,
			minlength: 6,
			remote :{
				url : "<?php echo URL::to('user/user-pass-confirm'); ?>",
				type : "post",
				data :{
					password : function(){
						return $("#password").val();
					}
				}
			}
		},
		newPassword : {
			required : true,
			minlength : 6
		},
		confirmPassword : {
			required : true,
			minlength : 6,
			equalTo: "#newPassword"
		},
		
		
	},
	messages:{
		password : {
			required : "请填写原密码",
			minlength: "密码不能少于6位",
			remote : "原密码不正确"
		},
		newPassword : {
			required : "请填写新密码",
			minlength : "密码不能少于6位",
		},
		confirmPassword : {
			required : "请填写确认密码",
			minlength : "密码不能少于6位",
			equalTo: "请输入正确的确认密码"
		},
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
