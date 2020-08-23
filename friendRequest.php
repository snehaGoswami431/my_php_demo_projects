<?php
include('config.php');

if(isset($_POST['userId']))
{

	$fid 		 =$_POST['userId'];
	$uid 		 = $_SESSION['uid'];

	$select1 = mysqli_query($host,'INSERT INTO friendrequest(uid,requestid)VALUES("'.$fid.'","'.$uid.'")');
	

	if($select1)
	{
		echo '1';
	}
	else
	{
		echo '0';
	}
}

//cancel request
if(isset($_POST['userId1']))
{
	 $fid 		 =$_POST['userId1'];
	 $uid 		 = $_SESSION['uid'];

 $select = mysqli_query($host,"DELETE FROM friendrequest WHERE uid ='".$fid."'");
	if($select)
	{
		echo '1';
	}
	else
	{
		echo '0';
	}
}
//confirm request
if(isset($_POST['userId2']))
{
	 $fid 		 =$_POST['userId2'];
	 $uid 		 = $_SESSION['uid'];
	//  $duplicateCheck1 = mysqli_query($host,"SELECT requestid FROM friendrequest WHERE uid='".$uid."'");
 // if(mysqli_num_rows($duplicateCheck1) < 1){
    $query = "UPDATE `friendrequest` SET `status`='1' WHERE `requestid`='$fid' AND `uid`='$uid'";

 $select = mysqli_query($host,$query);
	if($select)
	{
		echo '1';
	}
	else
	{
		echo '0';
	}
// }

// else
// {

// }
}
//cancel request
if(isset($_POST['userId3']))
{
	 $fid 		 =$_POST['userId3'];
	 $uid 		 = $_SESSION['uid'];

 $select = mysqli_query($host,"DELETE FROM friendrequest WHERE requestid ='".$fid."'");
	if($select)
	{
		echo '1';
	}
	else
	{
		echo '0';
	}
}
if(isset($_POST['idfriend']))
{
	$id 		 = $_POST['idfriend'];
	$uid 		 = $_SESSION['uid'];

	$deletequery="DELETE FROM `friendrequest` WHERE (`requestid`='$id' AND `uid`='$uid') OR (`uid`='$id'AND 
	`requestid`='$uid')";

	$delete = mysqli_query($host,$deletequery);
	

	if($delete)
	{
		echo '1';
	}
	else
	{
		echo '0';
	}
}
?>