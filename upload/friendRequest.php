<?php
include('config.php');
if(isset($_POST['userId']))
{
	$fid 		 =$_POST['userId'];
	$uid 		 = $_SESSION['uid'];

	echo $select = mysqli_query($host,'INSERT INTO friendRequest(uid,requestid) VALUES ("'.$fid.'","'.$uid.'")');
	
	
	
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