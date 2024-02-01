<?php
error_reporting(E_ALL);
include('vdfparser.php');

$remote_version = getVersion();

// 2394010 = Palworld Dedicated Server
// windows path
$kv = VDFParse("C:\\steamcmd\\steamapps\\appmanifest_2394010.acf");


$local_version = $kv['AppState']['buildid'];


if($local_version === $remote_version)
{
	echo "Error, your version is newer then the remote, this should never happen";
}
else
{
	if($local_version > $remote_version)
	{
		echo "Error, your version is newer then the remote, this should never happen";
	}
	else if($local_version < $remote_version)
	{
		echo "There is a new version for your server, please update it";
		msg_discord("There is a new version for your server, please update it");
	}	
	else
	{
		echo "Error in versions";
	}
}
	
	
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
