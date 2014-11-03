<?php
$rq = true;
require'./system/system_config.php';
session_destroy();
header("Location: $config_domain");
?>