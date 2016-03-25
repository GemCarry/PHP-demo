$(document).ready(function(){

	$('[data-toggle="tooltip"]').tooltip();
	$("#mainContainer").load("content.php #contentLogin");
	$("#modalContainer").load("content.php #newGameModal");

	$(function clickNewgame() {
    		$(document).on('click', '#newGameDiv', function() {
       		$("#newGameModal").modal("toggle");
    		});
	});
	$(function clickContinue() {
    		$(document).on('click', '#loadGameDiv', function() {
       		$("#mainContainer").load("content.php #contentShop");
    		});
	});
	$(function clickFight() {
    		$(document).on('click', '#shopViewDiv', function() {
    			$.post(
    				"phpfunctions.php", {newEncounter : "go"}
    			).done(function() {
    				$("#battleDiv").load("content.php #creepDiv");
    				$("#charViewDiv").load("content.php #heroDiv");
    				$("#shopViewDiv").load("content.php #sendme");
    			});
    		});
	});
///////
	function useAttack(attackName, fromPlayer) {
		$.post(
			"phpfunctions.php", {useAttack : attackName, fromPlayer : fromPlayer}
		).done(function() {
			$("#battleDiv").load("content.php #creepDiv");
			$("#charViewDiv").load("content.php #heroDiv");
			$("#shopViewDiv").load("content.php #sendme");
		});
	};
		$(function clickFireball() {
	    		$(document).on('click', '#useFireball', function() {
	       		useAttack("fireball", "yes");
	    		});
		});
		$(function clickPunch() {
			$(document).on('click', '#usePunch', function() {
       			useAttack("punch", "yes");
    			});
		});
///////
	$(function submitNewgame() {
		$(document).on("click", "#newGameSubmit", function() {
			var inp = $("#newGameName").val();
			var rad = $('input:radio[name=newGameDifficulty]:checked').val();
			$.post(
				"phpfunctions.php", { newGameName : inp, newGameDifficulty : rad } 
			).done(function() {
				$("#newGameModal").modal("toggle");
				$("#mainContainer").load("content.php #contentShop");
			});
		});
	});
});
