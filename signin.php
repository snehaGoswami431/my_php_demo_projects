<?php
$pagename = 'Signin';
include('config.php');
if(isset($_SESSION['uid']))
{
  header('location:index.php');
}

if (isset($_POST['login_user'])) {
  	$username = $_POST['username'];
  	$password = md5($_POST['password']);
	$query = "SELECT * FROM users WHERE email='".$username."' AND password='".$password."'";
	$results = mysqli_query($host, $query);
	$userdata =mysqli_fetch_array($results);
	 	// echo $results;
	if(mysqli_num_rows($results)>0) 
	{
	 	$_SESSION['uid'] = $userdata['id'];
     $_SESSION['SET_TYPE'] = 'success';
      $_SESSION['SET_FLASH'] = 'Login  successfully';
	 	header('location:index.php');
	}
	else 
	{
		  $_SESSION['SET_TYPE'] = 'error';
      $_SESSION['SET_FLASH'] = 'Unable to login';
	}
}
 

 if(!empty($_POST["remember"])) {
	setcookie ("username",$_POST["username"],time()+ 3600);
	setcookie ("password",$_POST["password"],time()+ 3600);
	
} else {
	setcookie("username","");
	setcookie("password","");
	
}
include('metakey_css.php');
// include('header.php');

?>
<div class="container">

  <div class="signindiv">
    <div class="lock"> <i class="icofont-lock"></i></div>
    <p class="heading">Sign into your account</p>
  <form class="needs-validation" method="POST" action=""  novalidate>
  <div class="form-group">
          <label for="username"><b>Username</b></label>
          <input type="text" placeholder="Enter Username" name="username" class="form-control inputBx" value="<?php if(isset($_COOKIE["username"])) { echo $_COOKIE["username"]; } ?>" required>
           <div class="valid-feedback">Valid.</div>
          <div class="invalid-feedback">Please fill out this field.</div>
    </div>
    <div class="form-group">
      <label for="password"><b>Password</b></label>
      <input type="password" placeholder="Enter Password" class="form-control inputBx" name="password"  value="<?php if(isset($_COOKIE["password"])) { echo $_COOKIE["password"]; } ?>"  required>
      <div class="valid-feedback">Valid.</div>
        <div class="invalid-feedback">Please fill out this field.</div>
     </div>   
      <button type="submit" class="submitButton" name="login_user">Login</button>
      <div class="checkboxportion">
      <label class="remember">
        <input type="checkbox"  name="remember"> Remember me
      </label>
       <span class="psw">Forgot <a href="javascript:void(0)" class="psw_a">password?</a></span>
      </div>
   <p class="Registerhere">Don't have an account? <a href="signup.php" class="psw_a">Register here</a></p>

   </form>
 </div>
    </div> 
      
<?php
include('metakey_js.php');
?>