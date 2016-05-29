<?php
	include '../Connections/wifiAtt.php';
	//include '../generalFn/genericFn.php';
	//include 'bracketFunction.php';
?>

<?php
	if(isset($_POST['btnSubmitIndividualOR'])) {
		$qrySelectCategoryInfo = "SELECT * FROM category WHERE range_Id = :range_Id";
		$stmtSelectCategoryInfo = $db->prepare($qrySelectCategoryInfo);
		$stmtSelectCategoryInfo->bindValue(':range_Id', $_POST['slctCat'], PDO::PARAM_STR);
		$stmtSelectCategoryInfo->execute();
		$recordSelectCategoryInfo = $stmtSelectCategoryInfo->fetchAll(PDO::FETCH_ASSOC);
		//print_r($recordSelectCategoryInfo);
		
		$qryScore = "SELECT SUM(score) AS totalScore, SUM(cntX) as totalX, SUM(cnt10) as total10, SUM(cnt9) as total9, SUM(cntM) as totalM,
					scoring.archer_no, players.player_name FROM scoring
					JOIN players ON scoring.archer_no = players.player_no
					WHERE scoring.range = :range_Id
					GROUP BY scoring.archer_no
					ORDER BY totalScore DESC, totalX DESC, total10 DESC, total9 DESC, totalM 
					LIMIT :indvNo";
		$stmtSelectIndv = $db->prepare($qryScore);
		$stmtSelectIndv->bindParam(':range_Id', $_POST['slctCat'], PDO::PARAM_STR);
		$stmtSelectIndv->bindValue(':indvNo', (int)$_POST['slctIndvNo'], PDO::PARAM_INT);
		$stmtSelectIndv->execute();
		
		$recordIndvScore = $stmtSelectIndv->fetchAll(PDO::FETCH_ASSOC);
		$cntRow = $stmtSelectIndv -> rowCount(); //echo $cntRow." ROWS";
		// Number of individual archer from database
		$totalNoIndv = $cntRow; //$json = json_encode($recordIndvScore); echo $json;
		if($totalNoIndv == 0) {
			
		}
		else {
			$teamA = array("","","","","","","","","","",
						"","","","","","","","","","",
						"","","","","","","","","","",
						"","","","","","","","","","",
						"","","","","","","","","","",
						"","","","","","","","","","",
						"","","","","",""); // 66 index
			$teamB = array(); $teamB = $teamA;
			$teamSkip = array("","","","","","","","","","","","","","","","","",""); // 18 index 
			if($totalNoIndv >= 48) $teamNoSkip = 64 - $totalNoIndv;
			else if($totalNoIndv < 48) $teamNoSkip = $totalNoIndv - 32;
			else $teamNoSkip = 0;
			
			//echo $totalNoIndv." ".$teamNoSkip;
			$indexForArcherInfo = 1;
			$arrayArcherInfo = array();
			$arrayArcherInfoTest = array();
			for($row=1; $row<=64; $row++) {
				$arrayArcherInfoTest[$row] = array();
				$arrayArcherInfoTest[$row]['archer_no'] = "";
				$arrayArcherInfoTest[$row]['player_name'] = "";
				$arrayArcherInfoTest[$row]['totalScore'] = "";
			}
			
			foreach ($recordIndvScore as $rowIndvScore) {
				$arrayArcherInfo[$indexForArcherInfo] = array();
				$arrayArcherInfo[$indexForArcherInfo]['archer_no'] = $rowIndvScore['archer_no'];
				$arrayArcherInfo[$indexForArcherInfo]['player_name'] = $rowIndvScore['player_name'];
				$arrayArcherInfo[$indexForArcherInfo]['totalScore'] = $rowIndvScore['totalScore'];
				$arrayArcherInfoTest[$indexForArcherInfo]['archer_no'] = $rowIndvScore['archer_no'];
				$arrayArcherInfoTest[$indexForArcherInfo]['player_name'] = $rowIndvScore['player_name'];
				$arrayArcherInfoTest[$indexForArcherInfo]['totalScore'] = $rowIndvScore['totalScore'];
				$indexForArcherInfo++;
			}
			
			/* if($totalNoIndv >= 48) {
				$indexForTeamAB = 1;
				$valueForTeamA = $teamNoSkip+1;
				$valueForTeamB = $totalNoIndv;			
				for($indexForTeamAB; $indexForTeamAB<=(($totalNoIndv-$teamNoSkip)/2); $indexForTeamAB++ ) {
					$teamA[$indexForTeamAB] = $valueForTeamA;
					$teamB[$indexForTeamAB] = $valueForTeamB;
					
					$valueForTeamA++;
					$valueForTeamB--;
				}	var_dump($teamA); var_dump($teamB);
			}
			else if($totalNoIndv < 48) {
				$indexForTeamAB = 1;
				$valueForTeamA = $totalNoIndv - $teamNoSkip;
				$valueForTeamB = $totalNoIndv - $teamNoSkip + 1;
				for($indexForTeamAB; $indexForTeamAB<=$teamNoSkip; $indexForTeamAB++) {
					$teamA[$indexForTeamAB] = $valueForTeamA;
					$teamB[$indexForTeamAB] = $valueForTeamB;
					
					$valueForTeamA--;
					$valueForTeamB++;
				}
				$valueForTeamA = $teamNoSkip+1;
				$valueForTeamB = $totalNoIndv-($teamNoSkip * 2);		
				$indexForTeamAB = $teamNoSkip+1;
				for($indexForTeamAB; $indexForTeamAB<=(($totalNoIndv-$teamNoSkip)/2); $indexForTeamAB++ ) {
					$teamA[$indexForTeamAB] = $valueForTeamA;
					$teamB[$indexForTeamAB] = $valueForTeamB;
					
					$valueForTeamA++;
					$valueForTeamB--;
				} var_dump($teamA); var_dump($teamB);	
			}  */
			
			if($totalNoIndv<=8) {
				
			}
			else if($totalNoIndv<=16) {
				
			}
			else if($totalNoIndv<=32) {
				
			}
			else if($totalNoIndv<=64) {
			}
		}
	}
