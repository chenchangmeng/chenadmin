<?php

class CommonController extends Controller{
	public function __construct(){
		$this->beforeFilter('csrf', array('only'=>array('dealLogin')));
	}

	public function log($message){
		$mess = array(
			'uid' => 1,
			'ip' => Request::getClientIp(),
			'message' => $message,
			'created_at' => date('Y-m-d H:i:s')
		);

		DB::table('log')->insert($mess);
	}

	public function login(){
		return View::make('login');
	}

	/**
	 * captcha
	 */
	public function renderCaptcha(){
		$captcha = new Captcha;

		$code = $captcha->generateVerifyCode();
		
		//$this->log('new_'.$code);
		
		Session::put('captcha_code', $code);
		
		// $value = Session::get('captcha_code');
		// $this->log('session_'.$value);

		$captcha->renderImageGD($code);
	}

	public function validateCaptcha(){
		$value = Session::get('captcha_code');

		$captcha = Input::get('validate_code');
	
		if(strtolower($value) == strtolower($captcha)){
			//验证码正确
			echo 'true';
			exit;
		}

		echo 'false' . '#' .  $captcha . '#' . $value;
		exit;
	}

	public function dealLogin(){
		$userName = Input::get('userName');
		$userPass = Input::get('password');

		if (Auth::attempt(array('userName' => $userName, 'password' => $userPass), false)){
    		
    		DB::table('users')->where('id', Auth::user()->id)->update(array('loginNum' => Auth::user()->loginNum+1));
    		
    		$userInfo = DB::table('users')
			            ->join('role', 'role.roleId', '=', 'users.roleId')
			            ->select('users.*', 'role.roleName')
			            ->where('users.id', '=', Auth::user()->id)
			            ->get();
			Session::put('userInfo', serialize($userInfo[0]));

			return Redirect::to("news/news-index");
		}else{
			Session::flash('loginMsg', '用户名或密码错误！');
			return Redirect::to("login");
		}
	}

	public function dealLoginOut(){
		Auth::logout(); //修改源代码 注释修改 $this->refreshRememberToken($user);
		return Redirect::guest('login');
	}

}
