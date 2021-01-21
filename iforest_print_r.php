


<?php


	//header('Content-Type: text/html; charset=UTF-8');
	
	
	function get_url($url) {
		$ch = curl_init();                                 //curl 초기화
		curl_setopt($ch, CURLOPT_URL, $url);               //URL 지정하기
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);    //요청 결과를 문자열로 반환 
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);      //connection timeout 10초 
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);   //원격 서버의 인증서가 유효한지 검사 안함
		curl_setopt($ch, CURLOPT_POST, true);              //true시 post 전송 
		 
		$response = curl_exec($ch);
		curl_close($ch);
		 
		return $response;
	}
	
	function objectToArray($d) {
		if (is_object($d)) {
			// Gets the properties of the given object
			// with get_object_vars function
			$d = get_object_vars($d);
		}
	 
		if (is_array($d)) {
			/*
			* Return array converted to object
			* Using __FUNCTION__ (Magic constant)
			* for recursive call
			*/
			return array_map(__FUNCTION__, $d);
		} else {
			// Return array
			return $d;
		}
	}
	
   function urldecode_array( $mixed ) {
      if (is_array($mixed)) {
         foreach ($mixed as $key => $value) {
            $mixed[$key] = urldecode_array($value);
         }
      } elseif (is_string($mixed)) {
         return urldecode($mixed);
      }
      return $mixed;

   }

	$content = get_url("http://chs.physia.kr/php_test/iforest.php");
	$content = json_decode($content);
	$content = objectToArray($content);
	$content = urldecode_array($content);
	
	print_r($content);

?>