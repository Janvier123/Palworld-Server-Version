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
	echo "Your version is up to date! No need to update";
}
else
{
	if($local_version > $remote_version)
	{
		echo "Error, your version is newer then the remote, this should never happen";
	}
	else if($local_version < $remote_version)
	{
		echo "Error, your version is newer then the remote version. <br>Please update your server.";
		msg_discord("There is a new version for your server, please update it");
	}	
	else
	{
		echo "Error in versions";
	}
}
	
	
function msg_discord($msg)
{
	$webhookurl = "https://discord.com/api/webhooks/xxxxxxxxxxxxxxxxxxxxxxxxxxx/xxxxxxxxxxxxxxxxxxxxxxxxxxx";
	
	$json_data = json_encode(
	[
		"content" => $msg,
		"username" => "Palworld Version Checker",
	], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );

	$ch = curl_init( $webhookurl );
	curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
	curl_setopt( $ch, CURLOPT_POST, 1);
	curl_setopt( $ch, CURLOPT_POSTFIELDS, $json_data);
	curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt( $ch, CURLOPT_HEADER, 0);
	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);

	$response = curl_exec( $ch );
	curl_close( $ch );		
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
