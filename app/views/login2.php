<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>laravel</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">
	<?php echo HTML::style('css/bootstrap.min.css'); ?>
	<?php echo HTML::style('css/style.css'); ?>
	<?php echo HTML::style('css/theme-element.css'); ?>
	<?php echo HTML::style('css/page.css'); ?>

  <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
  <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
  <![endif]-->

	<?php echo HTML::script('js/jquery.min.js'); ?>
	<?php echo HTML::script('js/bootstrap.min.js'); ?>
	<?php echo HTML::script('js/jquery.validate.js'); ?>
	<?php echo HTML::script('js/scripts.js'); ?>

</head>

<body class="login-body">
<div class="container sign ">
	<div class="row clearfix">
		<hr class="tall">

		<div class="col-md-12 column" style="border:1px solid red;">
			<?php echo Form::open(array('url' => 'dealLogin', 'method' => 'post', 'class'=>'form-horizontal', 'id'=>'login-form'));  ?>
				<div class="form-group login-form">
					<label for="userName" class="col-xs-2 control-label">用户名：</label>
					<div class="col-xs-3">
						<input type="text" name="userName" class="form-control" id="userName">
					</div>
				</div>
				<div class="form-group">
					<label for="password" class="col-xs-2 control-label">密码：</label>
					<div class="col-xs-3">
						<input type="password" name="password" class="form-control" id="password">
					</div>
				</div>
				<div class="form-group">
					<label for="captcha" class="col-xs-2 control-label">验证码：</label>
					<div class="col-xs-1" style="width:120px;">
						<input type="text" name="captcha" class="form-control" id="captcha">
					</div>
					<div class="col-xs-1" style="padding:0px;">
							<img id="renderCaptchaImg" onclick="this.src='<?php echo URL::to('renderCaptcha'); ?>?'+Math.random();" src="<?php echo URL::to('renderCaptcha'); ?>" />
					</div>
					<div class="col-xs-1" style="padding-left:0px;">
						<a href="javascript:void(0);" onclick="document.getElementById('renderCaptchaImg').src='<?php echo URL::to('renderCaptcha'); ?>?'+Math.random();">
							<em class="glyphicon glyphicon-refresh" style="margin-top:15px;"></em>换一张
						</a>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-2 col-xs-3">
						<div class="sign_submit">
							<input type="submit" class="btn btn-default" value="登录">
						</div>
						 <div class="sign_forget_pass"><a href="javascript:void(0);">忘记密码?</a></div>
					</div>
				</div>
			<?php echo Form::close();  ?>
		</div>
	</div>
</div>
<script type="text/javascript">
$("#login-form").validate({
	rrorContainer: "#messageBox",
	wrapper: "span",
	//debug:true,
	rules:{
		userName : "required",
		password : {
			required : true,
			minlength : 6
		},
		captcha : {
			required : true,
			remote:{
				type : "post",
				url : "<?php echo URL::to('validateCaptcha'); ?>",
				data :{
					validate_code: function(){
						return document.getElementById("captcha").value;
					}
				}
			}
		},
	},
	messages:{
		userName :  "请填写用户名",
		password : {
			required : "请填写密码",
			minlength : "请输入至少6位密码"
		},
		captcha : {
			require : "请填写验证码",
			remote : "验证码错误"
		}
	}
});
</script>
</body>
</html>
