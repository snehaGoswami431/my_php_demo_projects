<?php
$pagename = 'Home';
include('config.php');
if(!isset($_SESSION['uid']))
{
  header('location:signin.php');
}
    $session_uid       = $_SESSION['uid'];
$uid=$_GET['uid'];
$query    = "SELECT * FROM users WHERE id='".$uid."'";

$results  = mysqli_query($host, $query);

$userdata = mysqli_fetch_array($results);
$before=$userdata['name'];
$after=explode(' ',$before);
$after=$after[0];
$selectPosts= mysqli_query($host, "SELECT * FROM posts WHERE uid ='".$uid."'");


$selectFriendList = mysqli_query($host,"SELECT DISTINCT friendrequest.id , friendrequest.uid ,friendrequest.requestid,friendrequest.status,users.id,users.profile_picture,users.cover_picture,users.name FROM friendrequest LEFT JOIN users ON friendrequest.requestid = users.id OR friendrequest.uid = users.id WHERE (friendrequest.uid = $uid OR friendrequest.requestid = $uid) AND friendrequest.status ='1'");
$selectFriendListsub = mysqli_query($host,"SELECT DISTINCT friendrequest.id , friendrequest.uid ,friendrequest.requestid,friendrequest.status,users.id,users.profile_picture,users.cover_picture,users.name FROM friendrequest LEFT JOIN users ON friendrequest.requestid = users.id OR friendrequest.uid = users.id WHERE (friendrequest.uid = $session_uid  OR friendrequest.requestid = $session_uid) AND friendrequest.status ='1'");

// foreach ($selectFriendListsub as $key => $value4) {
// $i=0;
//  foreach ($$selectFriendList as $key => $value5) {
//  if($value4['id']!=$_SESSION['uid']){
//        if($value5['id']==$value4['id']){
//         $i=$i+1;

//        }
//      }
//  }
// }
// echo $i;



// foreach ($selectFriendListPrevious as $key => $value) {
//   $value2= $value['requestid'];
//  if($value1==$value2)

// {
//  $requestid1=$value1;
//  echo $value1;
// }
// }
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


$aboutlist = mysqli_query($host,"SELECT * FROM about WHERE uid='".$uid."'");
$aboutlistshow = mysqli_fetch_array($aboutlist);

include('metakey_css.php');
include('header.php');

?>
<section>
  <div class="container">
   <div class="row timelineHeader">
      <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="coverPhoto">
         <img id="imagePreview1" src="upload/<?=$userdata['cover_picture']?>">
         <!-- <div class="coverIcon"><i class="icofont-plus-square"></i></div> -->
         <form method="post" action="" enctype="multipart/form-data" id="picUploadForm1" target="uploadTarget1">
                <input type="file" name="picture1" id="fileInput1"  style="display:none"/>
            </form>
             <iframe id="uploadTarget1" name="uploadTarget1" src="#" style="width:0;height:0;border:0px solid #fff;">
               
             </iframe>
            <!--  <a class="editLink1 coverIcon tooltip1" href="javascript:void(0);"><i class="icofont-plus-square"></i>
              <span class="tooltiptext1">Edit</span></a> -->
        </div>
      </div>


      <div class="profilePicture">
          <img id="imagePreview" src="upload/<?=$userdata['profile_picture']?>">
           <form method="post" action="" enctype="multipart/form-data" id="picUploadForm" target="uploadTarget">
                <input type="file" name="picture" id="fileInput"  style="display:none"/>
            </form>
             <iframe id="uploadTarget" name="uploadTarget" src="#" style="width:0;height:0;border:0px solid #fff;">
               
             </iframe>
            <!--  <a class="editLink tooltip" href="javascript:void(0);"><i class="icofont-camera"></i>
               <span class="tooltiptext">Edit</span>
             </a> -->
            <!-- Profile image -->
      </div>
     
 </div>
 <div class="name_email">
    <h3 style="text-transform:uppercase;"><?=$userdata['name']?></h3>

             <p><?=$userdata['email']?></p>
