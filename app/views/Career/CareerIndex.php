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



	<?php echo HTML::script('js/theme.plugins.js'); ?>
	<?php echo HTML::script('js/theme.js'); ?>
	
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
					<a href="javascript:void(0);">内容管理</a> 
				</li>
				<li class="active">
					招聘信息
				</li>
			</ul>	

			<div class="row clearfix">

				<div class="col-xs-12 column">

					<!-- 加载编辑器的容器 -->
					<label for="content" class="control-label"><p>招聘简介：</p></label>
					<?php echo Form::open(array('url' => '', 'method' => 'post',  'id'=>'career_add_form', 'name'=>'career_add_form'));  ?>
					    <input type="hidden" id="careerBasicId" name="careerBasicId" value="<?php echo $careerBasicData[0]->id; ?>" />
					    <script id="careerInfo" name="careerInfo" type="text/plain">
					        <?php echo $careerBasicData[0]->content; ?>
					    </script>
					    <!-- 配置文件 -->
					    <?php echo HTML::script('js/ueditor/ueditor.config-career.js'); ?>
					    <!-- 编辑器源码文件 -->
					    <?php echo HTML::script('js/ueditor/ueditor.all.min.js'); ?>
					    <!-- 实例化编辑器 -->
					    <script type="text/javascript">
					        var ue = UE.getEditor('careerInfo');
					    </script>
					<?php echo Form::close();  ?>
				</div>

				<div class="col-xs-8 column" style="padding-top:10px;padding-left:12px;">	
					<h4>职位信息：</h4>				
				</div>
				<div class="col-xs-4 column" style="padding-left:102px;padding-top:10px;">
					<a href="javascript:void(0);" onclick="saveInfo()" class="btn btn-primary btn-custom">
						<em class='glyphicon glyphicon-saved'></em>保存
					</a>
					<a href="<?php echo URL::to('career/career-add'); ?>"   class="btn btn-primary btn-custom">
						<em class='glyphicon glyphicon-plus'></em>添加新职位
					</a>
				</div>

				<div class="col-xs-9 column">					
					
					<?php foreach ($careerInfoData as  $value) { ?>
						<section class="toggle">
							<label>
								<?php echo $value->careerName;  ?>
								<span style="margin-left:50px;">状态：<?php if($value->status == 1){echo '启用';}else{echo '禁用';}  ?></span>&nbsp;&nbsp;
								<span>创建时间：<?php echo date('Y-m-d', strtotime($value->created_at)); ?></span>&nbsp;&nbsp;
								<span><a href="<?php echo URL::to('career/career-update/'.$value->id); ?>" ><em class="glyphicon glyphicon-edit"></em>编辑</a></span>&nbsp;
								<span><a href="javascript:void(0);" onclick="DeleteCareer(<?php echo $value->id; ?>)"><em class='glyphicon glyphicon-remove'></em>删除</a></span>
							</label>
							
							<div class="toggle-content">
								<?php echo $value->careerInfo; ?>
							</div>
						</section>						
					<?php } ?>					
				</div>
				
				<div class="col-xs-3 column" >					

				</div>
			</div>
			
		</div>
	</div>
	<!-- footer html-->
	<?php echo $footer; ?>
</div>

</body>


<script type="text/javascript"> 

function saveInfo(){
	var  ll = document.getElementById("ueditor_textarea_careerInfo");

	if(ll){
		var v = ll.value;
		var id = document.getElementById("careerBasicId").value;
		if(v.length > 0){

			$.ajax({
				type : "post",
				url : "<?php echo URL::to('career/career-basic-data'); ?>",
				async : false,
				data : {id:id,content:v},
				success : function(data){
					if(data == "success"){
					   alert("保存信息成功");
					}else{
					   window.location.href = window.location.href;
					}
				}
			});

		}else{
			alert("请填写招聘信息");
		}
	}else{
		alert("请填写招聘信息");
	}
}



function trim(str){ //删除左右两端的空格    
     return str.replace(/(^\s*)|(\s*$)/g, "");    
} 

function DeleteCareer(id){
	if(confirm("确定要删除该内容吗？")){
		window.location.href = "<?php echo URL::to('career/career-delete/'); ?>/" + id;
	}
}

</script>
</html>
