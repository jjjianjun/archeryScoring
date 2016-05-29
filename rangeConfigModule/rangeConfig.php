<?php
include '../Connections/wifiAtt.php';
?>
<?php
//  $hostname_wifiAtt = "localhost";
//  $database_wifiAtt = "archery_scoring";
//  $username_wifiAtt = "root";
//  $password_wifiAtt = "";
//  $db = new PDO("mysql:host=$hostname_wifiAtt;dbname=archery_scoring", $username_wifiAtt, $password_wifiAtt);
  if(isset($_GET['action']))
  {
      if($_GET['action']=='Delete')
      {
          $stmt = $db->prepare("delete from category where range_Id = :range_id ");
          $stmt->execute(array(':range_id' => $_GET['pk']));
      }
  }
  
  if(isset($_POST['btnSubmit']))
      {
        try{
          
          $stmt = $db->prepare("INSERT into category (categories,`range`,shoot_qty ) VALUES (:categories,:range,:shoot_qty) ");

          $stmt->execute(array(':categories' => $_POST['slctCat'], ':range'=> $_POST['txtBoxRange'], ':shoot_qty'=> $_POST['txtBoxShootQty'] ));
          echo $stmt->rowCount().' were affected' ;
        }
        catch (Exception $ish)
        {
            echo 'Ada exception!:'.$ish->getMessage();
        }
      }
  
  $stmtSelect = $db->prepare("SELECT * from category ");

  $stmtSelect->execute();

  $row_RecordsetCat = $stmtSelect->fetchAll(PDO::FETCH_ASSOC);
  $cntRow = $stmtSelect -> rowCount();
  
    
      
      
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
        <link rel="stylesheet" href="../css/jquery-ui.css" />
        <link rel="stylesheet" href="../css/style_1.css" />		
		
		<!-- Bootstrap -->
		<link rel="stylesheet" href="../css/bootstrap.min.css">
		<style>
			.table-striped > tbody > tr:nth-child(even) > td, .table-striped > tbody > tr:nth-child(2n+1) > th {
				background-color: #e3f2fd;
			}
		</style>
		
        <script type="text/javascript" src="../js/jquery-1.9.1.min.js" ></script>
        <script type="text/javascript" src="../js/jquery-ui.js" ></script>
    </head>
    <body>
        <form class="form-horizontal" name="frmRangeConfig" method="post">
        <!--table-->
            <!--tr>
                <td>Range: </td>
                <td><div id="notification" name="notification"><input type="text" id="txtBoxRange" name="txtBoxRange"></div></td>
            </tr-->
			<div class="form-group">
				<label for="txtBoxRange" class="col-sm-2 control-label">Range:</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" id="txtBoxRange" name="txtBoxRange" placeholder="" value="">
				</div>
			</div>			
            <!--tr>
                <td>Category: </td>
                <td><select id="slctCat" name="slctCat" >
                        <?php 
                    $stmtSelect = $db->prepare("SELECT bow_category from bowcategories ");
                    $stmtSelect->execute();
                    $row_RecordsetBowCat = $stmtSelect->fetchAll(PDO::FETCH_ASSOC);
                    
                    foreach($row_RecordsetBowCat as $row)
                    {  ?>
                        <option value="<?php echo $row['bow_category'] ?>"><?php echo $row['bow_category'] ?></option>
                <?php    }
                ?>
                    </select>
                        
                </td>
            </tr-->
			<div class="form-group">
				<label for="slctCat" class="col-sm-2 control-label">Category:</label>
				<div class="col-sm-8">
					<select class="form-control" id="slctCat" name="slctCat" <?php echo ( isset($_POST['btnSubmit'])? "disabled" : "") ?> >
                        <?php 
							$stmtSelect = $db->prepare("SELECT bow_category FROM bowcategories");
							$stmtSelect->execute();
							$row_RecordsetBowCat = $stmtSelect->fetchAll(PDO::FETCH_ASSOC);
							
							foreach($row_RecordsetBowCat as $row)
							{  ?>
								<option value="<?php echo $row['bow_category'] ?>"><?php echo $row['bow_category'] ?></option>
						<?php    }
						?>
					</select>
				</div>
			</div>
			
            <!--tr>
                <td>Shooting Qty: </td>
                <td><input type="number" id="txtBoxShootQty" name="txtBoxShootQty"></td>
            </tr-->
			<div class="form-group">
				<label for="txtBoxShootQty" class="col-sm-2 control-label">Shooting Qty:</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" id="txtBoxShootQty" name="txtBoxShootQty" placeholder="" value="">
				</div>
			</div>			
            <!--tr>
                <td colspan="2"><input type="submit" id="btnSubmit" name="btnSubmit" ></td>
            </tr-->
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-6">
				<button type="submit" class="btn btn-default" id="btnSubmit" name="btnSubmit" style="padding: 6px 12px; font-size:14px;">Add Range Category</button>
			</div>
		</div>			
        <!--/table-->
        </form>
         <?php

            if($cntRow >0)
            {
        ?>
		<form class="form-horizontal">
			<div class="form-group">
			<div class="col-sm-offset-2 col-sm-6">
			<table class="table table-condensed table-bordered table-striped table-hover">
				<thead>
				<tr>
					<th>Range</th>
					<th>Category</th>
					<th colspan="1">Shooting Quantity</th>
					<th>Delete</th>
				</tr>
				</thead>
				<tbody>
				<?php
					$cnt = 1;
					foreach( $row_RecordsetCat as $rowCat )
					{  ?>
				<tr style="background-color:<?php //echo ($cnt%2==1 ? "#A1CCE4" : "#E9E5FD"); ?>">
					<td><?php echo $rowCat['range'];   ?></td>
					<td><?php echo $rowCat['categories']  ?></td>
					<td><?php echo $rowCat['shoot_qty']  ?></td>
					<td>
						<a href="rangeConfig.php?action=Delete&pk=<?php echo $rowCat['range_Id']  ?>">
							<span title="Remove Range: <?php echo $rowCat['range']." ".$rowCat['categories']; ?>" class="pull-right showopacity glyphicon glyphicon-trash"></span>
						</a>
					</td>
				</tr>    
						<?php
					  $cnt++;  
					}
				?>
			</tbody>
			</table>
			</div>
			</div>
		</form>
        <?php
            }
        ?>
        
    </body>
</html>
