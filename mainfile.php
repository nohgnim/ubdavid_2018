<?php
include ("includes/config.php");
require_once("includes/sql_layer.php");
$dbi = sql_connect($dbhost, $dbuname, $dbpass, $dbname);

if (!ini_get("register_globals")) {
    $php_ver = phpversion();
    $php_ver = explode(".", $php_ver);
    $phpver = "$php_ver[0]$php_ver[1]";
    if ($phpver >= 41) {
	$PHP_SELF = $_SERVER['PHP_SELF'];
	import_request_variables('GPC');
    }
}


// new function by LCR
function url_redirect($p_url) {
	echo "<HTML><HEAD><META http-equiv=\"Refresh\" content=\"0;URL=$p_url\"></HEAD><BODY></BODY></HTML>\n";
}


?>