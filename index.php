<?php

require_once "includes/db.php";

require_once "includes/header.php";

require_once "includes/functions.php";

session_regenerate_id(true); //--> will destroy old session

//jump to login page if dose not login
if (!isset($_SESSION['fandlname'])) {

	require_once "includes/login.php";
}
else{
?>
	<!-- diplay navigation bars -->
	<nav class="primary-nav">
		<a href="index.php?show=inbox">Inbox(<?php echo $_SESSION['count'];?>)</a>
		<a href="index.php?show=sent" >Sent &amp; drafts</a>
		<a href="index.php?show=compose">Write new email</a>
		<a href= "includes/logout.php"><label id="welcome">Logged in as <?php echo $_SESSION['fandlname'];?> (logout)</label></a>
	</nav>
	<main id="homepg-main-content" class="pg-main-content">
		
		<?php
			//showing different page by navigation bar
			if(!isset($_GET['show'])){
				$_GET['show']='inbox';
				require_once "includes/inbox.php";
			}
			if($_GET['show'] =='inbox'){
			 	require_once "includes/inbox.php";
			}
			else if($_GET['show'] =='sent'){
				require_once "includes/sent.php";
			}
			else if($_GET['show'] =='compose'){
				require_once "includes/compose.php";
			}
		?>
	</main>

<?php
}
require_once "includes/footer.php";
?>