<?php
class Download extends Eloquent{

	public function getDownloadBasicInfo($type = 'career'){
		$sql =" SELECT
					t1.*
				FROM
					eta_basic t1
				WHERE 
					t1.type = '".$type."' ";

		$result = DB::select($sql);

		return $result;
	}

	public function getSoftCount(){

		$sql =" SELECT
					count(1) as c
				FROM
					eta_soft t1 ";
		$result = DB::select($sql);

		return $result[0]->c;

	}

	public function getSoftData($offset = 0, $perPageSize = 10){
		$condition = " ";

		$sql =" SELECT
					t1.*,
					t2.name as softTypeName
				FROM
					eta_soft t1
				LEFT JOIN eta_taxonomy_term_data t2 ON t1.softType = t2.tid
				ORDER BY  t1.sort  DESC ,created_at DESC
				LIMIT 
					{$offset}, 
				{$perPageSize}";
				//echo $sql;
		$result = DB::select($sql);
		
		return $result;
	}

	public function getSoftOne($id){
		$sql =" SELECT
					t1.*
				FROM
					eta_soft t1
				WHERE 
					t1.id = "  . intval($id);

		$result = DB::select($sql);

		return $result;
	}

	public function getDocCount(){

		$sql =" SELECT
					count(1) as c
				FROM
					eta_doc t1 ";
		$result = DB::select($sql);

		return $result[0]->c;

	}

	public function getDocData($offset = 0, $perPageSize = 10){
		$condition = " ";

		$sql =" SELECT
					t1.*,
					t2.name as docTypeName
				FROM
					eta_doc t1
				LEFT JOIN eta_taxonomy_term_data t2 ON t1.docType = t2.tid
				ORDER BY  t1.sort  DESC ,created_at DESC
				LIMIT 
					{$offset}, 
				{$perPageSize}";

		$result = DB::select($sql);
		
		return $result;
	}

	public function getDocOne($id){
		$sql =" SELECT
					t1.*
				FROM
					eta_doc t1
				WHERE 
					t1.id = "  . intval($id);

		$result = DB::select($sql);

		return $result;
	}

	/**
	 * 读取目录下的软件或者文件
	 */
	public function getFileList($fileType = "soft"){
		$dirPath = $save_path = dirname(dirname(getcwd())) . "/etaf/public/upload/{$fileType}/";
		$fileData = array();
		if(is_dir($dirPath)){
			if($dh = opendir($dirPath)){
				while (($file = readdir($dh)) !== false) {
					if(!is_dir($dirPath.'/'.$file) && $file != "." && $file != ".."){
						//$file = iconv('GB2312', 'UTF-8', $file);
						$fileData[] = $file;
					}
				}
			}
			closedir($dh);
		}

		return $fileData;
	}



}