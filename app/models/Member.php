<?php
class Member extends Eloquent{

	/**
	 * 发信域名子账号
	 */
	private $api_user = "postmaster@chen.sendcloud.org";
	/**
	 * key值
	 */
	private $api_key = "53LkfBnHYALhbCpm";

	public function getMemberInfoCount(){
		$condition = "WHERE isDele = 0 ";
		
		$sql =" SELECT
					count(1) as c
				FROM
					eta_member_info " . $condition;
		$result = DB::select($sql);

		return $result[0]->c;
	}

	public function getMemberInfoData($offset = 0, $perPageSize = 10){
		$condition = "WHERE isDele = 0 ";

		$sql =" SELECT
					*
				FROM
					eta_member_info
				{$condition}
				ORDER BY created_at DESC
				LIMIT 
					{$offset}, 
				{$perPageSize}";
				//echo $sql;
		$result = DB::select($sql);
		
		return $result;
	}
	
	public function getMemberCount($query = array()){
		$condition = "WHERE isDele = 0 ";
		if(isset($query['email']) && $query['email']){
		   $condition .= " AND email LIKE '%".$query['email']."%' ";
		}
		if(isset($query['fromType']) && is_numeric($query['fromType'])){
		   $condition .= " AND fromType = " . $query['fromType'];
		}

		if(isset($query['memberType']) && is_numeric($query['memberType'])){
		   $condition .= " AND memberType = " . $query['memberType'];
		}
		$sql =" SELECT
					count(1) as c
				FROM
					eta_member " . $condition;
		$result = DB::select($sql);

		return $result[0]->c;

	}

	public function getMemberData($query = array(), $offset = 0, $perPageSize = 10){
		$condition = "WHERE isDele = 0 ";
		if(isset($query['email']) && $query['email']){
		   $condition .= " AND email LIKE '%".$query['email']."%' ";
		}
		if(isset($query['fromType']) && $query['fromType']){
		   $condition .= " AND fromType = '".$query['fromType']."' ";
		}

		if(isset($query['memberType']) && $query['memberType']){
		   $condition .= " AND memberType = '".$query['memberType'] ."' ";
		}

		$sql =" SELECT
					*
				FROM
					eta_member
				{$condition}
				ORDER BY created_at DESC
				LIMIT 
					{$offset}, 
				{$perPageSize}";
				//echo $sql;
		$result = DB::select($sql);
		
		return $result;
	}

	public function getMemberType(){
		$sql = "select memberType from eta_member GROUP BY memberType";
		$result = DB::select($sql);
		
		return $result;
	}

	public function getMemberTypeData($memberType){
		$memberTypeData = "";
		if($memberType){
			$sql = "SELECT id, email FROM eta_member WHERE memberType = '".$memberType."'";
			$result = DB::select($sql);
			if(!empty($result)){
				foreach ($result as $value) {
					$memberTypeData .= "<option value='".$value->id."' onclick='selectValue(this.value, this.text)'>".$value->email."</option>";
				}
			}
		}
		return $memberTypeData;
	}

	/**
	 * 获取收取人列表
	 */
	public function getToEmailData($memberTypeEmail = '', $ids = ''){
		$data = '';
		$sql = "SELECT 
					email
				FROM 
					eta_member
				WHERE memberType = '".$memberTypeEmail."' 
				OR id in({$ids}) ";
		$result = DB::select($sql);
		if(!empty($result)){
			foreach ($result as $value) {
				$data .= $value->email.';';
			}
		}
		return $data;
	}

	/**
	 * 处理邮件附件问题
	 */
	public function getAttachment(){
		$attachmentFile = array();
		$destinationPath = getcwd() . "/upload/email/";
		for($i=1;$i<3;$i++){
			$uploadName = 'etaFile'.$i;
		    //是否存在上传文件
			if(Input::hasFile($uploadName)){
			   //检查文件是否合法
			   if(Input::file($uploadName)->isValid()){
			   		//检查文件大小
			   	    $size = Input::file($uploadName)->getSize();
			   	    if($size >= 10485760){
			   	       //大于10M
			   	       break;
			   	    }
			   	    //移动文件
			   	    $name = Input::file($uploadName)->getClientOriginalName();
			   	    Input::file($uploadName)->move($destinationPath, $name);
			   	    
			   	    $attachmentFile['file'.$i] = '@' .$destinationPath . $name . ';filename=' . $name;
			   }else{
			   	  break;
			   }

			}else{
			   break;
			}
		}

		return $attachmentFile;
	}

