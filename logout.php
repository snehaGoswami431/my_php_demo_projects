<?php
session_start();
session_unset();
if(!isset($_SESSION['uid']))
{
	header('location:signin.php');
}
?>