<?php

require_once "db.php";

require_once "header.php";

//access control
if (!isset($_SESSION['fandlname'])) {
    header("Location:../index.php");
}
else if($_GET['show']!='sent'){
    header("Location:../index.php?show=inbox");
}
else if($_GET['show']=='sent'){

?>
<!-- Read from the DB table and display all emails in the sent view -->
<main id="sent_main">
    <?php
    if(!isset($_GET['mailID'])){
    ?>
    <h4>Sent emails</h4>
    <table id="sent-data">
    <tr>
		<th width='200px'>SENT TO</th>
		<th width='500px'>EMAIL SUBJECT</th>
		<th width='300px'>RECEIVED</th>
	</tr>
    <?php
        $Findemail = "SELECT * FROM j_mail WHERE j_mail_sender_fullname	 = '{$_SESSION['fandlname']}' AND j_mail_draft ='0'";
        $Data = $conn->query($Findemail);
        if($Data->num_rows>0){
            while($rows = $Data->fetch_assoc()){
    ?>
                <tr>
                    <td><?php echo $rows['j_mail_recipient_fullname']?></td>
                    <td><a href="index.php?show=sent&&mailID=<?php echo $rows['j_mail_id']?>"><?php echo $rows['j_mail_subject'] ?></a></td>
                    <td><?php echo $rows['j_mail_date'] ?></td>
                <tr>
    <?php              
            }
        }
    ?>
    </table>

    <!-- Read from the table and display all emails in the draft view -->
    <h4>Draft/saved emails</h4>
    <table id="draft-data">
    <tr>
		<th width='200px'>SENT TO</th>
		<th width='500px'>EMAIL SUBJECT</th>
		<th width='300px'>RECEIVED</th>
	</tr>
    <?php
        $Findemail = "SELECT * FROM j_mail WHERE j_mail_sender_fullname	 = '{$_SESSION['fandlname']}' AND j_mail_draft ='1'";
        $Data = $conn->query($Findemail);
        if($Data->num_rows>0){
            while($rows = $Data->fetch_assoc()){
    ?>
                <tr>
                    <td><?php echo $rows['j_mail_recipient_fullname']?></td>
                    <td><a href="index.php?show=sent&&draft=true&&mailID=<?php echo $rows['j_mail_id']?>"><?php echo $rows['j_mail_subject'] ?></a></td>
                    <td><?php echo $rows['j_mail_date'] ?></td>
                <tr>
    <?php
            }
        }
    ?>
    </table>
    <?php
    }
    else if($_GET['draft']=='true'){//showing the draft/saved individual email
        $FindDraftDetail = "SELECT * FROM j_mail WHERE j_mail_id = '{$_GET['mailID']}'";
        $Data = $conn->query($FindDraftDetail);
        $row = $Data->fetch_assoc();
    ?>
        <h4>Draft/saved email</h4>
        <div id="detail-data">
            <label>To be send to: </label>
            <?php echo $row['j_mail_recipient_fullname'] ?>(<?php echo $row['j_mail_recipient_email'] ?>)<br>
            <br>
            <label>Email send on: </label>
            <?php echo $row['j_mail_date'] ?><br>
            <br>
            <label>Subject: </label>
            <a href="index.php?show=inbox&&draft=true&&mailID=<?php echo $row['j_mail_id']?>"><?php echo $row['j_mail_subject'] ?></a><br>
            <br>
            <br>
            <label>Email content: </label><br>
            <br>
            <?php echo $row['j_mail_text'] ?>
        </div>
    <?php
    }
    else{//showing the sent individual email
        $Findetail = "SELECT * FROM j_mail WHERE j_mail_id = '{$_GET['mailID']}'";
        $Data = $conn->query($Findetail);
        $row = $Data->fetch_assoc();
    ?>
        <h4>Sent email</h4>
        <div id="detail-data">
            <label>Send To: </label>
            <?php echo $row['j_mail_recipient_fullname'] ?>(<?php echo $row['j_mail_recipient_email'] ?>)<br>
            <br>
            <label>Email send on: </label>
            <?php echo $row['j_mail_date'] ?><br>
            <br>
            <label>Subject: </label>
            <a href="index.php?show=inbox&&mailID=<?php echo $row['j_mail_id']?>"><?php echo $row['j_mail_subject'] ?></a><br>
            <br>
            <br>
            <label>Email content: </label><br>
            <br>
            <?php echo $row['j_mail_text'] ?>
        </div>
    <?php
    }
    ?>
</main>
<?php
require_once "footer.php";
}
?>