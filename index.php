<?php
$pagename = 'Home';
include('config.php');
if(!isset($_SESSION['uid']))
{
  header('location:signin.php');
}

$userdata = mysqli_fetch_array($results);
$query    = "SELECT * FROM users WHERE id='".$_SESSION['uid']."'";
$results  = mysqli_query($host, $query);
$userdata = mysqli_fetch_array($results);
$before=$userdata['name'];
$after=explode(' ',$before);
$after=$after[0];
 $suggetionList = mysqli_query($host,"SELECT * FROM users WHERE id !='".$_SESSION['uid']."'");



 if(isset($_POST['submit'])){ 
      
     $uid       = $_SESSION['uid'];
     $caption   = $_POST['postText'];
     $feeling_id   = $_POST['activity1'];
     $targetDir = "upload/";

     $allFiles  = '';
     $date      = date("Y-m-d H:i:s");

     $fileNames = array_filter($_FILES['files']['name']); 
     if(!empty($fileNames)){ 
        foreach($_FILES['files']['name'] as $key=>$val){ 
            // $fileName = basename($_FILES['files']['name'][$key]);
            $basename = pathinfo($_FILES['files']['name'][$key], PATHINFO_BASENAME);
            $ext      = pathinfo($basename, PATHINFO_EXTENSION);
            $rand     = rand(000,9999);
            $newName  = md5($basename).$rand.'.'.$ext;
            $targetFilePath = $targetDir . $newName; 
            move_uploaded_file($_FILES["files"]["tmp_name"][$key], $targetFilePath);
            $files[] = $newName;
        }
        
        $allFiles = implode(',',$files);




        $insert = mysqli_query($host,"INSERT INTO posts (uid, caption,files,date_time,feeling_id) VALUES ('".$uid."','".$caption."','".$allFiles."','".$date."','".$feeling_id."')");

        if($insert)
        {
          $_SESSION['SET_TYPE'] = 'success';
          $_SESSION['SET_FLASH'] = 'Posted successfully';
        }
        else
        {
          $_SESSION['SET_TYPE'] = 'error';
          $_SESSION['SET_FLASH'] = 'Unable to post';
        }
      } 
} 




$selectPosts = mysqli_query($host, "SELECT posts.id AS POSTID, posts.uid,posts.caption,posts.files,posts.date_time,posts.feeling_id,users.id,users.profile_picture,users.cover_picture,users.name FROM posts LEFT JOIN users ON posts.uid = users.id WHERE 1 ORDER BY POSTID DESC");

$selectPosts1= mysqli_query($host, "SELECT * FROM posts WHERE uid ='".$_SESSION['uid']."' ORDER BY id DESC");

$queryfeeling    = "SELECT * FROM feeling";
$resultsfeeling = mysqli_query($host, $queryfeeling);

//ACTIVITY

/*PROFILE PIC UPLOAD*/
if(!empty($_FILES['picture']['name'])){
  
   $uid       = $_SESSION['uid'];
    //File uplaod configuration
    $result = 0;
    $uploadDir = "upload/";
    $fileName = time().'_'.basename($_FILES['picture']['name']);
    $targetPath = $uploadDir. $fileName;
    
    //Upload file to server
    if(move_uploaded_file($_FILES['picture']['tmp_name'], $targetPath)){
      
       $update = mysqli_query($host,"UPDATE users SET profile_picture ='$fileName' WHERE id ='$uid'");
        
        //Update status
        if($update){
            $result = 1;
        }
    }
    
    //Load JavaScript function to show the upload status
    echo '<script type="text/javascript">window.top.window.completeUpload(' . $result . ',\'' . $targetPath . '\');</script>';

  }


  /*COVER PIC UPLOAD*/
if(!empty($_FILES['picture1']['name'])){
  
    $uid       = $_SESSION['uid'];
    //File uplaod configuration
    $result1 = 0;
    $uploadDir1 = "upload/";
    $fileName1 = time().'_'.basename($_FILES['picture1']['name']);
    $targetPath1 = $uploadDir1. $fileName1;
    
    //Upload file to server
    if(move_uploaded_file($_FILES['picture1']['tmp_name'], $targetPath1)){
      
       $update1 = mysqli_query($host,"UPDATE users SET cover_picture ='$fileName1' WHERE id ='$uid'");
        
        //Update status
        if($update1){
            $result1 = 1;
        }
    }
    
    //Load JavaScript function to show the upload status
    echo '<script type="text/javascript">window.top.window.completeUpload1(' . $result1 . ',\'' . $targetPath1 . '\');</script>  ';
  }
  $uid       = $_SESSION['uid'];


$selectFriendRequest = mysqli_query($host,"SELECT friendrequest.id , friendrequest.uid ,friendrequest.requestid,friendrequest.status,users.id,users.profile_picture,users.cover_picture,users.name FROM friendrequest LEFT JOIN users ON friendrequest.requestid = users.id WHERE friendrequest.uid = $uid AND friendrequest.status='0'");

$selectFriendRequestSendByMe = mysqli_query($host,"SELECT friendrequest.id , friendrequest.uid ,friendrequest.requestid,friendrequest.status,users.id,users.profile_picture,users.cover_picture,users.name FROM friendrequest LEFT JOIN users ON friendrequest.uid = users.id WHERE friendrequest.requestid = $uid AND friendrequest.status='0'");


$selectFriendList = mysqli_query($host,"SELECT DISTINCT friendrequest.id , friendrequest.uid ,friendrequest.requestid,friendrequest.status,users.id,users.profile_picture,users.cover_picture,users.name FROM friendrequest LEFT JOIN users ON friendrequest.requestid = users.id OR friendrequest.uid = users.id WHERE (friendrequest.uid = $uid OR friendrequest.requestid = $uid) AND friendrequest.status ='1'");






 // $suggetionList = mysqli_query($host,"SELECT friendrequest.id , friendrequest.uid ,friendrequest.requestid,friendrequest.status,users.id,users.profile_picture,users.cover_picture,users.name FROM friendrequest LEFT JOIN users ON users.id !=$uid AND users.id!=friendrequest.requestid");


// foreach ($selectFriendList as $key => $value) {

//   $donttake= $value['requestid'];
//   print_r($donttake);
// }


if(isset($_POST['abtsubmit'])){ 
  $uid       = $_SESSION['uid'];
     $school   = $_POST['school'];
     $college   = $_POST['college'];
     $status   = $_POST['status'];
     $place   = $_POST['place'];

$duplicateCheck = mysqli_query($host,"SELECT uid FROM about WHERE uid='".$uid."'");
 if(mysqli_num_rows($duplicateCheck) < 1) {
 
$aboutinsert = mysqli_query($host,"INSERT INTO about(uid,school,college,place,statuses) VALUES ('".$uid."','".$school."','".$college."','".$place."','".$status."')");
        if($aboutinsert)
        {
          $_SESSION['SET_TYPE'] = 'success';
          $_SESSION['SET_FLASH'] = 'Your data inserted successfully';
        }
        else
        {
          $_SESSION['SET_TYPE'] = 'error';
          $_SESSION['SET_FLASH'] = 'Unable to insert';
        }
      }
      else
      {
        $_SESSION['SET_TYPE'] = 'error';
      $_SESSION['SET_FLASH'] = 'User data already exists,please update.';
      }
}
$aboutList = mysqli_query($host,"SELECT * FROM about WHERE uid ='".$_SESSION['uid']."'");
$aboutvalue=mysqli_fetch_array($aboutList);

if(isset($_POST['abtupdate'])){ 
  $uid       = $_SESSION['uid'];
     $school   = $_POST['school'];
     $college   = $_POST['college'];
     $status   = $_POST['status'];
     $place   = $_POST['place'];


 $aboutupdate = mysqli_query($host,"UPDATE `about` SET `school`='$school',`college`='$college',`place`='$place',`statuses`='$status' WHERE `uid`='$uid'");
        if($aboutupdate)
        {
          $_SESSION['SET_TYPE'] = 'success';
          $_SESSION['SET_FLASH'] = 'Updated successfully';
        }
        else
        {
          $_SESSION['SET_TYPE'] = 'error';
          $_SESSION['SET_FLASH'] = 'Unable to update';
        }
      
     
}
$aboutList = mysqli_query($host,"SELECT * FROM about WHERE uid ='".$_SESSION['uid']."'");
$aboutvalue=mysqli_fetch_array($aboutList);


// abtupdate



function time_ago_in_php($timestamp){

  date_default_timezone_set("Asia/Kolkata");  
  //Time  date split   
$splitTimeStamp = explode(" ",$timestamp);
 $date1 = $splitTimeStamp[0];
 $time1 = $splitTimeStamp[1];//time split

 //date split 
 $orderdate = explode('-', $date1);
$month1 = $orderdate[1];
if(($orderdate[2][0])==0)
{
$day1  = $orderdate[2][1];
}
else
{
 $day1  = $orderdate[2]; 
}
$year1  = $orderdate[0];

//month name from date
 $monthname=date('F', strtotime($date1));
$monthname=substr($monthname, 0, 3);

//time split 

$ordertime=substr($time1, 0, 5);


  $time_ago        = strtotime($timestamp);
  $current_time    = time();
  $time_difference = $current_time - $time_ago;
  $seconds         = $time_difference;
  
  $minutes = round($seconds / 60); // value 60 is seconds  
  $hours   = round($seconds / 3600); //value 3600 is 60 minutes * 60 sec  
  $days    = round($seconds / 86400); //86400 = 24 * 60 * 60;  
  $weeks   = round($seconds / 604800); // 7*24*60*60;  
  $months  = round($seconds / 2629440); //((365+365+365+365+366)/5/12)*24*60*60  
  $years   = round($seconds / 31553280); //(365+365+365+365+366)/5 * 24 * 60 * 60
                
  if ($seconds <= 60){

    return "Just now";

  } else if ($minutes <= 60){

    if ($minutes == 1){

      return "1 min";

    } else {

      return "$minutes min";

    }

  } else if ($hours <= 24){

    if ($hours == 1){

      return "1 hrs";

    } else {

      return "$hours hrs";

    }

  } else if ($days <= 7){

    if ($days == 1){

       return "Yesterday at $ordertime";

    } else {
return "$day1 $monthname at $ordertime";
       // return "$days days ago";
    

    }

  } else if ($weeks <= 4.3){

    if ($weeks == 1){

      // return "a week ago";
      return "$day1 $monthname at $ordertime";

    } else {

      // return "$weeks weeks ago";
      return "$day1 $monthname at $ordertime";

    }

  } else if ($months <= 12){

    if ($months == 1){

      // return "a month ago";
      return "$day1 $monthname at $ordertime";

    } else if(($months>1) and ($years<1)){

      // return "$months months ago";
      return "$day1 $monthname  at $ordertime";

    }
    else{
      return "$day1 $monthname $year1 at $ordertime";
    }


  } else {
    
    if ($years == 1){

      // return "one year ago";
      return "$day1 $monthname $year1 at $ordertime";

    } else {

      // return "$years years ago";
      return "$day1 $monthname $year1 at $ordertime";

    }
  }
}


