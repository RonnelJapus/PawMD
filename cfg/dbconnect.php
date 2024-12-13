<?php
  $host = 'localhost';
  $db = 'pawmd_db';
  $user = 'root';
  $password = '';

  $conn = new mysqli(hostname: $host, username :$user, password:$password, database :$db );
//Check connection
if ($conn->connect_error){
  die("Connection failed:" . $conn->connect_error);
} 
?>