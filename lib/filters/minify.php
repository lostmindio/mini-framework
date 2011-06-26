<?php
ob_start(function($buff) {
    foreach(explode("\n", $buff) as $line) {
        $out .= trim($line);
    }
	return $out;
});