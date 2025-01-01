<?php
require_once('root/config.php');
session_start();
session_destroy();
header('Location:'.SITE_URL);
?>