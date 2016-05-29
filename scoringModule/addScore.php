<?php
include '../Connections/wifiAtt.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
        <link rel="stylesheet" href="../css/jquery-ui.css" />
        <link rel="stylesheet" href="../css/style_1.css" />
		<link rel="stylesheet" href="../css/scrolLBar.css" />
        <script type="text/javascript" src="../js/jquery-1.9.1.min.js" ></script>
        <script type="text/javascript" src="../js/jquery-ui.js" ></script>
		
		<!-- Bootstrap -->
		<link rel="stylesheet" href="../css/bootstrap.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">
		<script src="../js/bootstrap.min.js"></script>
		<!-- jQuery.NumPad -->
		<script src="../jQuery.NumPad/jquery.numpad.js"></script>
		<link rel="stylesheet" href="../jQuery.NumPad/jquery.numpad.css">
    </head>
    <body style="overflow-x:hidden;">
        <script type="text/javascript">
            $(document).ready(function() {
							// These defaults will be applied to all NumPads within this document!
			$.fn.numpad.defaults.gridTpl = '<table class="table modal-content"></table>';
			$.fn.numpad.defaults.backgroundTpl = '<div class="modal-backdrop in"></div>';
			$.fn.numpad.defaults.displayTpl = '<input type="text" class="form-control" />';
			$.fn.numpad.defaults.buttonNumberTpl =  '<button type="button" class="btn btn-default"></button>';
			$.fn.numpad.defaults.buttonFunctionTpl = '<button type="button" class="btn" style="width: 100%;"></button>';
			$.fn.numpad.defaults.onKeypadCreate = function(){$(this).find('.done').addClass('btn-primary');};
//			$('.txtBoxMark').numpad();
				$(function (){
				 $('#txtBoxArcherNo').autocomplete({ 
					 source:"../generalFN/genericFn.php",
					 minLength:1
				 })   
				});
				
                $('#txtBoxArcherNo').blur(function(){
                    $("#frmAddScore").css("display","none");
                    $.ajax({
                        url:'../generalFN/genericFn.php',
                        dataType: "json",
                        cache: false,
                        data:{action:'getArcherInfo',archerNo:$('#txtBoxArcherNo').val()},
                        type:'post',
                        success:function(response){
                            $('#txtBoxArcherName').val(response.archerName);
                            $('#txtBoxGender').val(response.archerGender);
                            $('#txtBoxCat').val(response.archerCat);
                            $('#txtBoxTeam').val(response.archerTeam);
                            if(response.archerName == null || response.archerName == "")
                                $('#btnSubmit').attr('disabled','disabled');
                            else
                                {
                                $('#btnSubmit').removeAttr('disabled');
                                $('#slctCat').removeAttr('disabled');
                                }
                        }
                    });
                });
				
				// Convert score to 10 if the entered score is more than 10
				$('.txtBoxMark').bind("change paste keyup", function() {
					if($(this).val() > 10) {
						$(this).val(10);
					}
				});
            });
        </script>
       
<form class="form-horizontal" method="POST">
	<div class="form-group">
		<label for="txtBoxArcherNo" class="col-sm-2 control-label">Archer No:</label>
		<div class="col-sm-8">
			<input type="text" class="form-control" id="txtBoxArcherNo" name="txtBoxArcherNo" placeholder="" value="<?php echo ($_POST == null ? "" : $_POST['txtBoxArcherNo']) ?>">
		</div>
	</div>
	<div class="form-group">
		<label for="txtBoxArcherName" class="col-sm-2 control-label">Archer Name:</label>
		<div class="col-sm-8">
			<input type="text" class="form-control" id="txtBoxArcherName" name="txtBoxArcherName" placeholder="" readonly="true" value="<?php echo ($_POST == null ? "" : $_POST['txtBoxArcherName']) ?>">
		</div>
	</div>	
	<div class="form-group">
		<label for="txtBoxGender" class="col-sm-2 control-label">Gender:</label>
		<div class="col-sm-8">
			<input type="text" class="form-control" id="txtBoxGender" name="txtBoxGender" placeholder="" readonly="true" value="<?php echo ($_POST == null ? "" : $_POST['txtBoxGender']) ?>">
		</div>
	</div>
	<div class="form-group">
		<label for="txtBoxCat" class="col-sm-2 control-label">Category:</label>
		<div class="col-sm-8">
			<input type="text" class="form-control" id="txtBoxCat" name="txtBoxCat" placeholder="" readonly="true" value="<?php echo ($_POST == null ? "" : $_POST['txtBoxCat']) ?>">
		</div>
	</div>
	<div class="form-group">
		<label for="txtBoxTeam" class="col-sm-2 control-label">Team:</label>
		<div class="col-sm-8">
			<input type="text" class="form-control" id="txtBoxTeam" name="txtBoxTeam" placeholder="" readonly="true" value="<?php echo ($_POST == null ? "" : $_POST['txtBoxTeam']) ?>">
		</div>
	</div>
	
	<?php
		$stmtSelect = $db->prepare("SELECT * from category ");
		
		$stmtSelect->execute();

		$recordSetCategory = $stmtSelect->fetchAll(PDO::FETCH_ASSOC);
		$cntRow = $stmtSelect -> rowCount();
    ?>
	<div class="form-group">
		<label for="slctCat" class="col-sm-2 control-label">Range Category:</label>
		<div class="col-sm-8">
			<select class="form-control" id="slctCat" name="slctCat" <?php echo ( isset($_POST['btnSubmit'])? "disabled" : "") ?> >
				<?php foreach ($recordSetCategory as $rowCat) {   ?>
				<option value="<?php echo $rowCat['range_Id'] ?>" <?php if(isset($_POST['slctCat']))
					{  echo ($rowCat['range_Id']==$_POST['slctCat']? "selected":"") ; }   ?> >
						<?php echo $rowCat['range']."-".$rowCat['categories'] ?></option>   
				<?php  } ?>
			</select>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-6">
			<button type="submit" class="btn btn-default" id="btnSubmit" name="btnSubmit" style="padding: 6px 12px; font-size:14px;" disabled="disabled">Confirmed Category & Start Scoring!</button>
		</div>
	</div>	
