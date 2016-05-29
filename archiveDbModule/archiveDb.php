<?php
	include '../Connections/wifiAtt.php';
	include 'dumper.php';
	
	if(isset($_POST['btnArchiveDb'])) {
		$dbHost   = "localhost";
		$dbUser   = "root";
		$dbPassword    = "abc123";
		$dbName   = "archery_scoring_2015";
		$projectFolder = str_replace('\\', '/', __DIR__);
		$dumpFolder = $projectFolder."/mysqldump/";
		$dumpFile = $dbName . "_" . date("Y-m-d_H-i-s") . ".sql";

		$db_dumper = Shuttle_Dumper::create(array(
			'host' => $dbHost,
			'username' => $dbUser,
			'password' => $dbPassword,
			'db_name' => $dbName,
		));
		// dump the database to plain text file
		$db_dumper->dump($dumpFolder.$dumpFile);
		echo $dumpFolder;
		$dumpFileInfo = "File : <b>".$dumpFile."</b><br/>Saved in : <b>".$dumpFolder.$dumpFile."</b>";
	}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Dump & Archive Database</title>
        <link rel="stylesheet" href="../css/jquery-ui.css" />
        <link rel="stylesheet" href="../css/style_1.css" />		
		
		<!-- Bootstrap -->
		<link rel="stylesheet" href="../css/bootstrap.min.css">
				
		<!-- Scroll Bar -->
		<link rel="stylesheet" href="../css/scrollBar.css" />
		
        <script type="text/javascript" src="../js/jquery-1.9.1.min.js" ></script>
        <script type="text/javascript" src="../js/jquery-ui.js" ></script>
		<script>

			$(document).ready(function(){ 
/* 				$('#btnArchiveDb').on('click', function() {
					//alert( this.value ); 
					$.ajax({ 
						url:'../generalFn/genericFn.php',
						dataType: "json",
						cache: false,
						data:{action:'countArcherAmount', range_Id:$(this).val()},
						type:'post', 
						success:function(response){
						},
						fail:function(){
							
						}
					});
				}); */
				
				var warningMessage = "Once the button is clicked, all the data rows of all tables will be permanently deleted and this operation cannot be redo. However, database is archived before the database is dumped.";
				$('#spanWarning').html(warningMessage);
			});
		</script>
    </head>
    <body>
        <form class="form-horizontal" name="frmArchiveDb" method="post" target="" action="">
			<div class="form-group">
				<label for="spanWarning" class="col-sm-2 control-label">Warning:</label>
				<div class="col-sm-8">
					<span class="help-block" id="spanWarning" name="txtBoxWarning"></span>
				</div>
			</div>		
			<div class="form-group" id="form-group-archive-location" style="display: <?php echo (isset($_POST['btnArchiveDb']) ?"" :"none"); ?>;">
				<label for="txtArchiveLocation" class="col-sm-2 control-label">Archived File Info:</label>
				<div class="col-sm-8">
					<span class="help-block" id="txtArchiveLocation" name="txtArchiveLocation"><?php echo (isset($_POST['btnArchiveDb']) ?$dumpFileInfo :"none"); ?></span>
				</div>
			</div>				
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-6">
					<button type="submit" class="btn btn-danger" id="btnArchiveDb" name="btnArchiveDb">Archive & Clear Database!</button>
				</div>
			</div>
        </form>
        
    </body>
</html>
