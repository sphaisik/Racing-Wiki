<?php

// data for the connection
$dbserver = "localhost";
$dbname = "racing_wiki";
$dbuser = "dbconnector";
$dbpswd = "dbconnector";

// Create connection
try {
  $conn = new mysqli($dbserver, $dbuser, $dbpswd, $dbname);
  echo "<h2>Connected successfully</h2>";
} catch (mysqli_sql_exception $e) {
  // Connection failed, redirect to an error page
  header("Location: error.php?error=" . $e->getMessage());
}
?>