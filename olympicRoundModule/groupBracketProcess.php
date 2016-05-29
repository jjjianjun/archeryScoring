<?php
	include '../Connections/wifiAtt.php';
	//include 'bracketFunction.php';
?>

<?php
	if(isset($_POST['btnSubmitGroupOR'])) {
		$qrySelectCategoryInfo = "SELECT * FROM category WHERE range_Id = :range_Id";
		$stmtSelectCategoryInfo = $db->prepare($qrySelectCategoryInfo);
		$stmtSelectCategoryInfo->bindValue(':range_Id', $_POST['slctCat'], PDO::PARAM_STR);
		$stmtSelectCategoryInfo->execute();
		$recordSelectCategoryInfo = $stmtSelectCategoryInfo->fetch();		
		
		// Get total marks for a team
		$qryScore = "SELECT SUM(memberScore) AS totalTeamScore, players.team AS teamName FROM teamscores, players 
					WHERE teamscores.memberArcherNo = players.player_no and players.player_bow_cat = :player_bow_cat
					GROUP BY players.team
					ORDER BY totalTeamScore DESC
					LIMIT :teamNo";
		$stmtSelectTeam = $db->prepare($qryScore);
		$stmtSelectTeam->bindParam(':player_bow_cat', $recordSelectCategoryInfo['categories'], PDO::PARAM_STR);
		$stmtSelectTeam->bindValue(':teamNo', (int)$_POST['slctTeamNo'], PDO::PARAM_INT);
		//$stmtSelectTeam->execute(array(':player_bow_cat'=>$_POST['slctCat']));
		//$stmtSelectTeam->execute(array(':player_bow_cat'=>$_POST['slctCat'],':teamNo'=>$_POST['slctTeamNo']));
		$stmtSelectTeam->execute();
		
		$arrayTeam = array();
		for($row=0; $row<18; $row++) {
			$arrayTeam[$row] = array();
			$arrayTeam[$row]['teamName'] = "";
			$arrayTeam[$row]['totalTeamScore'] = 0;
		}
		
		$recordTeamScore = $stmtSelectTeam->fetchAll(PDO::FETCH_ASSOC); 
		$totalNoTeam = $stmtSelectTeam->rowCount();
		//echo $totalNoTeam;
		$index = 1;
		foreach ($recordTeamScore as $rowTeamScore) {
			$arrayTeam[$index]['teamName']= $rowTeamScore['teamName']; 
			$arrayTeam[$index]['totalTeamScore'] = $rowTeamScore['totalTeamScore'];
			$index++;
		}
		//$string=implode(",",$teamArray);
		//echo $string;
		//echo $_POST['slctTeamNo'].$_POST['slctCat'];
		//$cntRow = $stmtSelectTeam -> rowCount(); echo $cntRow;
		//$json = json_encode($recordTeamScore); echo $json;
	}
/* 	else if(isset($_POST['btnSubmitScoreOR'])) {
		
	} */
	else {
		echo "none";
		echo "<script>alert('Please use F5 and refresh button to refresh page.');</script>";
		header("Location: ../home.php");
		die();
	}
