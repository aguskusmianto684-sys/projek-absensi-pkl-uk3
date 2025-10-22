<?php
session_name("ecommerceUserSession");
session_start();
session_destroy();
header("Location: login.php");
exit;
?>
