<?php

clearstatcache();
session_start();
unset($_SESSION['user']);
unset($_SESSION['user_id']);
$_SESSION['logged_in'] = false;
header("Location:index.php");
session_destroy();
?>