?>
<html>
<head>
	<title>Tournament Bracket</title>
	<link rel="shortcut icon" type="image/png" href="../images/favicon.png">	
	
	<!-- Scroll Bar -->
	<link rel="stylesheet" href="../css/scrollBar.css" />
	
	<link href="../css/bootstrap.min.css" rel="stylesheet">
	<!--link href="../css/jquery.bracket-world.css" rel="stylesheet">
	<link href="../css/bracket-index.css" rel="stylesheet">
	<link href="../css/jquerysctipttop.css" rel="stylesheet" type="text/css"-->
	<link href="../css/bracket.css" rel="stylesheet">
	
		
	<script src="../js/jquery-2.2.1.min.js"></script>
	<script src="../js/bootstrap.min.js"></script>
	<script src="../js/jquery.bracket-world.min.js"></script>	
	<script src="../js/html2canvas.js"></script>
	<script>
		
		var arrowNo = '<?php echo $_POST["txtBoxArrowNo"]; ?>';
		$(document).ready(function(){ 
			
			// To build Top 8
			var totalNoTeam = '<?php echo $totalNoTeam; ?>';
			if(totalNoTeam > 8 && totalNoTeam <= 16) {
				generateTop8();	
			}
			else if (totalNoTeam <= 8){
				generateTop4();
			}
			/* var teamA	= $('#top64 li.game-top').eq(1).html().indexOf('<span>');//css("color","yellow");
			var teamB = $('#top64 li.game-bottom').eq(1).html().indexOf('<span>'); //css("color","green");
			var filteredTeamA = $('#top64 li.game-top').eq(1).html().substring(0, teamA != -1 ? teamA : teamA.length);
			var filteredTeamB = $('#top64 li.game-bottom').eq(1).html().substring(0, teamB != -1 ? teamB : teamB.length);
			console.log(filteredTeamA+filteredTeamB);
			var winner = getTeamRoundWinner(filteredTeamA, filteredTeamB, '1/64', '1','#top32 li.game-bottom','0'); alert(winner); */
			//#bracketCSS > main > ul > li, #bracketCSS > main > ul > div > li
			var filteredTeamName;
			$(".game").click(function(event) {
				var clickedInnerhtml = $(this).html();
				var oriInnerHTML = clickedInnerhtml.indexOf('<span>');
				filteredTeamName = clickedInnerhtml.substring(0, oriInnerHTML != -1 ? oriInnerHTML : oriInnerHTML.length);
				//alert(filteredTeamName);
				var selectedRoundNum = $(this).closest('ul').attr('id');
				selectedRoundNum = '1/'+selectedRoundNum.replace('top','');		
				
				$('#modalAddScoreOR').modal('toggle'); 
				$('#isNewData').html("");
				
				$.ajax({ 
					url:'../olympicRoundModule/bracketFunction.php',
					dataType: "json",
					cache: false,
					data:{action:'getORTeamInfo', teamName:filteredTeamName.trim(), selectedRoundNum:selectedRoundNum, range_Id:$('#slctCat').val(), arrowNo:arrowNo},
					type:'post',
					success:function(response){	//alert(response.archerScoreOR);
						$('#txtBoxTeamName').val(filteredTeamName);
						$('#slctRoundNo').val(selectedRoundNum);
						$('#isNewData').html(""); //alert(response.teamMembers[1].player_no);
						for($index=0; $index<arrowNo; $index++) {
							$strTxtBoxName= "txtBoxMark-"+($index+1);
							$('#'+$strTxtBoxName).val(response.teamScoreOR[$index]);
						}
						if(filteredTeamName == "" || filteredTeamName == null || filteredTeamName == "No winner" || selectedRoundNum == "1/3rdPlace") {
							$('#btnSubmitScoreOR').attr('disabled','disabled');
							$('input').attr('disabled','disabled');
						}
						else {
							$('#btnSubmitScoreOR').removeAttr('disabled');
							$('input').removeAttr('disabled'); 
							$archerList = "<ol>";
							for($teamMembersIndex=0; $teamMembersIndex<response.teamMembers.length; $teamMembersIndex++) {
								//$archerList += "Archer "+($teamMembersIndex+1)+": "+response.teamMembers[$teamMembersIndex].player_name+"<br/>";
								$archerList += "<li>"+response.teamMembers[$teamMembersIndex].player_name+"</li>";
							}
							$archerList += "</ol>";
							$('#isNewData').html($archerList);
							//$('#slctCat').removeAttr('disabled');
						}
					},
					fail:function(){
						alert("Fail to load archer info.");
					}
				//alert(filteredTeamName+"/"+selectedRoundNum+"/"+$('#slctCat').val());
				});
			});
			
			$("#btnSubmitScoreOR, #frmAddScoreOR").submit(function(event) {
				event.preventDefault();
				var selectedRoundNum = $('#slctRoundNo').val();
				var scoreORArray = [];
				var jsonStringScoreORArray;
				for($index=0; $index<arrowNo; $index++) {
					$strTxtBoxName= "txtBoxMark-"+($index+1);
					$('#'+$strTxtBoxName).val();
					scoreORArray[$index] = $('#'+$strTxtBoxName).val();
				} 
				jsonStringScoreORArray = JSON.stringify(scoreORArray); 
				//alert(jsonStringScoreORArray+"->"+scoreORArray+"->"+filteredTeamName+"->"+$('#slctCat').val()+"->"+$('#slctRoundNo').val());
				$.ajax({ 
					url:'../olympicRoundModule/bracketFunction.php',
					dataType: "json",
					cache: false,
					data:{action:'saveTeamScoreOR', teamName:filteredTeamName.trim(), selectedRoundNum:$('#slctRoundNo').val(), 
						range_Id:$('#slctCat').val(), jsonStringScoreORArray:jsonStringScoreORArray, arrowNo:arrowNo},
					type:'post',
					beforeSend:function() {
						$('#loading-image').show();
					},
					complete:function(response){	//alert(response.archerScoreOR);
						$('#loading-image').hide();
						$('#isNewData').html("Score is saved."+response.affectedRowCount);
						setTimeout($('#modalAddScoreOR').modal('toggle'),1000);
						//$("#buttonRefresh").trigger("click");
						// After score entry, rerun the generate next round function
						if(selectedRoundNum == "1/16") {
							generateTop8();
						}
						else if(selectedRoundNum == "1/8") {
							generateTop4();
						}
						else if(selectedRoundNum == "1/4") {
							generateTop2();
						}			
						else if(selectedRoundNum == "1/2") {
							generateTop1();
						}						
/* 						for(roundNumIndex=16; roundNumIndex>0; roundNumIndex/=2) {
							roundNumString = "1/"+roundNumIndex;
							if(roundNumString == $('#slctRoundNo').val()) {
								"generateTop"+(roundNumIndex/2)+"()";
								break;
							}
						} */
						//alert(response.affectedRowCount);
					},
					fail:function(){
						alert("Fail to save score.");
						$('#isNewData').html("Fail to save score.");
						$('#isNewData').css("color", "red");
					}
				});
			});
			var filteredPointedTeam;
			$(".game, .finalWinner").mouseover(function(){
				var pointedTeam = $(this).html().indexOf('<span>'); 				
				filteredPointedTeam = $(this).html().substring(0, pointedTeam != -1 ? pointedTeam : pointedTeam.length);
				
				$('.game, .finalWinner').filter(function() {
					var otherElementTeam = $(this).html().substring(0, $(this).html().indexOf('<span>') != -1 ? $(this).html().indexOf('<span>') : $(this).html().indexOf('<span>').length);
					if(otherElementTeam == filteredPointedTeam && filteredPointedTeam != "No winner")
					return $(this);
				}).css({"background-color":"#5bc0de", "color":"#f9f9f9"});
				//$(".game:contains("+filteredPointedTeam+")").css({"background-color":"#5bc0de", "color":"#f9f9f9"});
			});
			$(".game, .finalWinner").mouseleave(function(){
				$(".game, .finalWinner:contains("+filteredPointedTeam+")").css({"background-color":"white", "color":"#000000"});
			});			
		});		
		function exportToPDF() {
			var doc = new jsPDF();
			var specialElementHandlers = {
				'#editor': function (element, renderer) {
					return true;
				}
			};
			
			var pdfFileName = document.getElementById("panelTitle").innerHTML;
			//$('#buttonGeneratePDF').click(function () {
				console.log("clicked");
				doc.fromHTML($('#bracketCSS').html(), 15, 15, {
					'width': 170,
						'elementHandlers': specialElementHandlers
				});
				doc.save(pdfFileName);
			//});
		}
		
		function exportToImage() {
			html2canvas($('#panel'), {
				onrendered: function(canvas) {
					var img = canvas.toDataURL();
					window.location.href = img;
					//window.open(img); // open to new tab
				},
				letterRendering: true
			});
		}

		function getTeamRoundWinner(teamA, teamB, round_no, range_Id, elementIdentifier, elementIndex, teamAElementIdentifier, teamBElementIdentifier, teamABElementIndex) {
			var winner="x";
			$.ajax({ 
				url:'../olympicRoundModule/bracketFunction.php',
				dataType: "json",
				cache: false,
				data:{action:'getTeamRoundWinner', teamA:teamA, teamB:teamB, round_no:round_no, range_Id:range_Id, arrowNo:arrowNo},
				type:'post',
				success:function(response){	
					//alert("done with get data of next round winner");
					// Reset the font weight to normal before deciding which winner
					$(teamAElementIdentifier).eq(teamABElementIndex).css("font-weight", "normal");
					$(teamBElementIdentifier).eq(teamABElementIndex).css("font-weight", "normal");
					
					// Set winner of each round
					$(elementIdentifier).eq(elementIndex).html(response.winner_archer_no);
					if(response.winner_archer_no == teamA && response.winner_archer_no != "No winner") {
						$(teamAElementIdentifier).eq(teamABElementIndex).css("font-weight", "bold");
					}
					if(response.winner_archer_no == teamB && response.winner_archer_no != "No winner") {
						$(teamBElementIdentifier).eq(teamABElementIndex).css("font-weight", "bold");
					}					
					// Set totalScore in the current round
					$(teamAElementIdentifier).eq(teamABElementIndex).html(teamA+"<span>"+response.teamATotalScore+"</span>");
					$(teamBElementIdentifier).eq(teamABElementIndex).html(teamB+"<span>"+response.teamBTotalScore+"</span>");
					winner = response.winner_archer_no;
				},
				fail:function(){
					alert("Fail to get data of next round winner.");
				}
			});
			return winner;
		}
		

		function generateTop8() {
			var triggerPoint = 1; 
			var elementIndex = 0;
			var elementIdentifier = "";
			var range_Id = '<?php echo $_POST['slctCat'] ?>';	
			var round_no = '1/16';
			var teamAElementIdentifier = "#top16 li.game-top";
			var teamBElementIdentifier = "#top16 li.game-bottom";
			
			for(indexForTop8=0; indexForTop8<8; indexForTop8++) {
				
				var teamA	= $('#top16 li.game-top').eq(indexForTop8).html().indexOf('<span>');//css("color","yellow");
				var teamB = $('#top16 li.game-bottom').eq(indexForTop8).html().indexOf('<span>'); //css("color","green");
				var filteredTeamA = $('#top16 li.game-top').eq(indexForTop8).html().substring(0, teamA != -1 ? teamA : teamA.length);
				var filteredTeamB = $('#top16 li.game-bottom').eq(indexForTop8).html().substring(0, teamB != -1 ? teamB : teamB.length);
				var teamABElementIndex = indexForTop8;
				
				if(triggerPoint == 1) {
					elementIdentifier = "#top8 li.game-top";
				}
				else if(triggerPoint == 2) {
					elementIdentifier = "#top8 li.game-bottom";
				}
				
				if(filteredTeamA.length>0 && filteredTeamB.length>0) {
					console.log("Team A: "+filteredTeamA+" Team B: "+filteredTeamB );
					var winner = getTeamRoundWinner(filteredTeamA, filteredTeamB, round_no, range_Id, elementIdentifier, elementIndex, teamAElementIdentifier, teamBElementIdentifier, teamABElementIndex);
 				}
				else if(filteredTeamA.length>0 && filteredTeamB.length==0) { 
					$(elementIdentifier).eq(elementIndex).html(filteredTeamA);
				}				
				else if(filteredTeamA.length==0 && filteredTeamB.length>0) { getTeamRoundWinner(filteredTeamA, filteredTeamB, round_no, '1', elementIdentifier, elementIndex);
					$(elementIdentifier).eq(elementIndex).html(filteredTeamB);
				}
/*				else if(filteredTeamA.length==0 && filteredTeamB.length==0) { getTeamRoundWinner(filteredTeamA, filteredTeamB, round_no, '1', elementIdentifier, elementIndex);
				} */
				triggerPoint++;
				if(triggerPoint>2) { triggerPoint = 1; elementIndex++; }
			}
			setTimeout(generateTop4, 300);	
		}	
		
		function generateTop4() {
			var triggerPoint = 1; 
			var elementIndex = 0;
			var elementIdentifier = "";
			var range_Id = '<?php echo $_POST['slctCat'] ?>';
			var round_no = '1/8';
			var teamAElementIdentifier = "#top8 li.game-top";
			var teamBElementIdentifier = "#top8 li.game-bottom";
			
			for(indexForTop4=0; indexForTop4<4; indexForTop4++) {	
				
				var teamA	= $('#top8 li.game-top').eq(indexForTop4).html().indexOf('<span>');//css("color","yellow");
				var teamB = $('#top8 li.game-bottom').eq(indexForTop4).html().indexOf('<span>'); //css("color","green");
				var filteredTeamA = $('#top8 li.game-top').eq(indexForTop4).html().substring(0, teamA != -1 ? teamA : teamA.length);
				var filteredTeamB = $('#top8 li.game-bottom').eq(indexForTop4).html().substring(0, teamB != -1 ? teamB : teamB.length);
				var teamABElementIndex = indexForTop4;
				
				if(triggerPoint == 1) {
					elementIdentifier = "#top4 li.game-top";
				}
				else if(triggerPoint == 2) {
					elementIdentifier = "#top4 li.game-bottom";
				}
				
				if(filteredTeamA.length>0 && filteredTeamB.length>0) {
					console.log("Team A: "+filteredTeamA+" Team B: "+filteredTeamB );
					var winner = getTeamRoundWinner(filteredTeamA, filteredTeamB, round_no, range_Id, elementIdentifier, elementIndex, teamAElementIdentifier, teamBElementIdentifier, teamABElementIndex);
 				}
				else if(filteredTeamA.length>0 && filteredTeamB.length==0) { 
					$(elementIdentifier).eq(elementIndex).html(filteredTeamA);
				}				
				else if(filteredTeamA.length==0 && filteredTeamB.length>0) { getTeamRoundWinner(filteredTeamA, filteredTeamB, round_no, '1', elementIdentifier, elementIndex);
					$(elementIdentifier).eq(elementIndex).html(filteredTeamB);
				}
/*				else if(filteredTeamA.length==0 && filteredTeamB.length==0) { getTeamRoundWinner(filteredTeamA, filteredTeamB, round_no, '1', elementIdentifier, elementIndex);
				} */
				triggerPoint++;
				if(triggerPoint>2) { triggerPoint = 1; elementIndex++; }
			}
			setTimeout(generateTop2, 300);
		}		

		function generateTop2() {
			var triggerPoint = 1; 
			var elementIndex = 0;
			var elementIdentifier = "";
			var range_Id = '<?php echo $_POST['slctCat'] ?>';
			var round_no = '1/4';
			var teamAElementIdentifier = "#top4 li.game-top";
			var teamBElementIdentifier = "#top4 li.game-bottom";
			
			for(indexForTop2=0; indexForTop2<2; indexForTop2++) {	
				
				var teamA	= $('#top4 li.game-top').eq(indexForTop2).html().indexOf('<span>');//css("color","yellow");
				var teamB = $('#top4 li.game-bottom').eq(indexForTop2).html().indexOf('<span>'); //css("color","green");
				var filteredTeamA = $('#top4 li.game-top').eq(indexForTop2).html().substring(0, teamA != -1 ? teamA : teamA.length);
				var filteredTeamB = $('#top4 li.game-bottom').eq(indexForTop2).html().substring(0, teamB != -1 ? teamB : teamB.length);
				var teamABElementIndex = indexForTop2;
				
				if(triggerPoint == 1) {
					elementIdentifier = "#top2 li.game-top";
				}
				else if(triggerPoint == 2) {
					elementIdentifier = "#top2 li.game-bottom";
				}
				
				//if(filteredTeamA.length>0 && filteredTeamB.length>0) {
					console.log("Team A: "+filteredTeamA+" Team B: "+filteredTeamB );
					var winner = getTeamRoundWinner(filteredTeamA, filteredTeamB, round_no, range_Id, elementIdentifier, elementIndex, teamAElementIdentifier, teamBElementIdentifier, teamABElementIndex);
/* 				}
				else if(filteredTeamA.length>0 && filteredTeamB.length==0) { getTeamRoundWinner(filteredTeamA, filteredTeamB, round_no, '1', elementIdentifier, elementIndex);
				}				
				else if(filteredTeamA.length==0 && filteredTeamB.length>0) { getTeamRoundWinner(filteredTeamA, filteredTeamB, round_no, '1', elementIdentifier, elementIndex);
				}
				else if(filteredTeamA.length==0 && filteredTeamB.length==0) { getTeamRoundWinner(filteredTeamA, filteredTeamB, round_no, '1', elementIdentifier, elementIndex);
				} */
				triggerPoint++;
				if(triggerPoint>2) { triggerPoint = 1; elementIndex++; }
			}
			setTimeout(generateTop1, 300);
			setTimeout(generate3rdPlace, 300);
		}
		
		function generateTop1() {
			var triggerPoint = 1; 
			var elementIndex = 0;
			var elementIdentifier = "#top1 li.finalWinner";
			var range_Id = '<?php echo $_POST['slctCat'] ?>';
			var round_no = '1/2';
			var teamAElementIdentifier = "#top2 li.game-top";
			var teamBElementIdentifier = "#top2 li.game-bottom";
				
			for(indexForTop1=0; indexForTop1<1; indexForTop1++) {
				
				var teamA	= $('#top2 li.game-top').eq(indexForTop1).html().indexOf('<span>');//css("color","yellow");
				var teamB = $('#top2 li.game-bottom').eq(indexForTop1).html().indexOf('<span>'); //css("color","green");
				var filteredTeamA = $('#top2 li.game-top').eq(indexForTop1).html().substring(0, teamA != -1 ? teamA : teamA.length);
				var filteredTeamB = $('#top2 li.game-bottom').eq(indexForTop1).html().substring(0, teamB != -1 ? teamB : teamB.length);
				var teamABElementIndex = indexForTop1;
				
				console.log("Team A: "+filteredTeamA+" Team B: "+filteredTeamB );
				var winner = getTeamRoundWinner(filteredTeamA, filteredTeamB, round_no, range_Id, elementIdentifier, elementIndex, teamAElementIdentifier, teamBElementIdentifier, teamABElementIndex);
			}
		}	

		function generate3rdPlace() {
			var top4Team1	= $('#top4 li.game-top').eq(0).html().indexOf('<span>');//css("color","yellow");
			var top4Team2 = $('#top4 li.game-bottom').eq(0).html().indexOf('<span>'); //css("color","green");
			var filteredTop4Team1 = $('#top4 li.game-top').eq(0).html().substring(0, top4Team1 != -1 ? top4Team1 : top4Team1.length);
			var filteredTop4Team2 = $('#top4 li.game-bottom').eq(0).html().substring(0, top4Team2 != -1 ? top4Team2 : top4Team2.length);		

			var top4Team3	= $('#top4 li.game-top').eq(1).html().indexOf('<span>');//css("color","yellow");
			var top4Team4 = $('#top4 li.game-bottom').eq(1).html().indexOf('<span>'); //css("color","green");
			var filteredTop4Team3 = $('#top4 li.game-top').eq(1).html().substring(0, top4Team3 != -1 ? top4Team3 : top4Team3.length);
			var filteredTop4Team4 = $('#top4 li.game-bottom').eq(1).html().substring(0, top4Team4 != -1 ? top4Team4 : top4Team4.length);	
			
			var top2Team1	= $('#top2 li.game-top').eq(0).html().indexOf('<span>');//css("color","yellow");
			var top2Team2 = $('#top2 li.game-bottom').eq(0).html().indexOf('<span>'); //css("color","green");
			var filteredTop2Team1 = $('#top2 li.game-top').eq(0).html().substring(0, top2Team1 != -1 ? top2Team1 : top2Team1.length);
			var filteredTop2Team2 = $('#top2 li.game-bottom').eq(0).html().substring(0, top2Team2 != -1 ? top2Team2 : top2Team2.length);
			
			var elementIdentifier = "#3rdPlace li.thirdWinner";
			var elementIndex = "0";
			var range_Id = '<?php echo $_POST['slctCat'] ?>';
			var round_no = '1/3';			
			var teamAElementIdentifier = "#top3 li.game-top";
			var teamBElementIdentifier = "#top3 li.game-bottom";		
			var teamABElementIndex = 0;			
			var filteredTeamA = "";
			var filteredTeamB = "";
			if(filteredTop4Team1 == filteredTop2Team1) {
				$(teamAElementIdentifier).eq(teamABElementIndex).html(filteredTop4Team2);
				filteredTeamA = filteredTop4Team2;
			}
			else if(filteredTop4Team2 == filteredTop2Team1) {
				$(teamAElementIdentifier).eq(teamABElementIndex).html(filteredTop4Team1);
				filteredTeamA = filteredTop4Team1;
			}
			
			if(filteredTop4Team3 == filteredTop2Team2) {
				$(teamBElementIdentifier).eq(teamABElementIndex).html(filteredTop4Team4);
				filteredTeamB = filteredTop4Team4;
			}
			else if(filteredTop4Team4 == filteredTop2Team2) {
				$(teamBElementIdentifier).eq(teamABElementIndex).html(filteredTop4Team3);
				filteredTeamB = filteredTop4Team3;
			}
			
			getTeamRoundWinner(filteredTeamA, filteredTeamB, round_no, range_Id, elementIdentifier, elementIndex, teamAElementIdentifier, teamBElementIdentifier, teamABElementIndex);
		}		
	</script>
