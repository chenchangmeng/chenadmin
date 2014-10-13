<?php

class CareerController extends BaseController {
	private $career;

	public function __construct(){
		parent::__construct();
		$this->career = new Career;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getCareerIndex()
	{
		//获取招聘基本信息

		$this->cVariable['careerBasicData'] = $this->career->getCareerBasicInfo('career');

		$this->cVariable['careerInfoData'] = $this->career->getCareerData();


        //var_dump($this->cVariable['newsData']);

		return View::make('Career.CareerIndex', $this->cVariable);
	}

	public function postCareerBasicData(){

		$careerInfo = array(
			'type' => 'career',
			'content' => Input::get('content'),
			'updated_at' => date('Y-m-d H:i:s')
		);
		$bool = DB::table('basic')
		            ->where('id', intval(Input::get('id')))
		            ->update($careerInfo);
		if($bool){
			$this->log('保存招聘信息成功');
			echo 'success';
		}else{
			echo 'fail';
		}
	}

	public function getCareerAdd(){
		return View::make('Career.CareerAdd', $this->cVariable);
	}

	public function getCareerUpdate($id){
		$resultData = $this->career->getCareerOne($id);
		if(empty($resultData)){
			return Redirect::to("career/career-index");
		}

		$this->cVariable['resultData'] = $resultData;

		return View::make('Career.CareerUpdate', $this->cVariable);
	}

	public function postCareerAddData(){
		$xss = new Xss;
		$careerInfo = array(
			'careerName' => $xss->clean(Input::get('careerName')),
			'sort' => intval(Input::get('sort')),
			'status' => intval(Input::get('status')),
			'careerInfo' => Input::get('careerDetailContent'),
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s')
		);
		$action = "career/career-index";
		$insertId = DB::table('career')->insertGetId($careerInfo);

		if($insertId){
		   $this->log('添加职位：'.$careerInfo['careerName']);
		}else{
		   $action = "career/career-add";
		}

		return Redirect::to($action);
	}

	public function postCareerUpdateData(){
		$xss = new Xss;
		$id = intval(Input::get('id'));
		$careerInfo = array(
			'careerName' => $xss->clean(Input::get('careerName')),
			'sort' => intval(Input::get('sort')),
			'status' => intval(Input::get('status')),
			'careerInfo' => Input::get('careerDetailContent'),
			'updated_at' => date('Y-m-d H:i:s')
		);
		$action = "career/career-index";
		$bool = DB::table('career')
		            ->where('id', $id)
		            ->update($careerInfo);

		if($bool){
		   $this->log('修改职位：'.$careerInfo['careerName']);
		}else{
		   $action = "career/career-update/".$id;
		}

		return Redirect::to($action);
	}

	public function getCareerDelete($id){
		$action = "career/career-index";
		if(is_numeric($id)){
			$newsData = DB::table('career')->where('id', '=', $id)->get();
			$bool = DB::table('career')->where('id', '=', $id)->delete();
			if($bool){				
				$this->log('删除职位：'.$newsData[0]->careerName);
			}
		}
		return Redirect::to($action);
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
