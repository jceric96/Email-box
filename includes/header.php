<?php
	/*
	 * CSCI 2170: Fall 2021, Assignment 4
	 * index.php - the main homepage file for this template
	 * Author: Raghav V. Sampangi (raghav@cs.dal.ca)
	 */
?>
<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>JediMail</title>

	<!-- Link to the CSS reset file, Normalize.css 
		Author: Nicolas Gallagher
		URL: https://necolas.github.io/normalize.css/
		Date accessed: 20 November 2021
	-->
	<link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/main.css">
	<link rel="stylesheet" href="../css/main.css">
	<script src="js/scripts.js"></script>  
	
</head>
<body>
	<header id="homepg-banner" class="pg-banner">
	<?php	
	if (!isset($_SESSION['fandlname'])) {
	?>
		<h1><a href="index.php">JediMail</a></h1>
	<?php
	}else{
	?>
		<h1><a href="index.php?show=inbox">JediMail</a></h1>
	<?php
	}
	?>
	</header>
	
	
	