</head>

<body class="container">
	<button type="button" class="btn btn-default btn-lg" id="buttonRefresh" onclick="window.location.reload(true)">
		<span class="glyphicon glyphicon-repeat" aria-hidden="true"></span> Refresh
	</button>
	<button type="button" class="btn btn-default btn-lg" id="buttonExportImage" onclick="exportToImage()">
		<span class="glyphicon glyphicon glyphicon-export" aria-hidden="true"></span> Export As Image
	</button>	
	<!--button class="btn btn-primary glyphicon glyphicon-repeat" id="buttonRefresh" aria-label="Refresh" onclick="window.location.reload(true)">Refresh</button>
	<button class="btn btn-primary glyphicon glyphicon-download-alt" id="buttonExportImage" aria-label="Export as Image" onclick="exportToImage"></button-->
<div class="panel panel-default" id="panel">
	<div class="panel-heading">
		<h3 class="panel-title" id="panelTitle"><?php echo (isset($_POST['btnSubmitGroupOR'])) ? $_POST['slctTeamNo']." Teams ".$recordSelectCategoryInfo['categories'] : $_POST['slctIndvNo']." Individuals ".$recordSelectCategoryInfo[0]['categories']; echo " => ".$_POST['txtBoxArrowNo']." Arrows"; ?></h3>
	</div>
	<div class="panel-body">
		<div id="bracket"></div>
		<div id="bracketCSS" style="font-family: sans-serif;">
			<main style="">
				<?php if($totalNoTeam<=16 && $totalNoTeam>0) { ?>
					<ul id="top16" style="display:<?php echo (($totalNoTeam <= 8) ?"none" :""); ?>;">
						<li>&nbsp;</li>
					<!-- ROUND 1 START -->
					<div style="visibility:<?php echo (empty($arrayTeam[1]['teamName']) || empty($arrayTeam[16]['teamName']) ? "hidden" :" visible")?>;">	
						<li class="game game-top winner"><?php echo $arrayTeam[1]['teamName']; ?><span></span></li>
						<li>&nbsp;</li>
						<li class="game game-bottom"><?php echo $arrayTeam[16]['teamName']; ?><span></span></li>
						<!--li>&nbsp;</li-->
					</div>
					<li>&nbsp;</li> <!--SPECIAL CASE -->
					<div style="visibility:<?php echo (empty($arrayTeam[8]['teamName']) || empty($arrayTeam[9]['teamName']) ? "hidden" : "visible")?>;">	
						<li class="game game-top winner"><?php echo $arrayTeam[8]['teamName']; ?><span></span></li>
						<li>&nbsp;</li>
						<li class="game game-bottom"><?php echo $arrayTeam[9]['teamName']; ?><span></span></li>
					</div>
					<li>&nbsp;</li>
					<div style="visibility:<?php echo (empty($arrayTeam[4]['teamName']) || empty($arrayTeam[13]['teamName']) ? "hidden" : "visible");?>;">
						<li class="game game-top winner"><?php echo $arrayTeam[4]['teamName']; ?><span></span></li>
						<li>&nbsp;</li>
						<li class="game game-bottom "><?php echo $arrayTeam[13]['teamName']; ?><span></span></li>
					</div>
					<li>&nbsp;</li>
					<div style="visibility:<?php echo (empty($arrayTeam[5]['teamName']) || empty($arrayTeam[12]['teamName']) ? "hidden" : "visible");?>;">
						<li class="game game-top winner"><?php echo $arrayTeam[5]['teamName']; ?><span></span></li>
						<li>&nbsp;</li>
						<li class="game game-bottom "><?php echo $arrayTeam[12]['teamName']; ?><span></span></li>
					</div>
					<li>&nbsp;</li>
					<div style="visibility:<?php echo (empty($arrayTeam[2]['teamName']) || empty($arrayTeam[15]['teamName']) ? "hidden" : "visible");?>;">
						<li class="game game-top winner"><?php echo $arrayTeam[2]['teamName']; ?><span></span></li>
						<li>&nbsp;</li>
						<li class="game game-bottom "><?php echo $arrayTeam[15]['teamName']; ?><span></span></li>
					</div>
					<li>&nbsp;</li>
					<div style="visibility:<?php echo (empty($arrayTeam[7]['teamName']) || empty($arrayTeam[10]['teamName']) ? "hidden" : "visible");?>;">
						<li class="game game-top winner"><?php echo $arrayTeam[7]['teamName']; ?><span></span></li>
						<li>&nbsp;</li>
						<li class="game game-bottom "><?php echo $arrayTeam[10]['teamName']; ?><span></span></li>
					</div>
					<li>&nbsp;</li>
					<div style="visibility:<?php echo (empty($arrayTeam[3]['teamName']) || empty($arrayTeam[14]['teamName']) ? "hidden" : "visible");?>;">
						<li class="game game-top winner"><?php echo $arrayTeam[3]['teamName']; ?><span></span></li>
						<li>&nbsp;</li>
						<li class="game game-bottom "><?php echo $arrayTeam[14]['teamName']; ?><span></span></li>
					</div>
					<li>&nbsp;</li>
					<div style="visibility:<?php echo (empty($arrayTeam[6]['teamName']) || empty($arrayTeam[11]['teamName']) ? "hidden" : "visible");?>;">	
						<li class="game game-top winner"><?php echo $arrayTeam[6]['teamName']; ?><span></span></li>
						<li>&nbsp;</li>
						<li class="game game-bottom "><?php echo $arrayTeam[11]['teamName']; ?><span></span></li>
					</div>
						<li>&nbsp;</li>				
					<!-- ROUND 1 END -->
					</ul>
					
					<ul id="top8">
						<li style="flex-grow: .5;">&nbsp;</li>
					<!-- ROUND 2: PART 1 START -->
						<li class="game game-top winner"><?php echo (!empty($arrayTeam[1]['teamName']) && empty($arrayTeam[16]['teamName']) ? $arrayTeam[1]['teamName'] : "Loading");?><span>Loading</span></li>
						<li>&nbsp;</li>
						<li class="game game-bottom "><?php echo (!empty($arrayTeam[8]['teamName']) && empty($arrayTeam[9]['teamName']) ? $arrayTeam[8]['teamName'] : "Loading");?><span>Loading</span></li>
						<li>&nbsp;</li>	
						
						<li class="game game-top winner"><?php echo (!empty($arrayTeam[4]['teamName']) && empty($arrayTeam[13]['teamName']) ? $arrayTeam[4]['teamName'] : "Loading");?><span>Loading</span></li>
						<li>&nbsp;</li>
						<li class="game game-bottom "><?php echo (!empty($arrayTeam[5]['teamName']) && empty($arrayTeam[12]['teamName']) ? $arrayTeam[5]['teamName'] : "Loading");?><span>Loading</span></li>
						<li>&nbsp;</li>
						
						<li class="game game-top winner"><?php echo (!empty($arrayTeam[2]['teamName']) && empty($arrayTeam[15]['teamName']) ? $arrayTeam[2]['teamName'] : "Loading");?><span>Loading</span></li>
						<li>&nbsp;</li>
						<li class="game game-bottom "><?php echo (!empty($arrayTeam[7]['teamName']) && empty($arrayTeam[10]['teamName']) ? $arrayTeam[7]['teamName'] : "Loading");?><span>Loading</span></li>
						<li>&nbsp;</li>
						
						<li class="game game-top winner"><?php echo (!empty($arrayTeam[3]['teamName']) && empty($arrayTeam[14]['teamName']) ? $arrayTeam[3]['teamName'] : "Loading");?><span>Loading</span></li>
						<li>&nbsp;</li>
						<li class="game game-bottom "><?php echo (!empty($arrayTeam[6]['teamName']) && empty($arrayTeam[11]['teamName']) ? $arrayTeam[6]['teamName'] : "Loading");?><span>Loading</span></li>
						<li style="">&nbsp;</li>
					<!-- ROUND 2: PART 1 END -->
					</ul>
					
					<ul id="top4">
						<li>&nbsp;</li>
						<li class="game game-top winner"><?php echo (!empty($arrayTeam[1]['teamName']) && empty($arrayTeam[8]['teamName']) ? $arrayTeam[1]['teamName'] : "Loading");?><span>Loading...</span></li>		
						<li>&nbsp;</li>
						<li class="game game-bottom"><?php echo (!empty($arrayTeam[4]['teamName']) && empty($arrayTeam[5]['teamName']) ? $arrayTeam[4]['teamName'] : "Loading");?><span>Loading...</span></li>	
						<li>&nbsp;</li>	
						<li class="game game-top winner"><?php echo (!empty($arrayTeam[3]['teamName']) && empty($arrayTeam[6]['teamName']) ? $arrayTeam[3]['teamName'] : "Loading");?><span>Loading...</span></li>		
						<li>&nbsp;</li>
						<li class="game game-bottom"><?php echo (!empty($arrayTeam[2]['teamName']) && empty($arrayTeam[7]['teamName']) ? $arrayTeam[2]['teamName'] : "Loading");?><span>Loading...</span></li>	
						<li>&nbsp;</li>				
					</ul>	
					
					<ul id="top2">
						<li>&nbsp;</li>
						<li class="game game-top winner">Loading... <span>Loading...</span></li>		
						<li>&nbsp;</li>
						<li class="game game-bottom">Loading... <span>Loading...</span></li>	
						<li>&nbsp;</li>				
					</ul>
					
					<ul id="top1">
						<li>&nbsp;</li>						
						<li class="finalWinner">Winner<span></span></li>	
						<li>&nbsp;</li>	
					</ul>					
				<?php } ?>
			</main>
			<div class="page-header">
				<h1><small>3rd Place</small></h1>
			</div>
			<main>
				<ul id="top3">
					<li>&nbsp;</li>
					<li class="game game-top winner">Third<span>Loading...</span></li>		
					<li>&nbsp;</li>
					<li class="game game-bottom">Forth<span>Loading...</span></li>	
					<li>&nbsp;</li>				
				</ul>
				<ul id="3rdPlace">
					<li>&nbsp;</li>						
					<li class="game thirdWinner">3rd<span></span></li>	
					<li>&nbsp;</li>	
				</ul>
			</main>		
			<div class="page-header">
				<h1><small>FIRST RUNNER-UP</small></h1>
			</div>
			<div class="game secondWinner">No winner</div>
			<div class="page-header">
				<h1><small>CHAMPION</small></h1>
			</div>			
			<div class="game firstWinner">No winner</div>			
		</div>
	</div>
