<?php
class Partner extends Eloquent{

	public function getPartnerCount($query = array()){
		$condition = "WHERE isDele = 0 ";
		if(isset($query['brandName']) && $query['brandName']){
		   $condition .= " AND brandName LIKE '%".$query['brandName']."%' ";
		}

		$sql =" SELECT
					count(1) as c
				FROM
					eta_partner t1 " . $condition;
		$result = DB::select($sql);

		return $result[0]->c;

	}

	public function getPartnerData($query = array(), $offset = 0, $perPageSize = 10){
		$condition = "WHERE t1.isDele = 0 ";
		if(isset($query['brandName']) && $query['brandName']){
		   $condition .= " AND brandName LIKE '%".$query['brandName']."%' ";
		}
		
		$condition .= " ";

		$sql =" SELECT
					t1.*
				FROM
					eta_partner t1
				{$condition}
				ORDER BY  t1.sort  DESC 
				LIMIT 
					{$offset}, 
				{$perPageSize}";

		$result = DB::select($sql);
		if(!empty($result)){
		   foreach ($result as $key => $value) {
		   		$result[$key]->showbrandName = strlen($value->brandName) > 6 ? $this->utf8Substr($value->brandName, 0, 6).'...' : $value->brandName;
		   }
		}
		return $result;
	}

	public function getPartnerOne($id){
		$sql =" SELECT
					t1.*
				FROM
					eta_partner t1
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