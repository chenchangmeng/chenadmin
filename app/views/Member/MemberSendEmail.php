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
	<?php echo HTML::script('js/jquery-ui.min.js'); ?>
	<?php echo HTML::script('js/bootstrap.min.js'); ?>
	<?php echo HTML::script('js/scripts.js'); ?>
	<style type="text/css">
		#selectable { list-style-type: none; margin: 0; padding: 0; display:inline;}
		#selectable li {float:left;}
		#selectable li a {text-decoration: none;}
	</style>
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
					<a href="javascript:void(0);">会员管理</a> 
				</li>
				<li class="active">
					邮件群发
				</li>
			</ul>	

			<div class="row clearfix">
				<div class="col-md-9 column">
					<?php echo Form::open(array('url' => 'member/deal-member-send', 'method' => 'post', 'class'=>'form-horizontal', 'id'=>'member_send_form', 'enctype'=>'multipart/form-data'));  ?>
						<div class="form-group">
							
							<div class="col-xs-10" id="emails_mess">
								<?php echo Session::get('sendEmailFail') ? '<span style="color:red;">' . Session::get('sendEmailFail') . '</span>' : '';  ?>
							</div>
						</div>
						<div class="form-group">
							<label for="emails" class="col-sm-2 control-label">收件人<span class="asterisk-tip">*</span>：</label>
							<input type="hidden" name="ids" id="ids" value="" />
							<div class="col-xs-10" id="emails_mess">
								<div class="form-control" id="selectTableDiv" style="height:50px;">
									<ul id="selectable" >									  									  
									</ul>
								</div>
							</div>
						</div>

						<div class="form-group">
							 <label for="memberTypeEmail" class="col-sm-2 control-label">分组群发：</label>	
							 <div class="col-xs-10" >					
								 <select name="memberTypeEmail" id="memberTypeEmail" id="memberTypeEmail" class="form-control ">
								 	<option value="">----</option>
								 	<?php foreach ($memberTypeData as $key => $value) { ?>
								 		<option value="<?php echo $value->memberType; ?>"><?php echo $value->memberType; ?></option>
								 	<?php } ?>
								 </select>		
							 </div>					
						</div>	

						<div class="form-group">
							<label for="subject" class="col-sm-2 control-label">主题<span class="asterisk-tip">*</span>：</label>
							<div class="col-xs-10" id="subject_mess">
								<input type="text" class="form-control" name="subject" id="subject" maxlength="80" />
							</div>
						</div>

						<div class="form-group">
							<label for="fromEmailName" class="col-sm-2 control-label">发件人<span class="asterisk-tip">*</span>：</label>
							<div class="col-xs-10" id="fromEmailName_mess">
								<input type="text" value="<?php if(isset($content['companyEmailFrom'])){echo $content['companyEmailFrom'];} ?>" class="form-control" name="fromEmailName" id="fromEmailName" maxlength="80" />
							</div>
						</div>

						<div class="form-group">
							<label for="fromEmail" class="col-sm-2 control-label">来源<span class="asterisk-tip">*</span>：</label>
							<div class="col-xs-10" id="fromType_mess">
								<input type="text" value="<?php if(isset($content['companyEmail'])){echo $content['companyEmail'];} ?>" class="form-control" name="fromEmail" id="fromEmail" maxlength="80" />
							</div>
						</div>

						<div class="form-group">
							<label for="fromTips" class="col-sm-2 control-label"></label>
							<div class="col-xs-10" id="fromTips_mess">
								<span class="asterisk-tip">总共的附件大小必须小于10 MB</span>
							</div>
						</div>

						<div class="form-group">
							<label for="fromEmail" class="col-sm-2 control-label">附件1：</label>
							<div class="col-xs-10" id="fromType_mess">
								<input type="file"  class="form-control" name="etaFile1" id="file1"  />
							</div>
						</div>

						<div class="form-group">
							<label for="fromEmail" class="col-sm-2 control-label">附件2：</label>
							<div class="col-xs-10" id="fromType_mess">
								<input type="file"  class="form-control" name="etaFile2" id="file2"  />
							</div>
						</div>

						<div class="form-group">
							<label for="html" class="col-sm-2 control-label">正文<span class="asterisk-tip">*</span>：</label>
							<div class="col-xs-10" id="html_mess">
								<!-- 加载编辑器的容器 -->
							    <script id="container" name="content" type="text/plain">
							        
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
							<div class="col-sm-offset-2 col-xs-5">
								 <a href="javascript:void(0);" onclick="submitData()" class="btn btn-success custom-news-btn">发送</a>
							</div>
						</div>
					<?php echo Form::close();  ?>
				</div>
				
				<div class="col-md-3 column" >
					<div class="form-group">
						 <label for="memberType" >会员分组：</label>						
						 <select name="memberType" id="memberType" onchange="searchMember(this.value)" class="form-control operate-form">
						 	<option value="">----</option>
						 	<?php foreach ($memberTypeData as $key => $value) { ?>
						 		<option value="<?php echo $value->memberType; ?>"><?php echo $value->memberType; ?></option>
						 	<?php } ?>
						 </select>							
					</div>

					<div class="form-group">
						 <label for="memberTypeData" >会员列表：</label>						
						 <select name="memberTypeData" id="memberTypeData" multiple class="form-control operate-form" style="height:400px;">
						 	
						 </select>							
					</div>
				
				</div>

			</div>				
		</div>
	</div>
	<!-- footer html-->
	<?php echo $footer; ?>