</form>		
        <br> 
        <?php if(isset($_POST['btnSubmit'] )) 
        {
           $qrySelCat = "Select shoot_qty from category where range_Id = :range_Id "; 
           $fetchQry = $db->prepare($qrySelCat);
           $fetchQry->execute(array('range_Id'=>$_POST['slctCat']));
           $recordSet = $fetchQry->fetch();
           
           $cntArrow = $recordSet['shoot_qty'];
           $colForm = 6;
           $startCol = 1;
        ?>
    <form method="POST" action="addScoreProcess.php" id="frmAddScore" name="frmAddScore" class="form-horizontal">
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-8">
				<table class="table-bordered table-condensed" border="0" width="">
					<?php 
					$isNewData = 1;
					for($u=0;$u<=$cntArrow;) 
					{ 
						
					?>
					<tr style="background-color: #d3d3d3">
						<?php while($startCol <= $colForm)
							  { 
						?>
						<td>Arrow-<?php echo $startCol;  ?></td>
						<?php
								$startCol++;                  
							  } ?>
					</tr>
					<tr style="background-color: <?php echo ($startCol%2==2 ? "#999999" : "EEEEEE"); //#E9E5FD ?> ">
						<?php 
						$startCol -=6;
						while($startCol <= $colForm) 
							{ 
							$strTxtBoxName= "txtBoxMark-".$startCol;
							$currMark = fnGetExistingRangeMark($_POST['txtBoxArcherNo'], $startCol, $_POST['slctCat']);
							$isNewData = ($currMark == '' ? 1 : 0 );
						 ?>
						<td><input type="text" id="<?php echo $strTxtBoxName ?>" class="form-control txtBoxMark" name="<?php echo $strTxtBoxName ?>" value="<?php echo $currMark; ?>" maxLength="2"></td>
						<?php 
							  $startCol++;
							}
						
						?>
					</tr>
					<?php
					   $startCol = $colForm+1;
					   $colForm += 6;
					   $u = $colForm;
					 }               
					?>
					<tr><td colspan="6" align="center">
						<div class="col-sm-offset-2 col-sm-12" style="margin-left:0px;">
							<button type="submit" class="btn btn-default" id="btnSave" name="btnSave" value="Save" style="padding: 6px 12px; font-size:14px;">Save</button><?php echo $isNewData;  ?>
						</div>
						<input type="hidden" name="hidArchNo" id="hidArchNo" value="<?php echo strtoupper($_POST['txtBoxArcherNo']);  ?>">
						<input type="hidden" name="hidCatRange" id="hidCatRange" value="<?php echo $_POST['slctCat'];  ?>">
						<input type="hidden" name="hidCntArrow" id="hidCntArrow" value="<?php echo $cntArrow;  ?>">
						<input type="hidden" name="hidIsNewData" id="hidIsNewData" value="<?php echo $isNewData;  ?>">
						</td>
					</tr>
				</table> 
			</div>
		</div>
	</form>
        
       <?php }   ?>
        
        <?php 
           
        function fnGetExistingRangeMark ($archerNo,$nthArrow,$rangeId)
        {
            global $db;
            
            $qrySelCat = "select score,cntX,cntM from scoring WHERE archer_no = :archer_no and Nth_arrow = :Nth_arrow and `range` = :range "; 
            $fetchQry = $db->prepare($qrySelCat);
            $fetchQry->execute(array(':archer_no'=> $archerNo, ':Nth_arrow' =>$nthArrow , ':range' =>$rangeId));
            $recordSet = $fetchQry->fetch();
           
            $arrwMark = $recordSet['score'];
            
            if($arrwMark == null )
                $arrwMark = '';
            else if ($recordSet['cntX'] == 1)
                $arrwMark = 'X';
            else if ($recordSet['cntM'] == 1)
                $arrwMark = 'M';
            
            return $arrwMark;
        }
        
        ?>
    </body>
</html>
