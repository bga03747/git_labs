<?php

	$requestAddress = "http://www.google.com/ig/api?weather=PH,1304&hl=en";
	
	if(file_get_contents($requestAddress)){
		//Get and Store API results into a variable
		$xml_str = file_get_contents($requestAddress,0);
	}else{
		$ch = curl_init();
		$timeout = 5;
		curl_setopt($ch,CURLOPT_URL,$requestAddress);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
		$xml_str = curl_exec($ch);
		curl_close($ch);		
	}
	
	// Parses XML
	$xml = new SimplexmlElement($xml_str);

	//retrieves information
	$information = $xml->xpath("/xml_api_reply/weather/forecast_information");
	foreach($information as $info){
		echo 'City&nbsp;:&nbsp;'.$info->city['data'].'<br>';
		echo 'Forecast date&nbsp;:&nbsp;'.$info->forecast_date['data'].'<br><br>';
	}
	
	//retrieves current conditions
	$current = $xml->xpath("/xml_api_reply/weather/current_conditions");
	foreach($current as $curr){
		echo 'Condition&nbsp;:&nbsp;'.$curr->condition['data'].'<br>';
		echo 'Fahrenheit&nbsp;:&nbsp;'.$curr->temp_f['data'].'<br>';
		echo 'Celsius&nbsp;:&nbsp;'.$curr->temp_c['data'].'<br>';
		echo $curr->humidity['data'].'<br>';
		echo $curr->wind_condition['data'].'<br><br>';
	}
	
	//retrieves forecast conditions
	$forecast_list = $xml->xpath("/xml_api_reply/weather/forecast_conditions");
	
	echo '<div id="weather">';
	
	foreach($forecast_list as $new) {
		echo '<div class="weatherIcon">';
		echo '<img src="http://www.google.com/' . $new->icon['data'] . '"/><br/>';
		echo $new->day_of_week['data'];
		echo '</div>';
	}
	
	echo '</div>';

?>
