<?php
	session_start();
	if(isset($_SESSION['userID'])){ 
		header("Location: home.php");
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en-AU">
<head>
 <title>Archery Scoring System</title>
 <link rel="shortcut icon" type="image/png" href="images/favicon.png">
 <meta name="keywords" content="Sleek & Modern Login Form, sleek, modern, Web Resource, Where design has a new dimension, Freebies, Design3, Design3Edge, Sada, HTML, Photoshop, CSS, Web Resource, Vector, Design Elements, Tutorials, CoreDraw, Graphic Design,  web design,  design,  vector,  graphics,  brushes,  shapes,  backgrounds,  textures,  wallpapers,  tutorials,  web 2.0,  icons,  art,  icons,  illustrator, wordpress, clean, modern, web, internet, professional, Free templates, free themes, themes, templates, forms, business cards, corporate identity, web elements, visiting cards, wordpress themes, wordpress templates, posts, blogs, free elements, business templates, corporate templates, login forms, hosting, premium templates, wordpress plugins, Vcard themes, Vcard templates, hosting packages, menus, design elements, design resources" />
 
 <meta http-equiv="content-type" content="application/xhtml; charset=UTF-8" />
 <meta name="viewport" content="width=device-width, user-scalable=no" />
 <meta name="HandheldFriendly" content="true"/>  
 <meta name="MobileOptimized" content="width" />

<!-- Bootstrap -->
<link rel="stylesheet" href="./css/bootstrap.min.css"> 
 <link rel="stylesheet" type="text/css" href="./css/parallax-login-form.css" />
<!-- <link rel="stylesheet" type="text/css" media="screen" href="milk.css" />-->
<!--<link rel="stylesheet" type="text/css" media="screen" href="jquery.validate.password.css"/>-->

<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<!--<script type="text/javascript" src="js/"></script>
<script type="text/javascript" src="jquery.validate.password.js"></script>-->

<script id="demo" type="text/javascript">
$(document).ready(function() {
	// validate signup form on keyup and submit
		/* var validator = $("#signupform").validate({
		rules: {
			username: {
				required: true,
				minlength: 2
			},
			password: {
				password: "#username"
			},
			password_confirm: {
				required: true,
				equalTo: "#password"
			}
		},
		messages: {
			username: {
				required: "Enter a username",
				minlength: jQuery.format("Enter at least {0} characters")
			},
			password_confirm: {
				required: "Repeat your password",
				minlength: jQuery.format("Enter at least {0} characters"),
				equalTo: "Enter the same password as above"
			}
		},
		// the errorPlacement has to take the table layout into account
		errorPlacement: function(error, element) {
			error.prependTo( element.parent().next() );
		},
		// specifying a submitHandler prevents the default submit, good for the demo
		submitHandler: function() {
			alert("submitted!");
		},
		// set this class to error-labels to indicate valid fields
		success: function(label) {
			// set &nbsp; as text for IE
			label.html("&nbsp;").addClass("checked");
		}
	}); */ 
	
	// propose username by combining first- and lastname
	$("#username").focus(function() {
		var firstname = $("#firstname").val();
		var lastname = $("#lastname").val();
		if(firstname && lastname && !this.value) {
			this.value = firstname + "." + lastname;
		}
	});
        
        
	
});
$(function() {
    $('#username').click(function(){
        //alert('ggrrr');
    });
      
});
</script>


  <!--[if lt IE 8.]>
<link rel="stylesheet" type="text/css" href="css/style-ie.css" />
<![endif]-->
 <!--[if lt IE 7.]>
<link rel="stylesheet" type="text/css" href="css/style-ie6.css" />
<![endif]-->
</head>

<body>

<!-- Main Body Starts Here -->
<div id="main_body">
<?php //include('tryMacAddressForClient.php');  ?>

<!-- Form Starts Here -->
<div class="form_box">

<!--form id="loginform" name="loginform" method="post" action="processLogin.php"-->
<div align="center">Welcome, Your IP address is <?php echo $ipclient=$_SERVER['REMOTE_ADDR']; ?> </div>

	<div class="container">
		<div class="row vertical-offset-100">
			<div class="col-md-4 col-md-offset-4">
				<div class="panel panel-default">
					<div class="panel-heading">                                
						<div class="row-fluid user-row">
							<img src="./images/favicon.png" style="width:50%;" class="img-responsive" alt="Conxole Admin"/>
						</div>
					</div>
					<div class="panel-body">
						<form accept-charset="UTF-8" role="form" class="form-signin" id="loginform" name="loginform" method="post" action="authenticationModule/processLogin.php">
							<fieldset>
								<label class="panel-login">
									<div class="login_result" style="color: <?php echo (isset($_GET['error']) ? "red" : "") ?>"><?php echo (isset($_GET['error']) ? "Incorrect username or password." : "Hi from Archery Scoring System.") ?></div>
								</label>
								<input class="form-control" placeholder="Username" name="username" type="text">
								<input class="form-control" placeholder="Password" name="password" type="password">
								<label>Username:admin | Password:abc123</label>
								<br></br>
								<input title="login Now" class="btn btn-lg btn-primary btn-block" type="submit" name="login" id="login" value="Login »">
								<input type="hidden" name="Submit" id="Submit" />
							</fieldset>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
<!--/form-->

</div>
<!-- Form Ends Here -->

</div>
<!-- Main Body Ends Here -->

<!-- Copyright
<div style="text-align:right;margin:100px 20px 0px 0px;">
<a href="http://www.design3edge.com" ><img src="images/design3edge.png" alt="Design3Edge" title="Design3Edge" /></a>
</div>
 Copyright -->

 </body>
</html>