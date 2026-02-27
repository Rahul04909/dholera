<?php
/**
 * Logout Script
 * Dholera Smart City
 */
session_start();
session_unset();
session_destroy();
header("Location: login.php");
exit();
?>
