<?php

class TaxonomyController extends BaseController {

	private $taxonomy;

	public function __construct(){
		parent::__construct();
		$this->taxonomy = new Taxonomy;
		$this->beforeFilter('csrf', array('only'=>array('postUserAddData')));
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getTaxonomyIndex($vid = "")
	{
		if(is_numeric($vid)){
			$this->cVariable['vid'] = $vid;

			$this->cVariable['vocaData'] = $this->taxonomy->getVocabularyInfo($vid);

			$this->cVariable['termData'] = $this->taxonomy->getTermsData($vid);

			return View::make('Taxonomy.TaxonomyIndex', $this->cVariable);
		}else{
			return Redirect::to("taxonomy/vocabulary-index", $this->cVariable);
		}
		
	}

	/**
	 * 添加子分类
	 */
	public function getTaxonomyAdd($vid){
		// dan bilzerian
		$this->cVariable['termData'] = $this->taxonomy->getTermsData($vid);

		$this->cVariable['vocaData'] = $this->taxonomy->getVocabularyInfo($vid);

		return View::make('Taxonomy.TaxonomyAdd', $this->cVariable);
	}

	/**
	 * 修改子分类
	 */
	public function getTaxonomyUpdate($vid, $tid){
		// 当前分类信息
		$this->cVariable['currTermData'] = $this->taxonomy->getTermData($tid);
		// 当前词根分类列表
		$this->cVariable['termData'] = $this->taxonomy->getTermsData($vid);

		// echo "<pre>";
		// var_dump($this->cVariable['termData']);
		// echo "</pre>";
		$toStrPath = $this->cVariable['currTermData'][0]->path . '_' . $this->cVariable['currTermData'][0]->tid;
		foreach ($this->cVariable['termData'] as $key => $value) {
			//查找当前类的所有子分类
			if(stripos($value->path . '_' . $value->tid, $toStrPath) !== FALSE && $value->tid != $this->cVariable['currTermData'][0]->tid){
			   $this->cVariable['termData'][$key]->isChild = 1;
			}else{
			   $this->cVariable['termData'][$key]->isChild = 0;
			}
		}
		// echo "<pre>";
		// var_dump($this->cVariable['termData']);
		// echo "</pre>";
		// 词根信息
		$this->cVariable['vocaData'] = $this->taxonomy->getVocabularyInfo($vid);

		return View::make('Taxonomy.TaxonomyUpdate', $this->cVariable);
	}

	/**
	 * 验证分类名称的唯一性
	 */
	public function postTaxonomyNameUnique(){
		$data = Input::all();

		$flag = $this->taxonomy->taxonomyIsUnique($data);

		echo $flag;
	}

	public function postTaxonomyAddData(){
		$data = Input::all();
		
	    $path = 0;
	    $pid = 0;
		
		if(stripos($data['pid'], '@') !== false){
		   $tempArr = explode('@', $data['pid']);
		   $path = $tempArr[1] . '_' . $tempArr[0];
		   $pid =  $tempArr[0];
		}
		$action = 'taxonomy-add/';
		$flag = DB::table('taxonomy_term_data')->insert(
					array(
						'name' => htmlspecialchars($data['name']),
						'enName' => htmlspecialchars($data['enName']),
						'description' => isset($data['content']) ? $data['content'] : '',
						'vid' => $data['vid'],
						'pid' => $pid,
						'path' => $path,
						'weight' => $data['weight']
					)
				);
		if($flag){
		   $action = 'taxonomy-index/';
		}
		return Redirect::to('taxonomy/'.$action . $data['vid']);
	}

	/**
	 * 子分类修改数据
	 */
	public function postTaxonomyUpdateData(){
		$data = Input::all();
		// 当前词根分类列表
		$this->cVariable['termData'] = $this->taxonomy->getTermsData($data['vid']);

		$path = 0;
	    $pid = 0;
		
		if(stripos($data['pid'], '@') !== false){
		   //更改之后的path pid
		   $tempArr = explode('@', $data['pid']);
		   $path = $tempArr[1] . '_' . $tempArr[0];
		   $pid =  $tempArr[0];
		}

		$toStrPath = $data['path'] . '_' . $data['tid'];
		// 开始事物
		DB::beginTransaction();
		//更新当前数据信息
		$flag =	DB::table('taxonomy_term_data')
				->where('tid', $data['tid'])
				->update(
					array(
						'name' => htmlspecialchars($data['name']),
						'enName' => htmlspecialchars($data['enName']),
						'description' => isset($data['content']) ? $data['content'] : '',
						'pid' => $pid,
						'path' => $path,
						'weight' => $data['weight'],
						'updated_at' => date('Y-m-d H:i:s')
					)
				);
		// 上级分类
		$pPath = $path;
		foreach ($this->cVariable['termData'] as $key => $value) {
			//查找当前类的所有子分类
			if(stripos($value->path . '_' . $value->tid, $toStrPath) !== FALSE && $value->tid != $data['tid']){
			   //$this->cVariable['termData'][$key]->isChild = 1;
			   $this->cVariable['termData'][$key]->path = $pPath . '_' . $value->pid;
			   if(!$flag){
			   	  break;
			   }
			   //更新子类信息
				$flag = DB::table('taxonomy_term_data')
						->where('tid', $value->tid)
						->update(
							array(
								'path' => $this->cVariable['termData'][$key]->path,
								'updated_at' => date('Y-m-d H:i:s')
							)
						);
			   $pPath = $this->cVariable['termData'][$key]->path;
			}
		}

		if(!$flag){
			$action = "taxonomy-update/". $data['vid'] . '/' . $data['tid'];
			DB::rollback();
		}else{
			$action = "taxonomy-index/". $data['vid'];
			DB::commit();
		}

		return Redirect::to('taxonomy/'.$action);
	}

	/**
	 * 删除当前分类及当前分类的子类
	 */
	public function postTaxonomyDeleteData(){
		$vid = Input::get('vid');
		$tid = Input::get('tid');

		$currTermData = $this->taxonomy->getTermData($tid);

		$toStrPath = $currTermData[0]->path . '_' . $tid;

		// 当前词根分类列表
		$termData = $this->taxonomy->getTermsData($vid);

		// 开始事物
		DB::beginTransaction();
		//更新当前数据信息
		$flag =	DB::table('taxonomy_term_data')
				->where('tid', $tid)
				->update(
					array(
						'isDele' => 1
					)
				);
		foreach ($termData as $key => $value) {
			//查找当前类的所有子分类
			if(stripos($value->path . '_' . $value->tid, $toStrPath) !== FALSE && $value->tid != $tid){
			   if(!$flag){
			   	  break;
			   }
			   //更新子类信息
				$flag = DB::table('taxonomy_term_data')
						->where('tid', $value->tid)
						->update(
							array(
								'isDele' => 1
							)
						);
			}
		}
		if(!$flag){
			DB::rollback();
		}else{
			DB::commit();
		}
		echo '1';
		exit;
	}

	public function getVocabularyIndex()
	{
		$this->cVariable['vocaData'] = DB::table('taxonomy_vocabulary')->get();

		return View::make('Taxonomy.VocabularyIndex', $this->cVariable);
	}

	public function postVocabularyAddData(){
		$vocabularyName = Input::get('vocabularyName');
		$vocabularyDescription = Input::get('vocabularyDescription');

		$flag =	DB::table('taxonomy_vocabulary')->insert(
					array(
						'name' => $vocabularyName,
						'description' => $vocabularyDescription,
						'machine_name' => md5($vocabularyName),
						'hierarchy' => 0
					)
				);

		echo $flag;
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