	/**
	 * 发送邮件
	 */
	public function sendEmail($toEmailData, $subject, $fromEmailName, $fromEmail, $content, $attachmentFile=array()){
		$data = array(
			'api_user' => $this->api_user,
            'api_key' => $this->api_key,
            'from' =>  $fromEmail,
            'fromname' => $fromEmailName,
            'to' => 'eta@eta.com.cn',
            'bcc' => $toEmailData,
            'subject' => $subject,
            'html' => $content,
            //'file1' => '@/path/to/附件.png;filename=附件.png',
            //'file2' => '@/path/to/附件2.txt;filename=附件2.txt'
        );
        //添加附件
        if(!empty($attachmentFile)){
        	foreach ($attachmentFile as $key => $value) {
        		$data[$key] = $value;
        	}
        }
        $this->logEmailError('parama', serialize($data));
		$ch = curl_init();

	    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);

	    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
	    curl_setopt($ch, CURLOPT_URL, 'https://sendcloud.sohu.com/webapi/mail.send.json');
	    //不同于登录SendCloud站点的帐号，您需要登录后台创建发信子帐号，使用子帐号和密码才可以进行邮件的发送。
	    curl_setopt($ch, CURLOPT_POSTFIELDS,$data);        
        
        $result = curl_exec($ch);

        if($result === false) //请求失败
        {
           echo 'last error : ' . curl_error($ch);
        }

        curl_close($ch);

