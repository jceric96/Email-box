<?php
require_once "db.php";

require_once "header.php";

//access control
if (!isset($_SESSION['fandlname'])) {
    header("Location:../index.php");
}else if($_GET['show']!='inbox'){
    header("Location:../index.php?show=inbox");
}
else if($_GET['show']=='inbox'){

?>

<!-- Read from the DB table and display all emails in the inbox view -->
<main id="inbox_main">
    <h4>Inbox</h4>
    <?php
    if(!isset($_GET['mailID'])){
    ?>
    <table id="inbox-data">
    <tr>
		<th width='200px'>FROM</th>
		<th width='500px'>EMAIL SUBJECT</th>
		<th width='300px'>RECEIVED</th>
	</tr>
    <?php
        $countEmails=0;
        // $Findemail = "SELECT * FROM j_mail WHERE j_mail_recipient_fullname = '{$_SESSION['fname']}' OR j_mail_recipient_fullname ='{$_SESSION['fandlname']}'";
        $Findemail = "SELECT * FROM j_mail WHERE j_mail_recipient_email = '{$_SESSION['username']}'";
        $Data = $conn->query($Findemail);
        if($Data->num_rows>0){
            while($rows = $Data->fetch_assoc()){
                $countEmails++;
    ?>
                <tr>
                    <td><?php echo $rows['j_mail_sender_fullname']?></td>
                    <td><a href="index.php?show=inbox&&mailID=<?php echo $rows['j_mail_id']?>"><?php echo $rows['j_mail_subject'] ?></a></td>
                    <td><?php echo $rows['j_mail_date'] ?></td>
                <tr>    
    <?php   
            }
        }
        $_SESSION['count']= $countEmails;
        ?>
        </table>
    <?php
    }
    else{//showing the individual email
        $Findetail = "SELECT * FROM j_mail WHERE j_mail_id = '{$_GET['mailID']}'";
        $Data = $conn->query($Findetail);
        $row = $Data->fetch_assoc();
    ?>
        <div id="detail-data">
            <label>Sender: </label>
            <?php echo $row['j_mail_sender_fullname'] ?>(<?php echo $row['j_mail_sender_email'] ?>)<br>
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