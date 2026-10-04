<?php

session_start();

/* Remove only the admin login session */
unset($_SESSION["admin_logged_in"]);

/* Redirect to admin login */
header("Location: login.php");
exit();

?>