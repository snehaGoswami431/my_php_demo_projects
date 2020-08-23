<?php
$pagename = 'Signup';
include('config.php');
if(isset($_SESSION['uid']))
{
  header('location:index.php');
}

if(isset($_POST['save']))
{
  $first_name           = $_POST['first_name'];
  $last_name            = $_POST['last_name'];
  $name                 = $_POST['first_name'].' '.$_POST['last_name'];
  $email                = $_POST['email'];
  $contact              = $_POST['contact'];
  $gender               = $_POST['gender'];
  $language             = implode(',', $_POST['language']);//form comma separated string elements from array
  $password             = md5($_POST['password1']);
  $profile_picture      = $_FILES['profile_picture']['name'];
  $basename             = pathinfo($profile_picture, PATHINFO_BASENAME);
  $ext                  = pathinfo($profile_picture, PATHINFO_EXTENSION);
  $rand                 = rand(000,9999);
  $newName              = md5($basename).$rand.'.'.$ext;
  $cover_picture      = $_FILES['cover_picture']['name'];
  $basename1             = pathinfo($cover_picture, PATHINFO_BASENAME);
  $ext1                  = pathinfo($cover_picture, PATHINFO_EXTENSION);
  $rand1                 = rand(000,9999);
  $newName1              = md5($basename1).$rand1.'.'.$ext1;
 
  $duplicateCheck = mysqli_query($host,"SELECT email FROM users WHERE email='".$email."'");

  if(mysqli_num_rows($duplicateCheck) > 0) 
  { 
     $_SESSION['SET_TYPE'] = 'error';
      $_SESSION['SET_FLASH'] = 'Email Id already exists.';
  }
  else
  {
    $insert = mysqli_query($host,'INSERT INTO users(name,email,contact,password,gender,language,profile_picture,cover_picture)VALUES("'.$name.'","'.$email.'","'.$contact.'","'.$password .'","'.$gender.'","'.$language.'","'.$newName.'","'.$newName1.'")');
    if($insert)
    {
      move_uploaded_file($_FILES['profile_picture']['tmp_name'], "upload/".$newName);
      move_uploaded_file($_FILES['cover_picture']['tmp_name'], "upload/".$newName1);
      // echo 'Insert';
       $_SESSION['SET_TYPE'] = 'success';
      $_SESSION['SET_FLASH'] = 'Your acount has been created successfully';
    }
    else
    {
      $_SESSION['SET_TYPE'] = 'error';
      $_SESSION['SET_FLASH'] = 'Unable to create';
    }
  }       
  

}
include('metakey_css.php');
// include('header.php');
?>
<div class="container">

  <div class="signupdiv">
    <div class="lock"> <i class="icofont-lock"></i></div>
     <p class="heading">Create your account</p>
     <form class="needs-validation form" method="POST" action="" novalidate enctype="multipart/form-data" data-bv-feedbackicons-valid="glyphicon glyphicon-ok"
    data-bv-feedbackicons-invalid="glyphicon glyphicon-remove"
    data-bv-feedbackicons-validating="glyphicon glyphicon-refresh">
    <div class="form-group">
        <label for="first_name"><b>First Name</b></label>
        <input type="text" placeholder="Enter first name" name="first_name" class="form-control inputBx" required>
        <div class="valid-feedback">Valid.</div>
        <div class="invalid-feedback">Please fill out this field.</div>

    </div>
    <div class="form-group">
      <label for="last_name"><b>Last Name</b></label>
      <input type="text" placeholder="Enter Last name" name="last_name" class="form-control inputBx" required>
      <div class="valid-feedback">Valid.</div>
      <div class="invalid-feedback">Please fill out this field.</div>
    </div>
 
    <div class="form-group">
      <label for="gender"><b>Gender</b></label>
      <input type="radio" name="gender" value="M" class="inputBx" id="M" required=""> 
      <label for="m" style="font-size:13px;color:black;">Male</label>
      <input type="radio" name="gender" value="F" id="F" class="inputBx" required="" > 
      <label for="f"  style="font-size:13px;color:black;">Female</label>
      <div class="valid-feedback">Valid.</div>
      <div class="invalid-feedback">Please check</div>
     </div>
  
     <div class="form-group">
       <label for="email"><b>Email</b></label>
      <input type="email" placeholder="Enter email" name="email" class="form-control inputBx"  onkeyup="checkEmail1(this.value)" required>
      <div class="valid-feedback">Valid.</div>
      <div class="invalid-feedback">Please fill out this field.</div>
       <p id="email-feedback1"></p>
    </div>
    <div class="form-group">
       <label for="password"><b>Password</b></label>
      <input type="text" placeholder="Enter password" name="password" class="form-control inputBx" id="txtPassword" required>
      <div class="valid-feedback">Valid.</div>
      <div class="invalid-feedback">Please fill out this field.</div>
    </div>
    <div class="form-group">
       <label for="password1"><b>Confirm Password</b></label>
      <input type="text" placeholder="Re-enter password" name="password1" class="form-control inputBx" id="txtConfirmPassword" required>
     <span id='message'></span>
      
    </div>
      <div class="form-group">
      <label for="phn"><b>Phone number</b></label>
      <input type="number" placeholder="Enter phone number" name="contact" class="form-control inputBx" required>
      <div class="valid-feedback">Valid.</div>
      <div class="invalid-feedback">Please fill out this field.</div>
     </div>
      <div class="form-group">
          <label for="languages"><b>Known Languages</b></label>
              <div class="form-check">
                  <input type="checkbox" value="english" id="check1" name="language[]" class="form-check-input checkbox inputBx "data-bv-choice="true"
                        data-bv-choice-min="1"
                        data-bv-choice-max="3"
                        data-bv-choice-message="Please choose atleast one" >
                   <label class="form-check-label" for="check1"  style="font-size:13px;color:black;">English</label>
              </div>
               <div class="form-check">
                  <input type="checkbox" value="english1" id="check2" name="language[]" class="form-check-input checkbox inputBx">
                 <label class="form-check-label" for="check2"  style="font-size:13px;color:black;">English1</label>
             </div>
             <div class="form-check">
                <input type="checkbox" value="english2" id="check3" name="language[]" class="form-check-input checkbox inputBx" >
                <label class="form-check-label" for="check3"  style="font-size:13px;color:black;">English2</label>
                
            </div>
             
                <!--  <span id="spnError" class="error" style="display: none;color:#dc3545;font-size:13px;">Please select at-least one. </span>
                  <span id="spnRight" class="error" style="display: none;color:#28a768;font-size:13px;">Valid. </span>
       -->
         <div class="invalid-feedback">Please check this</div>
                <div class="valid-feedback">ok</div>
     </div>
     <div class="form-group">
      <label for="avatar"><b>Choose a profile picture:</b></label>
       <input type="file" id="avatar" name="profile_picture" accept="image/png, image/jpeg, image/jpg" class="form-control inputBx" required>
        <div class="invalid-feedback">Please choose</div>
        <div class="valid-feedback"> valid</div>
      </div>
       <div class="form-group">
      <label for="avatar"><b>Choose a cover picture:</b></label>
       <input type="file" id="avatar1" name="cover_picture" accept="image/png, image/jpeg, image/jpg" class="form-control inputBx" required>
        <div class="invalid-feedback">Please choose</div>
        <div class="valid-feedback"> valid</div>
      </div>
      <button type="submit" class="btnSubmit" name="save" onclick="return Validate()">Sign Up</button>
      <p class="Registerhere">Already have  an account? <a href="signin.php" class="psw_a">Login here</a></p>
 </form>
</div>

</div>
<script type="text/javascript">
     function checkEmail1(email)
  {
   
    $.ajax({
      type:'POST',
      url:'commonAjax.php',
      data:{email:email},
      success: function(data){
        if(data == '0')
        {
          $('#email-feedback1').html('Email is ok');
        }
        else
        {
          $('#email-feedback1').html('Email is already exists');
        }
        
      },
      error: function(data){
        console.log(data);
      }
    })
  }
  $(document).ready(function() {
   $('.form').submit(function() {
    alert("submit");
        amIChecked = false;
        $('input[type="checkbox"]').each(function() {
            if (this.checked) {
                amIChecked = true;
            }
        });
        if (amIChecked) {
            alert('atleast one box is checked');
        }
        else {
            alert('please check one checkbox!');
        }
        return false;
    });
 });

$(document).ready(function() {
    $('.form').bootstrapValidator({
      alert("dff");
    });
});
</script>
<?php
include('metakey_js.php');
?>