<?php
$pagename = 'Signin';
include('config.php');
if(!isset($_SESSION['uid']))
{
  header('location:signin.php');
}
$query    = "SELECT * FROM users WHERE id='".$_SESSION['uid']."'";
$results  = mysqli_query($host, $query);
$userdata = mysqli_fetch_array($results);
$name = explode(' ',$userdata['name']);//form array from comma separated string elements
$language = explode(',',$userdata['language']);//remove comma and form array
$first_name = $name[0];
$last_name = $name[1];
$id        = $_SESSION['uid'];
if(isset($_POST['update']))
{
   $name                 = $_POST['first_name'].' '.$_POST['last_name'];
  $email                = $_POST['email'];
  $contact              = $_POST['contact'];
  $gender               = $_POST['gender'];
  $language             = implode(',', $_POST['language']);//form comma separated string elements from array

  if(isset($_POST['oldPassword']) =='')
  {
    $newPass     =$userdata['password'];
  }
  else
  {
   $newPass              =md5($_POST['newPassword']);
  }

  if($_FILES['profile_picture']['name'] !='')
  {
    $profile_picture      = $_FILES['profile_picture']['name'];
    $basename             = pathinfo($profile_picture, PATHINFO_BASENAME);
    $ext                  = pathinfo($profile_picture, PATHINFO_EXTENSION);
    $rand                 = rand(000,9999);
    $newName              = md5($basename).$rand.'.'.$ext;
    move_uploaded_file($_FILES['profile_picture']['tmp_name'], "upload/".$newName);
  }
  else
  {
    $newName              = $userdata['profile_picture'];
  }
  
  if($_FILES['cover_picture']['name'] !='')
  {
    $cover_picture      = $_FILES['cover_picture']['name'];
    $basename1             = pathinfo($cover_picture, PATHINFO_BASENAME);
    $ext1                  = pathinfo($cover_picture, PATHINFO_EXTENSION);
    $rand1                 = rand(000,9999);
    $newName1              = md5($basename1).$rand1.'.'.$ext1;
    move_uploaded_file($_FILES['cover_picture']['tmp_name'], "upload/".$newName1);
  }
  else
  {
    $newName1              = $userdata['cover_picture'];
  }
  
 
   $duplicateCheck = mysqli_query($host,"SELECT email FROM users WHERE email='".$email."'");

  if(mysqli_num_rows($duplicateCheck) > 1) 
  { 
      $_SESSION['SET_TYPE'] = 'error';
      $_SESSION['SET_FLASH'] = 'Email already used in another account'; 
  }
  else
  {
    $query = "UPDATE `users` SET `name`='$name',`email`='$email',`contact`='$contact',`password`='$newPass',`gender`='$gender',`language`='$language',`profile_picture`='$newName',`cover_picture`='$newName1' WHERE `id`='$id' ";
    $run = mysqli_query($host,$query);

    if($run)
    {
      $_SESSION['SET_TYPE'] = 'success';
      $_SESSION['SET_FLASH'] = 'Your acount has been Update successfully';
    }
    else
    {
      $_SESSION['SET_TYPE'] = 'error';
      $_SESSION['SET_FLASH'] = 'Unable to Update';
    }

  } 
}

$query    = "SELECT * FROM users WHERE id='".$_SESSION['uid']."'";
$results  = mysqli_query($host, $query);
$userdata = mysqli_fetch_array($results);
$name = explode(' ',$userdata['name']);//form array from comma separated string elements
$language = explode(',',$userdata['language']);//remove comma and form array
$first_name = $name[0];
$last_name = $name[1];
 
include('metakey_css.php');
include('header.php');

