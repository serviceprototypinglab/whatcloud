<?php

include "check.php";

//peer = $_SERVER["REMOTE_ADDR"];
$peer = $_SERVER["HTTP_X_CLIENT_IP"];
$uri = $_SERVER["REQUEST_URI"];

if($uri == "/") {
	if(strpos($peer, ":") === false) {
		$cloud = matchip($peer);

		$stamp = time();
		$f = fopen(".log", "a");
		fwrite($f, "$stamp,$peer,$cloud\n");
		fclose($f);

		if($cloud) {
			echo $cloud;
		} else {
			echo "unknown [$peer]";
		}
	} else {
		echo "IPv6 not supported yet!";
	}
} elseif($uri == "/ip") {
	echo $peer;
} elseif($uri == "/info") {
	phpinfo();
} elseif(strpos($uri, "/logs") === 0) {
	$f = fopen(".secret", "r");
	if($f) {
		$secret = trim(fread($f, 1000));
		if(strpos($uri, $secret) > 0) {
			$f = fopen(".log", "r");
			fpassthru($f);
		}
	}
}
?>
