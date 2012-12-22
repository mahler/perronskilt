<?php
function fetchUrl($url = null) {
	$cUrl = curl_init();
	curl_setopt($cUrl, CURLOPT_URL, $url);
	curl_setopt($cUrl, CURLOPT_CONNECTTIMEOUT, 5);
	curl_setopt($cUrl, CURLOPT_RETURNTRANSFER, 1);

	$curlData = curl_exec($cUrl);
	curl_close($cUrl);

	return $curlData;
}