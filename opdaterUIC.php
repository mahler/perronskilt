<?php
/**
 * Denne fil downloader stationer fra dsb med henblik på at finde stationernes UIC nummer.
 * Vi er kun interesseret i s-tog, hvorfor stationer vælges ud fra en whiteliste, der findes
 * i den lokale fil "stations.txt".
 */
$targetFilename = 'stations.csv';
$fileContent    = file_get_contents('stations.txt');
$dataLines      = explode("\n", $fileContent);
$stogStation    = array();

setlocale(LC_ALL, 'da_DK.UTF8');

foreach ($dataLines as $stationRow) {
  /* Check at det ikke er en kommentar */
  if (!(substr($stationRow, 0, 1) == '#') && !empty($stationRow)) {
      $stogStation[$stationRow] = 1;
  }
}

/* Dette kald returnerer alle stationer (incl. et par tyske og svenske). */
$oDataUrl = 'http://traindata.dsb.dk/stationdeparture/opendataprotocol.svc/Station()?$format=json';

$cUrl = curl_init();
curl_setopt($cUrl, CURLOPT_URL, $oDataUrl);
curl_setopt($cUrl, CURLOPT_CONNECTTIMEOUT, 5);
curl_setopt($cUrl, CURLOPT_RETURNTRANSFER, 1);

$curlData = curl_exec($cUrl);
curl_close($cUrl);

$rawAnswer   = json_decode($curlData);
$rawStations = $rawAnswer->d;

$stogBuffer = array();
foreach ($rawStations as $stationRow) {
  $stationsNavn = $stationRow->Name;

  /* Er det en s-tog station? */
  if (isset($stogStation[$stationsNavn])) {
      $stogBuffer[$stationsNavn] = array( 'navn' => $stationsNavn, 'uic' => $stationRow->UIC);
  }
}

/* Sorter liste alfabetisk */
ksort($stogBuffer);

/* Data i filen skrives i UTF8 format (json data kommer ind som UTF8). */
$fp = fopen($targetFilename, 'w');
foreach ($stogBuffer as $stogStation) {
  fputcsv($fp, $stogStation);
}
fclose($fp);
