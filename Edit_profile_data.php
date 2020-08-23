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

include('metakey_css.php');
include('header.php');

?>

      
<?php
include('metakey_js.php');
?>