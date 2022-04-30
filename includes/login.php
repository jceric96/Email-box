<?php

require_once "db.php";

require_once "header.php";

require_once "functions.php";
?>

<!-- login form -->
<!-- two users:
1: rey@theforce.org
password: balance
2: yoda@theforce.org
password: doORdonotNOTRY -->
<main id="login_main">
    <h4>Login to JediMail</h4>
    <h5 id = "tip">*Wrong username or password. Please try again.</h5>
    <form id="login_form" action="index.php?loginerror=ture" method="post">
        <div id="email">
            <label>Your email:</label>
            <input type="text" id ="input-username" required="required" name="username">
        </div>
		<div id="pass">
		    <label>Your password:</label>
		    <input type="password" id ="input-password" required="required" name="password">
		</div>
		<!-- clear data or submit data-->
        <div id="sub">
		    <input type="submit" id ="submit-login" name="submit" value="Login">
            <input type="reset" id ="clear" name="clear" value="Clear">
        </div>
    </form>
</main>

<?php
	// verify whether the username and password match what is entered
	// and jump to index page
	if (isset($_POST['submit'])) {
		session_regenerate_id(true); //--> will destroy old session
		$_SESSION['username'] = sanitizeData($_POST['username']); //sanitize data	
		$checkUser = "SELECT * FROM j_login WHERE j_email ='{$_SESSION['username']}'";
		$Data = $conn->query($checkUser);
		$row = $Data->fetch_assoc();
		if($Data->num_rows>0 && password_verify( $_POST['password'],$row['j_password'])){
		// if($Data->num_rows>0){
            $FindName = "SELECT * FROM j_user WHERE j_user_id ='{$row['j_id']}'";
		    $Data = $conn->query($FindName);
		    $name = $Data->fetch_assoc();
			$_SESSION['fname']=$name['j_user_fname'];
			$_SESSION['fandlname']=$name['j_user_fname'].' '.$name['j_user_lname'];
			//count inbox
			$countEmails=0;
			$Findemail = "SELECT * FROM j_mail WHERE j_mail_recipient_fullname = '{$_SESSION['fname']}' OR j_mail_recipient_fullname ='{$_SESSION['fandlname']}'";
			$Data = $conn->query($Findemail);
			if($Data->num_rows>0){
				while($rows = $Data->fetch_assoc()){
					$countEmails++;
				}
			}
			$_SESSION['count']= $countEmails;
		 	header("Location:index.php?show=inbox");
		}
		else{//verify fail then display error message
			session_destroy();
?>
		<script>
			showError();
		</script>
<?php
		}
	}
	
require_once "footer.php";
?>