function time_ago_in_php_comment($timestamp){

  date_default_timezone_set("Asia/Kolkata");  
  //Time  date split   
$splitTimeStamp = explode(" ",$timestamp);
 $date1 = $splitTimeStamp[0];
 $time1 = $splitTimeStamp[1];//time split

 //date split 
 $orderdate = explode('-', $date1);
$month1 = $orderdate[1];
if(($orderdate[2][0])==0)
{
$day1  = $orderdate[2][1];
}
else
{
 $day1  = $orderdate[2]; 
}
$year1  = $orderdate[0];

//month name from date
 $monthname=date('F', strtotime($date1));
$monthname=substr($monthname, 0, 3);

//time split 

$ordertime=substr($time1, 0, 5);


  $time_ago        = strtotime($timestamp);
  $current_time    = time();
  $time_difference = $current_time - $time_ago;
  $seconds         = $time_difference;
  
  $minutes = round($seconds / 60); // value 60 is seconds  
  $hours   = round($seconds / 3600); //value 3600 is 60 minutes * 60 sec  
  $days    = round($seconds / 86400); //86400 = 24 * 60 * 60;  
  $weeks   = round($seconds / 604800); // 7*24*60*60;  
  $months  = round($seconds / 2629440); //((365+365+365+365+366)/5/12)*24*60*60  
  $years   = round($seconds / 31553280); //(365+365+365+365+366)/5 * 24 * 60 * 60
                
  if ($seconds <= 60){

    return "Just now";

  } else if ($minutes <= 60){

    if ($minutes == 1){

      return "1 min";

    } else {

      return "$minutes min";

    }

  } else if ($hours <= 24){

    if ($hours == 1){

      return "1 hrs";

    } else {

      return "$hours hrs";

    }

  } else if ($days < 7){

    if ($days == 1){

      return "1 d";

    } else {

      return "$days d";

    }
  }


  else if ($weeks <= 4.3){

    if ($weeks == 1){

      // return "a week ago";
      return "1 wk";

    } else {

      // return "$weeks weeks ago";
      return "$weeks wk";

    }

  } 
  else if (($weeks > 4.3) AND($years<1)){

   return "$weeks wk";

  } 
  else {
  if ($years == 1){

      // return "one year ago";
      return "1 y";

    } else {

      // return "$years years ago";
      return "$years y";

    }
  }
  
}

include('metakey_css.php');
include('header.php');

// if (isset($_POST['search'])) {
// //Search box value assigning to $Name variable.
//    $Name = $_POST['search'];
// //Search query.
//    $Query = "SELECT name FROM users WHERE name LIKE '%$Name%' LIMIT 5";
// //Query execution
//    $ExecQuery = mysqli_query($con, $Query);
// //Creating unordered list to display result.

//    //Fetching result from database.
//    while ($Result = mysqli_fetch_array($ExecQuery)) {
//     echo $Result['name'];
//       }}




?>
<section>

	<div class="container">
   <div class="row timelineHeader">
      <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="coverPhoto">
         <img id="imagePreview1" src="upload/<?=$userdata['cover_picture']?>">
         <!-- <div class="coverIcon"><i class="icofont-plus-square"></i></div> -->
         <script type="text/javascript">
         <?php $pagename=$userdata['name'];

         ?>
         
          $(function(){

     $(document).attr("title", "<?=$pagename?>'s profile");

  });
          
         </script>
         <form method="post" action="" enctype="multipart/form-data" id="picUploadForm1" target="uploadTarget1">
                <input type="file" name="picture1" id="fileInput1"  style="display:none"/>
            </form>
             <iframe id="uploadTarget1" name="uploadTarget1" src="#" style="width:0;height:0;border:0px solid #fff;">
               
             </iframe>
             <a class="editLink1 coverIcon tooltip1" href="javascript:void(0);"><i class="icofont-plus-square"></i>
              <span>Add Cover Photo</span>
             <!--  <span class="tooltiptext1">Edit</span> --></a>
        </div>
      </div>


      <div class="profilePicture">
          <img id="imagePreview" src="upload/<?=$userdata['profile_picture']?>">
           <form method="post" action="" enctype="multipart/form-data" id="picUploadForm" target="uploadTarget">
                <input type="file" name="picture" id="fileInput"  style="display:none"/>
            </form>
             <iframe id="uploadTarget" name="uploadTarget" src="#" style="width:0;height:0;border:0px solid #fff;">
               
             </iframe>
             <a class="editLink tooltip" href="javascript:void(0);"><i class="icofont-camera"></i>
               <span class="tooltiptext">Edit</span>
             </a>
            <!-- Profile image -->
      </div>
     
 </div>
 <div class="name_email">
    <h3 style="text-transform:uppercase;"><?=$userdata['name']?><a class="editpencil" href="Edit_profile.php"><i class="icofont-edit-alt"></i></a></h3>


             <p><?=$userdata['email']?></p>
 </div>
   <div class="row">
     <div class="col-md-12 col-lg-12 col-sm-12">
       <div class="timelineHeaderNav ">
         <ul class="nav nav-tabs">
           <li class="active">
             <a class="nav-item nav-link active" data-toggle="tab" href="#timeline">Timeline</a>
           </li>
           <li>
             <a class="nav-item nav-link " data-toggle="tab" href="#friend">Friends</a>
           </li>
          
           <li>
             <a class="nav-item nav-link" data-toggle="tab"href="#about">About</a>
           </li>
           <li>
             <a class="nav-item nav-link" data-toggle="tab" href="#photos">Photos</a>
           </li>
         </ul>
       </div> 
     </div>
   </div>
  </div>
</section>
 <div class="tab-content">
<div class="tab-pane fade in active show" id="timeline">

  <div class="container">
    <div class="row mt-1">
      <div class="col-lg-3 friendSection">
      	<!-- <form action="" method="post"> -->
            <div class="PplKnwDiv"> <p class="headingPplKnw">People you may know</p></div>
        <div class="owl-carousel owl-theme  friendSuggetions"  id="owl-demo"><!-- owl-carousel owl-theme -->
        	
          <?php
          $SendRequestIDs = array();
          $getRequests = array();

          foreach ($selectFriendRequestSendByMe as $key => $value1) {
            $SendRequestIDs[] =$value1['uid'];

          }

          foreach ($selectFriendRequest as $key => $value) { 
            $getRequests[] =$value['id'];
      
          }
           foreach ($selectFriendList as $key => $value) { 
            $getList[] =$value['id'];
      
          }

          foreach ($suggetionList as $key => $value) {
            

          ?>
          <div class="main">

            <div class="item  friendBox item1_<?=$value['id']?>"> <!-- item -->
              <img src="upload/<?=$value['profile_picture']?>">
              <p style="text-transform:uppercase;"><?=$value['name']?></p>
             
              <div class="btnGrp btnGrp1__<?=$value['id']?>">

                <!-- ADD REMOVE -->
                <?php
                if(in_array($value['id'], $SendRequestIDs))
                {
                  
                ?>
                 <button class="cancel cancel_<?=$value['id']?>"  name="cancelFriend"  onclick="cancelFriendevent(<?=$value['id']?>)">Cancel Friend Request</button>
                  <button class="remove remove_<?=$value['id']?>" style="display:none;" onclick="removeFriendevent(<?=$value['id']?>)">Remove</button>
                  <button class="add add_<?=$value['id']?>"  name="addFriend"  style="display:none;" onclick="addFriendevent(<?=$value['id']?>)">Add Friend</button>
                <?php } else if(in_array($value['id'], $getRequests)) {  ?>

                 <!--  <button class="confirm confirm_<?=$value['id']?>" onclick="confirmFriendevent(<?=$value['id']?>)">Confirm</button>
                  <p class="pConfirm pConfirm_<?=$value['id']?>" style="display:none;">You are now friends!</p>
                  <button class="delete delete_<?=$value['id']?>" onclick="deleteFriendevent(<?=$value['id']?>)">Delete</button> -->
                   <div class="friendsp"><p>Sent you a request!</p></div>

                <?php }
                 else if(in_array($value['id'], $getList)){

                  ?>
                 <!--  <script type="text/javascript">
                   $('.item1_<?=$value['id']?>').hide();
                    
                  </script> -->
                    <div class="friendsp"><p>Friends</p></div>
                  <?php
                 }

                else {?>
                  <button class="remove remove_<?=$value['id']?>" onclick="removeFriendevent(<?=$value['id']?>)">Remove</button>
                  <button class="add add_<?=$value['id']?>"  name="addFriend"  onclick="addFriendevent(<?=$value['id']?>)">Add Friend</button>
                  <button class="cancel cancel_<?=$value['id']?>"  name="cancelFriend"  style="display:none;" onclick="cancelFriendevent(<?=$value['id']?>)">Cancel Friend Request</button>
                <?php
                } 
                ?>
              </div>
             <p class="pRemoved pRemove_<?=$value['id']?>"></p>
               
            </div>
          </div>
<?php }?>

   
        </div>
<!-- </form> -->


