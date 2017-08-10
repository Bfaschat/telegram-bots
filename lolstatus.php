<?php 
define('BOT_TOKEN', '123');
define('API_URL', 'https://api.telegram.org/bot'.BOT_TOKEN.'/');
	
// read incoming info and grab the chatID
$content = file_get_contents("php://input");
$update = json_decode($content, true);
$chatID = $update["message"]["chat"]["id"];
$message = $update["message"]["text"];

$country = array(
"NA" => "North America",
"EUW" => "EU West",
"EUNE" => "EU Nordic & East",
"LAN" => "Latin America North",
"LAS" => "Latin America South",
"BR" => "Brazil",
"TR" => "Turkey",
"RU" => "Russia",
"OCE" => "Oceania",
"JP" => "Japan"
);

if($message=="/start")
{
	$sendto =API_URL."sendmessage?chat_id=".$chatID."&text=".urlencode("Welcome to the League of Ledgends Server Status Blog.")."&reply_markup=".urlenco
de('{"keyboard":[["NA","EUW","EUNE","LAN","LAS"],["BR","TR","RU","OCE","JP"]]}');
	file_get_contents($sendto);
}
	
// compose reply
if(in_array($message,array_keys($country)))
{
	$content = file_get_contents("http://status.leagueoflegends.com/shards/".strtolower($message)."/summary");
	$update = json_decode($content, true);
	$status = $update["status"];
	$info = $update["messages"][0]["content"];

	if($status=="online") $flag = "\xE2\x9C\x85"; else $flag = "\xE2\x9D\x8C";

	$sendto =API_URL."sendmessage?parse_mode=Markdown&chat_id=".$chatID."&text=".urlencode($flag." *".$country[$message]." [ ".ucwords($status)." ]*\n\n
".$info);
	file_get_contents($sendto);
}


?>
