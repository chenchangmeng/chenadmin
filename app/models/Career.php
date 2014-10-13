<?php
class Career extends Eloquent{
	
	public function getCareerBasicInfo($type = 'career'){
		$sql =" SELECT
					t1.*
				FROM
					eta_basic t1
				WHERE 
					t1.type = '".$type."' ";

		$result = DB::select($sql);

		return $result;
	}

	public function getCareerData(){

		$sql =" SELECT
					t1.*
				FROM
					eta_career t1
				ORDER BY  t1.sort  DESC ";

		$result = DB::select($sql);
		if(!empty($result)){
		   foreach ($result as $key => $value) {
		   		$result[$key]->showCareerName = strlen($value->careerName) > 15 ? $this->utf8Substr($value->careerName, 0, 15).'...' : $value->careerName;
		   }
		}
		
		return $result;
	}

	public function getCareerOne($id){
		$sql =" SELECT
					t1.*
				FROM
					eta_career t1
				WHERE 
					t1.id = "  . intval($id);

		$result = DB::select($sql);

		return $result;
	}

	private function utf8Substr($str, $from, $len){ 
		return preg_replace('#^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$from.'}'. 
		'((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$len.'}).*#s', 
		'$1',$str); 
	} 
}