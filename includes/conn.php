<?php
$conn = mysqli_connect("localhost", "root", "", "jobportal");

if (!$conn) {
  die("Connection failed!");
}

$folderName = basename(dirname($_SERVER['PHP_SELF'])); 