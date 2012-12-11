<?php
require './Mustache.php';

$stationsFile = 'stations.csv';

$debug = false;
if (isset($_GET['debug'])) {
	$debug = true;
}

if (isset($_GET['forceUpdate'])) {
	/* Hvis forceUpdate, så sletter vi filen med stationsnavne -> UIC kode filen */
	unlink($stationsFile);
}

if (!file_exists($stationsFile)) {
	/* Hvis vi ikke har filen, der har UIC koden til en station */
	include 'opdaterUIC.php';
}

$msTemplate = file_get_contents('index.mustache');

/**
 * stationuic 8600760 er Sydhavn s-tog station.
 * se mere på http://dsblabs.dk/webservices/webservicestationsafgange
 * se mere om oData på http://www.odata.org/documentation/uri-conventions
 **/
$stationUic  = 8600760;
$stationName = 'Sydhavn';

if (!empty($_GET['station']) && is_numeric($_GET['station'])) {
	/* Efter som vi ved at $_GET['station'] er numeric, så er det nok pjat at bruge intval herunder */
	$stationUic = intval($_GET['station']);
}

$stationDropdown = array();
if (($handle = fopen($stationsFile, "r")) !== FALSE) {
	while (($data = fgetcsv($handle, 1000)) !== FALSE) {
		if (count($data) == 2) {
			$station = array('name' => utf8_encode($data[0]), 'uic' => $data[1]);
			if ($station['uic'] == $stationUic) {
				/* Vi bruger dette til at kunne vælge den viste station i dropdown og i overskrift og html title */
				$station['selected'] = 'selected ';
				$stationName = $station['name'];
			}
			array_push($stationDropdown, $station);
		}
	}
	fclose($handle);
}

$oDataUrl  = 'http://traindata.dsb.dk/stationdeparture/opendataprotocol.svc/Queue()?$format=json&$filter=StationUic%20eq%20';
$oDataUrl .= "'$stationUic'";

$cUrl = curl_init();
curl_setopt($cUrl, CURLOPT_URL, $oDataUrl);
curl_setopt($cUrl, CURLOPT_CONNECTTIMEOUT, 5);
curl_setopt($cUrl, CURLOPT_RETURNTRANSFER, 1);

$curlData = curl_exec($cUrl);
curl_close($cUrl);

$stationsData = json_decode($curlData);
$afgange      = $stationsData->d;

$stogAfgange = array();
foreach ($afgange as $afgang) {

	if (isset($afgang->Line)) {
		array_push($stogAfgange, $afgang);
	}
}

$data['departures']      = $stogAfgange;
$data['StationName']     = $stationName;
$data['stationDropdown'] = $stationDropdown;

if ($debug) {
	/* debug bruges i templaten til at gøre "debug sticky", når man vælger en ny station. */
	$data['debug'] = 'yes';
}

if (count($stogAfgange) == 0) {
	/* En lidt hurtig måde at gætte på, at noget sikkert er gået galt - burde laves bedre. */
	$data['error'] = 'Modtog ingen data fra DSB :(';
}

$mustache = new Mustache($msTemplate);
echo $mustache->render($msTemplate, $data, array(), array('charset' => 'UTF8'));

if ($debug) {
	echo "<hr><h2>Template data</h2>\n<pre>";
	var_dump($data);
	echo "</pre>";

	echo 'oData URL:<br>', $oDataUrl;
}
?>
