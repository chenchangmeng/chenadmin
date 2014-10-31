<?php

class EmailController extends BaseController {

	private $email;

	public function __construct(){
		parent::__construct();
		$this->email = new Email;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getEmailIndex()
	{
		$xml = $this->email->getPostList();
		echo "<pre>";
		var_dump($xml);
		echo "</pre>";
	}


}
