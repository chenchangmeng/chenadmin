<?php
class Member extends Eloquent{
	
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
		     		'updated_at' => date('Y-m-d H:i:s'),
		     		'password' => Hash::make('123456'),
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
}