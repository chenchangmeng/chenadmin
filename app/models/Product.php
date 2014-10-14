<?php
class Product extends Eloquent{

	/**
	 * 获取基本信息
	 */
	public function getBasicInfo($tid){
		$data = DB::table('taxonomy_term_data')
				->where('tid', '=', $tid)
				->first();
		return $data;
	}

	/**
	 * 获取产品信息
	 */
	public function getProductBasicInfo($tid){
		$data = DB::table('product')
				->where('tid', '=', $tid)
				->first();
		return $data;
	}

	public function getProductOneInfo($id){
		$data = DB::table('product_info')
				->where('id', '=', $id)
				->first();
		return $data;
	}

	public function getProductDetailInfos($tid, $vid){
		//获取产品与服务的属性
		$propertyData = $this->getPropertyData($vid);

		//获取产品属性详细信息
		$data = DB::table('product_info')
				->where('tid', '=', $tid)
				->orderBy('sort', 'desc')
				->get();
		// 		echo "<pre>";
		// var_dump($data[0]);
		// echo "</pre>";
		if(!empty($propertyData)){
			foreach ($propertyData as $key => $value) {
				foreach ($data as $kkey => $kvalue) {
					if($kvalue->type == $value['tid']){
						$propertyData[$key]['child'][] = (array)$data[$kkey];
					}
				}
			}
		}

		// $newData = array();
		// if(!empty($data)){
		// 	foreach ($data as $key => $value) {
		// 		$newData[$value->type][] = $data[$key];
		// 	}
		// }
		return $propertyData;
	}

	public function getPropertyData($vid){
		$taxonomy = new Taxonomy;
		//获取当前分类的属性
		$propetyData = array();
		$propertyMenu = array();
		if($vid == 4){
		   //产品属性
		   $propetyData = $taxonomy->getTermsData(10);
		}else if($vid == 6){
		   //服务属性
		   $propetyData = $taxonomy->getTermsData(11);
		}
		if(!empty($propetyData)){
			foreach ($propetyData as $key => $value) {
				if($value->pid == 0){
					$propertyMenu[$value->tid]['name'] = $value->name;
					$propertyMenu[$value->tid]['sort'] = $value->weight;
					$propertyMenu[$value->tid]['tid'] = $value->tid;
					$propertyMenu[$value->tid]['child'] = array();
				}
			}

			$propertyMenu = $this->KKSort($propertyMenu);
			
		}

		return $propertyMenu;
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

}