<?php  foreach($selectFriendListsub as $key => $value) {


    $session_uid       = $_SESSION['uid'];

          if($userdata['id']==$value['id']){
            // echo $value['name'];
           
  ?>
             <div class="friendsbuttondiv"><button><i class="icofont-verification-check"></i>Friends</button>
             <button><i class="icofont-facebook-messenger"></i>Message</button></div>
           <?php } 
          

         }?>
 </div>
   <div class="row">
     <div class="col-md-12 col-lg-12 col-sm-12">
       <div class="changeHeader">
         <ul class="nav nav-tabs">
           <li class="active">
             <a class="nav-item nav-link active" data-toggle="tab" href="#timeline">Timeline</a>
           </li>
          
           <li>
             <a class="nav-item nav-link" data-toggle="tab"href="#friend">Friends</a>
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
    
      <div class="col-lg-3 introSection">
        
      <div class="innerdiv1">
        <p class="intro"><span><i class="icofont-world"></i></span>Intro</p>
        <div class="aboutMe"><p>About <?=$userdata['name']?></p></div>
         <script type="text/javascript">
         <?php $pagename=$userdata['name'];?>
         
          $(function(){

     $(document).attr("title", "<?=$pagename?>'s profile");

  });
          
         </script>
        <div class="line"></div>
         <?php if($aboutlistshow){?>
        <div class="aboutDetails">
          <p><span><i class="icofont-users-social"></i></span>Studied in <?=$aboutlistshow['school']?></p>
          <p><span><i class="icofont-graduate"></i></span>Graduated from <?=$aboutlistshow['college']?></p>
          <p><span><i class="icofont-home"></i></span>Lives in <?=$aboutlistshow['place']?></p>
          <p><span><i class="icofont-ui-love"></i></span><?=$aboutlistshow['statuses']?></p>
        </div>
        <?php } else{?>
  <div class="text-center pt-2">
             <img src="assets/images/details.svg" width="95px">
             <p><?=$after?> has no details to show</p>
          </div>

        <?php }?>
      </div>


      </div>
    
       

      <div class="col-lg-6">
        <div class="timeline">
          <!-- <div class="createPost">
            <form action="" method="post" enctype="multipart/form-data">
              <textarea name="postText"></textarea>
              <button class="postBtn" type="submit" name="submit"><i class="icofont-location-arrow"></i></button>
              <div class="attachBtn">
                <i class="icofont-attachment"></i>
                <input id="fileupload" type="file" name="files[]"  multiple="multiple">
              </div>
              <div style="clear:both"></div>
              <div id="dvPreview"></div>
            </form>
          </div> -->
        
          <div class="Postmedia marginpostmedia">
           <?php
            if(mysqli_num_rows($selectPosts) > 0)
          {
          foreach ($selectPosts as $key => $value) {

            $fileExplode = explode(',', $value['files']);
            
          ?>
            <div class="postMainBlock">
                <div class="postBlockHeader">
                  <div  class="media_profile">
                    <img src="upload/<?=$userdata['profile_picture']?>">
                  </div>
                  <div class="postInfo">
                    <h5><?=$userdata['name']?></h5>
                    <?php 
                   
                  
                      $feeling_id1=$value['feeling_id'];
                   $queryfeelingid= mysqli_query($host,"SELECT * FROM feeling WHERE feeling_id='$feeling_id1'");
                    foreach ($queryfeelingid as $key => $value4) {
                     ?>
                      <div class="activitydiv">is feeling<span><?=$value4['feeling']?>  <img src="assets/images/<?=$value4['emoji']?>"></span></div>
                    <?php 
                    }

                   ?>
                    <p class="status"><?=time_ago_in_php($value['date_time']);?></p>
                  </div>
                  <div class="clearfix"></div>
                </div>
                <div class="media_details">
                  <p>
                      <?=$value['caption']?>
                    </p>
                  <div  class="media_para">
                    <div id="gallery_<?=$value['id']?>"></div>
                  </div>
                </div>
                                <?php
                $selectlike= mysqli_query($host,"SELECT * FROM likepost WHERE post_id ='".$value['id']."'");?>
                <div class="likeshow">
                  
                  <ul>
                    <li class="lifirst">
                      <?php
                      if(mysqli_num_rows($selectlike)>0){
                       $i=0;
                       foreach ($selectlike as $key => $valuelike) { $i++;?>
                        
                     <?php } ?>
                      <b onmouseover="showlikeduser(<?=$value['id']?>)" onmouseout="hidelikeduser(<?=$value['id']?>)"><img src="assets/images/like.svg"><?=$i?>likes</b>
                   <?php }?>
                    </li>
                     <li class="commentnumber" onmouseover="showcommentuser(<?=$value['id']?>);" onmouseout="hidecommentuser(<?=$value['id']?>);">
                    <?php 
$valuepostid=$value['id'];
                     $sessionid=$_SESSION['uid'];

  $comment2=mysqli_query($host,"SELECT * FROM comment WHERE post_id='".$valuepostid."'");
  if(mysqli_num_rows($comment2)>0){
                   $k=0;    
 foreach ($comment2 as $key0 => $valuecomment1) {
$k++;
                    ?>
                   
                  <?php }?>
 <span class="commentnumspan_<?=$value['id']?>"><?=$k;?></span><span class="numcomment">comments</span>
               <?php }?>
               </li>
                    <li></li>
                  </ul>
                </div>
                 <div class="listusers listuser_<?=$value['id']?>" style="display:none;height:auto">
                  
                   <p>Likes</p>
                       <ul class="showusersul showusersul_<?=$value['id']?>">
                          <?php 
                      foreach ($selectlike as $key => $valueshow) {

                        $queryshow=mysqli_query($host,"SELECT id,name FROM users WHERE id='".$valueshow['uid']."'");
                        foreach ($queryshow as $key => $valueshowname) {
                         
                        
                        ?>
                          <li><?=$valueshowname['name']?></li>
                           <?php }}
                      ?>
                       </ul>
                     </div>
                     <div class="listuserscomment listusercomment_<?=$value['id']?>" style="display:none;height:auto">
                  <p>Comments</p>
                   
                       <ul class="showusersulcomment showusersulcomment_<?=$value['id']?>">
                          <?php 

$comment3=mysqli_query($host,"SELECT DISTINCT uid FROM comment WHERE post_id='".$valuepostid."'");
                     foreach ($comment3 as $key0 => $valuecomment1){

                        $queryshowusercomment=mysqli_query($host,"SELECT id,name FROM users WHERE id='".$valuecomment1['uid']."'");
                  
                       
                        foreach ($queryshowusercomment as $key => $valueshowcommentname) {
                        
                     
                        ?>

                          <li class="showusersulcommentli showusersulcommentli_<?=$value['id']?>" style="float: none;"><?=$valueshowcommentname['name']?></li>
                           <?php }}
                      
                      ?>
                       </ul>
                     </div>
                <div class="ulDiv">
                     <div style="width: 100%;height: 1px;background: #80808057;margin-top: 54px;"></div>

                  <div class="btn-group btnDiv">
                    <button type="button" class="" onclick="likepost(<?=$value['id']?>);">
                     <?php             
  $valuepostid=$value['id'];
                     $sessionid=$_SESSION['uid'];

  $query=mysqli_query($host,"SELECT * FROM likepost WHERE post_id='".$valuepostid."' AND uid='".$sessionid."'");
  if(mysqli_num_rows($query)>0){
                       foreach ($query as $key => $valuelike1) {
                         if($valuelike1['post_id']){
// echo $valuelike1['uid'];
// echo $valuelike1['post_id'];
// echo $value['POSTID'];
?>
                        
 <i class="icofont-like likebuttoni_<?=$value['id']?>" style="color:#4080ff;"></i><span class="likebuttonspan_<?=$value['id']?>" style="color:#4080ff;">Like</span>
<?php } }}  else{?>

 <i class="icofont-like likebuttoni_<?=$value['id']?>" style=""></i><span class="likebuttonspan_<?=$value['id']?>" style="">Like</span>
<?php }?>



                    </button>
                    <button type="button" class="" onclick="showcomment(<?=$value['id']?>);"><i class="icofont-comment"></i><span>Comment</span></button>
                    <button type="button" class=""><i class="icofont-share-alt"></i><span>Share</span></button>
                  </div>
                     <div style="width: 100%;height: 1px;background: #80808057;margin-top: -2px;"></div>

                                 <div class="comment comment_<?=$value['id']?>">
                <?php  $query1    = "SELECT * FROM users WHERE id='".$_SESSION['uid']."'";
$results1  = mysqli_query($host, $query1);
$userdata1 = mysqli_fetch_array($results1);?>
             <div class="ownimgdiv"><img src="upload/<?=$userdata1['profile_picture']?>"></div>   <div class="input-group">
    <input type="text" id="comment" class="form-control commenttext commenttext_<?=$value['id']?>" placeholder="Write a comment...." name="commentinput" style="margin-left: 47px;">

    <div class="input-group-append">
      <button class="postbutton" type="button" style="background: #f0f2f5;" onclick="postcomment(<?=$value['id']?>);">
       <i class="icofont-paper-plane"></i>
      </button>
    </div>
  </div>
 <?php $valuepostid=$value['id'];
                     $sessionid=$_SESSION['uid'];

  $comment1=mysqli_query($host,"SELECT * FROM comment WHERE post_id='".$valuepostid."'");
 foreach ($comment1 as $key0 => $valuecomment) {
 $queryshowcomment=mysqli_query($host,"SELECT name,profile_picture FROM users WHERE id='".$valuecomment['uid']."'");
                        foreach ($queryshowcomment as $key => $valuecommentname) {
  ?>
<div class="innercomment row">
  <div class="col-md-2"><img src="upload/<?=$valuecommentname['profile_picture']?>"  class="commentpropic"></div>
  <div class="col-md-10">
   <?php  if(($valuecomment['uid'])==($_SESSION['uid'])){?>
     <div> <button type="button" class="btndelete1 btndelete1_<?=$valuecomment['id']?>" style="background:transparent;" onclick="commentdelete(<?=$valuecomment['id']?>);">Delete</button></div>
   <?php }?>
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

?>
     <button type="button" class="btnlike btnlike_<?=$valuecomment['id']?>" style="background:transparent;color:#4080ff;" onclick="likecomment(<?=$valuecomment['id']?>)">Like</button>
                    
                      
<?php } }}  else{?>
 <button type="button" class="btnlike btnlike_<?=$valuecomment['id']?>" style="background:transparent;color:#fff;" onclick="likecomment(<?=$valuecomment['id']?>)">Like</button>
<?php }?>



              
  <button type="button" class="btnreply btnreply_<?=$valuecomment['id']?>" style="background:transparent;" 
    onclick="showreply(<?=$valuecomment['id']?>)">Reply</button>
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
<?php }
?>

