<?php
error_reporting(1);
session_start();
date_default_timezone_set('Asia/Calcutta'); 
$host 	  = mysqli_connect('localhost', 'root','');
$selectDB = mysqli_select_db($host, 'sneha');

?>