<div class="viewRequest">
  <p class="headingRequest">Friend Requests <span><i class="icofont-users-alt-4"></i><i class="icofont-arrow-right"></i></span><span class="badge badge-success badge1"></span></p>
  <div class="subdivView">
    <?php
    if(mysqli_num_rows($selectFriendRequest) > 0)
    {
      foreach ($selectFriendRequest as $key => $value) {  
    ?>
    <div class="row pt-2">
      <div class="col-md-3">
        <img src="upload/<?=$value['profile_picture']?>" class="friendIcon">
      </div>
      <div class="col-md-9">
        <p class="friendName"><?=$value['name']?></p>

         <div class="btnGrp buttonGrp">

           <button class="confirm confirm_<?=$value['id']?>" onclick="confirmFriendevent(<?=$value['id']?>)">Confirm</button>

           <p class="pConfirm pConfirm_<?=$value['id']?>" style="display:none;">You are now friends!</p>
           <button class="delete delete_<?=$value['id']?>" onclick="deleteFriendevent(<?=$value['id']?>)">Delete</button>
         </div>
      </div>
    </div>
    <?php } }else {?>
      <div class="text-center pt-2">
         <img src="assets/images/group.svg" width="95px">
         <p>No Request Found</p>
      </div>
    <?php }?>
  </div>
</div>

<div class="friendList">
  <p class="headingFriend">Friends <span><i class="icofont-users-alt-4"></i></span></p>
  <p class="pFriendCount"><span class="friendcount">No friends</span></p>
  <div class="innerdivfriend">
     <?php
      if(mysqli_num_rows($selectFriendList) > 0)
      {
         $j=0;
        foreach ($selectFriendList as $key => $value) {
         
               if($value['id']!=$_SESSION['uid']){

                $j++;


      ?>
     
            <div class="row">
              <p class="friendlistName col-lg-7"><?=$value['name']?></p>
              <img src="upload/<?=$value['profile_picture']?>" class="friendlistIcon col-lg-5">
            </div>
    <?php }?>
 <script type="text/javascript">
         var countfriend=<?=$j?>;
  if(countfriend>0){
  $('.friendcount').html(countfriend+" friend");
    if(countfriend>1){
  $('.friendcount').html(countfriend+" friends");
}
}
      </script>
 <?php }}else {?>
      <div class="text-center pt-2">
         <img src="assets/images/group.svg" width="95px">
         <p>You Have No Friends</p>
      </div>
    <?php }?>
  </div>