</div>	
<button class="btn btn-primary" id="buttonGenerateImage" onclick="exportToImage()">Export to Image</button>
<div class="modal fade bs-example-modal-lg" id="modalAddScoreOR" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
	<div class="modal-dialog modal-lg">
	<div class="modal-content">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title" id="modalTitleAddScoreOR">Team OR Add Score</h4>
	</div>
	<div class="modal-body">
		<img id="loading-image" src="../images/ajax-loader.gif" style="display:none;"/>
		<form class="form-horizontal" method="POST">
		<?php //echo json_encode($_GET['term']);
			$stmtSelect = $db->prepare("SELECT * FROM category WHERE range_Id = :range_Id");
			$stmtSelect->execute(array(':range_Id'=>$_POST['slctCat']));
			$recordSetCategory = $stmtSelect->fetch();
			
			$cntRow = $stmtSelect -> rowCount();
		
		?>
			<div class="form-group">
				<label for="txtBoxTeamName" class="col-sm-2 control-label">Team:</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" id="txtBoxTeamName" name="txtBoxTeamName" placeholder="" readonly="true" value="">
				</div>
			</div>
			<div class="form-group">
				<label for="txtBoxCat" class="col-sm-2 control-label">Category:</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" id="txtBoxCat" name="txtBoxCat" placeholder="" readonly="true" value="<?php echo $recordSetCategory['categories']; ?>">
				</div>
			</div>
			<div class="form-group">
				<label for="slctCat" class="col-sm-2 control-label">Range Category:</label>
				<div class="col-sm-8">
					<select class="form-control" id="slctCat" name="slctCat" disabled >
						<option value="<?php echo $recordSetCategory['range_Id']; ?>" selected>
							<?php echo $recordSetCategory['range']."-".$recordSetCategory['categories']; ?>
						</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="slctRoundNo" class="col-sm-2 control-label">Round Number:</label>
				<div class="col-sm-8">
					<select class="form-control" id="slctRoundNo" name="slctRoundNo" <?php echo ( isset($_POST['btnSubmit'])? "disabled" : "disabled"); ?> >
						<?php for($index=16;$index>=2;$index/=2) { ?>
							<option value="1/<?php echo $index; ?>">1/<?php echo $index; ?></option>
							<option value="1/3">1/3</option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="form-group" style="display: none;">
				<div class="col-sm-offset-2 col-sm-6">
					<button type="button" class="btn btn-default" id="btnSubmit" name="btnSubmit" style="padding: 6px 12px; font-size:14px;" disabled="disabled">Confirmed Category & Start Scoring!</button>
				</div>
			</div>	
		</form>
		
        <?php
           $qrySelCat = "Select shoot_qty from category where range_Id = :range_Id "; 
           $fetchQry = $db->prepare($qrySelCat);
           $fetchQry->execute(array('range_Id'=>$_POST['slctCat']));
           $recordSet = $fetchQry->fetch();
           
           //$cntArrow = $recordSet['shoot_qty'];
		   $cntArrow = $_POST['txtBoxArrowNo'];//6;
           $colForm = 6;
		   $colNumPerRow = 6;
           $startCol = 1;
        ?>		
		<form method="POST" action="" id="frmAddScoreOR" name="frmAddScoreOR" class="form-horizontal">
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-8">
					<table class="table table-bordered table-condensed table-striped" border="0">
						<?php 
						$isNewData = 1;
						for($u=0;$u<$cntArrow;) 
						{ 
							
						?>
						<tr style="">
							<?php while($startCol <= $colForm && $u<$cntArrow)
								  { 
							?>
							<td style="font-weight:600; text-align:center;">Arrow-<?php echo $startCol;  ?></td>
							<?php
									$startCol++;   
									$u++;									
								  } ?>
						</tr>
						<tr style="background-color: <?php //echo ($startCol%2==2 ? "#999999" : "#EEEEEE"); //#E9E5FD ?> ">
							<?php 
							//$startCol -= 6; //$colNumPerRow;
							if($cntArrow > 6) { 
								if(($startCol-1)%6 > 0) {
									$startCol = $startCol -(($startCol-1)%6);
									$u = $startCol-1;
								}
								else {
									$u -= 6; 
									$startCol -= 6; 
								}
							}
							else { $u -= $u; $startCol -= ($startCol-1);}
							//echo "top: ".$u."/".$startCol;
							while($startCol <= $colForm && $u<$cntArrow) 
							{ 
								$strTxtBoxName= "txtBoxMark-".$startCol;
								$currMark = 0;//fnGetExistingRangeMark($_POST['txtBoxArcherNo'], $startCol, $_POST['slctCat']);
								$isNewData = ($currMark == '' ? 1 : 0 );
							 ?>
							<td><input type="text" id="<?php echo $strTxtBoxName ?>" class="form-control txtBoxMark" name="<?php echo $strTxtBoxName ?>" value="<?php echo $currMark; ?>" maxLength="1"></td>
							<?php 
								  $startCol++;
								  $u++;
							}
							//echo "bottom: ".$u."/".$startCol;
							?>
						</tr>
						<?php
						   $startCol = $colForm+1; 
						   $colForm += 6; //$colNumPerRow;
						   //$u = $colForm;
						 }               
						?>
						<tr><td colspan="6" align="center">
							<div class="col-sm-offset-2 col-sm-12" style="margin-left:0px;">
								<button type="button" class="btn btn-default" id="btnSave" name="btnSave" value="Save" style="padding: 6px 12px; font-size:14px; display: none;">Save</button>
								<div id="isNewData" style="font-weight:bold;"><?php echo $isNewData; ?></div>
							</div>
							<!--input type="hidden" name="hidArchNo" id="hidArchNo" value="<?php //echo strtoupper($_POST['txtBoxArcherNo']);  ?>">
							<input type="hidden" name="hidCatRange" id="hidCatRange" value="<?php //echo $_POST['slctCat'];  ?>"-->
							<input type="hidden" name="hidCntArrow" id="hidCntArrow" value="<?php echo $cntArrow;  ?>">
							<input type="hidden" name="hidIsNewData" id="hidIsNewData" value="<?php echo $isNewData;  ?>">
							</td>
						</tr>
					</table>
				</div>
			</div>
				
	   
	</div>
	<div class="modal-footer">
		<!--button type="button" class="btn btn-primary" id="btnSubmitScoreOR" name="btnSubmitScoreOR" >Add Score</button-->
		<button type="button" class="btn btn-default" id="btnCancelScoreOR" data-dismiss="modal">Cancel</button>
		<input type="submit" class="btn btn-primary" id="btnSubmitScoreOR" name="btnSubmitScoreOR" value="Add Score">
	</div>
	</form>
	</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</body>

</html>