
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Login1</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Avant">
    <meta name="author" content="The Red Team">

   	<?php echo HTML::style('css/bootstrap.min.css'); ?>
   	<?php echo HTML::style('css/login.css'); ?>
    
    <?php echo HTML::script('js/less-1.3.3.min.js'); ?>

</head>
<body class="focusedform">

<div class="verticalcenter">
	<div class="panel panel-primary" style="border-color:#FFFFFF;">
		<div class="panel-body">
			<h4 class="text-center" style="margin-bottom: 25px;">Log in to get started or <a href="extras-signupform.php">Sign Up</a></h4>
			<?php echo Form::open(array('url' => 'dealLogin', 'method' => 'post', 'class'=>'form-horizontal', 'id'=>'login-form', 'style'=>'margin-bottom: 0px !important;'));  ?>
						<div class="form-group">
							<div class="col-sm-12">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa"><em class="glyphicon glyphicon-user"></em></i></span>
									<input type="text" class="form-control" name="userName" id="userName" placeholder="Username">
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-12">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa"><em class="glyphicon glyphicon-lock"></em></i></span>
									<input type="password" name="password" class="form-control" id="password" placeholder="Password">
								</div>
							</div>
						</div>
						
					<?php echo Form::close();  ?>
					
		</div>
		<div class="panel-footer">
			<a href="extras-forgotpassword.php" class="pull-left btn btn-link" style="padding-left:0">忘记密码?</a>
			
			<div class="pull-right">
				<a href="javascript:void(0);" onclick="resetForm()" class="btn btn-default">重置</a>
				<a href="javascript:void(0);" onclick="submitForm()" class="btn btn-primary">登录</a>
			</div>
		</div>
	</div>
 </div>
      
</body>
<script type="text/javascript">
function resetForm(){
	document.getElementById("login-form").reset();
}

function submitForm(){
	var userName = document.getElementById("userName").value;
	if(userName.length < 1){
		alert("请输入用户名!");
		return false;
	}

	var password = document.getElementById("password").value;
	if(password.length < 1){
		alert("请输入密码!");
		return false;
	}
	document.getElementById("login-form").submit();

}
</script>
</html>