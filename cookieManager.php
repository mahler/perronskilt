<?php
/**
 * Denne fil håndterer seneste sete station via en Cookie, der huskes i 30 dage.
 */

$cookieName = 'perronskilt_uic';

if (!empty($_COOKIE[$cookieName]) && is_numeric($_COOKIE[$cookieName])) {
	$stationUic = intval($_COOKIE[$cookieName]);
}

if (!empty($_GET['station']) && is_numeric($_GET['station'])) {
	$stationUic = intval($_GET['station']);

	// Gem cookie i cirka en måned (30 dage).
	setcookie ($cookieName, $stationUic, time() + 30*24*3600, '/');
}