        return $result;

	}

	/**
	 * 记录邮件错误日志
	 */
	public function logEmailError($msg = 'error', $info=''){
		$data = array(
			'status' => $msg,
			'info' => $info,
			'created_at' => date('Y-m-d H:i:s')
		);
		DB::table('email_error_log')->insertGetId($data);
	}


	public function memberImport(){
		$upload_name = "excelFile";
		//上传文件存放目录
		$save_path = getcwd() . "/upload/excel/";
		$max_file_size_in_bytes = 10485760; //10M
		$file_name = date('YmdHis');
		$ext_whitelist = array(
			'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 
			'application/vnd.ms-excel',
			'application/excel',
			'application/vnd.ms-excel', 
			'application/msexcel'
		); //允许上传的文件

		if(!isset($_FILES[$upload_name])) {
			$this->HandleError(1);
			exit(0);
		}else if(isset($_FILES[$upload_name]["error"]) && $_FILES[$upload_name]["error"] != 0) {
			$this->HandleError(1);
			exit(0);
		}else if(!isset($_FILES[$upload_name]["tmp_name"]) || !@is_uploaded_file($_FILES[$upload_name]["tmp_name"])) {
			$this->HandleError(1);
			exit(0);
		}else if(!isset($_FILES[$upload_name]['name'])) {
			$this->HandleError(1);
			exit(0);
		}

		//验证文件大小
		$file_size = @filesize($_FILES[$upload_name]["tmp_name"]);
		if(!$file_size || $file_size > $max_file_size_in_bytes){
			$this->HandleError(2);
			exit(0);
		}

		if($file_size <= 0){
			HandleError(1);
			exit(0);
		}

		// Validate file extension
		$path_info = pathinfo($_FILES[$upload_name]['name']);
		//$file_extension = $path_info["extension"];
		$file_extension = $_FILES[$upload_name]['type'];
		$is_valid_extension = false;
		foreach ($ext_whitelist as $extension) {
			if (strcasecmp($file_extension, $extension) == 0) {
				$is_valid_extension = true;
				break;
			}
		}
		if (!$is_valid_extension) {
			$this->HandleError(3);
			exit(0);
		}
		$file_name = $file_name . '.'. $path_info["extension"];
		if(!@move_uploaded_file($_FILES[$upload_name]["tmp_name"], $save_path.$file_name)) {
			$this->HandleError(4);
			exit(0);
		}
		//读取excel文件
		//$phpExcel = new PHPExcel;
		//跳转到数据处理页 读取excel
		$filePath = $save_path.$file_name;
		 //建立reader对象
		$PHPReader = new PHPExcel_Reader_Excel2007();
		if(!$PHPReader->canRead($filePath)){
		     $PHPReader = new PHPExcel_Reader_Excel5();
		     if(!$PHPReader->canRead($filePath)){
		         HandleError(4);
		         exit(0);
		     }
		}
		$PHPExcel = $PHPReader->load($filePath);
		/**读取excel文件中的第一个工作表*/
		$currentSheet = $PHPExcel->getSheet(0);
		 /**取得最大的列号*/
		$allColumn = $currentSheet->getHighestColumn();
		 /**取得一共有多少行*/
		$allRow = $currentSheet->getHighestRow();
		$newData = array();
		 
		 //循环读取每个单元格的内容。注意行从1开始，列从A开始
		for($rowIndex=2;$rowIndex<=$allRow;$rowIndex++){
		     for($colIndex='A';$colIndex<=$allColumn;$colIndex++){
		         $addr = $colIndex.$rowIndex;
		         $cell = $currentSheet->getCell($addr)->getValue();
		         if($cell instanceof PHPExcel_RichText)     //富文本转换字符串
		             $cell = $cell->__toString();
					//验证邮箱      
		            //echo $colIndex . '----' .$cell . "<br />";
		            if($colIndex == 'A' && preg_match('/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i',$cell)){
		            	$email = $cell;
		            	//echo $email . "<br />";
		            }
		            if($colIndex == 'B'){
		            	//会员类型
		            	$memberType = $cell;
		            }
		               
		     }
		     if(isset($email) && $email){
		     	//当邮箱地址为有效数据的时候
		     	$newData = array(
		     		'email' => $email,
		     		'memberType' => isset($memberType) ? $memberType : '',
		     		'fromType' => 'importExcel',
		     		'created_at' => date('Y-m-d H:i:s'),
		     		'updated_at' => date('Y-m-d H:i:s')
		     	);
		     	$id = DB::table('member')->insertGetId($newData);
		     }
		}
		//var_dump($PHPExcel);

	}

	public function memberExport($query = array()){
		$condition = "WHERE isDele = 0 ";
		if(isset($query['email']) && $query['email']){
		   $condition .= " AND email LIKE '%".$query['email']."%' ";
		}
		if(isset($query['fromType']) && $query['fromType']){
		   $condition .= " AND fromType = '".$query['fromType']."' ";
		}

		if(isset($query['memberType']) && $query['memberType']){
		   $condition .= " AND memberType = '".$query['memberType'] ."' ";
		}

		$sql =" SELECT
					email,
					memberType,
					created_at
				FROM
					eta_member
				{$condition}
				ORDER BY created_at DESC ";
		$result = DB::select($sql);
		
		//建立写对象
		$wexcel = new PHPExcel();
		 
		//设置第一排的字段
		$wexcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, 'Email');
		$wexcel->getActiveSheet()->setCellValueByColumnAndRow(1, 1, '会员分类');
		$wexcel->getActiveSheet()->setCellValueByColumnAndRow(2, 1, '创建时间');

		$wexcel->setActiveSheetIndex(0);
		/*************************************/
		
		$rowIndex = 2;//从第二行开始
		foreach ($result as  $value){
			$col = 0; //列
			foreach ($value as $kvalue) {
				$wexcel->getActiveSheet()->setCellValueByColumnAndRow($col, $rowIndex, $kvalue);
				$col++;
			}
			$rowIndex++;
		}
		$PHPWrite = new PHPExcel_Writer_Excel2007($wexcel); 
		$wexcel->setActiveSheetIndex(0);
		header("Pragma: public");  
		header("Expires: 0");  
		header("Cache-Control:must-revalidate, post-check=0, pre-check=0");  
		header("Content-Type:application/force-download");  
		header("Content-Type:application/vnd.ms-execl");  
		header("Content-Type:application/octet-stream");  
		header("Content-Type:application/download");  
		header('Content-Disposition: attachment;filename="member_'.date('dMyHis').'.xlsx"');
		header("Content-Transfer-Encoding:binary");  
		$PHPWrite->save('php://output'); 
	}

	private function HandleError($num){
		echo $num;
	}

	//curl -d "api_user=postmaster@chen.sendcloud.org&api_key=53LkfBnHYALhbCpm&to=308968154@qq.com&from=changmengcool@163.com&fromname=测试用户&subject=主题&html=正文sss"
	//curl -d "api_user=postmaster@chen.sendcloud.org&api_key=53LkfBnHYALhbCpm&to=308968154@qq.com&from=changmengcool@163.com&fromname=测试用户&subject=主题&html=正文sss" https://sendcloud.sohu.com/webapi/mail.send.json
}