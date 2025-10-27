<?php
session_name("absenPklSession");
session_start();
session_destroy();
header("Location: login.php");
exit;
?>
