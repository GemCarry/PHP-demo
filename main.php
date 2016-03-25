<?php session_start();
	//include "phpfunctions.php";
	//include 'content.php';
	?>

<!DOCTYPE html>
<html>
<head>
	<title> Dungeon Pro: Main </title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="jsfunctions.js"></script>
	<style>
		html {	height: 100%;
			scroll-behavior: static; }
		body { background-color: black;
			color: white;
			text-align: center;
			height: 100%; }
		.container {height: 100%;}
		.well { background-color: #554;
			 border-color: black;  }
		.well-sm { 
			background-color: #b41;
			border-style: none; }
		.row { height: 50%;
			margin-left: 0%;
			margin-right: 0%; }
		.col-sm-12 { height: 100%; }
		.well-lg { height: 50%; })
		.modal { margin-left: 25%;
			  margin-right: 25%; }
		.modal-body { background-color: #f85; }
		.focused {color: red;}
	</style>
</head>
<body>
	<div id="mainContainer" class="container"></div>
	<div id="modalContainer" class="container"></div>
</body>