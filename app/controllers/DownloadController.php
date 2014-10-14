<?php

class DownloadController extends BaseController {
	private $download;

	public function __construct(){
		parent::__construct();
		$this->download = new Download;
		//$this->beforeFilter('csrf', array('only'=>array('')));

		// php composer.phar install
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getSoftInfo($type)
	{
		$this->cVariable['softBasicData'] = $this->download->getDownloadBasicInfo('soft');


		$this->cVariable['total'] = 0;

        $this->cVariable['pages'] = ceil($this->cVariable['total'] / 10); //总页数

        $this->cVariable['softData'] = array();



		return View::make('Download.SoftIndex', $this->cVariable);
	}

	public function postDownloadBasicData(){
		$softInfo = array(
			'content' => Input::get('content'),
			'updated_at' => date('Y-m-d H:i:s')
		);
		$bool = DB::table('basic')
		            ->where('id', intval(Input::get('id')))
		            ->update($softInfo);
		if($bool){
			$this->log('保存软件信息简介成功');
			echo 'success';
		}else{
			echo 'fail';
		}
	}

}
