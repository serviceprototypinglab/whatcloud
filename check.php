<?php

function matchip($peer) {
	$ipv4 = explode(".", $peer);
	$cloud = null;

	$f = fopen("cloudnets.csv", "r");
	do {
		$cloudnets = fgetcsv($f);
		//print_r($cloudnets);

		$start = explode(".", $cloudnets[4]);
		$end = explode(".", $cloudnets[5]);

		if(($ipv4[0] > $start[0]) && ($ipv4[0] < $end[0])) {
			$cloud = $cloudnets[0];
		} elseif($ipv4[0] == $start[0]) {
			if($ipv4[1] > $start[1]) {
				$cloud = $cloudnets[0];
			} elseif($ipv4[1] == $start[1]) {
				if($ipv4[2] > $start[2]) {
					$cloud = $cloudnets[0];
				} elseif($ipv4[2] == $start[2]) {
					if($ipv4[3] >= $start[3]) {
						$cloud = $cloudnets[0];
					}
				}
			}
		} elseif($ipv4[0] == $end[0]) {
			if($ipv4[1] < $end[1]) {
				$cloud = $cloudnets[0];
			} elseif($ipv4[1] == $end[1]) {
				if($ipv4[2] < $end[2]) {
					$cloud = $cloudnets[0];
				} elseif($ipv4[2] == $end[2]) {
					if($ipv4[3] <= $end[3]) {
						$cloud = $cloudnets[0];
					}
				}
			}
		}
	} while($cloudnets);

	return $cloud;
}

//echo matchip("160.85.231.199");

?>