<!--  <script type="text/javascript">
  
  $('.showusersulcommentli_'+<?=$value['id']?>).each(function(){
   
 // var itemname='<?=$valuereply2['name']?>';

    if ($(this).text()!='<?=$valuereply2['name']?>')
    {
       $('.showusersulcomment_'+<?=$value['id']?>).append('<li class="showusersulcommentli_<?=$value['id']?>"><?=$valuereply2['name']?></li>');

    }
// if (itemFound == true)
// {
 
// }
// else
// {  

// }

});
 
</script> -->



<?php

} $k=$k+$n;?>

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
 

  $('.showusersulcomment_'+<?=$value['id']?>).append('<li class="showusersulcommentli_<?=$value['id']?>"><?=$valueshowcommentname1['name']?><span class="replyspan">reply</span></li>');
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
                   
                       <ul class=" showuserslikecomment">
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
     $('.commentnumspan_<?=$value['id']?>').html(<?=$k?>);
   </script>
 


 

             <?php }}else{?>
               <div class="postMainBlock text-center pt-2">
             <img src="assets/images/empty.png" width="95px" style="padding-top: 36px;">
             <p><?=$after?> has no posts</p>
          </div>

             <?php }?>
          </div>
        </div>
      </div>
    <div class="col-lg-3 post">
      
      <div class="subpost">
        <h4><i class="icofont-image"></i> Photos</h4>
        <?php
         if(mysqli_num_rows($selectPosts) > 0)
          {
            foreach ($selectPosts as $key => $value) 
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
             } }else{?>
               <div class="text-center pt-2">
             <img src="assets/images/image.svg" width="95px">
             <p><?=$after?> has no images</p>
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
            <p><span class="mutualcount">No mutual friends</span></p>
            <?php
            if(mysqli_num_rows($selectFriendList) > 0)
      {
          foreach ($selectFriendList as $key => $value) {
            $uid=$_GET['uid'];
           if($value['id']!=$uid){
          
          ?>
<div class="row friendListDiv">

   
     <div class="col-md-3">
       <?php if($value['id']!=$_SESSION['uid']){
       
        ?>

      <a href="friendView.php?uid=<?=$value['id']?>"> <img src="upload/<?=$value['profile_picture']?>" class="friendlistImg"></a>
<?php } else{?>
   <a href="index.php"> <img src="upload/<?=$value['profile_picture']?>" class="friendlistImg"></a>
 <?php }?>
     </div>
     <div class="col-md-5">
       <p class="friendname1"><?=$value['name']?></p>
    <?php  
  
     foreach ($selectFriendListsub as $key => $value1) {
       
      if($value['id']!=$_SESSION['uid']){
      
       if($value1['id']==$value['id']){

         $k1++;
         ?>

       <p class="mutual">Mutual friend</p>
     <?php } } } ?>
     <script type="text/javascript">
  var count=<?=$k1?>;
  if(count>0){
  $('.mutualcount').html(count+" mutual friends");
}
</script>
     </div>
     <div class="col-md-4">
      <?php
    
      if($value['id']!=$_SESSION['uid']){?>

        <button class="friendbutton">Friend </button>
    <?php }?>
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


<div  class="tab-pane fade in" id="photos">
  <div class="container">
   <div class="col-lg-12 subpostPhoto">
        <h4><i class="icofont-image"></i> Photos</h4>
        <div class="innerPhotodiv">
        <?php
         if(mysqli_num_rows($selectPosts) > 0)
          {
            foreach ($selectPosts as $key => $value) 
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
             }} else{?>
               <div class="text-center pt-2">
             <img src="assets/images/image.svg" width="95px">
             <p><?=$after?> has no images</p>
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
<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>

<script  type="text/javascript" src="assets/js/images-grid.js"></script>
<script type="text/javascript">
 <?php
         foreach ($selectPosts as $key => $value) {
        ?>
        var images<?=$value['id']?> = [
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
          $('#gallery_<?=$value['id']?>').imagesGrid({images : images<?=$value['id']?>});
          <?php
          }
          ?>
          
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
function showreplylikeuser(replylikeidshow){
$('.listuserlikereply_'+replylikeidshow).show();

}
function hidereplylikeuser(replylikeidshow){
$('.listuserlikereply_'+replylikeidshow).hide();

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

        </script>