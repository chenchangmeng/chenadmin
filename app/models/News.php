<?php
class News extends Eloquent{

	public function getNewsCount($query = array()){
		$condition = "WHERE isDele = 0 ";
		if(isset($query['title']) && $query['title']){
		   $condition .= " AND title LIKE '%".$query['title']."%' ";
		}
		if(isset($query['published']) && is_numeric($query['published'])){
		   $condition .= " AND published = " . $query['published'];
		}

		if(isset($query['promote']) && is_numeric($query['promote'])){
		   $condition .= " AND promote = " . $query['promote'];
		}

		if(isset($query['sticky']) && is_numeric($query['sticky'])){
		   $condition .= " AND sticky = " . $query['sticky'];
		}

		$sql =" SELECT
					count(1) as c
				FROM
					eta_node t1
				INNER JOIN eta_node_content t2 ON t1.nid = t2.nid " . $condition;
		$result = DB::select($sql);

		return $result[0]->c;

	}

	public function getNewsData($query = array(), $offset = 0, $perPageSize = 10){
		$condition = "WHERE t1.isDele = 0 ";
		if(isset($query['title']) && $query['title']){
		   $condition .= " AND title LIKE '%".$query['title']."%' ";
		}
		if(isset($query['published']) && is_numeric($query['published'])){
		   $condition .= " AND published = " . $query['published'];
		}

		if(isset($query['promote']) && is_numeric($query['promote'])){
		   $condition .= " AND promote = " . $query['promote'];
		}

		if(isset($query['sticky']) && is_numeric($query['sticky'])){
		   $condition .= " AND sticky = " . $query['sticky'];
		}
		$condition .= " ";

		$sql =" SELECT
					t1.*, t2.content,
					t2.promoteUrl,
					t2.stickyUrl,
					t3.userName
				FROM
					eta_node t1
				INNER JOIN eta_node_content t2 ON t1.nid = t2.nid
				INNER JOIN eta_users t3 ON t1.uid = t3.id
				{$condition}
				ORDER BY t1.created_at DESC 
				LIMIT 
					{$offset}, 
				{$perPageSize}";

		$result = DB::select($sql);
		if(!empty($result)){
		   foreach ($result as $key => $value) {
		   		$result[$key]->showTitle = strlen($value->title) > 6 ? $this->utf8Substr($value->title, 0, 6).'...' : $value->title;
		   		$result[$key]->showPromote = $value->promote ? '是' : '否';
		   		$result[$key]->showSticky = $value->sticky ? '是' : '否';
		   		$result[$key]->showPublish = $value->published ? '发布' : '未发布';
		   }
		}
		return $result;
	}

	public function getNewsOne($nid){
		$sql =" SELECT
					t1.*, t2.content,
					t2.promoteUrl,
					t2.stickyUrl
				FROM
					eta_node t1
				INNER JOIN eta_node_content t2 ON t1.nid = t2.nid
				WHERE 
					t1.nid = "  . intval($nid);

		$result = DB::select($sql);

		return $result;
	}



	private function utf8Substr($str, $from, $len){ 
		return preg_replace('#^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$from.'}'. 
		'((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$len.'}).*#s', 
		'$1',$str); 
	} 




	
}