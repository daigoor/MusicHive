<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require('constants.php');
$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);
$mysqli->set_charset("utf8");
?>