/* 	else if(isset($_POST['btnSubmitScoreOR'])) {
		
	}	 */
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
	
	<link href="../css/bootstrap.min.css" rel="stylesheet" />
	<!--link href="../css/jquery.bracket-world.css" rel="stylesheet">
	<link href="../css/bracket-index.css" rel="stylesheet">
	<link href="../css/jquerysctipttop.css" rel="stylesheet" type="text/css"-->
	<link href="../css/bracket.css" rel="stylesheet" />
	
	<!-- Tooltipster -->
	<link rel="stylesheet" href="../css/tooltipster.css">	
	
	<script src="../js/jquery-2.2.1.min.js"></script>
	<script src="../js/bootstrap.min.js"></script>
	<script src="../js/jquery.bracket-world.min.js"></script>	
	<script src="../jsPDF/jspdf.debug.js"></script>
	<script src="../js/html2canvas.js"></script>
	<script src="../js/jquery.tooltipster.min.js"></script>
	<script>
		var arrowNo = '<?php echo $_POST["txtBoxArrowNo"]; ?>'; 
		$(document).ready(function(){ 		
			$('.game, ul').tooltipster({   
				animation: 'fade',
				delay: 150,
				theme: 'tooltipster-default',
                contentAsHTML: true
            });
			
			// To build Top 32
			var totalNoIndv = '<?php echo $totalNoIndv; ?>';
			if(totalNoIndv > 32 && totalNoIndv <= 64) {
				generateTop32();	
			}
			else if (totalNoIndv > 16 && totalNoIndv <= 32){
				generateTop16();
			}
			else if (totalNoIndv > 8 && totalNoIndv <= 16){
				generateTop8();
			}
			else if (totalNoIndv > 4 && totalNoIndv <= 8){
				generateTop4();
			}			
			
			//#bracketCSS > main > ul > li, #bracketCSS > main > ul > div > li
			var filteredArcherNo;
			$(".game").click(function(event) {
				var clickedInnerhtml = $(this).html();
				var oriInnerHTML = clickedInnerhtml.indexOf('<span>');
				filteredArcherNo = clickedInnerhtml.substring(0, oriInnerHTML != -1 ? oriInnerHTML : oriInnerHTML.length);
				//alert(filteredArcherNo);
				var selectedRoundNum = $(this).closest('ul').attr('id');
				selectedRoundNum = '1/'+selectedRoundNum.replace('top','');
				
				$('#modalAddScoreOR').modal('toggle'); 
				$('#isNewData').html("");
				
				//alert(filteredArcherNo+"/"+selectedRoundNum+"/"+$('#slctCat').val());
				$.ajax({ 
					url:'../olympicRoundModule/bracketFunction.php',
					dataType: "json",
					cache: false,
					data:{action:'getORArcherInfo', archerNo:filteredArcherNo.trim(), selectedRoundNum:selectedRoundNum, range_Id:$('#slctCat').val(), arrowNo:arrowNo},
					type:'post',
					beforeSend:function() {
						$('#loading-image').show();
					},
					success:function(response){	//alert(response.archerScoreOR);
						//$('#modalTitleAddScoreOR').html("");
						$('#loading-image').hide();
						$('#txtBoxArcherNo').val(filteredArcherNo);
						$('#txtBoxArcherName').val(response.archerName);
						$('#txtBoxGender').val(response.archerGender);
						$('#txtBoxCat').val(response.archerCat);
						$('#txtBoxTeam').val(response.archerTeam);
						$('#slctRoundNo').val(selectedRoundNum); 
						//$('#slctCat').val();
						var totalScore = 0;
						for($index=0; $index<arrowNo; $index++) {
							$strTxtBoxName= "txtBoxMark-"+($index+1);
							$('#'+$strTxtBoxName).val(response.archerScoreOR[$index]);
							totalScore += response.archerScoreOR[$index];
						}
						if(response.archerName == null || response.archerName == "" || response.archerName == "No winner" || selectedRoundNum == "1/3rdPlace") {
							$('#btnSubmitScoreOR').attr('disabled','disabled');
							$('input').attr('disabled','disabled');
							$('#totalScore').html();
						}
						else {
							$('#btnSubmitScoreOR').removeAttr('disabled');
							$('input').removeAttr('disabled');
							$('#totalScore').html("Total Score: "+totalScore);
						}
					},
					fail:function(){
						alert("Fail to load archer info.");
					}
                });
			});
			
			$("#btnSubmitScoreOR, #frmAddScoreOR").submit(function(event) {
				event.preventDefault();
				var scoreORArray = [];
				var jsonStringScoreORArray;
				var selectedRoundNum = $('#slctRoundNo').val();
				for($index=0; $index<arrowNo; $index++) {
					$strTxtBoxName= "txtBoxMark-"+($index+1);
					$('#'+$strTxtBoxName).val();
					scoreORArray[$index] = $('#'+$strTxtBoxName).val();
				} 
				jsonStringScoreORArray = JSON.stringify(scoreORArray); 
				//alert(jsonStringScoreORArray+"->"+scoreORArray+"->"+filteredArcherNo+"->"+$('#slctCat').val()+"->"+$('#slctRoundNo').val());
				$.ajax({ 
					url:'../olympicRoundModule/bracketFunction.php',
					dataType: "json",
					cache: false,
					data:{action:'saveArcherScoreOR', archerNo:filteredArcherNo.trim(), selectedRoundNum:$('#slctRoundNo').val(), 
						range_Id:$('#slctCat').val(), jsonStringScoreORArray:jsonStringScoreORArray},
					type:'post',
					beforeSend:function() {
						$('#loading-image').show();
					},
					complete:function(response){	//alert(response.archerScoreOR);
						$('#loading-image').hide();
						$('#isNewData').html("Score is saved."+response.affectedRowCount);
						setTimeout($('#modalAddScoreOR').modal('toggle'),300);
						// After score entry, rerun the generate next round function
						if(selectedRoundNum == "1/64") {
							generateTop32();
						}	
						if(selectedRoundNum == "1/32") {
							generateTop16();
						}						
						else if(selectedRoundNum == "1/16") {
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
						else if(selectedRoundNum == "1/3") {
							generate3rdPlace2();
						}
						//$("#buttonRefresh").trigger("click");
						//alert(response.affectedRowCount);
					},
					fail:function(){
						alert("Fail to save score.");
						$('#isNewData').html("Fail to save score.");
						$('#isNewData').css("color", "red");
					}
				});
			});
			var filteredPointedArcherNo;
			$(".game, .finalWinner").mouseover(function(){
				var pointedArcherNo = $(this).html().indexOf('<span>'); 				
				filteredPointedArcherNo = $(this).html().substring(0, pointedArcherNo != -1 ? pointedArcherNo : pointedArcherNo.length);
				
				$('.game, .finalWinner').filter(function() {
					var otherElementArcherNo = $(this).html().substring(0, $(this).html().indexOf('<span>') != -1 ? $(this).html().indexOf('<span>') : $(this).html().indexOf('<span>').length);
					if(otherElementArcherNo == filteredPointedArcherNo && filteredPointedArcherNo != "No winner")
					return $(this);
				}).css({"background-color":"#5bc0de", "color":"#f9f9f9"});
				//$(".game:contains("+filteredPointedArcherNo+")").css({"background-color":"#5bc0de", "color":"#f9f9f9"});
			});
			$(".game, .finalWinner").mouseleave(function(){
				$(".game, .finalWinner:contains("+filteredPointedArcherNo+")").css({"background-color":"white", "color":"#000000"});
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

		function getIndvRoundWinner(playerA, playerB, round_no, range_Id, elementIdentifier, elementIndex, playerAElementIdentifier, playerBElementIdentifier, playerABElementIndex) {
			var winner="x";
			$.ajax({ 
				url:'../olympicRoundModule/bracketFunction.php',
				dataType: "json",
				cache: false,
				data:{action:'getIndvRoundWinner', playerA:playerA, playerB:playerB, round_no:round_no, 
					range_Id:range_Id, arrowNo:arrowNo},
				type:'post',
				async: false,
				success:function(response){	
					//alert("done with get data of next round winner");
					// Reset the font weight to normal before deciding which winner
					$(playerAElementIdentifier).eq(playerABElementIndex).css("font-weight", "normal");
					$(playerBElementIdentifier).eq(playerABElementIndex).css("font-weight", "normal");
					//$(playerAElementIdentifier).eq(playerABElementIndex).tooltipster({contentAsHTML: true});
					//$(playerBElementIdentifier).eq(playerABElementIndex).tooltipster({contentAsHTML: true});
					//$(elementIdentifier).eq(elementIndex).tooltipster({contentAsHTML: true});
					// Set winner of each round
					$(elementIdentifier).eq(elementIndex).html(response.winner['archer_no']);
					// Set title attribute(winner name) for the winner
					$(elementIdentifier).eq(elementIndex).prop('title', response.winner['player_name']);
					if(response.winner['archer_no'] == playerA && response.winner['archer_no'] != "No winner") {
						$(playerAElementIdentifier).eq(playerABElementIndex).css({'font-weight': 'bold'});
						if(round_no == "1/4") {
							// Take the loser of 1/4 round and put into the 3rd place bracket
							//$('#top3 li.game-top').eq(0).html(playerB);
						}
						else if(round_no == "1/2") {
							$('.firstWinner').html(playerA+" ("+response.playerA['player_name']+")<span>"+response.playerA['totalScore']+"</span>");
							$('.secondWinner').html(playerB+" ("+response.playerB['player_name']+")<span>"+response.playerB['totalScore']+"</span>");
						}
					}
					if(response.winner['archer_no'] == playerB && response.winner['archer_no'] != "No winner") {
						$(playerBElementIdentifier).eq(playerABElementIndex).css({'font-weight': 'bold'});
						if(round_no == "1/4") {
							// Take the loser of 1/4 round and put into the 3rd place bracket
							//$('#top3 li.game-top').eq(0).html(playerA);
						}								
						else if(round_no == "1/2") {
							$('.firstWinner').html(playerB+" ("+response.playerB['player_name']+")<span>"+response.playerB['totalScore']+"</span>");
							$('.secondWinner').html(playerA+" ("+response.playerA['player_name']+")<span>"+response.playerA['totalScore']+"</span>");					
						}				
					}
					if(round_no == "1/4") {
						//$('#top3 li.game-bottom').eq(0).html("hi<span>0</span>");
						//$('#top3 li.game-top').eq(0).html("hey<span>0</span>");
					}
					// Set totalScore in the current round					
					$(playerAElementIdentifier).eq(playerABElementIndex).html(playerA+"<span>"+response.playerA['totalScore']+"</span>");
					$(playerBElementIdentifier).eq(playerABElementIndex).html(playerB+"<span>"+response.playerB['totalScore']+"</span>");
					// Set player_name for the title attribute of two archers - for hovering purpose
					$(playerAElementIdentifier).eq(playerABElementIndex).prop('title', response.playerA['player_name']);
					$(playerBElementIdentifier).eq(playerABElementIndex).prop('title', response.playerB['player_name']);
					winner = response.winner['archer_no'];
				},
				fail:function(){
					alert("Fail to get data of next round winner.");
				}
			});
			return winner;
		}
		
		function generateTop32() {
			var triggerPoint = 1;
			var elementIdentifier = "";
			var elementIndex = 0;
			var range_Id = '<?php echo $_POST['slctCat'] ?>';
			var round_no = '1/64';
			var playerAElementIdentifier = "#top64 li.game-top";
			var playerBElementIdentifier = "#top64 li.game-bottom";
			
			for(indexForTop32=0; indexForTop32<32; indexForTop32++) {	
				
				var playerA	= $('#top64 li.game-top').eq(indexForTop32).html().indexOf('<span>');//css("color","yellow");
				var playerB = $('#top64 li.game-bottom').eq(indexForTop32).html().indexOf('<span>'); //css("color","green");
				var filteredPlayerA = $('#top64 li.game-top').eq(indexForTop32).html().substring(0, playerA != -1 ? playerA : playerA.length);
				var filteredPlayerB = $('#top64 li.game-bottom').eq(indexForTop32).html().substring(0, playerB != -1 ? playerB : playerB.length);
				var playerABElementIndex = indexForTop32;
				
				if(triggerPoint == 1) {
					elementIdentifier = "#top32 li.game-top";
				}
				else if(triggerPoint == 2) {
					elementIdentifier = "#top32 li.game-bottom";
				}
				
				if(filteredPlayerA.length>0 && filteredPlayerB.length>0) {	
					var winner = getIndvRoundWinner(filteredPlayerA, filteredPlayerB, round_no, range_Id, elementIdentifier, elementIndex, playerAElementIdentifier, playerBElementIdentifier, playerABElementIndex);
			 	}
				else if(filteredPlayerA.length>0 && filteredPlayerB.length==0) {
					$(elementIdentifier).eq(elementIndex).html(filteredPlayerA);
				}				
				else if(filteredPlayerA.length==0 && filteredPlayerB.length>0) {
					$(elementIdentifier).eq(elementIndex).html(filteredPlayerB);
				}
/*				else if(filteredPlayerA.length==0 && filteredPlayerB.length==0) {
				} */
				triggerPoint++;
				if(triggerPoint>2) { triggerPoint = 1; elementIndex++; }
			}
			// To build Top 16
			setTimeout(generateTop16, 300);				
		}
		
		function generateTop16() {
			var triggerPoint = 1; 
			var elementIndex = 0;
			var elementIdentifier = "";
			var range_Id = '<?php echo $_POST['slctCat'] ?>';
			var round_no = '1/32';
			var playerAElementIdentifier = "#top32 li.game-top";
			var playerBElementIdentifier = "#top32 li.game-bottom";
			
			for(indexForTop16=0; indexForTop16<16; indexForTop16++) {	
				
				var playerA	= $('#top32 li.game-top').eq(indexForTop16).html().indexOf('<span>');//css("color","yellow");
				var playerB = $('#top32 li.game-bottom').eq(indexForTop16).html().indexOf('<span>'); //css("color","green");
				var filteredPlayerA = $('#top32 li.game-top').eq(indexForTop16).html().substring(0, playerA != -1 ? playerA : playerA.length);
				var filteredPlayerB = $('#top32 li.game-bottom').eq(indexForTop16).html().substring(0, playerB != -1 ? playerB : playerB.length);
				var playerABElementIndex = indexForTop16;
				
				if(triggerPoint == 1) {
					elementIdentifier = "#top16 li.game-top";
				}
				else if(triggerPoint == 2) {
					elementIdentifier = "#top16 li.game-bottom";
				}
				
				if(filteredPlayerA.length>0 && filteredPlayerB.length>0) {
					console.log("Top16=>Player A: "+filteredPlayerA+" Player B: "+filteredPlayerB );
					var winner = getIndvRoundWinner(filteredPlayerA, filteredPlayerB, round_no, range_Id, elementIdentifier, elementIndex, playerAElementIdentifier, playerBElementIdentifier, playerABElementIndex);
 				}
				else if(filteredPlayerA.length>0 && filteredPlayerB.length==0) {
					$(elementIdentifier).eq(elementIndex).html(filteredPlayerA);
				}				
				else if(filteredPlayerA.length==0 && filteredPlayerB.length>0) {
					$(elementIdentifier).eq(elementIndex).html(filteredPlayerB);
				}
/*				else if(filteredPlayerA.length==0 && filteredPlayerB.length==0) { getIndvRoundWinner(filteredPlayerA, filteredPlayerB, round_no, '1', elementIdentifier, elementIndex);
				} */
				triggerPoint++;
				if(triggerPoint>2) { triggerPoint = 1; elementIndex++; }
			}
			// To build Top 8
			setTimeout(generateTop8, 300);	
		}

		function generateTop8() {
			var triggerPoint = 1; 
			var elementIndex = 0;
			var elementIdentifier = "";
			var range_Id = '<?php echo $_POST['slctCat'] ?>';	
			var round_no = '1/16';
			var playerAElementIdentifier = "#top16 li.game-top";
			var playerBElementIdentifier = "#top16 li.game-bottom";
			
			for(indexForTop8=0; indexForTop8<8; indexForTop8++) {
				
				var playerA	= $('#top16 li.game-top').eq(indexForTop8).html().indexOf('<span>');//css("color","yellow");
				var playerB = $('#top16 li.game-bottom').eq(indexForTop8).html().indexOf('<span>'); //css("color","green");
				var filteredPlayerA = $('#top16 li.game-top').eq(indexForTop8).html().substring(0, playerA != -1 ? playerA : playerA.length);
				var filteredPlayerB = $('#top16 li.game-bottom').eq(indexForTop8).html().substring(0, playerB != -1 ? playerB : playerB.length);
				var playerABElementIndex = indexForTop8;
				
				if(triggerPoint == 1) {
					elementIdentifier = "#top8 li.game-top";
				}
				else if(triggerPoint == 2) {
					elementIdentifier = "#top8 li.game-bottom";
				}
				
				//if(filteredPlayerA.length>0 && filteredPlayerB.length>0) {
					console.log("Player A: "+filteredPlayerA+" Player B: "+filteredPlayerB );
					var winner = getIndvRoundWinner(filteredPlayerA, filteredPlayerB, round_no, range_Id, elementIdentifier, elementIndex, playerAElementIdentifier, playerBElementIdentifier, playerABElementIndex);
/* 				}
				else if(filteredPlayerA.length>0 && filteredPlayerB.length==0) { getIndvRoundWinner(filteredPlayerA, filteredPlayerB, round_no, '1', elementIdentifier, elementIndex);
				}				
				else if(filteredPlayerA.length==0 && filteredPlayerB.length>0) { getIndvRoundWinner(filteredPlayerA, filteredPlayerB, round_no, '1', elementIdentifier, elementIndex);
				}
				else if(filteredPlayerA.length==0 && filteredPlayerB.length==0) { getIndvRoundWinner(filteredPlayerA, filteredPlayerB, round_no, '1', elementIdentifier, elementIndex);
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
			var playerAElementIdentifier = "#top8 li.game-top";
			var playerBElementIdentifier = "#top8 li.game-bottom";
			
			for(indexForTop4=0; indexForTop4<4; indexForTop4++) {	
				
				var playerA	= $('#top8 li.game-top').eq(indexForTop4).html().indexOf('<span>');//css("color","yellow");
				var playerB = $('#top8 li.game-bottom').eq(indexForTop4).html().indexOf('<span>'); //css("color","green");
				var filteredPlayerA = $('#top8 li.game-top').eq(indexForTop4).html().substring(0, playerA != -1 ? playerA : playerA.length);
				var filteredPlayerB = $('#top8 li.game-bottom').eq(indexForTop4).html().substring(0, playerB != -1 ? playerB : playerB.length);
				var playerABElementIndex = indexForTop4;
				
				if(triggerPoint == 1) {
					elementIdentifier = "#top4 li.game-top";
				}
				else if(triggerPoint == 2) {
					elementIdentifier = "#top4 li.game-bottom";
				}
				
				//if(filteredPlayerA.length>0 && filteredPlayerB.length>0) {
					console.log("Player A: "+filteredPlayerA+" Player B: "+filteredPlayerB );
					var winner = getIndvRoundWinner(filteredPlayerA, filteredPlayerB, round_no, range_Id, elementIdentifier, elementIndex, playerAElementIdentifier, playerBElementIdentifier, playerABElementIndex);
/* 				}
				else if(filteredPlayerA.length>0 && filteredPlayerB.length==0) { getIndvRoundWinner(filteredPlayerA, filteredPlayerB, round_no, '1', elementIdentifier, elementIndex);
				}				
				else if(filteredPlayerA.length==0 && filteredPlayerB.length>0) { getIndvRoundWinner(filteredPlayerA, filteredPlayerB, round_no, '1', elementIdentifier, elementIndex);
				}
				else if(filteredPlayerA.length==0 && filteredPlayerB.length==0) { getIndvRoundWinner(filteredPlayerA, filteredPlayerB, round_no, '1', elementIdentifier, elementIndex);
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
			var playerAElementIdentifier = "#top4 li.game-top";
			var playerBElementIdentifier = "#top4 li.game-bottom";
			
			for(indexForTop2=0; indexForTop2<2; indexForTop2++) {	
				
				var playerA	= $('#top4 li.game-top').eq(indexForTop2).html().indexOf('<span>');//css("color","yellow");
				var playerB = $('#top4 li.game-bottom').eq(indexForTop2).html().indexOf('<span>'); //css("color","green");
				var filteredPlayerA = $('#top4 li.game-top').eq(indexForTop2).html().substring(0, playerA != -1 ? playerA : playerA.length);
				var filteredPlayerB = $('#top4 li.game-bottom').eq(indexForTop2).html().substring(0, playerB != -1 ? playerB : playerB.length);
				var playerABElementIndex = indexForTop2;
				
				if(triggerPoint == 1) {
					elementIdentifier = "#top2 li.game-top";
				}
				else if(triggerPoint == 2) {
					elementIdentifier = "#top2 li.game-bottom";
				}
				
				//if(filteredPlayerA.length>0 && filteredPlayerB.length>0) {
					console.log("Player A: "+filteredPlayerA+" Player B: "+filteredPlayerB );
					var winner = getIndvRoundWinner(filteredPlayerA, filteredPlayerB, round_no, range_Id, elementIdentifier, elementIndex, playerAElementIdentifier, playerBElementIdentifier, playerABElementIndex);
/* 				}
				else if(filteredPlayerA.length>0 && filteredPlayerB.length==0) { getIndvRoundWinner(filteredPlayerA, filteredPlayerB, round_no, '1', elementIdentifier, elementIndex);
				}				
				else if(filteredPlayerA.length==0 && filteredPlayerB.length>0) { getIndvRoundWinner(filteredPlayerA, filteredPlayerB, round_no, '1', elementIdentifier, elementIndex);
				}
				else if(filteredPlayerA.length==0 && filteredPlayerB.length==0) { getIndvRoundWinner(filteredPlayerA, filteredPlayerB, round_no, '1', elementIdentifier, elementIndex);
				} */
				triggerPoint++;
				if(triggerPoint>2) { triggerPoint = 1; elementIndex++; }
			}
			setTimeout(generateTop1, 300);
			setTimeout(generate3rdPlace2, 300);
		}
		
		function generateTop1() {
			var triggerPoint = 1; 
			var elementIndex = 0;
			var elementIdentifier = "#top1 li.finalWinner";
			var range_Id = '<?php echo $_POST['slctCat'] ?>';
			var round_no = '1/2';
			var playerAElementIdentifier = "#top2 li.game-top";
			var playerBElementIdentifier = "#top2 li.game-bottom";
				
			for(indexForTop1=0; indexForTop1<1; indexForTop1++) {
				
				var playerA	= $('#top2 li.game-top').eq(indexForTop1).html().indexOf('<span>');//css("color","yellow");
				var playerB = $('#top2 li.game-bottom').eq(indexForTop1).html().indexOf('<span>'); //css("color","green");
				var filteredPlayerA = $('#top2 li.game-top').eq(indexForTop1).html().substring(0, playerA != -1 ? playerA : playerA.length);
				var filteredPlayerB = $('#top2 li.game-bottom').eq(indexForTop1).html().substring(0, playerB != -1 ? playerB : playerB.length);
				var playerABElementIndex = indexForTop1;
				
				console.log("1/2=>Player A: "+filteredPlayerA+" Player B: "+filteredPlayerB );
				var winner = getIndvRoundWinner(filteredPlayerA, filteredPlayerB, round_no, range_Id, elementIdentifier, elementIndex, playerAElementIdentifier, playerBElementIdentifier, playerABElementIndex);
			}
		}

		function generate3rdPlace() {
			var elementIdentifier = "#3rdPlace li.thirdWinner";
			var elementIndex = "0";
			var range_Id = '<?php echo $_POST['slctCat'] ?>';
			var round_no = '2/3';			
			var playerAElementIdentifier = "#top3 li.game-top";
			var playerBElementIdentifier = "#top3 li.game-bottom";		
			var playerABElementIndex = 0;
			var playerA	= $(playerAElementIdentifier).eq(playerABElementIndex).html().indexOf('<span>');//css("color","yellow");
			var playerB = $(playerBElementIdentifier).eq(playerABElementIndex).html().indexOf('<span>'); //css("color","green");
			var filteredPlayerA = $(playerAElementIdentifier).eq(playerABElementIndex).html().substring(0, playerA != -1 ? playerA : playerA.length);
			var filteredPlayerB = $(playerBElementIdentifier).eq(playerABElementIndex).html().substring(0, playerB != -1 ? playerB : playerB.length);
			
			getIndvRoundWinner(filteredPlayerA, filteredPlayerB, round_no, range_Id, elementIdentifier, elementIndex, playerAElementIdentifier, playerBElementIdentifier, playerABElementIndex);
		}
		
		function generate3rdPlace2() {
			var top4Player1	= $('#top4 li.game-top').eq(0).html().indexOf('<span>');//css("color","yellow");
			var top4Player2 = $('#top4 li.game-bottom').eq(0).html().indexOf('<span>'); //css("color","green");
			var filteredTop4Player1 = $('#top4 li.game-top').eq(0).html().substring(0, top4Player1 != -1 ? top4Player1 : top4Player1.length);
			var filteredTop4Player2 = $('#top4 li.game-bottom').eq(0).html().substring(0, top4Player2 != -1 ? top4Player2 : top4Player2.length);		

			var top4Player3	= $('#top4 li.game-top').eq(1).html().indexOf('<span>');//css("color","yellow");
			var top4Player4 = $('#top4 li.game-bottom').eq(1).html().indexOf('<span>'); //css("color","green");
			var filteredTop4Player3 = $('#top4 li.game-top').eq(1).html().substring(0, top4Player3 != -1 ? top4Player3 : top4Player3.length);
			var filteredTop4Player4 = $('#top4 li.game-bottom').eq(1).html().substring(0, top4Player4 != -1 ? top4Player4 : top4Player4.length);	
			
			var top2Player1	= $('#top2 li.game-top').eq(0).html().indexOf('<span>');//css("color","yellow");
			var top2Player2 = $('#top2 li.game-bottom').eq(0).html().indexOf('<span>'); //css("color","green");
			var filteredTop2Player1 = $('#top2 li.game-top').eq(0).html().substring(0, top2Player1 != -1 ? top2Player1 : top2Player1.length);
			var filteredTop2Player2 = $('#top2 li.game-bottom').eq(0).html().substring(0, top2Player2 != -1 ? top2Player2 : top2Player2.length);
			
			var elementIdentifier = "#3rdPlace li.thirdWinner";
			var elementIndex = "0";
			var range_Id = '<?php echo $_POST['slctCat'] ?>';
			var round_no = '1/3';			
			var playerAElementIdentifier = "#top3 li.game-top";
			var playerBElementIdentifier = "#top3 li.game-bottom";		
			var playerABElementIndex = 0;			
			var filteredPlayerA = "";
			var filteredPlayerB = "";
			if(filteredTop4Player1 == filteredTop2Player1) {
				$(playerAElementIdentifier).eq(playerABElementIndex).html(filteredTop4Player2);
				filteredPlayerA = filteredTop4Player2;
			}
			else if(filteredTop4Player2 == filteredTop2Player1) {
				$(playerAElementIdentifier).eq(playerABElementIndex).html(filteredTop4Player1);
				filteredPlayerA = filteredTop4Player1;
			}
			
			if(filteredTop4Player3 == filteredTop2Player2) {
				$(playerBElementIdentifier).eq(playerABElementIndex).html(filteredTop4Player4);
				filteredPlayerB = filteredTop4Player4;
			}
			else if(filteredTop4Player4 == filteredTop2Player2) {
				$(playerBElementIdentifier).eq(playerABElementIndex).html(filteredTop4Player3);
				filteredPlayerB = filteredTop4Player3;
			}
			
			getIndvRoundWinner(filteredPlayerA, filteredPlayerB, round_no, range_Id, elementIdentifier, elementIndex, playerAElementIdentifier, playerBElementIdentifier, playerABElementIndex);
		}
	</script>
</head>

<body class="container">
	<!--button class="btn btn-primary glyphicon glyphicon-repeat" id="buttonRefresh" aria-label="Refresh" onclick="window.location.reload(true)"></button>
	<button class="btn btn-primary" id="buttonGenerateImage" onclick="exportToImage()">Export to Image</button-->
	<button type="button" class="btn btn-default btn-lg" id="buttonRefresh" onclick="window.location.reload(true)">
		<span class="glyphicon glyphicon-repeat" aria-hidden="true"></span> Refresh
	</button>
	<button type="button" class="btn btn-default btn-lg" id="buttonExportImage" onclick="exportToImage()">
		<span class="glyphicon glyphicon glyphicon-export" aria-hidden="true"></span> Export As Image
	</button>	
<div class="panel panel-default" id="panel">
	<div class="panel-heading">
		<h3 class="panel-title" id="panelTitle"><?php echo $_POST['slctIndvNo']." Individuals ".$recordSelectCategoryInfo[0]['categories']; echo " => ".$_POST['txtBoxArrowNo']."Arrows"; ?></h3>
	</div>
	<div class="panel-body">
		<div id="bracket"></div>
		<div id="bracketCSS" style="font-family: sans-serif;">
			<main>
				<?php if($totalNoIndv<=64 && $totalNoIndv>0) { ?>
					<ul id="top64" title="Top 64" style="display:<?php echo (($totalNoIndv <= 32) ?"none" :""); ?>;">
						<li>&nbsp;</li>
					<!-- ROUND 1: PART 1 START -->
					<div style="visibility:<?php echo (empty($arrayArcherInfoTest[1]['archer_no']) || empty($arrayArcherInfoTest[64]['archer_no']) ? "hidden" :" visible")?>;">	
						<li class="game game-top winner"><?php echo $arrayArcherInfoTest[1]['archer_no']; ?><span></span></li>
						<li>&nbsp;</li>
						<li class="game game-bottom"><?php echo $arrayArcherInfoTest[64]['archer_no']; ?><span></span></li>
						<!--li>&nbsp;</li-->
					</div>
					<li>&nbsp;</li> 
					<div style="visibility:<?php echo (empty($arrayArcherInfoTest[32]['archer_no']) || empty($arrayArcherInfoTest[33]['archer_no']) ? "hidden" : "visible")?>;">	
						<li class="game game-top winner"><?php echo $arrayArcherInfoTest[32]['archer_no']; ?><span></span></li>
						<li>&nbsp;</li>
						<li class="game game-bottom"><?php echo $arrayArcherInfoTest[33]['archer_no']; ?><span></span></li>
					</div>
					<li>&nbsp;</li>
					<div style="visibility:<?php echo (empty($arrayArcherInfoTest[17]['archer_no']) || empty($arrayArcherInfoTest[48]['archer_no']) ? "hidden" : "visible");?>;">
						<li class="game game-top winner"><?php echo $arrayArcherInfoTest[17]['archer_no']; ?><span></span></li>
						<li>&nbsp;</li>
						<li class="game game-bottom "><?php echo $arrayArcherInfoTest[48]['archer_no']; ?><span></span></li>
					</div>
					<li>&nbsp;</li>
					<div style="visibility:<?php echo (empty($arrayArcherInfoTest[16]['archer_no']) || empty($arrayArcherInfoTest[49]['archer_no']) ? "hidden" : "visible");?>;">
						<li class="game game-top winner"><?php echo $arrayArcherInfoTest[16]['archer_no']; ?><span></span></li>
						<li>&nbsp;</li>
						<li class="game game-bottom "><?php echo $arrayArcherInfoTest[49]['archer_no']; ?><span></span></li>
					</div>
					<li>&nbsp;</li>
					<div style="visibility:<?php echo (empty($arrayArcherInfoTest[9]['archer_no']) || empty($arrayArcherInfoTest[56]['archer_no']) ? "hidden" : "visible");?>;">
						<li class="game game-top winner"><?php echo $arrayArcherInfoTest[9]['archer_no']; ?><span></span></li>
						<li>&nbsp;</li>
						<li class="game game-bottom "><?php echo $arrayArcherInfoTest[56]['archer_no']; ?><span></span></li>
					</div>
					<li>&nbsp;</li>
					<div style="visibility:<?php echo (empty($arrayArcherInfoTest[24]['archer_no']) || empty($arrayArcherInfoTest[41]['archer_no']) ? "hidden" : "visible");?>;">
						<li class="game game-top winner"><?php echo $arrayArcherInfoTest[24]['archer_no']; ?><span></span></li>
						<li>&nbsp;</li>
						<li class="game game-bottom "><?php echo $arrayArcherInfoTest[41]['archer_no']; ?><span></span></li>
					</div>
					<li>&nbsp;</li>
					<div style="visibility:<?php echo (empty($arrayArcherInfoTest[25]['archer_no']) || empty($arrayArcherInfoTest[40]['archer_no']) ? "hidden" : "visible");?>;">
						<li class="game game-top winner"><?php echo $arrayArcherInfoTest[25]['archer_no']; ?><span></span></li>
						<li>&nbsp;</li>
						<li class="game game-bottom "><?php echo $arrayArcherInfoTest[40]['archer_no']; ?><span></span></li>
					</div>
					<li>&nbsp;</li>
					<div style="visibility:<?php echo (empty($arrayArcherInfoTest[8]['archer_no']) || empty($arrayArcherInfoTest[57]['archer_no']) ? "hidden" : "visible");?>;">	
						<li class="game game-top winner"><?php echo $arrayArcherInfoTest[8]['archer_no']; ?><span></span></li>
						<li>&nbsp;</li>
						<li class="game game-bottom "><?php echo $arrayArcherInfoTest[57]['archer_no']; ?><span></span></li>
					</div>
						<li>&nbsp;</li>				
					<!-- ROUND 1: PART 1 END -->
					<!-- ROUND 1: PART 4 START -->
					<div style="visibility:<?php echo (empty($arrayArcherInfoTest[4]['archer_no']) || empty($arrayArcherInfoTest[61]['archer_no']) ? "hidden" :" visible")?>;">	
						<li class="game game-top winner"><?php echo $arrayArcherInfoTest[4]['archer_no']; ?><span></span></li>
						<li>&nbsp;</li>
						<li class="game game-bottom "><?php echo $arrayArcherInfoTest[61]['archer_no'];?><span></span></li>
						<!--li>&nbsp;</li-->
					</div>
					<li>&nbsp;</li> <!--SPECIAL CASE -->
					<div style="visibility:<?php echo (empty($arrayArcherInfoTest[29]['archer_no']) || empty($arrayArcherInfoTest[36]['archer_no']) ? "hidden" : "visible")?>;">	
						<li class="game game-top winner"><?php echo $arrayArcherInfoTest[29]['archer_no']; ?><span></span></li>
						<li>&nbsp;</li>
						<li class="game game-bottom "><?php echo $arrayArcherInfoTest[36]['archer_no']; ?><span></span></li>
					</div>
					<li>&nbsp;</li>
					<div style="visibility:<?php echo (empty($arrayArcherInfoTest[20]['archer_no']) || empty($arrayArcherInfoTest[45]['archer_no']) ? "hidden" : "visible");?>;">
						<li class="game game-top winner"><?php echo $arrayArcherInfoTest[20]['archer_no']; ?><span></span></li>
						<li>&nbsp;</li>
						<li class="game game-bottom "><?php echo $arrayArcherInfoTest[45]['archer_no']; ?><span></span></li>
					</div>
					<li>&nbsp;</li>
					<div style="visibility:<?php echo (empty($arrayArcherInfoTest[13]['archer_no']) || empty($arrayArcherInfoTest[52]['archer_no']) ? "hidden" : "visible");?>;">
						<li class="game game-top winner"><?php echo $arrayArcherInfoTest[13]['archer_no']; ?><span></span></li>
						<li>&nbsp;</li>
						<li class="game game-bottom "><?php echo $arrayArcherInfoTest[52]['archer_no']; ?><span></span></li>
					</div>
					<li>&nbsp;</li>
					<div style="visibility:<?php echo (empty($arrayArcherInfoTest[12]['archer_no']) || empty($arrayArcherInfoTest[53]['archer_no']) ? "hidden" : "visible");?>;">
						<li class="game game-top winner"><?php echo $arrayArcherInfoTest[12]['archer_no']; ?><span></span></li>
						<li>&nbsp;</li>
						<li class="game game-bottom "><?php echo $arrayArcherInfoTest[53]['archer_no']; ?><span></span></li>
					</div>
					<li>&nbsp;</li>
					<div style="visibility:<?php echo (empty($arrayArcherInfoTest[21]['archer_no']) || empty($arrayArcherInfoTest[44]['archer_no']) ? "hidden" : "visible");?>;">
						<li class="game game-top winner"><?php echo $arrayArcherInfoTest[21]['archer_no']; ?><span></span></li>
						<li>&nbsp;</li>
						<li class="game game-bottom "><?php echo $arrayArcherInfoTest[44]['archer_no']; ?><span></span></li>
					</div>
					<li>&nbsp;</li>
					<div style="visibility:<?php echo (empty($arrayArcherInfoTest[28]['archer_no']) || empty($arrayArcherInfoTest[37]['archer_no']) ? "hidden" : "visible");?>;">
						<li class="game game-top winner"><?php echo $arrayArcherInfoTest[28]['archer_no']; ?><span></span></li>
						<li>&nbsp;</li>
						<li class="game game-bottom "><?php echo $arrayArcherInfoTest[37]['archer_no']; ?><span></span></li>
					</div>
					<li>&nbsp;</li>
					<div style="visibility:<?php echo (empty($arrayArcherInfoTest[5]['archer_no']) || empty($arrayArcherInfoTest[60]['archer_no']) ? "hidden" : "visible");?>;">	
						<li class="game game-top winner"><?php echo $arrayArcherInfoTest[5]['archer_no']; ?><span></span></li>
						<li>&nbsp;</li>
						<li class="game game-bottom "><?php echo $arrayArcherInfoTest[60]['archer_no']; ?><span></span></li>
					</div>
						<li>&nbsp;</li>				
					<!-- ROUND 1: PART 4 END -->
					<!-- ROUND 1: PART 2 START -->
					<div style="visibility:<?php echo (empty($arrayArcherInfoTest[2]['archer_no']) || empty($arrayArcherInfoTest[63]['archer_no']) ? "hidden" :" visible")?>;">	
						<li class="game game-top winner"><?php echo $arrayArcherInfoTest[2]['archer_no']; ?><span></span></li>
						<li>&nbsp;</li>
						<li class="game game-bottom "><?php echo $arrayArcherInfoTest[63]['archer_no'];?><span></span></li>
					</div>
					<li>&nbsp;</li>
					<div style="visibility:<?php echo (empty($arrayArcherInfoTest[31]['archer_no']) || empty($arrayArcherInfoTest[34]['archer_no']) ? "hidden" : "visible")?>;">	
						<li class="game game-top winner"><?php echo $arrayArcherInfoTest[31]['archer_no']; ?><span></span></li>
						<li>&nbsp;</li>
						<li class="game game-bottom "><?php echo $arrayArcherInfoTest[34]['archer_no']; ?><span></span></li>
					</div>
					<li>&nbsp;</li>
					<div style="visibility:<?php echo (empty($arrayArcherInfoTest[18]['archer_no']) || empty($arrayArcherInfoTest[47]['archer_no']) ? "hidden" : "visible");?>;">
						<li class="game game-top winner"><?php echo $arrayArcherInfoTest[18]['archer_no']; ?><span></span></li>
						<li>&nbsp;</li>
						<li class="game game-bottom "><?php echo $arrayArcherInfoTest[47]['archer_no']; ?><span></span></li>
					</div>
					<li>&nbsp;</li>
					<div style="visibility:<?php echo (empty($arrayArcherInfoTest[15]['archer_no']) || empty($arrayArcherInfoTest[50]['archer_no']) ? "hidden" : "visible");?>;">
						<li class="game game-top winner"><?php echo $arrayArcherInfoTest[15]['archer_no']; ?><span></span></li>
						<li>&nbsp;</li>
						<li class="game game-bottom "><?php echo $arrayArcherInfoTest[50]['archer_no']; ?><span></span></li>
					</div>
					<li>&nbsp;</li>
					<div style="visibility:<?php echo (empty($arrayArcherInfoTest[10]['archer_no']) || empty($arrayArcherInfoTest[55]['archer_no']) ? "hidden" : "visible");?>;">
						<li class="game game-top winner"><?php echo $arrayArcherInfoTest[10]['archer_no']; ?><span></span></li>
						<li>&nbsp;</li>
						<li class="game game-bottom "><?php echo $arrayArcherInfoTest[55]['archer_no']; ?><span></span></li>
					</div>
					<li>&nbsp;</li>
					<div style="visibility:<?php echo (empty($arrayArcherInfoTest[23]['archer_no']) || empty($arrayArcherInfoTest[42]['archer_no']) ? "hidden" : "visible");?>;">
						<li class="game game-top winner"><?php echo $arrayArcherInfoTest[23]['archer_no']; ?><span></span></li>
						<li>&nbsp;</li>
						<li class="game game-bottom "><?php echo $arrayArcherInfoTest[42]['archer_no']; ?><span></span></li>
					</div>
					<li>&nbsp;</li>
					<div style="visibility:<?php echo (empty($arrayArcherInfoTest[26]['archer_no']) || empty($arrayArcherInfoTest[39]['archer_no']) ? "hidden" : "visible");?>;">
						<li class="game game-top winner"><?php echo $arrayArcherInfoTest[26]['archer_no']; ?><span></span></li>
						<li>&nbsp;</li>
						<li class="game game-bottom "><?php echo $arrayArcherInfoTest[39]['archer_no']; ?><span></span></li>
					</div>
					<li>&nbsp;</li>
					<div style="visibility:<?php echo (empty($arrayArcherInfoTest[7]['archer_no']) || empty($arrayArcherInfoTest[58]['archer_no']) ? "hidden" : "visible");?>;">	
						<li class="game game-top winner"><?php echo $arrayArcherInfoTest[7]['archer_no']; ?><span></span></li>
						<li>&nbsp;</li>
						<li class="game game-bottom "><?php echo $arrayArcherInfoTest[58]['archer_no']; ?><span></span></li>
					</div>
						<li>&nbsp;</li>					
					<!-- ROUND 1: PART 2 END -->
					<!-- ROUND 1: PART 3 START -->
					<div style="visibility:<?php echo (empty($arrayArcherInfoTest[3]['archer_no']) || empty($arrayArcherInfoTest[62]['archer_no']) ? "hidden" :" visible")?>;">	
						<li class="game game-top winner"><?php echo $arrayArcherInfoTest[3]['archer_no']; ?><span></span></li>
						<li>&nbsp;</li>
						<li class="game game-bottom "><?php echo $arrayArcherInfoTest[62]['archer_no'];?><span></span></li>
					</div>
					<li>&nbsp;</li>
					<div style="visibility:<?php echo (empty($arrayArcherInfoTest[30]['archer_no']) || empty($arrayArcherInfoTest[35]['archer_no']) ? "hidden" : "visible")?>;">	
						<li class="game game-top winner"><?php echo $arrayArcherInfoTest[30]['archer_no']; ?><span></span></li>
						<li>&nbsp;</li>
						<li class="game game-bottom "><?php echo $arrayArcherInfoTest[35]['archer_no']; ?><span></span></li>
					</div>
					<li>&nbsp;</li>
					<div style="visibility:<?php echo (empty($arrayArcherInfoTest[19]['archer_no']) || empty($arrayArcherInfoTest[46]['archer_no']) ? "hidden" : "visible");?>;">
						<li class="game game-top winner"><?php echo $arrayArcherInfoTest[19]['archer_no']; ?><span></span></li>
						<li>&nbsp;</li>
						<li class="game game-bottom "><?php echo $arrayArcherInfoTest[46]['archer_no']; ?><span></span></li>
					</div>
					<li>&nbsp;</li>
					<div style="visibility:<?php echo (empty($arrayArcherInfoTest[14]['archer_no']) || empty($arrayArcherInfoTest[51]['archer_no']) ? "hidden" : "visible");?>;">
						<li class="game game-top winner"><?php echo $arrayArcherInfoTest[14]['archer_no']; ?><span></span></li>
						<li>&nbsp;</li>
						<li class="game game-bottom "><?php echo $arrayArcherInfoTest[51]['archer_no']; ?><span></span></li>
					</div>
					<li>&nbsp;</li>
					<div style="visibility:<?php echo (empty($arrayArcherInfoTest[11]['archer_no']) || empty($arrayArcherInfoTest[54]['archer_no']) ? "hidden" : "visible");?>;">
						<li class="game game-top winner"><?php echo $arrayArcherInfoTest[11]['archer_no']; ?><span></span></li>
						<li>&nbsp;</li>
						<li class="game game-bottom "><?php echo $arrayArcherInfoTest[54]['archer_no']; ?><span></span></li>
					</div>
					<li>&nbsp;</li>
					<div style="visibility:<?php echo (empty($arrayArcherInfoTest[22]['archer_no']) || empty($arrayArcherInfoTest[43]['archer_no']) ? "hidden" : "visible");?>;">
						<li class="game game-top winner"><?php echo $arrayArcherInfoTest[22]['archer_no']; ?><span></span></li>
						<li>&nbsp;</li>
						<li class="game game-bottom "><?php echo $arrayArcherInfoTest[43]['archer_no']; ?><span></span></li>
					</div>
					<li>&nbsp;</li>
					<div style="visibility:<?php echo (empty($arrayArcherInfoTest[27]['archer_no']) || empty($arrayArcherInfoTest[38]['archer_no']) ? "hidden" : "visible");?>;">
						<li class="game game-top winner"><?php echo $arrayArcherInfoTest[27]['archer_no']; ?><span></span></li>
						<li>&nbsp;</li>
						<li class="game game-bottom "><?php echo $arrayArcherInfoTest[38]['archer_no']; ?><span></span></li>
					</div>
					<li>&nbsp;</li>
					<div style="visibility:<?php echo (empty($arrayArcherInfoTest[6]['archer_no']) || empty($arrayArcherInfoTest[59]['archer_no']) ? "hidden" : "visible");?>;">	
						<li class="game game-top winner"><?php echo $arrayArcherInfoTest[6]['archer_no']; ?><span></span></li>
						<li>&nbsp;</li>
						<li class="game game-bottom "><?php echo $arrayArcherInfoTest[59]['archer_no']; ?><span></span></li>
					</div>					
					<!-- ROUND 1: PART 3 END -->	
						<li>&nbsp;</li>
					</ul>
					
					<ul id="top32" title="Top 32" style="display:<?php echo (($totalNoIndv <= 16) ?"none" :""); ?>;">
						<li style="flex-grow: .5;">&nbsp;</li>
					<!-- ROUND 2: PART 1 START -->
						<li class="game game-top winner"><?php echo (!empty($arrayArcherInfoTest[1]['archer_no']) && empty($arrayArcherInfoTest[64]['archer_no']) ? $arrayArcherInfoTest[1]['archer_no'] : "No archer");?><span>Loading</span></li>
						<li>&nbsp;</li>
						<li class="game game-bottom "><?php echo (!empty($arrayArcherInfoTest[32]['archer_no']) && empty($arrayArcherInfoTest[33]['archer_no']) ? $arrayArcherInfoTest[32]['archer_no'] : "No archer");?><span>Loading</span></li>
						<li>&nbsp;</li>	
						
						<li class="game game-top winner"><?php echo (!empty($arrayArcherInfoTest[17]['archer_no']) && empty($arrayArcherInfoTest[48]['archer_no']) ? $arrayArcherInfoTest[17]['archer_no'] : "No archer");?><span>Loading</span></li>
						<li>&nbsp;</li>
						<li class="game game-bottom "><?php echo (!empty($arrayArcherInfoTest[16]['archer_no']) && empty($arrayArcherInfoTest[49]['archer_no']) ? $arrayArcherInfoTest[16]['archer_no'] : "No archer");?><span>Loading</span></li>
						<li>&nbsp;</li>
						
						<li class="game game-top winner"><?php echo (!empty($arrayArcherInfoTest[9]['archer_no']) && empty($arrayArcherInfoTest[56]['archer_no']) ? $arrayArcherInfoTest[9]['archer_no'] : "No archer");?><span>Loading</span></li>
						<li>&nbsp;</li>
						<li class="game game-bottom "><?php echo (!empty($arrayArcherInfoTest[24]['archer_no']) && empty($arrayArcherInfoTest[41]['archer_no']) ? $arrayArcherInfoTest[24]['archer_no'] : "No archer");?><span>Loading</span></li>
						<li>&nbsp;</li>
						
						<li class="game game-top winner"><?php echo (!empty($arrayArcherInfoTest[25]['archer_no']) && empty($arrayArcherInfoTest[40]['archer_no']) ? $arrayArcherInfoTest[25]['archer_no'] : "No archer");?><span>Loading </span></li>
						<li>&nbsp;</li>
						<li class="game game-bottom "><?php echo (!empty($arrayArcherInfoTest[8]['archer_no']) && empty($arrayArcherInfoTest[57]['archer_no']) ? $arrayArcherInfoTest[8]['archer_no'] : "No archer");?><span>Loading</span></li>
						<li style="flex-grow:1;">&nbsp;</li>
					<!-- ROUND 2: PART 1 END -->
					<!-- ROUND 2: PART 4 START -->
						<li class="game game-top winner"><?php echo (!empty($arrayArcherInfoTest[4]['archer_no']) && empty($arrayArcherInfoTest[61]['archer_no']) ? $arrayArcherInfoTest[4]['archer_no'] : "No archer");?><span>Loading</span></li>
						<li>&nbsp;</li>
						<li class="game game-bottom "><?php echo (!empty($arrayArcherInfoTest[29]['archer_no']) && empty($arrayArcherInfoTest[36]['archer_no']) ? $arrayArcherInfoTest[29]['archer_no'] : "No archer");?><span>Loading</span></li>
						<li style="">&nbsp;</li>	
						
						<li class="game game-top winner"><?php echo (!empty($arrayArcherInfoTest[20]['archer_no']) && empty($arrayArcherInfoTest[45]['archer_no']) ? $arrayArcherInfoTest[20]['archer_no'] : "No archer");?><span>Loading</span></li>
						<li>&nbsp;</li>
						<li class="game game-bottom "><?php echo (!empty($arrayArcherInfoTest[13]['archer_no']) && empty($arrayArcherInfoTest[52]['archer_no']) ? $arrayArcherInfoTest[13]['archer_no'] : "No archer");?><span>Loading</span></li>
						<li>&nbsp;</li>
						
						<li class="game game-top winner"><?php echo (!empty($arrayArcherInfoTest[12]['archer_no']) && empty($arrayArcherInfoTest[53]['archer_no']) ? $arrayArcherInfoTest[12]['archer_no'] : "No archer");?><span>Loading</span></li>
						<li>&nbsp;</li>
						<li class="game game-bottom "><?php echo (!empty($arrayArcherInfoTest[21]['archer_no']) && empty($arrayArcherInfoTest[44]['archer_no']) ? $arrayArcherInfoTest[21]['archer_no'] : "No archer");?><span>Loading</span></li>
						<li>&nbsp;</li>
						
						<li class="game game-top winner"><?php echo (!empty($arrayArcherInfoTest[28]['archer_no']) && empty($arrayArcherInfoTest[37]['archer_no']) ? $arrayArcherInfoTest[28]['archer_no'] : "No archer");?><span>Loading </span></li>
						<li>&nbsp;</li>
						<li class="game game-bottom "><?php echo (!empty($arrayArcherInfoTest[5]['archer_no']) && empty($arrayArcherInfoTest[60]['archer_no']) ? $arrayArcherInfoTest[5]['archer_no'] : "No archer");?><span>Loading</span></li>
						<li style="flex-grow:1;">&nbsp;</li>
					<!-- ROUND 2: PART 4 END -->					
					<!-- ROUND 2: PART 2 START -->
						<li class="game game-top winner"><?php echo (!empty($arrayArcherInfoTest[2]['archer_no']) && empty($arrayArcherInfoTest[63]['archer_no']) ? $arrayArcherInfoTest[2]['archer_no'] : "No archer");?><span>Loading</span></li>
						<li>&nbsp;</li>
						<li class="game game-bottom "><?php echo (!empty($arrayArcherInfoTest[31]['archer_no']) && empty($arrayArcherInfoTest[34]['archer_no']) ? $arrayArcherInfoTest[31]['archer_no'] : "No archer");?><span>Loading</span></li>
						<li>&nbsp;</li>	
						
						<li class="game game-top winner"><?php echo (!empty($arrayArcherInfoTest[18]['archer_no']) && empty($arrayArcherInfoTest[47]['archer_no']) ? $arrayArcherInfoTest[18]['archer_no'] : "No archer");?><span>Loading</span></li>
						<li>&nbsp;</li>
						<li class="game game-bottom "><?php echo (!empty($arrayArcherInfoTest[15]['archer_no']) && empty($arrayArcherInfoTest[50]['archer_no']) ? $arrayArcherInfoTest[15]['archer_no'] : "No archer");?><span>Loading</span></li>
						<li>&nbsp;</li>
						
						<li class="game game-top winner"><?php echo (!empty($arrayArcherInfoTest[10]['archer_no']) && empty($arrayArcherInfoTest[55]['archer_no']) ? $arrayArcherInfoTest[10]['archer_no'] : "No archer");?><span>Loading</span></li>
						<li>&nbsp;</li>
						<li class="game game-bottom "><?php echo (!empty($arrayArcherInfoTest[23]['archer_no']) && empty($arrayArcherInfoTest[42]['archer_no']) ? $arrayArcherInfoTest[23]['archer_no'] : "No archer");?><span>Loading</span></li>
						<li>&nbsp;</li>
						
						<li class="game game-top winner"><?php echo (!empty($arrayArcherInfoTest[26]['archer_no']) && empty($arrayArcherInfoTest[39]['archer_no']) ? $arrayArcherInfoTest[26]['archer_no'] : "No archer");?><span>Loading </span></li>
						<li>&nbsp;</li>
						<li class="game game-bottom "><?php echo (!empty($arrayArcherInfoTest[7]['archer_no']) && empty($arrayArcherInfoTest[58]['archer_no']) ? $arrayArcherInfoTest[7]['archer_no'] : "No archer");?><span>Loading</span></li>
						<li style="flex-grow:1;">&nbsp;</li>
					<!-- ROUND 2: PART 2 END -->
					<!-- ROUND 2: PART 3 START -->
						<li class="game game-top winner"><?php echo (!empty($arrayArcherInfoTest[3]['archer_no']) && empty($arrayArcherInfoTest[62]['archer_no']) ? $arrayArcherInfoTest[3]['archer_no'] : "No archer");?><span>Loading</span></li>
						<li>&nbsp;</li>
						<li class="game game-bottom "><?php echo (!empty($arrayArcherInfoTest[30]['archer_no']) && empty($arrayArcherInfoTest[35]['archer_no']) ? $arrayArcherInfoTest[30]['archer_no'] : "No archer");?><span>Loading</span></li>
						<li style="">&nbsp;</li>	
						
						<li class="game game-top winner"><?php echo (!empty($arrayArcherInfoTest[19]['archer_no']) && empty($arrayArcherInfoTest[46]['archer_no']) ? $arrayArcherInfoTest[19]['archer_no'] : "No archer");?><span>Loading</span></li>
						<li>&nbsp;</li>
						<li class="game game-bottom "><?php echo (!empty($arrayArcherInfoTest[14]['archer_no']) && empty($arrayArcherInfoTest[51]['archer_no']) ? $arrayArcherInfoTest[14]['archer_no'] : "No archer");?><span>Loading</span></li>
						<li>&nbsp;</li>
						
						<li class="game game-top winner"><?php echo (!empty($arrayArcherInfoTest[11]['archer_no']) && empty($arrayArcherInfoTest[54]['archer_no']) ? $arrayArcherInfoTest[11]['archer_no'] : "No archer");?><span>Loading</span></li>
						<li>&nbsp;</li>
						<li class="game game-bottom "><?php echo (!empty($arrayArcherInfoTest[22]['archer_no']) && empty($arrayArcherInfoTest[43]['archer_no']) ? $arrayArcherInfoTest[22]['archer_no'] : "No archer");?><span>Loading</span></li>
						<li>&nbsp;</li>
						
						<li class="game game-top winner"><?php echo (!empty($arrayArcherInfoTest[27]['archer_no']) && empty($arrayArcherInfoTest[38]['archer_no']) ? $arrayArcherInfoTest[27]['archer_no'] : "No archer");?><span>Loading </span></li>
						<li>&nbsp;</li>
						<li class="game game-bottom "><?php echo (!empty($arrayArcherInfoTest[6]['archer_no']) && empty($arrayArcherInfoTest[59]['archer_no']) ? $arrayArcherInfoTest[6]['archer_no'] : "No archer");?><span>Loading</span></li>
						<li>&nbsp;</li>
					<!-- ROUND 2: PART 3 END -->
					</ul>
					
					<ul id="top16" title="Top 16">
						<li>&nbsp;</li>
						<li class="game game-top winner"><?php echo (!empty($arrayArcherInfoTest[1]['archer_no']) && empty($arrayArcherInfoTest[32]['archer_no']) ? $arrayArcherInfoTest[1]['archer_no'] : "Loading... ");?><span>Loading...</span></li>
						<li>&nbsp;</li>
						<li class="game game-bottom "><?php echo (!empty($arrayArcherInfoTest[16]['archer_no']) && empty($arrayArcherInfoTest[17]['archer_no']) ? $arrayArcherInfoTest[16]['archer_no'] : "Loading... ");?><span>Loading...</span></li>
						<li>&nbsp;</li>				
						<li class="game game-top winner"><?php echo (!empty($arrayArcherInfoTest[9]['archer_no']) && empty($arrayArcherInfoTest[24]['archer_no']) ? $arrayArcherInfoTest[9]['archer_no'] : "Loading... ");?><span>Loading...</span></li>
						<li>&nbsp;</li>
						<li class="game game-bottom "><?php echo (!empty($arrayArcherInfoTest[8]['archer_no']) && empty($arrayArcherInfoTest[25]['archer_no']) ? $arrayArcherInfoTest[8]['archer_no'] : "Loading... ");?><span>Loading...</span></li>
						<li>&nbsp;</li>
						<li class="game game-top winner"><?php echo (!empty($arrayArcherInfoTest[4]['archer_no']) && empty($arrayArcherInfoTest[29]['archer_no']) ? $arrayArcherInfoTest[4]['archer_no'] : "Loading... ");?><span>Loading...</span></li>
						<li>&nbsp;</li>
						<li class="game game-bottom "><?php echo (!empty($arrayArcherInfoTest[13]['archer_no']) && empty($arrayArcherInfoTest[20]['archer_no']) ? $arrayArcherInfoTest[13]['archer_no'] : "Loading... ");?><span>Loading...</span></li>
						<li>&nbsp;</li>				
						<li class="game game-top winner"><?php echo (!empty($arrayArcherInfoTest[12]['archer_no']) && empty($arrayArcherInfoTest[21]['archer_no']) ? $arrayArcherInfoTest[12]['archer_no'] : "Loading... ");?><span>Loading...</span></li>
						<li>&nbsp;</li>
						<li class="game game-bottom "><?php echo (!empty($arrayArcherInfoTest[5]['archer_no']) && empty($arrayArcherInfoTest[28]['archer_no']) ? $arrayArcherInfoTest[5]['archer_no'] : "Loading... ");?><span>Loading...</span></li>
						<li>&nbsp;</li>				
						<li class="game game-top winner"><?php echo (!empty($arrayArcherInfoTest[2]['archer_no']) && empty($arrayArcherInfoTest[31]['archer_no']) ? $arrayArcherInfoTest[2]['archer_no'] : "Loading... ");?><span>Loading...</span></li>
						<li>&nbsp;</li>
						<li class="game game-bottom "><?php echo (!empty($arrayArcherInfoTest[15]['archer_no']) && empty($arrayArcherInfoTest[18]['archer_no']) ? $arrayArcherInfoTest[15]['archer_no'] : "Loading... ");?><span>Loading...</span></li>
						<li>&nbsp;</li>				
						<li class="game game-top winner"><?php echo (!empty($arrayArcherInfoTest[10]['archer_no']) && empty($arrayArcherInfoTest[23]['archer_no']) ? $arrayArcherInfoTest[10]['archer_no'] : "Loading... ");?><span>Loading...</span></li>
						<li>&nbsp;</li>
						<li class="game game-bottom "><?php echo (!empty($arrayArcherInfoTest[7]['archer_no']) && empty($arrayArcherInfoTest[26]['archer_no']) ? $arrayArcherInfoTest[7]['archer_no'] : "Loading... ");?><span>Loading...</span></li>
						<li>&nbsp;</li>				
						<li class="game game-top winner"><?php echo (!empty($arrayArcherInfoTest[3]['archer_no']) && empty($arrayArcherInfoTest[30]['archer_no']) ? $arrayArcherInfoTest[3]['archer_no'] : "Loading... ");?><span>Loading...</span></li>
						<li>&nbsp;</li>
						<li class="game game-bottom "><?php echo (!empty($arrayArcherInfoTest[14]['archer_no']) && empty($arrayArcherInfoTest[19]['archer_no']) ? $arrayArcherInfoTest[14]['archer_no'] : "Loading... ");?><span>Loading...</span></li>
						<li>&nbsp;</li>				
						<li class="game game-top winner"><?php echo (!empty($arrayArcherInfoTest[11]['archer_no']) && empty($arrayArcherInfoTest[22]['archer_no']) ? $arrayArcherInfoTest[11]['archer_no'] : "Loading... ");?><span>Loading...</span></li>
						<li>&nbsp;</li>
						<li class="game game-bottom "><?php echo (!empty($arrayArcherInfoTest[6]['archer_no']) && empty($arrayArcherInfoTest[27]['archer_no']) ? $arrayArcherInfoTest[6]['archer_no'] : "Loading... ");?><span>Loading...</span></li>
						<li>&nbsp;</li>				
					</ul>
					
					<ul id="top8" title="Top 8">
						<li>&nbsp;</li>
						<li class="game game-top winner">Loading... <span>Loading...</span></li>		
						<li>&nbsp;</li>
						<li class="game game-bottom">Loading... <span>Loading...</span></li>	
						<li>&nbsp;</li>	
						<li class="game game-top winner">Loading... <span>Loading...</span></li>		
						<li>&nbsp;</li>
						<li class="game game-bottom">Loading... <span>Loading...</span></li>	
						<li>&nbsp;</li>	
						<li class="game game-top winner">Loading... <span>Loading...</span></li>		
						<li>&nbsp;</li>
						<li class="game game-bottom">Loading... <span>Loading...</span></li>	
						<li>&nbsp;</li>	
						<li class="game game-top winner">Loading... <span>Loading...</span></li>		
						<li>&nbsp;</li>
						<li class="game game-bottom">Loading... <span>Loading...</span></li>	
						<li>&nbsp;</li>					
					</ul>
					
					<ul id="top4" title="Semi Final">
						<li>&nbsp;</li>
						<li class="game game-top winner">Loading... <span>Loading...</span></li>		
						<li>&nbsp;</li>
						<li class="game game-bottom">Loading... <span>Loading...</span></li>	
						<li>&nbsp;</li>	
						<li class="game game-top winner">Loading... <span>Loading...</span></li>		
						<li>&nbsp;</li>
						<li class="game game-bottom">Loading... <span>Loading...</span></li>	
						<li>&nbsp;</li>				
					</ul>	
					
					<ul id="top2" title="Final">
						<li>&nbsp;</li>
						<li class="game game-top winner">Loading... <span>Loading...</span></li>		
						<li>&nbsp;</li>
						<li class="game game-bottom">Loading... <span>Loading...</span></li>	
						<li>&nbsp;</li>				
					</ul>
					
					<ul id="top1" title="Champion">
						<li>&nbsp;</li>						
						<li class="finalWinner">Winner<span></span></li>	
						<li>&nbsp;</li>	
					</ul>					
				<?php } ?>
			</main>
			<div class="page-header">
				<h1><small>SECOND RUNNER-UP</small></h1>
			</div>
			<main>
				<ul id="top3" title="Bronze">
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
			<div class="game secondWinner">No Winner</div>
			<div class="page-header">
				<h1><small>CHAMPION</small></h1>
			</div>			
			<div class="game firstWinner">No Winner</div>
		</div>
		<!--div id="editor"></div>
		<button class="btn btn-primary" id="buttonGeneratePDF" onclick="exportToPDF()">Export to PDF</button-->
	</div>
</div>	
<div class="modal fade bs-example-modal-lg" id="modalAddScoreOR" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="modalTitleAddScoreOR">Individual OR Add Score</h4>
      </div>
	<div class="modal-body">
		<img id="loading-image" src="../images/ajax-loader.gif" style="display:none;"/>
		<form class="form-horizontal" method="POST">
			<div class="form-group">
				<label for="txtBoxArcherNo" class="col-sm-2 control-label">Archer No:</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" id="txtBoxArcherNo" name="txtBoxArcherNo" placeholder="" readonly="true" value="">
				</div>
			</div>
			<div class="form-group">
				<label for="txtBoxArcherName" class="col-sm-2 control-label">Archer Name:</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" id="txtBoxArcherName" name="txtBoxArcherName" placeholder="" readonly="true" value="">
				</div>
			</div>	
			<div class="form-group">
				<label for="txtBoxGender" class="col-sm-2 control-label">Gender:</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" id="txtBoxGender" name="txtBoxGender" placeholder="" readonly="true" value="">
				</div>
			</div>
			<div class="form-group">
				<label for="txtBoxCat" class="col-sm-2 control-label">Category:</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" id="txtBoxCat" name="txtBoxCat" placeholder="" readonly="true" value="">
				</div>
			</div>
			<div class="form-group">
				<label for="txtBoxTeam" class="col-sm-2 control-label">Team:</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" id="txtBoxTeam" name="txtBoxTeam" placeholder="" readonly="true" value="">
				</div>
			</div>
			
				<?php //echo json_encode($_GET['term']);
					$stmtSelect = $db->prepare("SELECT * FROM category WHERE range_Id = :bracketCategory");
					$stmtSelect->execute(array(':bracketCategory'=>$_POST['slctCat']));
					$recordSetCategory = $stmtSelect->fetchAll(PDO::FETCH_ASSOC);
					
					$cntRow = $stmtSelect -> rowCount();
				
				?>
			<div class="form-group">
				<label for="slctCat" class="col-sm-2 control-label">Range Category:</label>
				<div class="col-sm-8">
					<select class="form-control" id="slctCat" name="slctCat" <?php echo (isset($_POST['btnSubmit']) ? "disabled" : "disabled"); ?> >
						<?php foreach ($recordSetCategory as $rowCat) {   ?>
						<option value="<?php echo $rowCat['range_Id']; ?>" selected>
							<?php echo $rowCat['range']."-".$rowCat['categories']; ?>
						</option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="slctRoundNo" class="col-sm-2 control-label">Round Number:</label>
				<div class="col-sm-8">
					<select class="form-control" id="slctRoundNo" name="slctRoundNo" <?php echo ( isset($_POST['btnSubmit'])? "disabled" : "disabled"); ?> >
						<?php for($index=64;$index>=2;$index/=2) { ?>
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
		   $cntArrow = $_POST['txtBoxArrowNo'];
           $colForm = 6;
		   $colNumPerRow = 6;
           $startCol = 1;
        ?>		
		<form method="POST" action="" id="frmAddScoreOR" name="frmAddScoreOR" class="form-horizontal">
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-8">
					<table class="table table-bordered table-condensed table-striped" border="0.1">
						<?php 
						$isNewData = 1;
						for($u=0;$u<$cntArrow;) 
						{ 
							
						?>
						<tr style="">
							<?php while($startCol <= $colForm && $u<$cntArrow)
								  { 
							?>
							<td style="font-weight:600; text-align:center;">Arrow-<?php echo $startCol; ?></td>
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
//							echo "top: ".$u."/".$startCol;
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
//							echo "bottom: ".$u."/".$startCol;
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
								<div id="totalScore" style="font-weight:bold;"></div>
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
		<button type="submit" class="btn btn-primary" id="btnSubmitScoreOR" name="btnSubmitScoreOR" >Add Score</button>
		<button type="button" class="btn btn-default" id="btnCancelScoreOR" data-dismiss="modal">Cancel</button>
		<!--input type="submit" class="btn btn-primary" id="btnSubmitScoreOR" name="btnSubmitScoreOR" value="Add Score"-->	
	</div>
	</form>		  
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</body>

</html>