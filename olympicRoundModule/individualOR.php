<?php
//include '../Connections/wifiAtt.php';
include '../generalFn/genericFn.php';
?>
<?php

  $stmtSelect = $db->prepare("SELECT COUNT(DISTINCT scoring.archer_no) AS archerAmount, category.categories, category.range, category.range_Id, category.shoot_qty from category
							INNER JOIN scoring ON scoring.range = category.range_Id
							GROUP BY scoring.range");

  $stmtSelect->execute();

  $row_RecordsetCat = $stmtSelect->fetchAll(PDO::FETCH_ASSOC);
  $cntRow = $stmtSelect -> rowCount();
  
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Individual OR</title>
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
				$('#slctCat').on('change', function() {
					//alert( this.value ); 
					$.ajax({ 
						url:'../generalFn/genericFn.php',
						dataType: "json",
						cache: false,
						data:{action:'countArcherAmount', range_Id:$(this).val()},
						type:'post', 
						success:function(response){
							if(response.archerAmount > 32 && response.archerAmount <= 64) {
								//$('#option64').css("display","");
								$('#slctIndvNo').find('option').remove();
								$('#slctIndvNo').append('<option value="64">1/64</option>');
								$('#slctIndvNo').append('<option value="32">1/32</option>');
							}
							else if(response.archerAmount <= 32) {
								//$('#slctIndvNo').find('#option64').css("display","none");
								$('#slctIndvNo').find('option').remove();
								$('#slctIndvNo').append('<option value="32">1/32</option>');
							}
						},
						fail:function(){
							alert("Fail to change number");
						}
					});
				});
				
				$('#txtBoxArrowNo').bind("propertychange change click keyup input paste", function(event){
					var elem = $(this);
					
					if(elem.val() > 0) {
						$('#btnSubmitIndividualOR').removeAttr('disabled');
					}
					else {
						$('#btnSubmitIndividualOR').attr('disabled','disabled');
					}
				});
			});
		</script>
    </head>
    <body>
        <form class="form-horizontal" name="frmIndividualOR" method="post" target="_blank" action="bracketProcess.php">
        <table>
			<div class="form-group">
				<label for="slctCat" class="col-sm-2 control-label">Category:</label>
				<div class="col-sm-6">
					<select class="form-control" id="slctCat" name="slctCat" >
						<?php $recordSetCategory=fnGetAllCategory(); foreach ($recordSetCategory as $rowCat) {   ?>
						<option value="<?php echo $rowCat['range_Id'] ?>"><?php echo $rowCat['range']."-".$rowCat['categories'] ?></option>   
						<?php  } ?>
					</select>
				</div>
			</div>	
			<div class="form-group">
				<label for="slctIndvNo" class="col-sm-2 control-label">Bracket Size:</label>
				<div class="col-sm-6">
					<select class="form-control" id="slctIndvNo" name="slctIndvNo">
						<!--option value="64">64</option>
						<option value="32">32</option>
						<option value="37">37</option-->
						<option id="option64" value="64" style="display: <?php echo(($recordSetCategory[0]['archerAmount']<= 64 && $recordSetCategory[0]['archerAmount']>32) ?"" :"none" ); ?>;">1/64</option>
						<option id="option32" value="32" style="display: <?php echo(($recordSetCategory[0]['archerAmount']<= 64 && $recordSetCategory[0]['archerAmount']>16) ?"" :"none" ); ?>;">1/32</option>
						<!--option value="37">1/37</option-->
					</select>
				</div>
			</div>				
			<div class="form-group">
				<label for="txtBoxArrowNo" class="col-sm-2 control-label">Arrow Quantity:</label>
				<div class="col-sm-6">
					<input type="number" class="form-control" id="txtBoxArrowNo" name="txtBoxArrowNo" placeholder="" value="12">
				</div>
			</div>		
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-6">
					<button type="submit" class="btn btn-default" id="btnSubmitIndividualOR" name="btnSubmitIndividualOR">Generate Individual Bracket</button>
				</div>
			</div>
		<div class="form-group">
		</div>			
        </table>
        </form>
        
    </body>
</html>
