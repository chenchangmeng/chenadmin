<?php

class DashboardController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getDashboardIndex()
	{
		$con = DB::table('basic')->where('type', 'dashboard')->first();
		//反序列化
		$this->cVariable['id'] = $con->id;
		$this->cVariable['content'] = unserialize($con->content);
		return View::make('Dashboard.DashboardIndex', $this->cVariable);
	}

	public function postDashboardConfigData(){
		$xss = new Xss;
		$data = Input::all();
		if(is_array($data) && !empty($data)){
			foreach ($data as $key => $value) {
				$data[$key] = $xss->clean($value);
			}
		}
		$con = serialize($data);
		$config = array(
			'type' => 'dashboard',
			'content' => $con,
			'updated_at' => date('Y-m-d H:i:s')
		);
		$bool = DB::table('basic')
		            ->where('id', intval(Input::get('id')))
		            ->update($config);
		return Redirect::to("dashboard/dashboard-index");
	}

}
