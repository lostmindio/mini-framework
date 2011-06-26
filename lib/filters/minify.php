<?php
ob_start();
register_shutdown_function(function() {
    foreach(explode("\n", ob_get_clean()) as $line) {
        echo trim($line);
    }
});