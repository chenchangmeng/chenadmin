<?php
class Email extends Eloquent{
	/**
	 * 发信域名子账号
	 */
	private $api_user = "postmaster@chen.sendcloud.org";
	/**
	 * key值
	 */
	private $api_key = "53LkfBnHYALhbCpm";

	/**
	 * 获取邮件列表
	 */
	public function getPostList(){
		$url = "https://sendcloud.sohu.com/webapi/list.get.xml?api_user={$this->api_user}&api_key={$this->api_key}";

		$res = $this->getUrlResult($url);
		if($res !== FALSE && ($xmlData = simplexml_load_string($res)) !== FALSE){
		   return $xmlData;
		}
	}


	private function getUrlResult($url,$postData=""){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		if($postData){
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
			curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
		}
		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		$result = curl_exec($ch);

        if($result === false) //请求失败
        {
           //echo 'last error : ' . curl_error($ch);
           //$result = false;
        }

        curl_close($ch);

        return $result;
	}
}