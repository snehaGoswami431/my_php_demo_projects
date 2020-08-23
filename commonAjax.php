<?php
include('config.php');
if(isset($_POST['oldPassword']))
{
	$oldPassword = md5($_POST['oldPassword']);
	$uid 		 = $_SESSION['uid'];

	$select = mysqli_query($host,"SELECT password,id FROM users WHERE id='".$uid."' AND password='".$oldPassword."'");
	$fetchPassword = mysqli_fetch_array($select);
	
	if($oldPassword == $fetchPassword['password'])
	{
		echo '1';
	}
	else
	{
		echo '0';
	}
}
if(isset($_POST['email']))
{
	echo $oldEmail = $_POST['email'];

	$uid 		 = $_SESSION['uid'];

	$select = mysqli_query($host,"SELECT email,id FROM users WHERE id='".$uid."' AND email='".$oldEmail."'");
	$fetchEmail = mysqli_fetch_array($select);
	
	if($oldEmail == $fetchEmail['email'])
	{
		echo '1';
	}
	else
	{
		echo '0';
	}
}
if(isset($_POST['idpost']))
{
	$id 		 = $_POST['idpost'];

	$delete = mysqli_query($host,"DELETE FROM posts WHERE id ='".$id."'");
	

	if($delete)
	{
		echo '1';
	}
	else
	{
		echo '0';
	}
}
if(isset($_POST['value']))
{
	$return_arr = array();
	$name		 =$_POST['value'];

	$search = mysqli_query($host,"SELECT * FROM users WHERE name LIKE '%" . $name . "%'");
 
	echo '<ul>';
   while ($Result = mysqli_fetch_array($search)) {
   
    	 $id = $Result['id'];
    $name = $Result['name'];
    $img=$Result['profile_picture']
    ?>
    <li><a href="friendView.php?uid=<?=$id?>"><i class="icofont-search-user"></i><img src="upload/<?=$img?>" class="searchuser"><span><?=$name?></span></a></li>

  <?php  
  //$return_arr[]= array("id" => $id,"name" => $name);
//print_r($return_arr);
   	
   

      }
  
      echo '</ul>';
 

	
}
if(isset($_POST['postid']))
{
	$postid 		 = $_POST['postid'];
		$uid 		 = $_SESSION['uid'];
	 $duplicateCheck1 = mysqli_query($host,"SELECT * FROM likepost WHERE uid='".$uid."' AND post_id='".$postid."'");
 if(mysqli_num_rows($duplicateCheck1) < 1){
	$insert = mysqli_query($host,"INSERT INTO likepost(post_id,uid) VALUES ('".$postid."','".$uid."')");
	

	if($insert)
	{
		echo '1';
	}
	else
	{
		echo '0';
	}
}
else
{
	$delete = mysqli_query($host,"DELETE FROM likepost WHERE uid='".$uid."' AND post_id='".$postid."'");
	

	if($delete)
	{
		echo '2';
	}
	else
	{
		echo '0';
	} 
}
}

if(isset($_POST['idpostcomment']))
{
	$postid 		 = $_POST['idpostcomment'];
	$commenttext=$_POST['commenttext'];
		$uid 		 = $_SESSION['uid'];
		$datetime		 =date("Y-m-d H:i:s");

		
	// $duplicateCheck1 = mysqli_query($host,"SELECT * FROM likepost WHERE uid='".$uid."' AND post_id='".$postid."'");
 // if(mysqli_num_rows($duplicateCheck1) < 1){

	$insert = mysqli_query($host,"INSERT INTO comment(uid,post_id,comments,date_time) VALUES ('".$uid."','".$postid."','".$commenttext."','".$datetime."')");
	

	if($insert)
	{
		echo '1';
	}
	else
	{
		echo '0';
	}
//}

}



if(isset($_POST['idcomment']))
{
	$id 		 = $_POST['idcomment'];

	$delete = mysqli_query($host,"DELETE FROM comment WHERE id ='".$id."'");
	

	if($delete)
	{
		echo '1';
	}
	else
	{
		echo '0';
	}
}


if(isset($_POST['commentid']))
{
	$commentid 		 = $_POST['commentid'];
		$uid 		 = $_SESSION['uid'];
	 $duplicateCheck1 = mysqli_query($host,"SELECT * FROM commentlike WHERE uid='".$uid."' AND comment_id='".$commentid."'");
 if(mysqli_num_rows($duplicateCheck1) < 1){
	$insert = mysqli_query($host,"INSERT INTO commentlike(comment_id,uid) VALUES ('".$commentid."','".$uid."')");
	

	if($insert)
	{
		echo '1';
	}
	else
	{
		echo '0';
	}
}
else
{
	$delete = mysqli_query($host,"DELETE FROM commentlike WHERE uid='".$uid."' AND comment_id='".$commentid."'");
	

	if($delete)
	{
		echo '2';
	}
	else
	{
		echo '0';
	} 
}
}


if(isset($_POST['idpostreply']))
{
	$postid 		 = $_POST['idpostreply'];
	$replytext=$_POST['replytext'];
		$uid 		 = $_SESSION['uid'];
		$datetime		 =date("Y-m-d H:i:s");

		
	// $duplicateCheck1 = mysqli_query($host,"SELECT * FROM likepost WHERE uid='".$uid."' AND post_id='".$postid."'");
 // if(mysqli_num_rows($duplicateCheck1) < 1){

	$insert = mysqli_query($host,"INSERT INTO reply(uid,comment_id,replys,date_time) VALUES ('".$uid."','".$postid."','".$replytext."','".$datetime."')");
	

	if($insert)
	{
		echo '1';
	}
	else
	{
		echo '0';
	}
//}

}
if(isset($_POST['replyid']))
{
	$replyid 		 = $_POST['replyid'];
		$uid 		 = $_SESSION['uid'];
	 $duplicateCheck1 = mysqli_query($host,"SELECT * FROM replylike WHERE uid='".$uid."' AND reply_id='".$replyid."'");
 if(mysqli_num_rows($duplicateCheck1) < 1){
	$insert = mysqli_query($host,"INSERT INTO replylike(reply_id,uid) VALUES ('".$replyid."','".$uid."')");
	

	if($insert)
	{
		echo '1';
	}
	else
	{
		echo '0';
	}
}
else
{
	$delete = mysqli_query($host,"DELETE FROM replylike WHERE uid='".$uid."' AND reply_id='".$replyid."'");
	

	if($delete)
	{
		echo '2';
	}
	else
	{
		echo '0';
	} 
}
}
if(isset($_POST['idreply']))
{
	$id 		 = $_POST['idreply'];

	$delete = mysqli_query($host,"DELETE FROM reply WHERE id ='".$id."'");
	

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