<?php
require_once './Mustache.php';
require_once './shared.php';

$stationsFile = 'stations.csv';
$msTemplate   = file_get_contents('index.mustache');
$data         = array();
$debug        = false;

if (isset($_GET['debug'])) {
	$debug = true;

	/* debug bruges i templaten til at gøre "debug sticky", når man vælger en ny station. */
	$data['debug'] = 'yes';
}

if (isset($_GET['forceUpdate'])) {
	/* Hvis forceUpdate, så sletter vi filen med stationsnavne -> UIC kode filen */
	unlink($stationsFile);
}

if (!file_exists($stationsFile)) {
	/* Hvis vi ikke har filen, der har UIC koden til en station */
	include 'opdaterUIC.php';
}

/**
 * stationuic 8600760 er Sydhavn s-tog station.
 * se mere på http://www.dsb.dk/dsb-labs/webservice-stationsafgange/l
 * se mere om oData på http://www.odata.org/documentation/uri-conventions
 **/
$stationUic  = 8600760;
$stationName = 'Sydhavn';

/**
 * Cookie manager bruges til at huske seneste sete station.
 * Ønskes denne funktionalitet ikke, kan den blot udkommenteres.
 * cookieManager kan opdatere værdien af $stationUic, hvis der er en gemt værdi.
 */
include 'cookieManager.php';

if (!empty($_GET['station']) && is_numeric($_GET['station'])) {
	/* Efter som vi ved at $_GET['station'] er numeric, så er det nok pjat at bruge intval herunder */
	$stationUic = intval($_GET['station']);
}

$stationDropdown = array();
setlocale(LC_ALL, 'da_DK.UTF8');
if (($handle = fopen($stationsFile, "rb")) !== FALSE) {
	while (($fileRow = fgetcsv($handle, 1000)) !== FALSE) {
		if (count($fileRow) == 2) {
			$station = array('name' => $fileRow[0], 'uic' => $fileRow[1]);
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

$oDataUrl     = "http://traindata.dsb.dk/stationdeparture/opendataprotocol.svc/Queue()?\$format=json&\$filter=StationUic%20eq%20'$stationUic'";
$curlData     = fetchUrl($oDataUrl);
$stationsData = json_decode($curlData);
$afgange      = $stationsData->d;
$stogAfgange  = array();

/* Check at vi fik nogle afgange... */
if (is_array($afgange)) {
	foreach ($afgange as $afgang) {

		if (isset($afgang->Line)) {
			array_push($stogAfgange, $afgang);
		}
	}
}

if (file_exists('analytics.txt')) {
	/* Man kan tilføje analytics kode (f.eks. google analytics) ved at placere tracking koden i en fil kaldet "analytics.txt". */
	$analyticsCode = file_get_contents('analytics.txt');
	$data['analyticsCode']   = $analyticsCode;
}

$data['departures']      = $stogAfgange;
$data['StationName']     = $stationName;
$data['stationDropdown'] = $stationDropdown;

if (count($stogAfgange) == 0) {
	/* En lidt hurtig måde at gætte på, at noget sikkert er gået galt - burde laves bedre. */
	$data['error'] = 'Modtog ingen data fra DSB :(';
}

$mustache = new Mustache($msTemplate);
echo $mustache->render($msTemplate, $data, array(), array('charset' => 'UTF8'));

if ($debug) {
	echo "<hr><h2>Template data</h2>\n<pre>";
	var_dump($data);
	echo '</pre><br>oData URL:<br>', $oDataUrl;
}