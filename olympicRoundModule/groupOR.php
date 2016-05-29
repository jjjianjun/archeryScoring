<?php
//include '../Connections/wifiAtt.php';
include '../generalFn/genericFn.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Group OR</title>
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
						data:{action:'countTeamAmount', range_Id:$(this).val()},
						type:'post', 
						success:function(response){
							if(response.teamAmount > 8 && response.teamAmount <= 16) {
								//$('#option64').css("display","");
								$('#slctTeamNo').find('option').remove();
								$('#slctTeamNo').append('<option value="16">1/16</option>');
								$('#slctTeamNo').append('<option value="8">1/8</option>');
							}
							else if(response.teamAmount <= 8) {
								//$('#slctTeamNo').find('#option64').css("display","none");
								$('#slctTeamNo').find('option').remove();
								$('#slctTeamNo').append('<option value="8">1/8</option>');
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
						$('#btnSubmitGroupOR').removeAttr('disabled');
					}
					else {
						$('#btnSubmitGroupOR').attr('disabled','disabled');
					}
				});				
			});		
		</script>
    </head>
    <body>
        <form class="form-horizontal" name="frmGroupOR" method="post" target="_blank" action="groupBracketProcess.php">
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
				<label for="slctTeamNo" class="col-sm-2 control-label">Bracket Size:</label>
				<div class="col-sm-6">
					<select class="form-control" id="slctTeamNo" name="slctTeamNo">
						<option value="16" style="display: <?php echo(($recordSetCategory[0]['archerAmount']<= 16 && $recordSetCategory[0]['archerAmount']> 8) ?"" :"none" ); ?>;">1/16</option>
						<option value="8" style="display: <?php echo(($recordSetCategory[0]['archerAmount']<= 16 && $recordSetCategory[0]['archerAmount']> 4) ?"" :"none" ); ?>;">1/8</option>
					</select>
				</div>
			</div>		
			<div class="form-group">
				<!--label for="slctArrowNo" class="col-sm-2 control-label">Arrow Quantity:</label>
				<div class="col-sm-6">
					<select class="form-control" id="slctArrowNo" name="slctArrowNo">
						<option value="12">12</option>
						<option value="6">6</option>
					</select>					
				</div-->
				<label for="txtBoxArrowNo" class="col-sm-2 control-label">Arrow Quantity:</label>
				<div class="col-sm-6">
					<input type="number" class="form-control" id="txtBoxArrowNo" name="txtBoxArrowNo" placeholder="" value="12">
				</div>
			</div>	
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-6">
					<button type="submit" class="btn btn-default" id="btnSubmitGroupOR" name="btnSubmitGroupOR">Generate Team Bracket</button>
				</div>
			</div>			
		<div class="form-group">
		</div>			
        </table>
        </form>
        
    </body>
</html>
