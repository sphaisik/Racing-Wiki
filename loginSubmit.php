<?php

$username = $_GET['username'];
$password_hash = $_GET['password'];

$sql = "select username, password_hash from users where username = ?";
require 'DBConnect.php';

try {
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('s', $username);
  //$username = $user;
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if (password_verify($password_hash, $row['password_hash'])) {
      session_start();
      $_SESSION['user'] = $row['username'];
      $_SESSION['logged_in'] = true;
      header("Location:index.php");
    } else {
      header("Location:error.php?error=Login failed, please go back and try again.");
    }
  } else {
    header("Location:error.php?error=Login failed, please go back and try again.");
  }
  $conn->close();
} catch (Exception $ex) {
  $conn->close();
  header("Location:error.php?error=" . $ex->getMessage());
} 
?>