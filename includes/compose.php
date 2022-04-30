<?php

require_once "db.php";

require_once "header.php";

require_once "functions.php";

//access control
if (!isset($_SESSION['fandlname'])) {
    header("Location:../index.php");
}
else if($_GET['show']!='compose'){
    header("Location:../index.php?show=inbox");
}
else if($_GET['show']=='compose'){

?>

<!-- send email or draft email form -->
<main id="compose_main">
    <h4>Compose a new email</h4>
    <form id="compose_form" action="index.php?show=compose" method="post">
        <div id="fullname">
            <label>Recipient full name:</label>
            <input type="text" id ="Recipient-full-name" required="required" name="recipientname">
        </div>
        <div id="email">
            <label>Recipient email:</label>
            <input type="text" id ="Recipient-email" required="required" name="emailaddress">
        </div>
		<div id="subject">
		    <label>Email subject:</label>
		    <input type="text" id ="subject-sentence" required="required" name="subject-input">
		</div>
        <div id="content">
		    <label>Email text content:</label>
            <textarea id="textarea" required="required" name="content"></textarea>
		</div>
        <div id="compose-sub">
		    <input type="submit" id ="send" name="sendemail" value="Send email">
            <input type="submit" id ="save" name="savedraft" value="Save Draft">
            <input type="reset" id ="clear-content" name="clear" value="Clear content">
        </div>
    </form>

<!-- sanitize data and update data to database -->
<?php
    $RecipientName = sanitizeData($_POST['recipientname']);
    $RecipientEmail = sanitizeData($_POST['emailaddress']);
    $EmailSubject = sanitizeData($_POST['subject-input']);
    $EmailContent =  sanitizeData($_POST['content']);

    if(!isset($_POST['savedraft'])){
        $SaveDraft='0';
    }
    else{
        $SaveDraft='1';
    }
    if(isset($_POST['savedraft']) || isset($_POST['sendemail'])){
        $SendDate = date('Y-m-d H:i:s');
        $insert = "INSERT INTO j_mail (j_mail_recipient_email, j_mail_recipient_fullname, j_mail_sender_email, j_mail_sender_fullname, j_mail_subject, j_mail_text, j_mail_date, j_mail_draft)
        VALUES ('{$RecipientEmail}','{$RecipientName}','{$_SESSION['username']}','{$_SESSION['fandlname']}','{$EmailSubject}','{$EmailContent}','{$SendDate}','{$SaveDraft}')";  
        $result = mysqli_query($conn, $insert) or die ('Error querying database.'. mysqli_error($conn));
        header("Location:index.php?show=inbox");
    }	
?>
</main>
<?php
require_once "footer.php";
}
?>