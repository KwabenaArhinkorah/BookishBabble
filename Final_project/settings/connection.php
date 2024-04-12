<?php
define("servername", "localhost");
define("database", "project");
define("username", "root");
define("password", "");

$conn = new mysqli(servername, username, password, database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>