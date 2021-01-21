


<?php


	//header('Content-Type: text/html; charset=UTF-8');
	
	
	error_reporting(E_ALL^ E_WARNING); 
	
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
	
	function substr_from_to($sentence,$needle_from,$needle_to)
	{
		$pos = strpos($sentence,$needle_from)+strlen($needle_from);
		$sentence = substr($sentence,$pos);
		$pos = strpos($sentence,$needle_to);
		$sentence = substr($sentence,0,$pos);
		return $sentence;
	}

	function utf8ize( $mixed ) {
		if (is_array($mixed)) {
			foreach ($mixed as $key => $value) {
				$mixed[$key] = utf8ize($value);
			}
		} elseif (is_string($mixed)) {
			$mixed = str_replace("\n","",$mixed);
			$mixed = str_replace("	","",$mixed);
			$mixed = str_replace("\r","",$mixed);
			$mixed = str_replace("\t","",$mixed);
			return urlencode($mixed);
		}
		return $mixed;

	}

	//산림조합 공판시세 페이지 가져오기
	$sply_date = date("Ymd",time());
	$content = get_url("http://iforest.nfcf.or.kr/forest/user.tdf?a=user.songi.SongiApp&c=1002");
	
	//표 부분만 파싱
	$content = substr_from_to($content,"<tbody>","</tbody>");
	
	//행 단위로 분리하기
	$needle = "<tr>";
	for($i=0;$i<substr_count($content,$needle);$i++)
	{
		$needle_from = "<tr>";
		$needle_to = "</tr>";
		$row[$i] = substr_from_to($content,$needle_from,$needle_to);
		$content = substr($content,strpos($content,$needle_to)+strlen($needle_to));
	}
	
	//각 행에서 열 단위로 데이터 구분하기
	for($i=0;$i<count($row);$i++)
	{
		$row_column[$i]->state = substr_from_to($row[$i],"<td>","</td>");
			$row[$i] = substr($row[$i],strpos($row[$i],"</td>")+strlen("</td>"));
		$row_column[$i]->city = substr_from_to($row[$i],"<td>","</td>");
			$row[$i] = substr($row[$i],strpos($row[$i],"</td>")+strlen("</td>"));
		$row_column[$i]->data[1] = [
			"weight"=>substr_from_to($row[$i],'<td class="price">',"<br />"),
			"price"=>substr_from_to($row[$i],"<br />","</td>")
		]; $row[$i] = substr($row[$i],strpos($row[$i],"</td>")+strlen("</td>"));
		$row_column[$i]->data[2] = [
			"weight"=>substr_from_to($row[$i],'<td class="price">',"<br />"),
			"price"=>substr_from_to($row[$i],"<br />","</td>")
		]; $row[$i] = substr($row[$i],strpos($row[$i],"</td>")+strlen("</td>"));
		$row_column[$i]->data[3] = [
			"weight"=>substr_from_to($row[$i],'<td class="price">',"<br />"),
			"price"=>substr_from_to($row[$i],"<br />","</td>")
		]; $row[$i] = substr($row[$i],strpos($row[$i],"</td>")+strlen("</td>"));
		$row_column[$i]->data[4] = [
			"weight"=>substr_from_to($row[$i],'<td class="price">',"<br />"),
			"price"=>substr_from_to($row[$i],"<br />","</td>")
		]; $row[$i] = substr($row[$i],strpos($row[$i],"</td>")+strlen("</td>"));
		$row_column[$i]->data[5] = [
			"weight"=>substr_from_to($row[$i],'<td class="price">',"<br />"),
			"price"=>substr_from_to($row[$i],"<br />","</td>")
		]; $row[$i] = substr($row[$i],strpos($row[$i],"</td>")+strlen("</td>"));
		$row_column[$i]->data[6] = [
			"weight"=>substr_from_to($row[$i],'<td class="price">',"<br />"),
			"price"=>substr_from_to($row[$i],"<br />","</td>")
		]; $row[$i] = substr($row[$i],strpos($row[$i],"</td>")+strlen("</td>"));
		$row_column[$i]->data[7] = [
			"weight"=>substr_from_to($row[$i],'<td class="price">',"<br />"),
			"price"=>substr_from_to($row[$i],"<br />","</td>")
		]; $row[$i] = substr($row[$i],strpos($row[$i],"</td>")+strlen("</td>"));
		$row_column[$i]->data[8] = [
			"weight"=>substr_from_to($row[$i],'<td class="price">',"<br />"),
			"price"=>substr_from_to($row[$i],"<br />","</td>")
		]; $row[$i] = substr($row[$i],strpos($row[$i],"</td>")+strlen("</td>"));
		$row_column[$i]->data[9] = [
			"weight"=>substr_from_to($row[$i],'<td class="price">',"<br />"),
			"price"=>substr_from_to($row[$i],"<br />","</td>")
		]; $row[$i] = substr($row[$i],strpos($row[$i],"</td>")+strlen("</td>"));
		$row_column[$i]->date = substr_from_to($row[$i],"<td>","</td>");
			$row[$i] = substr($row[$i],strpos($row[$i],"</td>")+strlen("</td>"));
	}
	
	//객체로 구성하기
	for($i=0;$i<count($row);$i++)
	{
		$object[$i] = [
			"state" => $row_column[$i]->state,
			"city" => $row_column[$i]->city,
			"data" => [
				$row_column[$i]->data[1],
				$row_column[$i]->data[2],
				$row_column[$i]->data[3],
				$row_column[$i]->data[4],
				$row_column[$i]->data[5],
				$row_column[$i]->data[6],
				$row_column[$i]->data[7],
				$row_column[$i]->data[8],
				$row_column[$i]->data[9],
			],
			"date" => $row_column[$i]->date,
		];
	}

	//print_r($object);
	//print_r(utf8ize($object));
	echo json_encode(utf8ize($object),JSON_UNESCAPED_UNICODE);

?>