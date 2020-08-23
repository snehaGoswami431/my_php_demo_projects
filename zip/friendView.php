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
$selectPosts= mysqli_query($host, "SELECT * FROM posts WHERE uid ='".$uid."'");
$selectFriendList = mysqli_query($host,"SELECT DISTINCT friendrequest.id , friendrequest.uid ,friendrequest.requestid,friendrequest.status,users.id,users.profile_picture,users.cover_picture,users.name FROM friendrequest LEFT JOIN users ON friendrequest.requestid = users.id WHERE friendrequest.uid = $uid AND friendrequest.status ='1'");
// foreach ($selectFriendList as $key => $value) {
// 	 $value1=$value['requestid'];
// 	// echo $value1;
// }



// foreach ($selectFriendListPrevious as $key => $value) {
// 	 $value2= $value['requestid'];
// 	if($value1==$value2)

// {
// 	$requestid1=$value1;
// 	echo $value1;
// }
// }


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

             <div class="friendsbuttondiv"><button><i class="icofont-verification-check"></i>Friends</button></div>
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
      	<div class="line"></div>
      	<div class="aboutDetails">
      		<p><span><i class="icofont-users-social"></i></span>Studied in <?=$aboutlistshow['school']?></p>
      		<p><span><i class="icofont-graduate"></i></span>Graduated from <?=$aboutlistshow['college']?></p>
      		<p><span><i class="icofont-home"></i></span>Lives in <?=$aboutlistshow['place']?></p>
      		<p><span><i class="icofont-ui-love"></i></span><?=$aboutlistshow['statuses']?></p>
      	</div>
      </div>


      </div>
      <div class="col-lg-6">
        <div class="timeline">
          <div class="createPost">
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
          </div>
        
          <div class="Postmedia">
           <?php
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
                    <p class="status"><?=$value['date_time']?></p>
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
                <div class="ulDiv">
                  <div class="btn-group btnDiv">
                    <button type="button" class=""><i class="icofont-like"></i><span>Like</span></button>
                    <button type="button" class=""><i class="icofont-comment"></i><span>Comment</span></button>
                    <button type="button" class=""><i class="icofont-share-alt"></i><span>Share</span></button>
                  </div>
                </div>
            </div>
             <?php }?>
          </div>
        </div>
      </div>
    <div class="col-lg-3 post">
      
      <div class="subpost">
        <h4><i class="icofont-image"></i> Photos</h4>
        <?php
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
             } ?>
     </div>
   </div>
    </div>
  </div>
</div>
<div  class="tab-pane fade in" id="friend">
  <div class="container">
   
         

          <div class="col-lg-12 friendInnerDiv">
            <p class="Para_friends">Friends <i class="icofont-users-alt-4"></i> </p>
            <?php
          foreach ($selectFriendList as $key => $value) {
            
          
          ?>
<div class="row friendListDiv">

   
     <div class="col-md-3">
      <a href="friendView.php?uid=<?=$value['requestid']?>"> <img src="upload/<?=$value['profile_picture']?>" class="friendlistImg"></a>
     </div>
     <div class="col-md-5">
       <p class="friendname1"><?=$value['name']?></p>
     </div>
     <div class="col-md-4">
     		<?php



     		 if($value['status']=='1'){?>
       <button class="friendbutton">

       	<i class="icofont-verification-check"></i>


       	 Friend </button><?php }
else{?>
	 <button class="friendbutton">

       	<i class="icofont-users-alt-4"></i>


       	Add Friend </button>
<?php }?>

     </div>
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
             } ?>
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
        </script>