<?php
include '../Connections/wifiAtt.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="../css/jquery-ui.css" />
        <link rel="stylesheet" href="../css/style_1.css" />
		<!-- Bootstrap -->
		<link rel="stylesheet" href="../css/bootstrap.min.css" />
		
        <script type="text/javascript" src="../js/jquery-1.9.1.min.js" ></script>
        <script type="text/javascript" src="../js/jquery-ui.js" ></script>
        
        <title></title>
    </head>
    <body>         
		<?php
		$stmtSelect = $db->prepare("SELECT * from category ");
		
		$stmtSelect->execute();

		$recordSetCategory = $stmtSelect->fetchAll(PDO::FETCH_ASSOC);
		$cntRow = $stmtSelect -> rowCount();
            
        ?>
		<form class="form-horizontal" method="POST" target="_blank" action="viewScoreProcess.php">
		<div class="form-group">
			<label for="slctCat" class="col-sm-2 control-label">Range Category:</label>
			<div class="col-sm-6">
				<select class="form-control" id="slctCat" name="slctCat" >
					<?php foreach ($recordSetCategory as $rowCat) {   ?>
					<option value="<?php echo $rowCat['range_Id'] ?>"><?php echo $rowCat['range']."-".$rowCat['categories'] ?></option>   
					<?php  } ?>
				</select>
			</div>		
			<div class="col-sm-2">
				<button type="submit" class="btn btn-default" id="btnSubmit" name="btnSubmit" style="padding: 6px 12px; font-size:14px;">View Score</button>
			</div>	
		</div>				
		</form>
        
		   
		<?php
		$stmtSelect = $db->prepare("SELECT distinct(player_bow_cat) as ListBowCat from players Order by ListBowCat");
		
		$stmtSelect->execute();

		$recordSetCategory = $stmtSelect->fetchAll(PDO::FETCH_ASSOC);
		?>		
		<form class="form-horizontal" method="POST" target="_blank" action="viewScoreProcessByCat.php" style="display:none;">
		<div class="form-group">
			<label for="slctCat" class="col-sm-2 control-label">Category:</label>
			<div class="col-sm-6">
				<select class="form-control" id="slctCat" name="slctCat" >                      
					<?php foreach ($recordSetCategory as $rowCat) {   ?>
					<option value="<?php echo $rowCat['ListBowCat'] ?>"><?php echo $rowCat['ListBowCat'] ?></option>   
					<?php  } ?>
				</select>
			</div>		
			<div class="col-sm-2">
				<button type="submit" class="btn btn-default" id="btnSubmit" name="btnSubmit" style="padding: 6px 12px; font-size:14px;" value="View Score"></button>
			</div>
		</div>	
		</form>
    
    </body>
</html>