</div>


      </div>
      <div class="col-lg-6">
        <div class="timeline">
           <div class="createPost">
            <form action="" method="post" enctype="multipart/form-data">
               <input type="hidden" value="" name="activity1" class="activitytextid"><br>
              <div class=""> <input type="text" value="" name="activity2" class="activitytextfeeling">
              </div><br>
              <textarea class="postTextarea" name="postText" placeholder="What's on your mind <?=$after?>?"></textarea>
             

              <button type="button" class="activity" data-toggle="modal" data-target="#myModal"><img src="assets/images/emoji.png">Feeling/Activity</button>
               
              <button class="postBtn" type="submit" name="submit">Post</button>

              <div class="attachBtn">
                <button class="addphotos"><img src="assets/images/addphoto.png">Photos</button>
                <input id="fileupload" type="file" name="files[]"  multiple="multiple">
              </div>
              <div style="clear:both"></div>
              <div id="dvPreview"></div>
            </form>
          </div>
         <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
         <!--  <form action="" method="post" enctype="multipart/form-data"> -->
        <div class="modal-header">
          
          <h4 class="modal-title modaltitle">Your Feelings</h4>
          <button type="button" class="close" data-dismiss="modal" style="width:48px;">&times;</button>
        </div>
        <div class="modal-body">
    
         <!-- <select class="selectFeeling">
           <option value="feeling sad">Feeling sad</option>
           <option value="feeling happy">Feeling happy</option>
           
         </select> -->
       <!-- display:inline-flex; -->
 <?php foreach ($resultsfeeling as $key => $value0) {?>
 
    <input type="hidden" value="<?=$value0['feeling_id']?>" class="inputfeeling_<?=$value0['feeling_id']?>" name="feelingid">
    <input type="hidden" value="<?=$value0['feeling']?>" class="inputfeeling1_<?=$value0['feeling_id']?>" name="feeling">
      <ul style="list-style: none;

margin: 0px;

margin-left: -20px;">
          <li style="float: left;
width: 50%;">
 <button type="button" value="<?=$value0['feeling']?>" name="valueFeelingsubmit" 
    class="valueFeelingbutton valueFeelingbtn_<?=$value0['feeling_id']?>">
    <img src="assets/images/<?=$value0['emoji']?>"><span><?=$value0['feeling']?></span></button>

</li>
</ul>
<script type="text/javascript">$('.valueFeelingbtn_'+<?=$value0['feeling_id']?>).click(function(){
   var d=$('.inputfeeling_'+<?=$value0['feeling_id']?>).val();
   var e=$('.inputfeeling1_'+<?=$value0['feeling_id']?>).val();
  // var e=$('.inputfeeling1').val();
   
    $('.activitytextid').val(d);
    //alert(d);
   $('.activitytextfeeling').val("Feeling "+e);
  
  });</script>

<?php }?>


        </div>
       <!--  <div class="modal-footer">
          <button type="submit" class="btn btn-default postFeelingbtn" name="feelingsubmit">Submit</button>
        </div> -->

      </div>
      
    </div>
  </div>
          <div class="Postmedia">
           <?php
          foreach ($selectPosts as $key => $value) {
            $fileExplode = explode(',', $value['files']);
            if($value['id']!=$_SESSION['uid']){
             foreach ($selectFriendList as $key => $value1) {
             
              if($value1['id']==$value['id'])
                {


          ?>
            <div class="postMainBlock">
                <div class="postBlockHeader">
                  <div  class="media_profile">
                    <img src="upload/<?=$value['profile_picture']?>">
                  </div>
                  <div class="postInfo">
                    <!--  <input type="text" class="showfeeling" value=""> -->
                   <div> <h5><?=$value['name']?></h5></div>
                   
                      <?php 
                   
                  
                      $feeling_id1=$value['feeling_id'];
                   $queryfeelingid= mysqli_query($host,"SELECT * FROM feeling WHERE feeling_id='$feeling_id1'");
                    foreach ($queryfeelingid as $key => $value4) {
                     ?>
                      <div class="activitydiv">is feeling<span><?=$value4['feeling']?>
                        

                        <img src="assets/images/<?=$value4['emoji']?>">
                      </span></div>
                    <?php 
                    }

                   ?>
                  



                    
                   
                   



 <p class="status"><?=time_ago_in_php($value['date_time']);?>

                      <span style="padding:4px;"><i class="icofont-users-alt-4"></i></span></p>
                  </div>
                  <div class="clearfix"></div>
                </div>
                <div class="media_details">
                  <p>
                      <?=$value['caption']?>
                    </p>
                  <div  class="media_para">
                    <div id="gallery_<?=$value['POSTID']?>"></div>
                  </div>
                   <?php
                $selectlike= mysqli_query($host,"SELECT * FROM likepost WHERE post_id ='".$value['POSTID']."'");?>
                <div class="likeshow">
                  
                  <ul>
                    <li class="lifirst">
                     <?php
                      if(mysqli_num_rows($selectlike)>0){
                       $i=0;
                       foreach ($selectlike as $key => $valuelike) { $i++;
                    

// 
                        }

                 ?>
                     <b onmouseover="showlikeduser(<?=$value['POSTID']?>);" onmouseout="hidelikeduser(<?=$value['POSTID']?>);"><img src="assets/images/like.svg"><?=$i?>likes</b>
              
                   <?php }?>

                    </li>
                     <li class="commentnumber" onmouseover="showcommentuser(<?=$value['POSTID']?>);" onmouseout="hidecommentuser(<?=$value['POSTID']?>);">
                     <?php 
$valuepostid=$value['POSTID'];
                     $sessionid=$_SESSION['uid'];

  $comment2=mysqli_query($host,"SELECT * FROM comment WHERE post_id='".$valuepostid."'");
  if(mysqli_num_rows($comment2)>0){
                   $k=0;    
 foreach ($comment2 as $key0 => $valuecomment1) {
$k++;
                    ?>
                   
                  <?php }?>
<span class="commentnumspan_<?=$value['POSTID']?>"><?=$k;?></span><span class="numcomment">comments</span>
               <?php }?>
               </li>
                    <li></li>
                  </ul>
                </div>
                </div>
        <div class="listusers listuser_<?=$value['POSTID']?>" style="display:none;height:auto">
                  <p>Likes</p>
                   
                       <ul class="showusersul">
                          <?php 
                      foreach ($selectlike as $key => $valueshow) {

                        $queryshow=mysqli_query($host,"SELECT id,name FROM users WHERE id='".$valueshow['uid']."'");
                        foreach ($queryshow as $key => $valueshowname) {
                         
                        
                        ?>

                          <li style="float: none;"><?=$valueshowname['name']?></li>
                           <?php }}
                      ?>
                       </ul>
                     </div>

                      <div class="listuserscomment listusercomment_<?=$value['POSTID']?>" style="display:none;height:auto">
                  <p>Comments</p>
                   
                       <ul class="showusersulcomment showusersulcomment_<?=$value['POSTID']?>">
                          <?php 

$comment3=mysqli_query($host,"SELECT DISTINCT uid FROM comment WHERE post_id='".$valuepostid."'");
                     foreach ($comment3 as $key0 => $valuecomment1){

                        $queryshowusercomment=mysqli_query($host,"SELECT id,name FROM users WHERE id='".$valuecomment1['uid']."'");
                        // $v=mysqli_fetch_array($queryshowusercomment);
                        // echo $v['name'];
                       
                        foreach ($queryshowusercomment as $key => $valueshowcommentname) {
                        
                     
                        ?>

                          <li  class="showusersulcommentli showusersulcommentli_<?=$value['POSTID']?>" style="float: none;"><?=$valueshowcommentname['name']?></li>
                           <?php }}
                      
                      ?>
                       </ul>
                     </div>
                <div class="ulDiv">
                  <div style="width: 100%;height: 1px;background: #80808057;margin-top: 54px;"></div>
                  <div class="btn-group btnDiv">
                    <button type="button" class="" onclick="likepost(<?=$value['POSTID']?>);" >
                      <?php             
  $valuepostid=$value['POSTID'];
                      $sessionid=$_SESSION['uid'];

  $query=mysqli_query($host,"SELECT * FROM likepost WHERE post_id='".$valuepostid."' AND uid='".$sessionid."'");
  if(mysqli_num_rows($query)>0){
                       foreach ($query as $key => $valuelike1) {
                         if($valuelike1['post_id']){
// echo $valuelike1['uid'];
// echo $valuelike1['post_id'];
// echo $value['POSTID'];
?>
                        
 <i class="icofont-like likebuttoni_<?=$value['POSTID']?>" style="color:#4080ff;"></i><span class="likebuttonspan_<?=$value['POSTID']?>" style="color:#4080ff;">Like</span>
<?php } }}  else{?>

 <i class="icofont-like likebuttoni_<?=$value['POSTID']?>" style=""></i><span class="likebuttonspan_<?=$value['POSTID']?>" style="">Like</span>
<?php }?>
                     

                    </button>
                    <button type="button" class=""  onclick="showcomment(<?=$value['POSTID']?>);"><i class="icofont-comment"></i><span>Comment</span></button>
                    <button type="button" class=""><i class="icofont-share-alt"></i><span>Share</span></button>
                  </div>
              <div style="width: 100%;height: 1px;background: #80808057;margin-top: -2px;">  </div>
<div class="comment comment_<?=$value['POSTID']?>">
              
             <div class="ownimgdiv"><img src="upload/<?=$userdata['profile_picture']?>"></div>   <div class="input-group">
    <input type="text" id="comment" class="form-control commenttext commenttext_<?=$value['POSTID']?>" placeholder="Write a comment...." name="commentinput" style="margin-left: 47px;">

    <div class="input-group-append">
      <button class="postbutton" type="button" style="background: #f0f2f5;" onclick="postcomment(<?=$value['POSTID']?>);">
       <i class="icofont-paper-plane"></i>
      </button>
    </div>
  </div>
 <?php $valuepostid=$value['POSTID'];
                     $sessionid=$_SESSION['uid'];

  $comment1=mysqli_query($host,"SELECT * FROM comment WHERE post_id='".$valuepostid."'");
 foreach ($comment1 as $key0 => $valuecomment) {
 $queryshowcomment=mysqli_query($host,"SELECT name,profile_picture FROM users WHERE id='".$valuecomment['uid']."'");
                        foreach ($queryshowcomment as $key => $valuecommentname) {
  ?>
<div class="innercomment row">
  <div class="col-md-2"><img src="upload/<?=$valuecommentname['profile_picture']?>"  class="commentpropic"></div>
<?php if(($valuecomment['uid'])==($_SESSION['uid'])){?>
   <div> <button type="button" class="btndelete1 btndelete1_<?=$valuecomment['id']?>" style="background:transparent;"
    onclick="commentdelete(<?=$valuecomment['id']?>);">Delete</button></div>
  <?php }?>
  <div class="col-md-10">
    <div class="comment_individual">
    <p class="username"><?=$valuecommentname['name']?></p>
    <p class="usercomment"><?=$valuecomment['comments']?></p>
  </div>
  <span class="showcommenttime"><?=time_ago_in_php_comment($valuecomment['date_time']);?></span>
<div class="likeReply">
  <div>
 <div class="btn-group">
 <!--  <button type="button" class="btnlike" style="background:transparent;">Like</button> -->
  <?php             
  $valuecommentid=$valuecomment['id'];
                     $sessionid=$_SESSION['uid'];

  $query1=mysqli_query($host,"SELECT * FROM commentlike WHERE comment_id='".$valuecommentid."' AND uid='".$sessionid."'");
  if(mysqli_num_rows($query1)>0){
                       foreach ($query1 as $key => $valuecommentlike) {
                         if($valuecommentlike['comment_id']){
// echo $valuelike1['uid'];
// echo $valuelike1['post_id'];
// echo $value['POSTID'];
?>
     <button type="button" class="btnlike btnlike_<?=$valuecomment['id']?>" style="background:transparent;color:#4080ff;" onclick="likecomment(<?=$valuecomment['id']?>)">Like</button>
                    
                      
<?php } }}  else{?>
 <button type="button" class="btnlike btnlike_<?=$valuecomment['id']?>" style="background:transparent;color:#fff;" onclick="likecomment(<?=$valuecomment['id']?>)">Like</button>
<?php }?>


  <button type="button" class="btnreply" style="background:transparent;" onclick="showreply(<?=$valuecomment['id']?>)">Reply</button>
 
</div> 
</div>
<div class="showreplydiv showreplydiv_<?=$valuecomment['id']?>">
    <div class="ownimgdivreply"><img src="upload/<?=$userdata1['profile_picture']?>"></div> 
   <div class="input-group">
    <input type="text" id="reply" class="form-control replytext replytext_<?=$valuecomment['id']?>"  placeholder="Write a reply...." name="replyinput">

    <div class="input-group-append">
      <button class="postreplybutton" type="button" style="background: #f0f2f5;" onclick="postreply(<?=$valuecomment['id']?>);">
       <i class="icofont-paper-plane"></i>
      </button>
    </div>
  </div>



</div> 
<?php $valuepostid=$valuecomment['id'];
                     $sessionid=$_SESSION['uid'];

  $comment1=mysqli_query($host,"SELECT * FROM reply WHERE comment_id='".$valuepostid."'");
  $n=0;
 foreach ($comment1 as $key0 => $valuereply) {
$n++;
 $queryshowreply=mysqli_query($host,"SELECT name,profile_picture FROM users WHERE id='".$valuereply['uid']."'");
                        foreach ($queryshowreply as $key => $valuereply1) {
  ?>
<div class="row innerreplymain__<?=$valuereply['id']?>">
  <div class="col-md-2"><img src="upload/<?=$valuereply1['profile_picture']?>" class="replyimg"></div>
  <?php if(($valuereply['uid'])==($_SESSION['uid'])){?>
   <div> <button type="button" class="btndelete3 btndelete3_<?=$valuereply['id']?>" style="background:transparent;"
    onclick="replydelete(<?=$valuereply['id']?>);">Delete</button></div>
  <?php }?>
  <div class="col-md-10">
   <div class="innerreply innerreply_<?=$valuereply['id']?>" style=""> <p class="pname"> <?=$valuereply1['name']?></p>
  <p class="preply"> <?=$valuereply['replys']?></p></div>

</div>
<div class="btn-group">
     <?php             
  $valuereplyid=$valuereply['id'];
                     $sessionid=$_SESSION['uid'];

  $query1=mysqli_query($host,"SELECT * FROM replylike WHERE reply_id='".$valuereplyid."' AND uid='".$sessionid."'");
  if(mysqli_num_rows($query1)>0){
                       foreach ($query1 as $key => $valuereplylike) {
                         if($valuereplylike['reply_id']){

?>
   <button type="button" class="btnreplylike btnreplylike_<?=$valuecomment['id']?>" style="background:transparent;color:#4080ff;" onclick="likereplyreply(<?=$valuereply['id']?>)">Like</button>
   <?php } }}  else{?>

     <button type="button" class="btnreplylike btnreplylike_<?=$valuecomment['id']?>" style="background:transparent;color:#fff;" onclick="likereplyreply(<?=$valuereply['id']?>)">Like</button>
   <?php }?>
   <button type="button" class="btnreplyreply btnreplylike_<?=$valuecomment['id']?>" style="background:transparent;color:#fff;"  onclick="showreplydivopen(<?=$valuecomment['id']?>)">Reply</button>
</div>
<span class="showcommenttimereply"><?=time_ago_in_php_comment($valuereply['date_time']);?></span>
</div>

<p class="replylikenumber replylikenumber_<?=$valuereply['id']?>"  onmouseover="showreplylikeduser(<?=$valuereply['id']?>)"
 onmouseout="hidereplylikeduser(<?=$valuereply['id']?>)">
                    <?php 
$replyid=$valuereply['id'];
                     $sessionid=$_SESSION['uid'];

  $comment4=mysqli_query($host,"SELECT * FROM replylike WHERE reply_id='".$replyid."'");
  if(mysqli_num_rows($comment4)>0){
                   $l=0;    
 foreach ($comment4 as $key0 => $valuecomment3) {
$l++;
                    ?>
                   
                  <?php }?>
<img src="assets/images/like.svg" class="likecountimgreply"><span class="likecountspanreply"><?=$l;?></span>
               <?php }?>
               
    </p>
      <div class="listuserlikereply listuserlikereply_<?=$valuereply['id']?>" style="display:none;height:auto">
                  <p>Likes</p>
                   
                       <ul class="showuserslikereply">
                          <?php 
$query1=mysqli_query($host,"SELECT * FROM replylike WHERE reply_id='".$valuereplyid."'");

                     foreach ($query1 as $key0 => $valuelikereply){

                        $queryshowuserreply=mysqli_query($host,"SELECT id,name FROM users WHERE id='".$valuelikereply['uid']."'");
                        // $v=mysqli_fetch_array($queryshowusercomment);
                        // echo $v['name'];
                       
                        foreach ($queryshowuserreply as $key => $valueshowreplyname) {
                        
                     
                        ?>

                          <li style="float: none;"><?=$valueshowreplyname['name']?></li>
                           <?php }}
                      
                      ?>
                       </ul>
                     </div>
<?php }}$k=$k+$n;?>

<?php 

// $queryshowreply1=mysqli_query($host,"SELECT DISTINCT name FROM users WHERE id='".$valuereply['uid']."'");
                       //foreach ($queryshowreply1 as $key => $valuereply2) {  

 $valuecommentid=$valuecomment['id'];

$comment3=mysqli_query($host,"SELECT DISTINCT uid FROM reply WHERE comment_id ='".$valuecommentid."'");
                     foreach ($comment3 as $key0 => $valuecomment2){

                        $queryshowusercomment1=mysqli_query($host,"SELECT id,name FROM users WHERE 
                          id='".$valuecomment2['uid']."'");
                  
                       
                        foreach ($queryshowusercomment1 as $key => $valueshowcommentname1) {
                        
                       ?>


 <script type="text/javascript">
 

  $('.showusersulcomment_'+<?=$value['POSTID']?>).append('<li class="showusersulcommentli_<?=$value['POSTID']?>"><?=$valueshowcommentname1['name']?><span class="replyspan">reply</span></li>');
</script> 
<?php  
}}
?>




 <p class="commentlikenumber"  onmouseover="showcommentlikeuser(<?=$valuecomment['id']?>)"
 onmouseout="hidecommentlikeuser(<?=$valuecomment['id']?>)">
                    <?php 
$commentid=$valuecomment['id'];
                     $sessionid=$_SESSION['uid'];

  $comment4=mysqli_query($host,"SELECT * FROM commentlike WHERE comment_id='".$commentid."'");
  if(mysqli_num_rows($comment4)>0){
                   $l=0;    
 foreach ($comment4 as $key0 => $valuecomment3) {
$l++;
                    ?>
                   
                  <?php }?>
<img src="assets/images/like.svg" class="likecountimg"><span class="likecountspan"><?=$l;?></span>
               <?php }?>
               
    </p>
     <div class="listuserlikecomment listuserlikecomment_<?=$valuecomment['id']?>" style="display:none;height:auto">
                  <p>Likes</p>
                   
                       <ul class="showuserslikecomment">
                          <?php 
$query1=mysqli_query($host,"SELECT * FROM commentlike WHERE comment_id='".$valuecommentid."'");

                     foreach ($query1 as $key0 => $valuelikecomment){

                        $queryshowusercomment=mysqli_query($host,"SELECT id,name FROM users WHERE id='".$valuelikecomment['uid']."'");
                        // $v=mysqli_fetch_array($queryshowusercomment);
                        // echo $v['name'];
                       
                        foreach ($queryshowusercomment as $key => $valueshowcommentname) {
                        
                     
                        ?>

                          <li style="float: none;"><?=$valueshowcommentname['name']?></li>
                           <?php }}
                      
                      ?>
                       </ul>
                     </div>
</div>
</div>

</div>
  <?php }}?>
</div>
              </div>
            </div>
              <script type="text/javascript">
     $('.commentnumspan_<?=$value['POSTID']?>').html(<?=$k?>);
   </script>
                         <!--  <p style="color:green;"><?=$k;?></p> -->
             <?php }}}else{?>

   <div class="postMainBlock postMainBlock1_<?=$value['POSTID']?>">
                <div class="postBlockHeader">
                  <div  class="media_profile">
                    <img src="upload/<?=$value['profile_picture']?>">
                  </div>
                  <div class="postInfo">
                  <div>  <h5><?=$value['name']?></h5></div>
                      <?php 
                   
                  
                      $feeling_id1=$value['feeling_id'];
                   $queryfeelingid= mysqli_query($host,"SELECT * FROM feeling WHERE feeling_id='$feeling_id1'");
                    foreach ($queryfeelingid as $key => $value4) {
                     ?>
                      <div class="activitydiv">is feeling<span><?=$value4['feeling']?>
                        <img src="assets/images/<?=$value4['emoji']?>">
                      </span></div>
                    <?php 
                    }

                   ?>
                    <p class="status"><?=time_ago_in_php($value['date_time']);?><span style="padding:4px;"><i class="icofont-users-alt-4"></i></p>
                      <p class="delete_post"><i class="icofont-ui-delete" onclick="deletepost(<?=$value['POSTID']?>)"></i></p>
                  </div>
                  <div class="clearfix"></div>
                </div>
                <div class="media_details">
                  <p>
                      <?=$value['caption']?>
                    </p>
                  <div  class="media_para">
                    <div id="gallery_<?=$value['POSTID']?>"></div>
                  </div>
                </div>
                <?php
                $selectlike= mysqli_query($host,"SELECT * FROM likepost WHERE post_id ='".$value['POSTID']."'");?>
                <div class="likeshow">
                  
                  <ul>
                    <li class="lifirst">
                     <?php
                      if(mysqli_num_rows($selectlike)>0){
                       $i=0;
                       foreach ($selectlike as $key => $valuelike) { $i++;
                    

// 
                        }

                 ?>
                   <b onmouseover="showlikeduser(<?=$value['POSTID']?>);" onmouseout="hidelikeduser(<?=$value['POSTID']?>);"><img src="assets/images/like.svg"><?=$i?>likes</b>
                     <div class="listusers listuser_<?=$value['POSTID']?>" style="display:none;height:auto">
                  
                    <p>Likes</p>
                       <ul class="showusersul">
                          <?php 
                      foreach ($selectlike as $key => $valueshow) {

                        $queryshow=mysqli_query($host,"SELECT id,name FROM users WHERE id='".$valueshow['uid']."'");
                        foreach ($queryshow as $key => $valueshowname) {
                         
                        
                        ?>
                          <li style="float:none;"><?=$valueshowname['name']?></li>
                           <?php }}
                      ?>
                       </ul>
                     </div>
                   <?php }?>

                    </li>
                    <li class="commentnumber" onmouseover="showcommentuser(<?=$value['POSTID']?>);" onmouseout="hidecommentuser(<?=$value['POSTID']?>);">
                    <?php 
$valuepostid=$value['POSTID'];
                     $sessionid=$_SESSION['uid'];

  $comment2=mysqli_query($host,"SELECT * FROM comment WHERE post_id='".$valuepostid."'");
  if(mysqli_num_rows($comment2)>0){
                   $k=0;    
 foreach ($comment2 as $key0 => $valuecomment1) {
$k++;
                    ?>
                   
                  <?php }?>
 <span class="commentnumspan_<?=$value['POSTID']?>"><?=$k;?></span><span class="numcomment">comments</span>
               <?php }?>
               </li>
                    <li></li>
                  </ul>
                </div>
                 <div class="listuserscomment listusercomment_<?=$value['POSTID']?>" style="display:none;height:auto">
                  <p>Comments</p>
                   
                       <ul class="showusersulcomment showusersulcomment_<?=$value['POSTID']?>">
                          <?php 
                          $comment3=mysqli_query($host,"SELECT DISTINCT uid FROM comment WHERE post_id='".$valuepostid."'");
                     foreach ($comment3 as $key0 => $valuecomment1){

                        $queryshowusercomment=mysqli_query($host,"SELECT id,name FROM users WHERE id='".$valuecomment1['uid']."'");
                        if(mysqli_num_rows($queryshowusercomment)==1){
                        foreach ($queryshowusercomment as $key => $valueshowcommentname) {
                         
                        
                        ?>

                          <li class="showusersulcommentli showusersulcommentli_<?=$value['POSTID']?>" style="float: none;"><?=$valueshowcommentname['name']?></li>
                           <?php }}}
                      ?>
                       </ul>
                     </div>
                <div class="ulDiv">
                  <div style="width: 100%;height: 1px;background: #80808057;margin-top:54px;"></div>
                  <div class="btn-group btnDiv">
                    <button type="button" class="" onclick="likepost(<?=$value['POSTID']?>);">



 <?php             
  $valuepostid=$value['POSTID'];
                      $sessionid=$_SESSION['uid'];

  $query=mysqli_query($host,"SELECT * FROM likepost WHERE post_id='".$valuepostid."' AND uid='".$sessionid."'");
  if(mysqli_num_rows($query)>0){
                       foreach ($query as $key => $valuelike1) {
                         if($valuelike1['post_id']){
// echo $valuelike1['uid'];
// echo $valuelike1['post_id'];
// echo $value['POSTID'];
?>
                        
 <i class="icofont-like likebuttoni_<?=$value['POSTID']?>" style="color:#4080ff;"></i><span class="likebuttonspan_<?=$value['POSTID']?>" style="color:#4080ff;">Like</span>
<?php } }}  else{?>

 <i class="icofont-like likebuttoni_<?=$value['POSTID']?>" style=""></i><span class="likebuttonspan_<?=$value['POSTID']?>" style="">Like</span>
<?php }?>
</button>
                    <button type="button" class="" onclick="showcomment(<?=$value['POSTID']?>);"><i class="icofont-comment"></i><span>Comment</span></button>
                    <button type="button" class=""><i class="icofont-share-alt"></i><span>Share</span></button>
                  </div>
                </div>
                <div style="width: 100%;height: 1px;background: #80808057;margin-top: -2px;"></div>
                <div class="comment comment_<?=$value['POSTID']?>">
               
               <div class="ownimgdiv"><img src="upload/<?=$userdata['profile_picture']?>"></div>   <div class="input-group">
    <input type="text" id="comment" class="form-control commenttext commenttext_<?=$value['POSTID']?>" placeholder="Write a comment...." name="commentinput" style="margin-left: 47px;">

    <div class="input-group-append">
      <button class="postbutton" type="button" style="background: #f0f2f5;" onclick="postcomment(<?=$value['POSTID']?>);">
       <i class="icofont-paper-plane"></i>
      </button>
    </div>
  </div>
  <?php $valuepostid=$value['POSTID'];
                     $sessionid=$_SESSION['uid'];

  $comment1=mysqli_query($host,"SELECT * FROM comment WHERE post_id='".$valuepostid."'");
  
                       
 foreach ($comment1 as $key0 => $valuecomment) {

 $queryshowcomment=mysqli_query($host,"SELECT name,profile_picture FROM users WHERE id='".$valuecomment['uid']."'");
                        foreach ($queryshowcomment as $key => $valuecommentname) {
  ?>
<div class="innercomment row">
  <div class="col-md-2"><img src="upload/<?=$valuecommentname['profile_picture']?>" class="commentpropic"></div>
  <div class="col-md-10">
     <div> <button type="button" class="btndelete1 btndelete1_<?=$valuecomment['id']?>" style="background:transparent;" onclick="commentdelete(<?=$valuecomment['id']?>);">Delete</button></div>
    <div class="comment_individual">
    <p class="username"><?=$valuecommentname['name']?></p>
    <p class="usercomment"><?=$valuecomment['comments']?></p>

  </div>
 
  <span class="showcommenttime"><?=time_ago_in_php_comment($valuecomment['date_time']);?></span>
  <div class="likeReply">
    <div>
 <div class="btn-group">
   <?php             
  $valuecommentid=$valuecomment['id'];
                     $sessionid=$_SESSION['uid'];

  $query1=mysqli_query($host,"SELECT * FROM commentlike WHERE comment_id='".$valuecommentid."' AND uid='".$sessionid."'");
  if(mysqli_num_rows($query1)>0){
                       foreach ($query1 as $key => $valuecommentlike) {
                         if($valuecommentlike['comment_id']){
// echo $valuelike1['uid'];
// echo $valuelike1['post_id'];
// echo $value['POSTID'];
?>
     <button type="button" class="btnlike btnlike_<?=$valuecomment['id']?>" style="background:transparent;color:#4080ff;" onclick="likecomment(<?=$valuecomment['id']?>)">Like</button>
                    
                      
<?php } }}  else{?>
 <button type="button" class="btnlike btnlike_<?=$valuecomment['id']?>" style="background:transparent;color:#fff;" onclick="likecomment(<?=$valuecomment['id']?>)">Like</button>
<?php }?>


 <!--  <button type="button" class="btnlike" style="background:transparent;">Like</button> -->
  <button type="button" class="btnreply" style="background:transparent;" onclick="showreply(<?=$valuecomment['id']?>)">Reply</button>
 </div>
</div>
<div class="showreplydiv showreplydiv_<?=$valuecomment['id']?>">
    <div class="ownimgdivreply"><img src="upload/<?=$userdata1['profile_picture']?>"></div> 
   <div class="input-group">
    <input type="text" id="reply" class="form-control replytext replytext_<?=$valuecomment['id']?>"  placeholder="Write a reply...." name="replyinput">

    <div class="input-group-append">
      <button class="postreplybutton" type="button" style="background: #f0f2f5;" onclick="postreply(<?=$valuecomment['id']?>);">
       <i class="icofont-paper-plane"></i>
      </button>
    </div>
  </div>



</div> 
<?php $valuepostid=$valuecomment['id'];
                     $sessionid=$_SESSION['uid'];

  $comment1=mysqli_query($host,"SELECT * FROM reply WHERE comment_id='".$valuepostid."'");
  $n=0;
 foreach ($comment1 as $key0 => $valuereply) {
  $n++;
 $queryshowreply=mysqli_query($host,"SELECT name,profile_picture FROM users WHERE id='".$valuereply['uid']."'");
                        foreach ($queryshowreply as $key => $valuereply1) {
  ?>
<div class="row innerreplymain__<?=$valuereply['id']?>">
  <div class="col-md-2"><img src="upload/<?=$valuereply1['profile_picture']?>" class="replyimg"></div>

   <div> <button type="button" class="btndelete3 btndelete3_<?=$valuereply['id']?>" style="background:transparent;"
    onclick="replydelete(<?=$valuereply['id']?>);">Delete</button></div>
 
  <div class="col-md-10">
   <div class="innerreply innerreply_<?=$valuereply['id']?>" style=""> <p class="pname"> <?=$valuereply1['name']?></p>
  <p class="preply"> <?=$valuereply['replys']?></p></div>

</div>
<div class="btn-group">
     <?php             
  $valuereplyid=$valuereply['id'];
                     $sessionid=$_SESSION['uid'];

  $query1=mysqli_query($host,"SELECT * FROM replylike WHERE reply_id='".$valuereplyid."' AND uid='".$sessionid."'");
  if(mysqli_num_rows($query1)>0){
                       foreach ($query1 as $key => $valuereplylike) {
                         if($valuereplylike['reply_id']){

?>
   <button type="button" class="btnreplylike btnreplylike_<?=$valuecomment['id']?>" style="background:transparent;color:#4080ff;" onclick="likereplyreply(<?=$valuereply['id']?>)">Like</button>
   <?php } }}  else{?>

     <button type="button" class="btnreplylike btnreplylike_<?=$valuecomment['id']?>" style="background:transparent;color:#fff;" onclick="likereplyreply(<?=$valuereply['id']?>)">Like</button>
   <?php }?>
   <button type="button" class="btnreplyreply btnreplylike_<?=$valuecomment['id']?>" style="background:transparent;color:#fff;"  onclick="showreplydivopen(<?=$valuecomment['id']?>)">Reply</button>
</div>
<span class="showcommenttimereply"><?=time_ago_in_php_comment($valuereply['date_time']);?></span>
</div>
<p class="replylikenumber replylikenumber_<?=$valuereply['id']?>"  onmouseover="showreplylikeduser(<?=$valuereply['id']?>)"
 onmouseout="hidereplylikeduser(<?=$valuereply['id']?>)">
                    <?php 
$replyid=$valuereply['id'];
                     $sessionid=$_SESSION['uid'];

  $comment4=mysqli_query($host,"SELECT * FROM replylike WHERE reply_id='".$replyid."'");
  if(mysqli_num_rows($comment4)>0){
                   $l=0;    
 foreach ($comment4 as $key0 => $valuecomment3) {
$l++;
                    ?>
                   
                  <?php }?>
<img src="assets/images/like.svg" class="likecountimgreply"><span class="likecountspanreply"><?=$l;?></span>
               <?php }?>
               
    </p>
      <div class="listuserlikereply listuserlikereply_<?=$valuereply['id']?>" style="display:none;height:auto">
                  <p>Likes</p>
                   
                       <ul class="showuserslikereply">
                          <?php 
$query1=mysqli_query($host,"SELECT * FROM replylike WHERE reply_id='".$valuereplyid."'");

                     foreach ($query1 as $key0 => $valuelikereply){

                        $queryshowuserreply=mysqli_query($host,"SELECT id,name FROM users WHERE id='".$valuelikereply['uid']."'");
                        // $v=mysqli_fetch_array($queryshowusercomment);
                        // echo $v['name'];
                       
                        foreach ($queryshowuserreply as $key => $valueshowreplyname) {
                        
                     
                        ?>

                          <li style="float: none;"><?=$valueshowreplyname['name']?></li>
                           <?php }}
                      
                      ?>
                       </ul>
                     </div>
<?php }}$k=$k+$n;?>

 
<?php 

// $queryshowreply1=mysqli_query($host,"SELECT DISTINCT name FROM users WHERE id='".$valuereply['uid']."'");
                       //foreach ($queryshowreply1 as $key => $valuereply2) {  

 $valuecommentid=$valuecomment['id'];

$comment3=mysqli_query($host,"SELECT DISTINCT uid FROM reply WHERE comment_id ='".$valuecommentid."'");
                     foreach ($comment3 as $key0 => $valuecomment2){

                        $queryshowusercomment1=mysqli_query($host,"SELECT id,name FROM users WHERE 
                          id='".$valuecomment2['uid']."'");
                  
                       
                        foreach ($queryshowusercomment1 as $key => $valueshowcommentname1) {
                        
                       ?>


 <script type="text/javascript">
 

  $('.showusersulcomment_'+<?=$value['POSTID']?>).append('<li class="showusersulcommentli_<?=$value['POSTID']?>"><?=$valueshowcommentname1['name']?><span class="replyspan">reply</span></li>');
</script> 
<?php  
}}
?>



<p class="commentlikenumber" onmouseover="showcommentlikeuser(<?=$valuecomment['id']?>)"
 onmouseout="hidecommentlikeuser(<?=$valuecomment['id']?>)">
                    <?php 
$commentid=$valuecomment['id'];
                     $sessionid=$_SESSION['uid'];

  $comment4=mysqli_query($host,"SELECT * FROM commentlike WHERE comment_id='".$commentid."'");
  if(mysqli_num_rows($comment4)>0){
                   $l=0;    
 foreach ($comment4 as $key0 => $valuecomment3) {
$l++;
                    ?>
                   
                  <?php }?>
<img src="assets/images/like.svg" class="likecountimg"><span class="likecountspan"><?=$l;?></span>
               <?php }?>
               
    </p>
     <div class="listuserlikecomment listuserlikecomment_<?=$valuecomment['id']?>" style="display:none;height:auto">
                  <p>Likes</p>
                   
                       <ul class="showuserslikecomment">
                          <?php 
$query1=mysqli_query($host,"SELECT * FROM commentlike WHERE comment_id='".$valuecommentid."'");

                     foreach ($query1 as $key0 => $valuelikecomment){

                        $queryshowusercomment=mysqli_query($host,"SELECT id,name FROM users WHERE id='".$valuelikecomment['uid']."'");
                        // $v=mysqli_fetch_array($queryshowusercomment);
                        // echo $v['name'];
                       
                        foreach ($queryshowusercomment as $key => $valueshowcommentname) {
                        
                     
                        ?>

                          <li style="float: none;"><?=$valueshowcommentname['name']?></li>
                           <?php }}
                      
                      ?>
                       </ul>
                                            </div>
</div>
  </div>






</div>
  <?php }}?>
  <!--  <p><?=$k;?></p> -->
   <script type="text/javascript">
     $('.commentnumspan_<?=$value['POSTID']?>').html(<?=$k?>);
   </script>
               

              </div>
            </div>
      <?php }}?>
          
          </div>

        </div>

       </div>

    <div class="col-lg-3 post">
      
      <div class="subpost">
        <h4><i class="icofont-image"></i> Photos</h4>
        <?php
          if(mysqli_num_rows($selectPosts1) > 0)
          {
            foreach ($selectPosts1 as $key => $value) 
            {
                  if (strpos($value['files'], ',') !== false)
                  {
                    $fileExplode1 = explode(',', $value['files']);
                    foreach ($fileExplode1 as $key1)
                     {
                     ?>
                      <a class="image-link" href="upload/<?=$key1?>">  <img src='upload/<?=$key1?>'></a>
                        <!-- for multiple images separated by comma posted-->
                    <?php 
                     }
                }
                 else {
                    ?>
                  <a class="image-link" href="upload/<?=$value['files']?>">   <img src='upload/<?=$value['files']?>'></a>
                        <!-- for single image posted -->
                        <?php 
                  }
            }
          } else {?>
          <div class="text-center pt-2">
             <img src="assets/images/image.svg" width="95px">
             <p>You Have no Images</p>
          </div>
        <?php }?>
     </div>
   </div>
    </div>
  </div>
</div>
<div  class="tab-pane fade in" id="friend">
  <div class="container">
   
         

          <div class="col-lg-12 friendInnerDiv">
            <p class="Para_friends">Friends <i class="icofont-users-alt-4"></i> </p>
            <p class="friendlistpara">No Friends</p>
            <?php
             if(mysqli_num_rows($selectFriendList) > 0)
      {     $l=0;
          foreach ($selectFriendList as $key => $value) {
            if($value['id']!=$_SESSION['uid']){
          $l++;
          ?>
<script type="text/javascript">
   var countfriend1=<?=$l?>;
  if(countfriend1>0){

  $('.friendlistpara').html(countfriend1+" friend");
  if(countfriend1>1){
  $('.friendlistpara').html(countfriend1+" friends");
}
}
</script>
<div class="row friendListDiv">

   
     <div class="col-md-3">
      <a href="friendView.php?uid=<?=$value['id']?>"> <img src="upload/<?=$value['profile_picture']?>" class="friendlistImg"></a>
     </div>
     <div class="col-md-5">
       <p class="friendname1"><?=$value['name']?></p>
     </div>
     <div class="col-md-4 
     friendbuttondiv<?=$value['id']?>">
      <!--  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script> -->
       <button class="friendbutton"><i class="icofont-verification-check"></i> Friend </button>
       <button class="friendbutton" onclick="deleteFriend(<?=$value['id']?>)">UnFriend </button>

      <!--  <div class="dropdown-menu">
        <a class="dropdown-item" href="#">Unfriend</a>
       
      </div> -->
     </div>
   </div>

<?php }}}else{?>
  <div class="text-center pt-2">
         <img src="assets/images/group.svg" width="95px">
         <p>You Have No Friends</p>
      </div>
    <?php }?>
</div>


  </div>
</div>
<div  class="tab-pane fade in" id="about">
<div class="container">
  <div class="col-lg-12 backgroundAbout">
     <ul class="nav nav-tabs aboutNav">
           <li class="active">
             <a class="nav-item nav-link active" data-toggle="tab" href="#aboutsubmit">Details</a>
           </li>
           <li>
             <a class="nav-item nav-link " data-toggle="tab" href="#overview">Overview</a>
           </li>
         </ul>


    <div class="tab-content aboutTab">
    <div class="tab-pane fade in active show" id="aboutsubmit">
     <form action="" method="post" class="needs-validation" novalidate>
    <div class="form-group">
      <label for="school">School</label>
      <input type="text" class="form-control" id="school" placeholder="Enter school name" name="school" required>
      <div class="valid-feedback">Valid.</div>
      <div class="invalid-feedback">Please fill out this field.</div>
    </div>
    <div class="form-group">
      <label for="college">College</label>
      <input type="text" class="form-control" id="college" placeholder="Enter college name" name="college" required>
      <div class="valid-feedback">Valid.</div>
      <div class="invalid-feedback">Please fill out this field.</div>
    </div>
    <div class="form-group">
      <label for="place">Native Place</label>
      <input type="text" class="form-control" id="place" placeholder="Enter your native place" name="place" required>
      <div class="valid-feedback">Valid.</div>
      <div class="invalid-feedback">Please fill out this field.</div>
    </div>
    <div class="form-group">
      <label for="place">Status</label>
      <input type="text" class="form-control" id="status" placeholder="Enter your status" name="status" required>
      <div class="valid-feedback">Valid.</div>
      <div class="invalid-feedback">Please fill out this field.</div>
    </div>
    <div class="btn-group">
    <button type="submit" name="abtsubmit" class="aboutsubmit">Submit</button>
    <button type="submit" name="abtupdate"class="aboutupdate">Update</button>
  </div>
  </form>
</div>
<div class="tab-pane fade in" id="overview">

  <div class="col-lg-12">
    <?php if($aboutvalue){?>
    <div class="row">
      <div class="col-lg-4"> <label for="school">School</label></div>
      <div class="col-lg-8"><p><?=$aboutvalue['school']?></p></div>
    </div>
    <div class="row">
       <div class="col-lg-4"> <label for="college">College</label></div>
      <div class="col-lg-8"><p><?=$aboutvalue['college']?></p></div>
    </div>
    <div class="row">
       <div class="col-lg-4"> <label for="place">Native Place</label></div>
      <div class="col-lg-8"><p><?=$aboutvalue['place']?></p></div>
    </div>
    <div class="row">
       <div class="col-lg-4"> <label for="status">Status</label></div>
      <div class="col-lg-8"><p><?=$aboutvalue['statuses']?></p></div>
    </div>
  <?php } else{?>
    <div class="text-center pt-2">
             <img src="assets/images/details.svg" width="95px">
             <p>You have no details.</p>
          </div>
  <?php }?>
  </div>
</div>
</div>
  </div>
  
</div>
</div>

<div  class="tab-pane fade in" id="photos">
  <div class="container">
   <div class="col-lg-12 subpostPhoto">
        <h4><i class="icofont-image"></i> Photos</h4>
        <div class="innerPhotodiv">
        <?php
         if(mysqli_num_rows($selectPosts1) > 0)
          {
            foreach ($selectPosts1 as $key => $value) 
            {
                  if (strpos($value['files'], ',') !== false)
                  {
                    $fileExplode1 = explode(',', $value['files']);
                    foreach ($fileExplode1 as $key1)
                     {
                     ?>
                      <a class="photoImg" href="upload/<?=$key1?>">  <img src='upload/<?=$key1?>'></a>
                        <!-- for multiple images separated by comma posted-->
                    <?php 
                     }
                }
                 else {
                    ?>
                  <a class="photoImg" href="upload/<?=$value['files']?>">   <img src='upload/<?=$value['files']?>'></a>
                        <!-- for single image posted -->
                        <?php 
        }
             }}else{?>
              <div class="text-center pt-2">
             <img src="assets/images/image.svg" width="95px">
             <p>You have no images</p>
          </div>
             <?php }?>
           </div>
     </div>
</div>
</div>



</div>
<?php
include('metakey_js.php');
?>
<script type="text/javascript">
  $(document).ready(function () {
    //If image edit link is clicked
    $(".editLink").on('click', function(e){
        e.preventDefault();
        $("#fileInput:hidden").trigger('click');
    });
     $(".editLink1").on('click', function(e){
        e.preventDefault();
        $("#fileInput1:hidden").trigger('click');
    });

    //On select file to upload
    $("#fileInput").on('change', function(){
        var image = $('#fileInput').val();
        var img_ex = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
        
        //validate file type
        if(!img_ex.exec(image)){
            alert('Please upload only .jpg/.jpeg/.png/.gif file.');
            $('#fileInput').val('');
            return false;
        }else{
            $('.uploadProcess').show();
            $('#uploadForm').hide();
            $( "#picUploadForm" ).submit();
        }
    });

     //On select file to upload
    $("#fileInput1").on('change', function(){
        var image1 = $('#fileInput1').val();
        var img_ex1 = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
        
        //validate file type
        if(!img_ex1.exec(image1)){
            alert('Please upload only .jpg/.jpeg/.png/.gif file.');
            $('#fileInput1').val('');
            return false;
        }else{
            $('.uploadProcess1').show();
            $('#uploadForm1').hide();
            $( "#picUploadForm1" ).submit();
        }
    });
});
  function completeUpload(success, fileName) {
    if(success == 1){
        $('#imagePreview').attr("src", "");
        $('#imagePreview').attr("src", fileName);
        $('#fileInput').attr("value", fileName);
        $('.uploadProcess').hide();
    }else{
        $('.uploadProcess').hide();
        alert('There was an error during file upload!');
    }
    return true;
}
 function completeUpload1(success, fileName) {
    if(success == 1){
        $('#imagePreview1').attr("src", "");
        $('#imagePreview1').attr("src", fileName);
        $('#fileInput1').attr("value", fileName);
        $('.uploadProcess1').hide();
    }else{
        $('.uploadProcess1').hide();
        alert('There was an error during file upload!');
    }
    return true;
}
$('.image-link').magnificPopup({
    type: 'image',
    gallery: {
              enabled: true,
              navigateByImgClick: true
          },
        cursor: 'mfp-zoom-out-cur'
    });

$('.photoImg').magnificPopup({
    type: 'image',
    gallery: {
              enabled: true,
              navigateByImgClick: true
          },
        cursor: 'mfp-zoom-out-cur'
    });
  $("#owl-demo").owlCarousel({
 
      navigation : true, // Show next and prev buttons
      slideSpeed : 300,
      paginationSpeed : 400,
      singleItem:true
 
      // "singleItem:true" is a shortcut for:
      // items : 1, 
      // itemsDesktop : false,
      // itemsDesktopSmall : false,
      // itemsTablet: false,
      // itemsMobile : false
 
  });
  $( ".owl-prev").html('<i class="icofont-rounded-left" ></i>');
  $( ".owl-next").html('<i class="icofont-rounded-right" ></i>');
  //  $("#owl-demo1").owlCarousel({
 
  //     navigation : true, // Show next and prev buttons
  //     singleItem:true,
  //     autoplay:true,
  //     loop:true,
  //      autoplayTimeout:1000,
 
  // });
  // $( ".owl-prev").html('<i class="icofont-rounded-left" ></i>');
  // $( ".owl-next").html('<i class="icofont-rounded-right" ></i>');
</script>
<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
<script  type="text/javascript" src="assets/js/images-grid.js"></script>
<script type="text/javascript">

     window.onload = function () {
            var fileUpload = document.getElementById("fileupload");
            fileUpload.onchange = function () {
                if (typeof (FileReader) != "undefined") {
                    var dvPreview = document.getElementById("dvPreview");
                    dvPreview.innerHTML = "";
                    var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.jpg|.jpeg|.gif|.png|.bmp)$/;
                    for (var i = 0; i < fileUpload.files.length; i++) {
                        var file = fileUpload.files[i];
                        if (regex.test(file.name.toLowerCase())) {
                            var reader = new FileReader();
                            reader.onload = function (e) {
                                var img = document.createElement("IMG");
                                img.height = "100";
                                img.width = "100";
                                img.src = e.target.result;
                                dvPreview.appendChild(img);
                            }
                            reader.readAsDataURL(file);
                        } else {
                            alert(file.name + " is not a valid image file.");
                            dvPreview.innerHTML = "";
                            return false;
                        }
                    }
                } else {
                    alert("This browser does not support HTML5 FileReader.");
                }
            }
        };
        

        <?php
         foreach ($selectPosts as $key => $value) {
        ?>
        var images<?=$value['POSTID']?> = [
                      <?php
                        $fileExplode = explode(',', $value['files']);
                        foreach ($fileExplode as $key => $image) {
                      ?>
                      'upload/<?=$image?>',
                      <?php } ?>
                    ];
        <?php }?>

        $(function() {
          <?php
          foreach ($selectPosts as $key => $value) {
          ?>
          $('#gallery_<?=$value['POSTID']?>').imagesGrid({images : images<?=$value['POSTID']?>});
          <?php
          }
          ?>
          
      });

      function addFriendevent(userId)
      {

      	$.ajax({
      type:'POST',
      url:'friendRequest.php',
      data:{userId:userId},
      success: function(data){
        if(data == '1')
        {
          // $('.add').html('Cancel Request');
          // $('.add').css("font-size","11px");
          //  $('.add').css("width","58%");
          //  $('.remove').css("font-size","11px");
          //  $('.remove').css("width","37%");

           $('.add_'+ userId).hide();
           $('.cancel_'+ userId).show();
           $('.remove_'+ userId).hide();
         
          
           // $('.remove').css("font-size","11px");
           // $('.remove').css("width","37%");
			}
        else
        {
         
        }
        
      },
      error: function(data){
        console.log(data);
      }
    })
      }


           function removeFriendevent(userId2)
      {
         $('.pRemove_'+ userId2).html('Removed');
         $('.remove_'+ userId2).hide();
            $('.add_'+ userId2).hide();
          
       
      }






       function cancelFriendevent(userId1)
      {

      	$.ajax({
      type:'POST',
      url:'friendRequest.php',
      data:{userId1:userId1},
      success: function(data){
        if(data == '1')
        {
			$('.cancel_'+ userId1).hide();
          	$('.add_'+ userId1).show();
            $('.remove_'+ userId1).show();
         
          
		}
        else
        {
         
        }
        
      },
      error: function(data){
        console.log(data);
      }
    })
      }

       function confirmFriendevent(userId2)
      {

        $.ajax({
      type:'POST',
      url:'friendRequest.php',
      data:{userId2:userId2},
      success: function(data){
        if(data == '1')
        {
      $('.confirm_'+ userId2).hide();
      $('.delete_'+ userId2).hide();
      $('.pConfirm_'+ userId2).show();

         
          
    }
        else
        {
        alert('cant');
        }
        
      },
      error: function(data){
        console.log(data);
      }
    })
      }

        function deleteFriendevent(userId3)
      {

        $.ajax({
      type:'POST',
      url:'friendRequest.php',
      data:{userId3:userId3},
      success: function(data){
        if(data == '1')
        {
       $('.confirm_'+ userId3).hide();
      $('.delete_'+ userId3).hide();
      $('.pConfirm_'+ userId3).show();
      $('.pConfirm_'+ userId3).html('Request is removed');
      $('.pConfirm_'+ userId3).css('color','red');

         
          
    }
        else
        {
         
        }
        
      },
      error: function(data){
        console.log(data);
      }
    })
      }
       function deletepost(idpost)
      {
         // var returnval = confirm('Want to delete this post.');

         // if(returnval==true){

        $.ajax({
      type:'POST',
      url:'commonAjax.php',
      data:{idpost:idpost},
      success: function(data){
        if(data == '1')
        {
         
          $('.postMainBlock1_'+ idpost).html('Your post has been deleted successfully.');
           $('.postMainBlock1_'+ idpost).css('text-align','center');
           $('.postMainBlock1_'+ idpost).css('padding','10px');
           $('.postMainBlock1_'+ idpost).css('font-size','14px');
           $('.postMainBlock1_'+ idpost).css('font-weight','500');
           $('.postMainBlock1_'+ idpost).css('color','#704c4c');

 }
        else
        {
         
        }
        
      },
      error: function(data){
        console.log(data);
      }
    })

      // }
      // else
      // {
      //    $_SESSION['SET_TYPE'] = 'error';
      //     $_SESSION['SET_FLASH'] = 'Cancelled';
         
      // }
      }
       function deleteFriend(idfriend)
      {
         // var returnval = confirm('Want to delete this post.');

         // if(returnval==true){

        $.ajax({
      type:'POST',
      url:'friendRequest.php',
      data:{idfriend:idfriend},
      success: function(data){
        if(data == '1')
        {
         $('.friendbuttondiv'+idfriend).html("Removed");
         $('.friendbuttondiv'+idfriend).css({"margin-top": "54px", "color": "#bc9e9e","font-weight": "500","font-size": "15px"}); 

 }
        else
        {
          $('.friendbuttondiv'+idfriend).html("not Removed");
        }
        
      },
      error: function(data){
        console.log(data);
      }
    })
      }
      $(document).ready(function(){
  $(".nav-tabs a").click(function(){
    $(this).tab('show');
  });
 
});

// $(document).ready(function(){
//     $(".activity").click(function(){
//         $("#myModal").modal('show');
//     });
// });
$(document).ready(function(){

    $(".postFeelingbtn").click(function(){

        var selectedCountry = $('.selectFeeling').children("option:selected").val();
$('.activitytext').val(selectedCountry);
        // alert("You have selected the country - " + selectedCountry);

    });
     });

function likepost(postid){

  $.ajax({
      type:'POST',
      url:'commonAjax.php',
      data:{postid:postid},
      success: function(data){
        if(data == '1')
        {
          alert("success to like");

        
         $('.likebuttoni_'+postid).css("color","#4080ff");
         $('.likebuttonspan_'+postid).css("color","#4080ff");

      
        
 }
 else if(data == '2')
        {
          alert("success to dislike");

         $('.likebuttoni_'+postid).css("color","#677c8e");
         $('.likebuttonspan_'+postid).css("color","#677c8e");

    
        
 }
        else
        {
           alert("failure");
        }
        
      },
      error: function(data){
        console.log(data);
      }
    })


}
function showlikeduser(postidshow){
$('.listuser_'+postidshow).show();

}
function hidelikeduser(postidshow){
$('.listuser_'+postidshow).hide();

}
function showcomment(postidcomment){
// alert("click");
  $('.comment_'+postidcomment).toggle();
}
function postcomment(idpostcomment){
var commenttext=$('.commenttext_'+idpostcomment).val();
// alert(commenttextval);


  $.ajax({
      type:'POST',
      url:'commonAjax.php',
      data:{idpostcomment:idpostcomment,commenttext:commenttext},
      success: function(data){
        if(data == '1')
        {
          alert("success to comment");

        
         // $('.likebuttoni_'+postid).css("color","#4080ff");
         // $('.likebuttonspan_'+postid).css("color","#4080ff");

      
        
 }
   else
        {
           alert("failure");
        }
        
      },
      error: function(data){
        console.log(data);
      }
    })


}
function showcommentuser(postidshow){
$('.listusercomment_'+postidshow).show();

}
function hidecommentuser(postidshow){
$('.listusercomment_'+postidshow).hide();

}


function commentdelete(idcomment)
      {
         

        $.ajax({
      type:'POST',
      url:'commonAjax.php',
      data:{idcomment:idcomment},
      success: function(data){
        if(data == '1')
        {
         
         alert("Comment deleted successfully");

 }
        else
        {
         
        }
        
      },
      error: function(data){
        console.log(data);
      }
    })
      }

 function likecomment(commentid){
    $.ajax({
      type:'POST',
      url:'commonAjax.php',
      data:{commentid:commentid},
      success: function(data){
         if(data == '1')
        {
          alert("success to like");

        
         $('.btnlike_'+commentid).css("color","#4080ff");
        // $('.btnlike_'+commentid).css("color","#4080ff");

      
        
 }
 else if(data == '2')
        {
          alert("success to dislike");

         $('.btnlike_'+commentid).css("color","#fff");
        // $('.likebuttonspan_'+commentid).css("color","#fff");

    
        
 }
        else
        {
           alert("failure");
        }
        
      },
      error: function(data){
        console.log(data);
      }
    })


}
function showcommentlikeuser(commentlikeidshow){
$('.listuserlikecomment_'+commentlikeidshow).show();

}
function hidecommentlikeuser(commentlikeidshow){
$('.listuserlikecomment_'+commentlikeidshow).hide();

}
function showreply(postidreply){
// alert("click");
  $('.showreplydiv_'+postidreply).toggle();
}
function postreply(idpostreply){
var replytext=$('.replytext_'+idpostreply).val();
// alert(commenttextval);
  $.ajax({
      type:'POST',
      url:'commonAjax.php',
      data:{idpostreply:idpostreply,replytext:replytext},
      success: function(data){
        if(data == '1')
        {
          alert("success to comment");

        
         // $('.likebuttoni_'+postid).css("color","#4080ff");
         // $('.likebuttonspan_'+postid).css("color","#4080ff");

      
        
 }
   else
        {
           alert("failure");
        }
        
      },
      error: function(data){
        console.log(data);
      }
    })


}
function showreplydivopen(postidreply){
 $('.showreplydiv_'+postidreply).toggle();

}
 function likereplyreply(replyid){
    $.ajax({
      type:'POST',
      url:'commonAjax.php',
      data:{replyid:replyid},
      success: function(data){
         if(data == '1')
        {
          alert("success to like");

        
         $('.btnreplylike_'+replyid).css("color","#4080ff");
        // $('.btnlike_'+commentid).css("color","#4080ff");

      
        
 }
 else if(data == '2')
        {
          alert("success to dislike");

         $('.btnreplylike_'+replyid).css("color","#fff");
        // $('.likebuttonspan_'+commentid).css("color","#fff");

    
        
 }
        else
        {
           alert("failure");
        }
        
      },
      error: function(data){
        console.log(data);
      }
    })


}
function replydelete(idreply)
      {
         

        $.ajax({
      type:'POST',
      url:'commonAjax.php',
      data:{idreply:idreply},
      success: function(data){
        if(data == '1')
        {
         
         alert("Reply deleted successfully");

 }
        else
        {
         
        }
        
      },
      error: function(data){
        console.log(data);
      }
    })
      }
function showreplylikeduser(replyidshow){
$('.listuserlikereply_'+replyidshow).show();

}
function hidereplylikeduser(replyidshow){
$('.listuserlikereply_'+replyidshow).hide();

}
      if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}


</script>