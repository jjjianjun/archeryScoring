<?php require_once('Connections/dbConnMysqli.php'); ?>
<?php
session_start();
if(isset($_SESSION['userID'])){ 
    
    $qStaf = "SELECT * FROM staff where staff_id = '$_SESSION[userID]'";
    $Staf = mysqli_query($wifiAtt,$qStaf) or die(mysqli_error());
    $row_qStaf = mysqli_fetch_assoc($Staf);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	<title>Archery Scoring System</title>
	<link rel="shortcut icon" type="image/png" href="images/favicon.png">
	
		
	<!--  <script type="text/javascript" src="js/jquery-ui.js" />-->
	<link rel="stylesheet" type="text/css" href="css/style_1.css" />
	
	<!-- Menu -->
	<link rel="stylesheet" href="./css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="css/nav.css" />
	<script src="js/jquery-2.2.1.min.js" type="text/javascript"></script>
	<script src="js/bootstrap.min.js"></script>

	<script>
		function showPageTitle(title) {
			document.getElementById("pageTitle").innerHTML = title;
		}
	</script>
	<!-- Scroll Bar -->
	<link rel="stylesheet" href="css/scrollBar.css" />
<style>
div.formrow {background:#ffc;border:2px solid #ffc;margin:0 0 5px 0;float:left;width:100%;padding:6px 0;}
div.formrow label {float:left;display:block;width:15em;font-weight:bold;padding:0 6px;}
div.formrow label:hover {background:#FFFF66;cursor:pointer;}
div.formrow fieldset {border:1px solid gray;margin:0 6px;}
div.formrow fieldset span {display:block;}
div.formrow fieldset span label {float:none;display:inline;}
div.formrow fieldset legend {font-weight:bold;}
div.requiredRow {border:2px solid #049;}
</style>


<style type="text/css">

.top {
margin-bottom: 15px;
}
.buttondiv {
margin-top: 10px;
}
.messagebox{
	position:absolute;
	width:100px;
	margin-left:30px;
	border:1px solid #c93;
	font-size:12px;
	background:#ffc;
	padding:3px;
}
.messageboxok{
	position:absolute;
	width:auto;
	margin-left:30px;
	border:1px solid #349534;
	background:#C9FFCA;
	padding:3px;
	font-weight:bold;
	font-size:12px;
	color:#008000;
	
}
.messageboxerror{
	position:absolute;
	width:auto;
	margin-left:30px;
	border:1px solid #CC0000;
	background:#F7CBCA;
	padding:3px;
	font-weight:bold;
	font-size:12px;
	color:#CC0000;
}
.table-striped > tbody > tr:nth-child(even) > td, .table-striped > tbody > tr:nth-child(2n+1) > th {
	background-color: #e3f2fd;
}
</style>
    
   
 <style>
 #container {
  position: relative;
}
 </style>   
    
<style>
		body {
	margin:0;
	padding:0;
	text-align:right;
	font-family: Arial, Helvetica, sans-serif;
		}

		.panels{
	z-index:90;
	position:absolute;
	top:-9px;
	left:-8px;
	padding:15px 15px 7px 15px;
	filter:alpha(opacity=90);
	-moz-opacity:0.9;
	-khtml-opacity: 0.9;
	opacity: 0.9;
		}

		.panels .main{
			float:left;
			width:200px;
			height:50px;
			background:#FFFFFF;
			border:1px solid #000000;
			border-bottom:0;
			padding:5px;
		}

		.panels .last{
			border:1px solid #000000;
		}

		.panels div{
			z-index:91;
		}

		.panels img{
			float:left;
			border:0px solid #000;
			margin-right:10px;
		}

		.panels div h2{
			padding:0px 6px 6px 6px;
			font-size:12px;
			color:#666666;
			letter-spacing:-1px;
			width:120px;
			float:left;
		}

		.panels div.sub_panel{
			clear:both;
			float:left;
		}

		.panels:hover,
		div.main:hover,
		span:hover{
			cursor:pointer;
		}

		.panels span{
			display:none;
			float:left;
			position:relative;
			right:170px;
			border:2px solid #FFFF00;
		    background-color:#000000;
			color:#FFFF00;
			z-index:99;
			width: 400px;
			height: 100px;
		}

		.panels .main:hover span{
			display:block;
		}

		.panels span img{
			margin:10px;
			border:0px solid #333;
			float:left;
		}

	v	.panels span p2{
			margin:0 0px 0px 0px;
			color:#FF0000;
			width:360px;
			float:right;
			font-size:11px;
			line-height:1.4em;
			letter-spacing:0.0em;
			
		}

		.panels div h3{
			padding:0px;
			font-size:22px;
			color:#FFCC00;
			font-weight:normal;
			letter-spacing:0px;
			float:left;
			margin-top:0px;
		}


	.style1 {
	font-size: 12px;
	font-weight: bold;
}
.style10 {font-size: 14px}
.style11 {font-size: 12px}
.style12 {color: #000000}
</style>
</head>

  <body  background="" style="text-align:left;">
  <div class="container">
  <div class="col-md-12">
	<a href="#"><img class="img-responsive img-rounded" src="images/bannerAchery_1100px.jpg" alt="Home | Archery Scoring System" width="1100" height="160" /></a>
  </div>
  <!--div class="container" style=""-->
    <!--td width="200" align="left" valign="top"-->
	<div class="col-md-4" style="width:19%; max-width:19%;">
    <!--div class="container" align="left" style=""-->   
		<nav class="navbar navbar-default sidebar" role="navigation">
			<div class="container-fluid">
			<div class="navbar-header">
			  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-sidebar-navbar-collapse-1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			  </button>      
			</div>
			<div class="collapse navbar-collapse" id="bs-sidebar-navbar-collapse-1">
			  <ul class="nav navbar-nav">
				<li class="active" onclick="showPageTitle('Home')"><a href="index3.php">Home<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-home"></span></a></li>
				<li class="dropdown">
				  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Configure Match <span class="caret"></span><span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-user"></span></a>
				  <ul class="dropdown-menu forAnimate" role="menu">
					<li onclick="showPageTitle('Add/Delete Team & Bow Category')"><a href="playerMaintenanceModule/ListAddTeam.php" target="content">Add/Delete Team &<br/>Bow Category</a></li>
					<li onclick="showPageTitle('Add/Edit/Delete Player')"><a href="playerMaintenanceModule/ListNAddPlayer.php" target="content">Add/Edit/Delete Player</a></li>
					<li onclick="showPageTitle('Add/Delete Range')"><a href="rangeConfigModule/rangeConfig.php" target="content">Add/Delete Range</a></li>
				  </ul>
				</li>       
				<li class="dropdown">
				  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Scoring <span class="caret"></span><span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-list-alt"></span></a>
				  <ul class="dropdown-menu forAnimate" role="menu">
					<li onclick="showPageTitle('Add Score')"><a href="scoringModule/addScore.php" target="content">Add Score</a></li>
					<li onclick="showPageTitle('Individual Score Report')"><a href="reportModule/viewScore.php" target="content">Indv. Score Report</a></li>
					<li onclick="showPageTitle('Team Score Report')"><a href="reportModule/teamRpt.php" target="_blank">Team Score Report</a></li>
				  </ul>
				</li>
				<li class="dropdown">
				  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Olympic Round <span class="caret"></span><span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-stats"></span></a>
				  <ul class="dropdown-menu forAnimate" role="menu">
					<li onclick="showPageTitle('Individual Olypmpic Round')"><a href="olympicRoundModule/individualOR.php" target="content">Individual OR</a></li>
					<li onclick="showPageTitle('Team Olympic Round')"><a href="olympicRoundModule/groupOR.php" target="content">Team OR</a></li>
				  </ul>
				</li>	
				<li style="display:none;" onclick="showPageTitle('Archive & Clear Database')"><a href="archiveDbModule/archiveDb.php" target="content">Archive & Clear Db<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-folder-close"></span></a></li> 				
				<li><a href="authenticationModule/logout.php">Logout<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-log-out"></span></a></li> 				
			  </ul>
			</div>
		  </div>
		</nav>
		<!--div class="col-md-4"-->
		<span class="label label-default">Login as [<?php echo $row_qStaf['staff_name'];?>]</span>
		<label for="basic-url" style="display:none;">Login as [<?php echo $row_qStaf['staff_name'];?>]</label>
		<!--/div-->
	<!--/div-->	
	
	<!--/td-->
	</div>
    <!--td width="780" height="432" align="center" valign="top"-->
	<div class="col-md-8" height="432" style="width:80%; max-width:80%;">
		<div class="panel panel-default">
		  <div class="panel-heading" id="pageTitle" style="height: 52px; text-align: left; font-weight: bold;">Archery Scoring System </div>
		  <div class="panel-body" style="padding:10px;">
			  <iframe name="content" src='' height="376" style="width:100%; max-width:99%" scrolling="yes" frameborder="0" > 
					Your browser does not support i-frame</iframe>
					<?php  // include ('stafIndex.php'); ?>
		  </div>
		</div>

<!--/td-->
  <!--tr>
	<td colspan="2"-->
	<div class="panel panel-default">
	  <div class="panel-footer" style="text-align:center;">COPYRIGHT mhariznaim@gmail.com @ 2014<br/>COPYRIGHT jjwong888@hotmail.com.tw @ 2016</div>
	</div>
	</div>
	<!--/td>
  </tr-->
<!--/table--> 
</div>
</body>
</html>
<?php  
	}  
	else {
		header("Location: index.php");
		die();
	}
?>