</div>
<script type="text/javascript">
var _this = this;
function searchMember(v){
	//console.log(v);
	if(v){
		$.ajax({
			type : "post",
			url : "<?php echo URL::to('member/member-type-data'); ?>",
			async : false,
			data : {memberType:v},
			success : function(data){
				//pagelist.loadPage();
				document.getElementById('memberTypeData').innerHTML = data;
			}
		});
	}
}

//email ID
var optionID = new Array();

var numOp = 0;
var selectDivH = 50;
function selectValue(id, v){
	//判断当前邮箱是否已经添加
	if(inArray(id, _this.optionID) !== false){
	   return false;
	}else{
	   //新数据
	   _this.optionID.push(id);
	}
	
	var t = "<li><a href='javascript:void(0);' id='opID_"+id+"' onclick='deleteV("+id+")'>&lt;"+v+"&gt;;</a></li>";
	if(_this.numOp == 3){
		_this.selectDivH = _this.selectDivH + 20;
		console.log(_this.selectDivH);
		document.getElementById('selectTableDiv').style.height = _this.selectDivH + 'px';
		_this.numOp = 0;
	}
	//console.log(document.getElementById('selectTableDiv').style.height);
	console.log(t);
	$("#selectable").append(t);
	_this.numOp++;
}

var dnumop = 0;
function deleteV(id){
	
	_this.optionID.splice(inArray(id, _this.optionID), 1);
	
	//console.log(_this.optionID);
	$("#opID_"+id).remove();
	if(_this.dnumop == 3){
		_this.selectDivH = _this.selectDivH - 20;
		//console.log(_this.selectDivH);
		document.getElementById('selectTableDiv').style.height = _this.selectDivH + 'px';
		_this.dnumop = 0;
	}
	_this.dnumop++;
}

function inArray(needle,array){ 
    if(typeof needle=="string"||typeof needle=="number"){ 
        for(var i in array){ 
            if(needle===array[i]){ 
                return i;
            } 
        } 
        return false; 
    } 
}

function submitData(){
	var ids = _this.optionID.toString();
	var idsType = document.getElementById("memberTypeEmail").value;
	//console.log(idsType.length);
	//console.log(ids.length);
	if(ids.length <= 0 && idsType.length <= 0){
		alert("请选择发件人或者群发分组");
		return false;		
	}
	if(ids.length > 0){
		document.getElementById("ids").value = ids;
	}

	var subject = document.getElementById("subject").value;
	if(subject.length < 1){
	   alert("请填写主题");
	   return false;
	}

	var companyEmailFrom = document.getElementById("fromEmailName").value;
	
	if(companyEmailFrom.length < 1){
	   alert("请填写发件人");
	   return false;
	}

	var companyEmail = document.getElementById("fromEmail").value;
	var reg = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$/;
	if(companyEmail.length < 1){
	   alert("请填写来源邮箱");
	   return false;
	}else if(!reg.test(companyEmail)){
	   alert("请填写正确来源邮箱");
	   return false;
	}

	var  ll = document.getElementById("ueditor_textarea_content");
	if(ll){
		if(ll.length < 1){
			alert("请填写正文");
	   		return false;
		}
	}else{
		alert("请填写正文");
	   	return false;
	}
	
	document.getElementById("member_send_form").submit();
}



function trim(str){ //删除左右两端的空格    
     return str.replace(/(^\s*)|(\s*$)/g, "");    
} 
</script>
</body>
</html>
