<?php
include('config.php');

if(isset($_POST['userId']))
{
	$fid 		 =$_POST['userId'];
	 $uid 		 = $_SESSION['uid'];

 $select = mysqli_query($host,"DELETE FROM `friendRequest` WHERE `uid`= $uid");
	if($select)
	{
		echo '1';
	}
	else
	{
		echo '0';
	}
}



?>
