<?php

function sanitizeData($data) {
    $cleanData = trim($data);
    $cleanData = stripslashes($cleanData);
    $cleanData = htmlspecialchars($cleanData);
    return $cleanData;
}

//update email count
$countEmails=0;
$Findemail = "SELECT * FROM j_mail WHERE j_mail_recipient_fullname = '{$_SESSION['fname']}' OR j_mail_recipient_fullname ='{$_SESSION['fandlname']}'";
$Data = $conn->query($Findemail);
    if($Data->num_rows>0){
        while($rows = $Data->fetch_assoc()){
            $countEmails++;
        }
    }
$_SESSION['count']= $countEmails;
?>