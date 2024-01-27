<?php
error_reporting(E_ALL);


echo getVersion();
	
	
function getVersion()
{
	// 2394010 = Palworld Dedicated Server
	$api_url = 'https://api.steamcmd.net/v1/info/2394010';
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_URL, $api_url);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);     
	$curl_data = curl_exec($ch);
	curl_close($ch);
	$json_array = json_decode($curl_data, true);
	
	return $json_array['data']['2394010']['depots']['branches']['public']['buildid'];
}
?>
