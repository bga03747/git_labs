<?php
	
	if(isset($_POST['convert_button'])){
		
		$amount = $_POST['amount'];
		$ctype = $_POST['ctype'];
		$convtype = $_POST['convtype'];
		
		//make string to be put in API
		$getstr = $amount.$ctype.'=?'.$convtype;
		
		//Call Google API
		$url = "http://www.google.com/ig/calculator?hl=en&q=".$getstr;
 		
		if(file_get_contents($url)){
			//Get and Store API results into a variable
			$res = explode(',',file_get_contents($url));
		}else{
			$ch = curl_init();
			$timeout = 5;
			curl_setopt($ch,CURLOPT_URL,$url);
			curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
			curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
			$res = explode(',',curl_exec($ch));
			curl_close($ch);		
		}
 		
		/*left hand side*/
		$lh_arr= explode(':',$res[0]);
		$currency = str_replace('"','',$lh_arr[1]);
		
		/*right hand side*/
		$rh_arr= explode(':',$res[1]);
		$converted = str_replace('"','',$rh_arr[1]);
		
		$results = 'Url&nbsp;:&nbsp;'.$url.'<br>Currency&nbsp;:&nbsp;'.$currency.'<br>Converted&nbsp;:&nbsp;'.$converted.'<br>';
		
		//temporarily hide converter div
		echo '<style>#converter{display:none}</style>';
		
		echo '<script type="text/javascript">';
		echo '	function new_conversion(){
					document.getElementById(\'result\').style.display = "none";
					document.getElementById(\'converter\').style.display = "block";
				}';
		echo '</script>';
	
	}else{ 
		//by default, hide results div
		echo '<style>#result{display:none}</style>';
	}
	
	//currency
	$curr_arr = array(
					array('EUR','Euro - EUR'),
					array('USD','United States Dollars - USD'),
					array('GBP','United Kingdom Pounds - GBP'),
					array('CAD','Canada Dollars - CAD'),
					array('AUD','Australia Dollars - AUD'),
					array('JPY','Japan Yen - JPY'),
					array('INR','India Rupees - INR'),
					array('NZD','New Zealand Dollars - NZD'),
					array('CHF','Switzerland Franc - CHF'),
					array('ZAR','South Africa Rand - ZAR'),
					array('DZD','Algeria Dinars - DZD'),
					array('USD','America (United States) Dollars - USD'),
                  	array('ARS','Argentina Pesos - ARS'),
                  	array('AUD','Australia Dollars - AUD'),
					array('BHD','Bahrain Dinars - BHD'),
                  	array('BRL','Brazil Reais - BRL'),
                  	array('BGN','Bulgaria Leva - BGN'),
                  	array('CAD','Canada Dollars - CAD'),
                  	array('CLP','Chile Pesos - CLP'),
                  	array('CNY','China Yuan Renminbi - CNY'),
                  	array('CNY','RMB (China Yuan Renminbi) - CNY'),
                  	array('COP','Colombia Pesos - COP'),
                  	array('CRC','Costa Rica Colones - CRC'),
                  	array('HRK','Croatia Kuna - HRK'),
                  	array('CZK','Czech Republic Koruny - CZK'),
                  	array('DKK','Denmark Kroner - DKK'),
                  	array('DOP','Dominican Republic Pesos - DOP'),
                  	array('EGP','Egypt Pounds - EGP'),
                  	array('EEK','Estonia Krooni - EEK'),
                  	array('EUR','Euro - EUR'),
                  	array('FJD','Fiji Dollars - FJD'),
                  	array('HKD','Hong Kong Dollars - HKD'),
                  	array('HUF','Hungary Forint - HUF'),
                  	array('ISK','Iceland Kronur - ISK'),
                  	array('INR','India Rupees - INR'),
                  	array('IDR','Indonesia Rupiahs - IDR'),
                  	array('ILS','Israel New Shekels - ILS'),
                  	array('JMD','Jamaica Dollars - JMD'),
                  	array('JPY','Japan Yen - JPY'),
                  	array('JOD','Jordan Dinars - JOD'),
                  	array('KES','Kenya Shillings - KES'),
                  	array('KRW','Korea (South) Won - KRW'),
                  	array('KWD','Kuwait Dinars - KWD'),
                  	array('LBP','Lebanon Pounds - LBP'),
                  	array('MYR','Malaysia Ringgits - MYR'),
                  	array('MUR','Mauritius Rupees - MUR'),
                  	array('MXN','Mexico Pesos - MXN'),
                  	array('MAD','Morocco Dirhams - MAD'),
                  	array('NZD','New Zealand Dollars - NZD'),
                  	array('NOK','Norway Kroner - NOK'),
                  	array('OMR','Oman Rials - OMR'),
                  	array('PKR','Pakistan Rupees - PKR'),
                  	array('PEN','Peru Nuevos Soles - PEN'),
                  	array('PHP','Philippines Pesos - PHP'),
                  	array('PLN','Poland Zlotych - PLN'),
                  	array('QAR','Qatar Riyals - QAR'),
                  	array('RON','Romania New Lei - RON'),
                  	array('RUB','Russia Rubles - RUB'),
                  	array('SAR','Saudi Arabia Riyals - SAR'),
                  	array('SGD','Singapore Dollars - SGD'),
                  	array('SKK','Slovakia Koruny - SKK'),
                  	array('ZAR','South Africa Rand - ZAR'),
                  	array('KRW','South Korea Won - KRW'),
                  	array('LKR','Sri Lanka Rupees - LKR'),
                  	array('SEK','Sweden Kronor - SEK'),
                  	array('CHF','Switzerland Francs - CHF'),
                  	array('TWD','Taiwan New Dollars - TWD'),
                  	array('THB','Thailand Baht - THB'),
                  	array('TTD','Trinidad and Tobago Dollars - TTD'),
                  	array('TND','Tunisia Dinars - TND'),
                  	array('TRY','Turkey Lira - TRY'),
                  	array('AED','United Arab Emirates Dirhams - AED'),
                  	array('GBP','United Kingdom Pounds - GBP'),
                  	array('USD','United States Dollars - USD'),
                  	array('VEB','Venezuela Bolivares - VEB'),
                  	array('VND','Vietnam Dong - VND'),
                  	array('ZMK','Zambia Kwacha - ZMK'),
					
				);
	
?>
<div id="result">
	<?php echo $results;?>
    <a href = "javascript:void(0)" onclick="new_conversion()">New Conversion</a>
</div>
<div id="converter">
    <form method="post">
        <table>
            <tr>
                <td>Amount:</td>
                <td><input type="text" name="amount" value="<?php echo $_POST['amount'];?>" /></td>
            </tr>
            <tr>
                <td>Currency Type:</td>
                <td>
                    <select name="ctype">
                        <?php foreach($curr_arr as $row):?>
                            <option <?php if($_POST['ctype'] == $row[0]){echo 'selected = "selected"';}?> value = "<?php echo $row[0];?>"><?php echo $row[1];?></option>
                        <?php endforeach;?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Currency Type:</td>
                <td>
                    <select name="convtype">
                        <?php foreach($curr_arr as $row):?>
                            <option <?php if($_POST['convtype'] == $row[0]){echo 'selected = "selected"';}?> value = "<?php echo $row[0];?>"><?php echo $row[1];?></option>
                        <?php endforeach;?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td><input type="submit" name="convert_button" value="Convert" /></td>
            </tr>
        </table>
    </form>
</div><!--end converter-->