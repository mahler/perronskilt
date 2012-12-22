<?php
require_once 'shared.php';

$long = null;
$lat  = null;

if (!empty($_GET['long'])) {
	$long = $_GET['long'];
}

if (!empty($_GET['lat'])) {
	$lat = $_GET['lat'];
}

if (isset($_GET['debug'])) {
	echo "lat: $lat<br>";
	echo "long: $long<br>";
}

$answer = '';
if ($long && $lat) {
	$url      = sprintf('http://geo.oiorest.dk/holdepladser/%f,%f.json?holdepladstype=1', $lat, $long);
	if (isset($_GET['debug'])) {
		echo $url;
	}
	$curlData = fetchUrl($url);
	$jsonData = json_decode($curlData);
	$station  = $jsonData[0];
	$holdepladsnr = $station->holdepladsnr;


	if (isset($_GET['debug'])) {
		var_dump($station);
	}


		$answer = sprintf('[{ "holdepladsnr": "%s" }]',  intval($holdepladsnr));
}

echo $answer;
exit();
?>