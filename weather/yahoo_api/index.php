<?php
	//the WOEID (Where on Earth IDentifier) used is for Manila, Philippines
	$url = 'http://weather.yahooapis.com/forecastrss?w=1199477&u=c';
	
	//if file_get_contents is permitted on the server
	if(file_get_contents($url)){
		$xml = file_get_contents($url);
	}else{
		//use cURL as substitute
		$ch = curl_init();
		$timeout = 5;
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
		$xml = curl_exec($ch);
		curl_close($ch);		
	}
	
	//load xml string
	$weather = simplexml_load_string($xml);
	
	//for the code to read yahoo weather api
	$channel_yweather = $weather->channel->children("http://xml.weather.yahoo.com/ns/rss/1.0");
	
	//compile channel data into an array ($yw_channel)
	foreach($channel_yweather as $x => $channel_item) 
		foreach($channel_item->attributes() as $k => $attr) 
			$yw_channel[$x][$k] = $attr;
	
	//retrieve location array
	foreach($yw_channel['location'] as $key => $val){
		$loc_tr .= '<tr>
						<td>'.$key.'</td>
						<td>'.$val.'</td>
					</tr>';
	}
	
	//retrieve units array
	foreach($yw_channel['units'] as $key => $val){
		$units_tr .= '<tr>
						<td>'.$key.'</td>
						<td>'.$val.'</td>
					</tr>';
	}
	
	//retrieve wind array
	foreach($yw_channel['wind'] as $key => $val){
		$wind_tr .= '<tr>
						<td>'.$key.'</td>
						<td>'.$val.'</td>
					</tr>';
	}
	
	//retrieve atmosphere array
	foreach($yw_channel['atmosphere'] as $key => $val){
		$atm_tr .= '<tr>
						<td>'.$key.'</td>
						<td>'.$val.'</td>
					</tr>';
	}
	
	//retrieve astronomy array
	foreach($yw_channel['astronomy'] as $key => $val){
		$astro_tr .= '<tr>
						<td>'.$key.'</td>
						<td>'.$val.'</td>
					</tr>';
	}
	
	echo '<table border="1" cellspacing="1" cellpadding="0">
			<tr>
				<th colspan="2">Location</th>
			</tr>
			'.$loc_tr.'
			<tr>
				<th colspan="2">Units</th>
			</tr>
			'.$units_tr.'
			<tr>
				<th colspan="2">Wind</th>
			</tr>
			'.$wind_tr.'
			<tr>
				<th colspan="2">Atmosphere</th>
			</tr>
			'.$atm_tr.'
			<tr>
				<th colspan="2">Astronomy</th>
			</tr>
			'.$astro_tr.'
		  </table>';
	
	//compile item data into an array ($yw_forecast)
	$channel_yweather = $weather->channel->item->children("http://xml.weather.yahoo.com/ns/rss/1.0");
	
	foreach($channel_yweather as $x => $yw_item) {
		foreach($yw_item->attributes() as $k => $attr) {
			if($k == 'day') $day = $attr;
			if($x == 'forecast') { $yw_forecast[$x][$day . ''][$k] = $attr;	} 
			else { $yw_forecast[$x][$k] = $attr; }
		}
	}
	
	//retrieve current condition array
	foreach($yw_forecast['condition'] as $key => $val){
		$curr_con_tr .= '<tr>
						<td>'.$key.'</td>
						<td>'.$val.'</td>
					</tr>';
	}
	
	//retrieve forecast array
	foreach($yw_forecast['forecast'] as $key => $val){
		foreach($val as $key2 => $val2){
			$fore_tr .= '<tr>
							<td>'.$key2.'</td>
							<td>'.$val2.'</td>
						</tr>';
		}
	}
	
	echo '<table border="1" cellspacing="1" cellpadding="0">
			<tr>
				<th colspan="2">Location</th>
			</tr>
			'.$curr_con_tr.'
			<tr>
				<th colspan="2">Forecast</th>
			</tr>
			'.$fore_tr.'
		  </table>';
	
	//compile image data into an array ($yw_img)
	$yw_image = $weather->channel->item->description;
	
	foreach($yw_image as $a) {
		$img_desc = explode('<br />',$a);
	}
	
	echo '<pre>';
	print_r($img_desc[0]);
	echo '</pre>';