?>
<div class="container">
  <div class="editform ">
     <p class="heading">Update Your Profile</p>
  <form class="needs-validation form form-horizontal" method="POST" action="" novalidate enctype="multipart/form-data">
    <div class="form-group row">
        <label for="first_name" class="col-md-3 lbl"><b>First Name</b></label>
        <div class="col-md-8">
        <input type="text" placeholder="Enter first name" name="first_name" class="form-control" value="<?=$first_name;?>" required>
      </div>
        <div class="valid-feedback">Valid.</div>
        <div class="invalid-feedback">Please fill out this field.</div>
    </div>
    <div class="form-group row">
      <label for="last_name" class="col-md-3 lbl"><b>Last Name</b></label>
      <div class="col-md-8">
      <input type="text" placeholder="Enter Last name" name="last_name" value="<?=$last_name;?>" class="form-control" required>
    </div>
      <div class="valid-feedback">Valid.</div>
      <div class="invalid-feedback">Please fill out this field.</div>
    </div>
 
    <div class="form-group row">
      <label for="gender" class="col-md-3 lbl"><b>Gender</b></label>
      <div class="col-md-8 radiodiv">
      <input type="radio" name="gender" value="M" id="M" <?= $userdata['gender'] =='M'?'checked':'' ?> required=""> 
      <label for="m">Male</label>
      <input type="radio" name="gender" value="F" id="F" <?= $userdata['gender'] =='F'?'checked':'' ?> required="" > 
      <label for="f">Female</label>
    </div>
      <div class="valid-feedback">Valid.</div>
      <div class="invalid-feedback">Please check</div>
     </div>
  
     <div class="form-group row">
       <label for="email" class="col-md-3 lbl"><b>Email</b></label>
            <div class="col-md-8">
      <input type="email" placeholder="Enter email" name="email" class="form-control" value="<?php echo 
        $userdata['email'];?>"  onkeyup="checkEmail(this.value)" required>
      </div>
      <div class="valid-feedback">Valid.</div>
      <div class="invalid-feedback">Please fill out this field.</div>
       <p id="email-feedback"></p>
    </div>
    <div class="form-group row">
       <label for="password" class="col-md-3 lbl"><b>Old Password</b></label>
       <div class="col-md-8">
       <input type="text" placeholder="Enter your old password" name="oldPassword" class="form-control" onkeyup="checkPassword(this.value)">
        <p id="oldPassword-feedback"></p>
     </div>
      
    </div>
    <div class="form-group row" id="newPassword" style="display: none">
       <label for="password" class="col-md-3 lbl"><b>New Password</b></label>
       <div class="col-md-8">
      <input type="text" placeholder="New password" name="newPassword" class="form-control" id="">
    </div>
    </div>
      <div class="form-group row">
      <label for="phn" class="col-md-3 lbl"><b>Phone number</b></label>
         <div class="col-md-8">
      <input type="number" placeholder="Enter phone number" name="contact" class="form-control" value="<?php echo 
        $userdata['contact'];?>"  required>
      </div>
      <div class="valid-feedback">Valid.</div>
      <div class="invalid-feedback">Please fill out this field.</div>
     </div>
      <div class="form-group row">
          <label for="languages" class="col-md-3 lbl"><b>Known Languages</b></label>
          <div class="col-md-8">
              <div class="form-check">
                  <input type="checkbox" value="english" id="check1" <?=in_array("english", $language)?'checked':'' ?> name="language[]" class="form-check-input checkbox">
                   <label class="form-check-label" for="check1">English</label>
              </div>
               <div class="form-check">
                  <input type="checkbox" value="english1"  <?=in_array("english1", $language)?'checked':'' ?> id="check2" name="language[]" class="form-check-input checkbox">
                 <label class="form-check-label" for="check2">English1</label>
             </div>
             <div class="form-check">
                <input type="checkbox" value="english2" id="check3"  <?=in_array("english2", $language)?'checked':'' ?> name="language[]" class="form-check-input checkbox">
                <label class="form-check-label" for="check3">English2</label>
                
            </div>
          </div>
             
                <!--  <span id="spnError" class="error" style="display: none;color:#dc3545;font-size:13px;">Please select at-least one. </span>
                  <span id="spnRight" class="error" style="display: none;color:#28a768;font-size:13px;">Valid. </span>
       -->
         <div class="invalid-feedback">Please check this</div>
                <div class="valid-feedback">ok</div>
     </div>
     <div class="form-group row">
      <label for="avatar" class="col-md-3 lbl"><b>Choose a profile picture:</b></label>
      <div class="col-md-8">
       <input type="file" id="avatar" name="profile_picture" accept="image/png, image/jpeg, image/jpg" class="form-control">
     </div>
        <div class="invalid-feedback">Please choose</div>
        <div class="valid-feedback"> valid</div>
      </div>
      <div class="img-Div col-md-11">
      <img src="upload/<?=$userdata['profile_picture']?>" class="img-div">
    </div>

    <div class="form-group row coverDiv">
      <label for="avatar" class="col-md-3 lbl"><b>Choose a Cover picture:</b></label>
      <div class="col-md-8">
       <input type="file" id="avatar_cover" name="cover_picture" accept="image/png, image/jpeg, image/jpg" class="form-control">
     </div>
        <div class="invalid-feedback">Please choose</div>
        <div class="valid-feedback"> valid</div>
      </div>
      <div class="img-Div-cover col-md-11">
      <img src="upload/<?=$userdata['cover_picture']?>" class="img-div-cover">
    </div>
      <button type="submit" class="btnSubmit" name="update" onclick="return Validate()">Update</button>
 </form>
</div>
</div>    
<?php
include('metakey_js.php');
?>
<script type="text/javascript">
  function checkPassword(oldPassword)
  {
    $.ajax({
      type:'POST',
      url:'commonAjax.php',
      data:{oldPassword:oldPassword},
      success: function(data){
        if(data == '0')
        {
          $('#oldPassword-feedback').html('Password not matched');
          $('#newPassword').hide();
        }
        else
        {
          $('#oldPassword-feedback').html('Password matched');
          $('#newPassword').show();
        }
        
      },
      error: function(data){
        console.log(data);
      }
    })
  }
   function checkEmail(email)
  {
    $.ajax({
      type:'POST',
      url:'commonAjax.php',
      data:{email:email},
      success: function(data){
        if(data == '0')
        {
          $('#email-feedback').html('Email is ok');
        }
        else
        {
          $('#email-feedback').html('Email is already exists');
        }
        
      },
      error: function(data){
        console.log(data);
      }
    })
  }
</script>