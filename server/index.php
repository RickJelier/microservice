<?php
//header('Access-Control-Allow-Origin: '.$_SERVER['HTTP_ORIGIN']);
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');



$request = explode('/', $_GET['url']);
$word = $request[0];
$language = isset($request[1]) ? $request[1] : false;

$dict = json_decode(file_get_contents('data/dict.json'), JSON_OBJECT_AS_ARRAY);
$result_str = '{';

foreach ($dict as $languageCode => $lang) {
	if (isset($lang[$word])) {
		$found = $lang[$word];


		if ($language) {
			if (isset($found[$language])) {
				$result_str .= '"'. $languageCode .'": [';
				foreach ($found[$language] as $foundLanguageWord) {
					$result_str .= '"'.$foundLanguageWord.'",';
				}
				$result_str = rtrim($result_str, ',');
				$result_str .= ']';

			}
		} else {
			foreach ($found as $languageCode2 => $foundword) {
				$result_str .= '"'. $languageCode2 .'": [';

				foreach ($foundword as $foundLanguageWord) {
					$result_str .= '"'.$foundLanguageWord.'",';
				}
				$result_str = rtrim($result_str, ',');
				$result_str .= ']';
				$result_str .= ",";
			}
		}
	}
}
$result_str = rtrim($result_str, ',');
$result_str .= '}';
echo json_encode('{"success": true, "results": '.$result_str.'}');




// echo json_encode('{"success": false, "error": {"code": 1, "message": "No translation found!"}}');