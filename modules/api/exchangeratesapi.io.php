<?php
define('URL', 'https://api.exchangeratesapi.io');


function currencyList(){
	$target_url = URL . '/latest';
	$response = file_get_contents($target_url);
	$response = json_decode($response, true)['rates'];
	$csv = array_map('str_getcsv', file('codes.csv'));
	$currency_name = '';
	foreach($response as $key => $value) {
		for($i = 0; $i<count($csv); $i++){
			if($csv[$i][2]=="$key"){
				$currency_name = $csv[$i][1];
				unset($csv[$i]);
				break;
			}
		}
 		echo "<option value='$key'>" . "$key - $currency_name" . "</option>";
	}
	
	

}

function buyPrice($to, $from, $endpoint = false, $params = false){
	if($endpoint == false){
		$endpoint = '/latest';
	}

	$target_url = URL . $endpoint . "?format=json&base=$from";

	if($params == !false){
		$target_url .= $params;
	}

	$response = file_get_contents($target_url);
	return json_decode($response, true)['rates'][$to];

}


if(isset($_GET['function'])){
	if(@$_GET['function']==0){
		$from_amount = $_GET['from_amount'];
		$price = buyPrice($_GET['to'], $_GET['from']);
		echo number_format(($from_amount * $price), 3);
	}
}



?>
