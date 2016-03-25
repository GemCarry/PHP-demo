<?php session_start(); 
	include "phpfunctions.php";
?>

<!-- Login -->

<div id="contentLogin" class="container">
	<div class="row">
		<div id="newGameDiv" class="col-sm-12 well well-lg"> <h1>New Game</h1> </div>
	</div>
	<div class="row">
		<div id="loadGameDiv" class="col-sm-12 well well-lg"> <h1>Continue</h1> </div>
	</div>
</div>

<!-- Shop-->

<div id="contentShop" class="container">
	<div class="row">
		<div id="charViewDiv" class="col-sm-3 well"> 
			<h6> <?php  displayUser($_SESSION['who']); ?> </h6> 
			<div id="heroDivSlot"></div>
			</div>
		<div id="shopViewDiv" class="col-sm-6 well"> 
			<div class="row well well-sm"> 
				<h1 "style=background-color: red">>FIGHT<</h1> 
			</div>
			<div id="dd3" class="row "> <?php echo $_SESSION["d3"]; ?> </div>
			<div id="dd2" class="row "> <?php echo $_SESSION["d2"]; ?> </div>
			<div id="dd1" class="row "> <?php echo $_SESSION["d1"]; ?> </div>
		</div> 
		<div id="battleDiv" class="col-sm-3 well"></div>
	</div>
</div>

<div id="sendme">
	<div class="row well well-sm"> 
		<h1 "style=background-color: red">>FIGHT<</h1> 
	</div>
	<div id="dd3" class="row"> <b> <?php echo $_SESSION["d3"]; ?> </b> </div>
	<div id="dd2" class="row"> <?php echo $_SESSION["d2"]; ?> </div>
	<div id="dd1" class="row"> <?php echo $_SESSION["d1"]; ?> </div>
	</div>
</div>

<div id="heroDiv">
	<div class="row">
		<h6> <?php  displayUser($_SESSION['who']); ?> </h6>
		<br><br>
	</div>
	<div id="usePunch" class="row well well-sm">
		<h3>PUNCH</h3>
	</div>
	<div id="useFireball" class="row well well-sm">
		<h3>FIREBALL</h3>
	</div>
</div>

<div id="creepDiv">
	<div class="row well">
		<?php displayCreep("gnome"); ?>
	</div>
	
</div>

<!-- Modals -->

<div id="contentLoginModal" class="container">
	<div id="newGameModal" class="modal fade" role="dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"> &times; </button>
				<h4 class="modal-title"> New Character </h4>
			</div>
			<div class="modal-body">
				<!--<form id="newGameForm" role="form" action="/">-->
					<label for="newGameName"> Name </label>
					<input type="text" class="form-control" id="newGameName" name="newGameName" autocomplete="off"></input>
					<label for="newGameDifficulty"></label>
					<label class="radio-inline"><input type="radio" id="newGameDifficulty" data-toggle="tooltip" title="Best for Beginners" name="newGameDifficulty" value="Casual"> Casual </label>
					<label class="radio-inline"><input type="radio" id="newGameDifficulty" data-toggle="tooltip" title="A Reasonable Challenge" name="newGameDifficulty" value="Normal"> Normal </label>
					<label class="radio-inline"><input type="radio" id="newGameDifficulty" data-toggle="tooltip" title="Are you PRO enough?" name="newGameDifficulty" value="Pro"> Pro </label>
				<!--</form>--></br>
					<button type="button" id="newGameSubmit">Create Character</button>
			</div>
		</div>
	</div>
</div>