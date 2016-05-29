<?php
include '../Connections/wifiAtt.php';
if(isset($_POST))
{
    $cntArrow = $_POST['hidCntArrow'];
    $archerNo = $_POST['hidArchNo'];
    $catRange = $_POST['hidCatRange'];
    $isNewData = $_POST['hidIsNewData'];
    
    $affactedRpw = false;
    try
    {
        for($i=1; $i<=$cntArrow;$i++)
        {
            $strTxtBoxMark = "txtBoxMark-".$i;
            $arrowMark  = checkMark($_POST[$strTxtBoxMark]);
            $cntX = fnCntFreq($_POST[$strTxtBoxMark],"X");
            $cnt10 = fnCntFreq($_POST[$strTxtBoxMark], "10");
            $cnt9 = fnCntFreq($_POST[$strTxtBoxMark], "9");
            $cntM = fnCntFreq($_POST[$strTxtBoxMark], "M");
            
            if($isNewData == '1')
                $qryInsertMark = "Insert into scoring (archer_no, `range`,Nth_arrow, score, cntX, cnt10, cnt9, cntM) values (:archer_no, :range, :Nth_arrow, :score, :cntX, :cnt10, :cnt9, :cntM) "; 
            else
                $qryInsertMark = "Update scoring SET score =:score, cntX=:cntX, cnt10=:cnt10, cnt9=:cnt9, cntM=:cntM where archer_no = :archer_no and Nth_arrow = :Nth_arrow and `range` = :range ";

            $insertQry = $db->prepare($qryInsertMark);
            $insertQry->execute(array(':archer_no'=>$archerNo, ':range'=> $catRange, ':Nth_arrow' =>$i, ':score' =>$arrowMark, ':cntX'=>$cntX, ':cnt10'=>$cnt10, ':cnt9'=>$cnt9,':cntM'=>$cntM));
            
            if($insertQry->rowCount()>0)
                $affactedRpw = TRUE;
        }
    }
    catch (Exception $grr)
    {
        echo $grr->getMessage();
    }
    if($affactedRpw > 0)
    {
        header("Location: addScore.php");
    }
}

function checkMark($strMark)
{
    $mark = 0;
    if($strMark == null ||  $strMark == '' || $strMark == 'M' || $strMark == 'm')
        $mark = 0;
    else if(strtoupper($strMark) == 'X')
        $mark = 10;        
    else
        $mark = $strMark;
    
    return $mark;
}

function fnCntFreq($strMark,$toBeCompared)
{
    $cntX = 0;
    if(strtoupper($strMark) == $toBeCompared)
        $cntX = 1;
    
    return $cntX;
}
?>
