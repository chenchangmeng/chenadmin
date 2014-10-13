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
					用户列表
				</li>
			</ul>	

			<div class="row clearfix">
				<div class="col-md-7 column">
					
				</div>
				<div class="col-md-5 column" >
					
				</div>
			</div>
			<?php echo Form::open(array('url' => 'user/user-add-data', 'method' => 'post', 'class'=>'form-horizontal', 'id'=>'user_add_form'));  ?>
				<div class="form-group">
					<label for="user_name" class="col-sm-2 control-label">用户名</label>
					<div class="col-xs-4" id="user_name_mess">
						<input type="text" class="form-control operate-form" maxlength="32" name="user_name" id="user_name" />
					</div>
				</div>
				<div class="form-group">
					 <label for="real_name" class="col-sm-2 control-label">真实姓名</label>
					<div class="col-xs-4" id="real_name_mess">
						<input type="text" class="form-control operate-form"  maxlength="32" name="real_name" id="real_name" />
					</div>
				</div>
				<div class="form-group">
					 <label for="password" class="col-sm-2 control-label">初始密码</label>
					<div class="col-xs-4" id="password_mess">
						<input type="password" class="form-control operate-form"  maxlength="32" name="password" id="password" />
					</div>
				</div>
				<div class="form-group">
					 <label for="role_id" class="col-sm-2 control-label">角色组</label>
					<div class="col-xs-4" id="role_id_mess">
						<select name="role_id" id="role_id" class="form-control operate-form">
							<option value="">--请选择--</option>
							<?php foreach ($roles as  $value) {  ?>
								<option value="<?php echo $value->roleId; ?>"><?php echo $value->roleName; ?></option>
							<?php }  ?>
						</select>
					</div>
				</div>

				<div class="form-group">
					 <label for="email" class="col-sm-2 control-label">邮箱</label>
					<div class="col-xs-4" id="email_mess">
						<input type="text" class="form-control operate-form"  maxlength="50" name="email" id="email" />
					</div>
				</div>
				<!-- <div class="form-group">
					 <label for="telephone" class="col-sm-2 control-label">手机号码</label>
					<div class="col-xs-4" id="telephone_mess">
						<input type="text" class="form-control operate-form"  maxlength="11" name="telephone" id="telephone" />
					</div>
				</div> -->
				<div class="form-group">
					<div class="col-sm-offset-2 col-xs-5">
						 <button type="submit" class="btn btn-default">添加</button>
					</div>
				</div>
			<?php echo Form::close();  ?>		
			
		</div>
	</div>
	<!-- footer html-->
	<?php echo $footer; ?>
</div>
<script type="text/javascript">
$("#user_add_form").validate({
	//debug:true,
	rules:{		
		user_name : {
			required : true,
			remote :{
				url : "<?php echo URL::to('user/user-unique'); ?>",
				type : "post",
				data :{
					userName : function(){
						return $("#user_name").val();
					}
				}
			}
		},
		real_name : {
			required : true,
		},
		password : {
			required : true,
			minlength: 6
		},
		role_id : {
			required : true,
		},
		email : {
			required : true,
			email : true,
		},
		
		
	},
	messages:{
		user_name : {
			required : "请填写用户名",
			remote : "用户名已存在"
		},
		real_name : {
			required : "请填写真实姓名",
		},
		password : {
			required : "请填写初始密码",
			minlength: "初始密码不能少于6位"
		},
		role_id : {
			required : "请选择角色组",
		},
		email : {
			required : "请填写邮箱",
			email : "请填写正确的邮箱地址",
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
