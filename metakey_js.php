	<script  type="text/javascript" src="assets/js/jquery.min.js"></script>
	<script  type="text/javascript" src="assets/js/popper.min.js"></script>
	<script  type="text/javascript" src="assets/js/bootstrap.min1.js"></script>
	<script  type="text/javascript" src="assets/js/sweetalert2.min.js"></script>
    <script  type="text/javascript" src="assets/js/slick.min.js"></script>
    <script  type="text/javascript" src="assets/js/owl.carousel.js"></script>
<!--     <script  type="text/javascript" src="assets/js/magnific-popup.min.js"></script> -->
    <script  type="text/javascript" src="assets/js/magnific.min.js"></script>
    

 <!--  <script  type="text/javascript" src="assets/js/owl.carousel.min.js"></script> -->
    

	<script>
		$(document).ready(function() {
		$('.navbar-nav a').on('click', function() {
				$(' .navbar-nav').find('li.active').removeClass('active');
	            $(this).parent('li').addClass('active');
	        });
		$('#txtConfirmPassword').on('keyup', function () {
    if ($(this).val() == $('#txtPassword').val()) {
        $('#message').html('Password matched').css('color', 'green');
    } else $('#message').html('Password doesnot match').css('color', 'red');
});
         $(document).ready(function() {
  
});
});
        (function() {
		  'use strict';
		  window.addEventListener('load', function() {
		    // Fetch all the forms we want to apply custom Bootstrap validation styles to
		    var forms = document.getElementsByClassName('needs-validation');
		    // Loop over them and prevent submission
		    var validation = Array.prototype.filter.call(forms, function(form) {
		      form.addEventListener('submit', function(event) {

		        if (form.checkValidity() === false) {
		          event.preventDefault();
		          event.stopPropagation();
		        }
		        form.classList.add('was-validated');
		      }, false);
		    });
		  }, false);
		})();

		 function Validate() {
        var password = document.getElementById("txtPassword").value;
        var confirmPassword = document.getElementById("txtConfirmPassword").value;
        if (password != confirmPassword)
         {
			// document.getElementsByClassName("match").style.display="block";
            alert("doesn't match");
            return false;
        }
         // document.getElementsByClassName("match1").style.display="block";
        return true;
    }

    function showError(msg)
    {
        if(msg!='')
        {
            swal("Sorry!",msg, "error");
        }
    }
    function showCustomMessage(msg)
    {
        if(msg!='')
        {   
            swal("Done!",msg, "success");
        }
    }       
    function showSuccess(msg)
    {
        if(msg!='')
        {   
            swal("Done!",msg, "success");
        }
    }




	</script>
</body>
</html>
<?php 
    if(isset($_SESSION['SET_FLASH']))
    {
        if($_SESSION['SET_TYPE']=='success')
        {
            echo "<script type='text/javascript'>showSuccess('".$_SESSION['SET_FLASH']."');</script>";
        }
        else if($_SESSION['SET_TYPE']=='error')
        {
            echo "<script type='text/javascript'>showError('".$_SESSION['SET_FLASH']."');</script>";
        }
    }
    unset($_SESSION['SET_FLASH']);
    unset($_SESSION['SET_TYPE']);
?>