<?php
$pagename = 'Home';
include('config.php');
if(!isset($_SESSION['uid']))
{
  header('location:signin.php');
}

$query    = "SELECT * FROM users WHERE id='".$_SESSION['uid']."'";
$results  = mysqli_query($host, $query);
$userdata = mysqli_fetch_array($results);

 $suggetionList = mysqli_query($host,"SELECT * FROM users WHERE id !='".$_SESSION['uid']."'");





 if(isset($_POST['submit'])){ 
      
     $uid       = $_SESSION['uid'];
     $caption   = $_POST['postText'];
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

        $insert = mysqli_query($host,"INSERT INTO posts (uid, caption,files,date_time) VALUES ('".$uid."','".$caption."','".$allFiles."','".$date."')");
        if($insert)
        {
          $_SESSION['SET_TYPE'] = 'success';
          $_SESSION['SET_FLASH'] = 'Your post successfully done';
        }
        else
        {
          $_SESSION['SET_TYPE'] = 'error';
          $_SESSION['SET_FLASH'] = 'Unable to post';
        }
      } 
} 
$selectPosts = mysqli_query($host, "SELECT posts.id AS POSTID, posts.uid,posts.caption,posts.files,posts.date_time,users.id,users.profile_picture,users.cover_picture,users.name FROM posts LEFT JOIN users ON posts.uid = users.id WHERE 1 ORDER BY POSTID DESC");
$selectPosts1= mysqli_query($host, "SELECT * FROM posts WHERE uid ='".$_SESSION['uid']."' ORDER BY id DESC");



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


            
          
$selectFriendList = mysqli_query($host,"SELECT DISTINCT friendrequest.id , friendrequest.uid ,friendrequest.requestid,friendrequest.status,users.id,users.profile_picture,users.cover_picture,users.name FROM friendrequest LEFT JOIN users ON friendrequest.requestid = users.id WHERE friendrequest.uid = $uid AND friendrequest.status ='1'");


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
          foreach ($suggetionList as $key => $value) {
          ?>
          <div class="main">

            <div class="item  friendBox item1_<?=$value['id']?>"> <!-- item -->
              <img src="upload/<?=$value['profile_picture']?>">
              <p style="text-transform:uppercase;"><?=$value['name']?></p>
             
              <div class="btnGrp btnGrp1__<?=$value['id']?>">
                <button class="remove remove_<?=$value['id']?>" onclick="removeFriendevent(<?=$value['id']?>)">Remove</button>
<!--                <input name="fid" value="<?=$value['id']?>" type="hidden"></p> -->
                <button class="add add_<?=$value['id']?>"  name="addFriend"  onclick="addFriendevent(<?=$value['id']?>)">Add Friend</button>
                <button class="cancel cancel_<?=$value['id']?>"  name="cancelFriend"  onclick="cancelFriendevent(<?=$value['id']?>)" style="display:none;">Cancel Friend</button>
               
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
  <?php 
 
}?>
  </div>

</div>

<div class="friendList">
  <p class="headingFriend">Friends <span><i class="icofont-users-alt-4"></i></span></p>
  <div class="innerdivfriend">
   <?php
          foreach ($selectFriendList as $key => $value) {
            
          ?>
          <div class="row">
          <p class="friendlistName col-lg-7"><?=$value['name']?></p>
  <img src="upload/<?=$value['profile_picture']?>" class="friendlistIcon col-lg-5">
   </div>

  <?php 
 
}?>
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
                    <img src="upload/<?=$value['profile_picture']?>">
                  </div>
                  <div class="postInfo">
                    <h5><?=$value['name']?></h5>
                    <p class="status"><?=$value['date_time']?></p>
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
       <button class="friendbutton"><i class="icofont-verification-check"></i> Friend </button>
     </div>
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
             } ?>
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
         
          
           $('.remove').css("font-size","11px");
           $('.remove').css("width","37%");
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
      $(document).ready(function(){
  $(".nav-tabs a").click(function(){
    $(this).tab('show');
  });
 
});
      if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}
</script>