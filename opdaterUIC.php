<?php
/**
 * Opdaterer cachet liste af s-togs stationer på baggrund af data fra geo.oiorest.dk
 */
$targetFilename = 'stations.csv';

setlocale(LC_ALL, 'da_DK.UTF8');

/* Dette kald returnerer alle s-tog stationer  */
$oDataUrl = 'http://geo.oiorest.dk/holdepladser.json?holdepladstype=1';

$cUrl = curl_init();
curl_setopt($cUrl, CURLOPT_URL, $oDataUrl);
curl_setopt($cUrl, CURLOPT_CONNECTTIMEOUT, 5);
curl_setopt($cUrl, CURLOPT_RETURNTRANSFER, 1);

$curlData = curl_exec($cUrl);
curl_close($cUrl);

$rawAnswer  = json_decode($curlData);
$stogBuffer = array();
foreach ($rawAnswer as $stationRow) {
	// Data fra oiorest postfix'er alle stationer med " st". Det fjerner vi lige.
	$sNavn = $stationRow->navn;
	$sNavn = preg_replace('/ (st)$/', '', $sNavn);

	array_push($stogBuffer, array( 'navn' => $sNavn, 'uic' => $stationRow->holdepladsnr));
}

/* Sorter liste alfabetisk */
ksort($stogBuffer);

/* Data i filen skrives i UTF8 format (json data kommer ind som UTF8). */
$fp = fopen($targetFilename, 'w');
foreach ($stogBuffer as $stogStation) {
	fputcsv($fp, $stogStation);
}
fclose($fp);
