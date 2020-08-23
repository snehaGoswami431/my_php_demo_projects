 <nav class="navbar  navbar-expand-lg navbar-fixed-top navbar-right stickAbsolute my-0 py-2 my-md-0 nav-icon" id="myScrollspy">
           
    <button class="navbar-toggler " type="button" data-toggle="collapse" data-target="#navbarsExample03" aria-controls="navbarsExample03" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon spanIcon"><i class="fas fa-bars "></i></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarsExample03">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          
         <!--  <form action="/action_page.php">
            <div class="container">
            <div class="row">
      <input type="text" placeholder="Search.." name="search" class="col-md-10 searchfriend">
      <button class="searchbutton col-md-2" type="submit"><i class="icofont-search"></i></button>
    </div>
  </div>
    </form> -->
     <div class="input-group">
    <input type="text" class="form-control searchtext" placeholder="Search....">
    <div class="input-group-append">
      <button class="btn btn-secondary searchbutton" type="button">
        <i class="icofont-search"></i>
      </button>
    </div>
  </div>
  
        </li>
      </ul>
       <ul class="navbar-nav ml-auto ul1">
          <li class="nav-item <?= $pagename == 'Home'?'active':''?> py-0">
           <?php
          if(isset($_SESSION['uid']))
          {
            $query1    = "SELECT * FROM users WHERE id='".$_SESSION['uid']."'";
$results1  = mysqli_query($host, $query1);
$userdata1 = mysqli_fetch_array($results1);

            ?>
             <a class="nav-link nav-link-ltr " href="index.php"><img src="upload/<?=$userdata1['profile_picture']?>" class="nav-img"></a>
          
         
          </li>
          <li><p class="navp"> <a class="index.php" href="index.php"><?=$userdata1['name']?></a></p></li>
           <?php }?>
         <!--  <?php
          if(!isset($_SESSION['uid']))
          {
          ?> -->
        <!--   <li class="nav-item <?= $pagename == 'Signin'?'active':''?>"><a class="nav-link nav-link-ltr " href="signin.php">Sign In</a></li> -->
          <!-- <li class="nav-item active">
             <a class="nav-link " href="#services">Services </a>
             </li> -->
          <!-- <li class="nav-item <?= $pagename == 'Signup'?'active':''?>">
             <a class="nav-link nav-link-ltr " href="signup.php">Sign Up</a>
          </li> -->
         <!--  <?php } else {?> -->
         <!--  <li class="nav-item">
             <a class="nav-link nav-link-ltr py-0" href="logout.php">Logout</a>
          </li> -->
          <!--  <li class="nav-item">
             <a class="nav-link nav-link-ltr " href="Edit_profile.php">Edit Profile</a>
          </li> -->
       <!--    <?php }?> -->
           <li class="nav-item">
             <a class="nav-link nav-link-ltr logout_i" href="logout.php"><i class="icofont-logout"></i>Logout</a><!--href="#home"-->
          </li>
       </ul>

    
    </div>
 </nav>
 <?php
include('metakey_js.php');
?>