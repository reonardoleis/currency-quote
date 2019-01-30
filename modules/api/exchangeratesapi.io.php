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



function pricesInPeriod($base){
	$year = date("Y");
	$month = date("m");
	$day = date("d");
	$start_date = "$year-$month-" . ($day-7);
	$end_date = "$year-$month-$day";
	$target_url = URL . '/history?start_at=' . $start_date . '&end_at=' . $end_date . '&base=' . $base;
	return json_decode(file_get_contents($target_url), true);
	
}


if(isset($_GET['function'])){
	if(@$_GET['function']==0){
		$from_amount = $_GET['from_amount'];
		$price = buyPrice($_GET['to'], $_GET['from']);
		echo number_format(($from_amount * $price), 3);
	}
}



?>