<?php
class Home extends Eloquent{

	public function getBannerData(){
		//获取推荐幻灯片新闻
		$newsData = $this->getNews();

		$psData = $this->getPSData();

		$currData = array_merge($newsData, $psData);
		//根据sort排序
		$currData = $this->KKSort($currData);

		return $currData;
	}

	private function getNews($type = "promote", $num = 3){
		$newsData = array();
		$sql = " SELECT 
					t1.`nid`,
					t1.`sort`,
					t1.`title`,
					t2.`promoteUrl`,
					t2.`stickyUrl`
				 FROM 
				 	eta_node t1
				 LEFT JOIN eta_node_content t2 ON t1.nid = t2.nid
				 WHERE 
				 	t1.{$type} = 1 
				 AND t1.`published` = 1
				 ORDER BY t1.`sort` DESC, t1.`created_at` DESC
				 LIMIT {$num}";
		$result = DB::select($sql);
		if(!empty($result)){
			foreach ($result as $key => $value) {
				$newsData[] = array(
					'url' => URL::to("news/news-detail/".$value->nid),
					'title' => $value->title,
					 'promoteUrl' => $value->promoteUrl ? $value->promoteUrl : HTML::imageUrl('upload/default/slide-1.jpg'),
					// 'promoteUrl' =>  $value->promoteUrl
					'stickyUrl' => '',
					'sort' => $value->sort
				);
			}
		}


		return $newsData;
	}

	/**
	 * 获取产品与服务幻灯片与推荐
	 */
	private function getPSData(){
		$psData = array();
		$sql = "SELECT 
				   t1.id,
				   t1.tid,
				   t1.promoteUrl,
				   t2.name,
				   t2.weight
				FROM 
				   eta_product t1
				LEFT JOIN eta_taxonomy_term_data t2 ON t1.tid = t2.tid
				WHERE isPromote = 1
				AND t2.isDele = 0
				LIMIT 3";
		$result = DB::select($sql);
		if(!empty($result)){
			foreach ($result as $key => $value) {
				$psData[] = array(
					'url' => '',
					'title' => $value->name,
					 'promoteUrl' => $value->promoteUrl ? $value->promoteUrl : HTML::imageUrl('upload/default/slide-1.jpg'),
					// 'promoteUrl' =>  $value->promoteUrl
					'stickyUrl' => '',
					'sort' => $value->weight
				);
			}
		}

		return $psData;

	}

	//产品与服务介绍
	public function psRecommend(){
		$currData = array();
		//产品
		$currData['pData'] = $this->psRecommendData(4, 3, 'product');

		//服务
		$currData['sData'] = $this->psRecommendData(6, 3, 'service');

		return $currData;
	}

	//产品
	private function psRecommendData($vid, $num = 3, $type="product"){
		$psData = array();
		$sql = "SELECT 
				   t1.id,
				   t1.tid,
				   t1.recommendUrl,
				   t2.name,
				   t2.weight
				FROM 
				   eta_product t1
				LEFT JOIN eta_taxonomy_term_data t2 ON t1.tid = t2.tid
				WHERE isRecommend = 1
				AND t2.isDele = 0 
				AND t2.vid = {$vid}
				LIMIT {$num}";
		$result = DB::select($sql);
		if(!empty($result)){
			foreach ($result as $key => $value) {
				$psData[] = array(
					'url' => URL::to('product/product-info/'.$type.'/'.$value->tid.'/'.$vid),
					'title' => $value->name,
					//'recommendUrl' => $value->recommendUrl ? $value->recommendUrl : HTML::imageUrl('upload/default/slide-1.jpg'),
					'recommendUrl' =>  $value->recommendUrl,
					'sort' => $value->weight
				);
			}
			$psData = $this->KKSort($psData);
		}

		return $psData;
	}

	public function getCustomerData(){
		$sql = "SELECT 
				  name,
				  customerUrl
				FROM 
				  eta_customer
				WHERE customerUrl <> ''
				ORDER BY sort DESC";
		$result = DB::select($sql);

		return $result;
	}

	public function getNewsData(){
		$xss = new Xss;
		$newsData = array();
		$sql = " SELECT 
					t1.`nid`,
					t1.`sort`,
					t1.`title`,
					t1.`overview`,
					t1.`publishedTime`,
					t1.`created_at`,
					t2.`content`
				 FROM 
				 	eta_node t1
				 LEFT JOIN eta_node_content t2 ON t1.nid = t2.nid
				 WHERE 
				 	t1.`published` = 1
				 ORDER BY t1.`sticky` DESC,
				 	t1.`sort` DESC,
				 	t1.`created_at` DESC
				 LIMIT 6";
		$result = DB::select($sql);
		if(!empty($result)){
			foreach ($result as $key => $value) {
				$content = $xss->clean($value->content);
				
				$newsData[] = array(
					'title' => $value->title,
					'overview' => $value->overview ? $this->utf8Substr($value->overview, 0, 120) : $this->utf8Substr($content, 0, 120),
					'url' => URL::to("news/news-detail/".$value->nid),
					'day' => date('d', strtotime($value->publishedTime ? $value->publishedTime : $value->created_at)),
					'month' => date('m', strtotime($value->publishedTime ? $value->publishedTime : $value->created_at))
				);
			}
		}

		return $newsData;
	}



	/**
	 * 冒泡排序
	 */
	public function KKSort($propertyMenu){
		sort($propertyMenu);
		$c = count($propertyMenu);
		for($i=0; $i<$c;$i++){
			for($j=$c-1; $j>$i; $j--){
				if($propertyMenu[$j]['sort'] > $propertyMenu[$j-1]['sort']){
					$tmp = $propertyMenu[$j];
					$propertyMenu[$j] =  $propertyMenu[$j-1];
					$propertyMenu[$j-1] = $tmp;
				}
			}
			if(isset($propertyMenu[$i]['child']) && !empty($propertyMenu[$i]['child'])){
				//递归
				$propertyMenu[$i]['child'] = $this->KKSort($propertyMenu[$i]['child']);
			}
		}
		return $propertyMenu;
	
	}

	private function utf8Substr($str, $from, $len){ 
		return preg_replace('#^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$from.'}'. 
		'((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$len.'}).*#s', 
		'$1',$str); 
	} 

}