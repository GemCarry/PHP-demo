<?php if (session_id() == ""){ session_start(); } ?>

<?php
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "mudb";	
	$conn = new mysqli($servername, $username, $password, $dbname);

	if(isset($_POST["newGameName"])) {
		$charName = $_POST["newGameName"];
		$_SESSION["who"] = $charName;
		$diff = $_POST["newGameDifficulty"];
		$stmt = $conn->prepare("INSERT INTO `user_table` (`user_NAME`, `user_HP`, `user_HP_max`, `user_MP`, `user_MP_max`, `user_ATT`, `user_DEF`, `user_LOC`, `user_XP`, `user_ENCOUNTER`) VALUES (?, '100', '100', '10', '10', '10', '10', ?, '0', '0')");
		$stmt->bind_param("ss", $charName, $diff);
		$stmt->execute();
	}

	if(isset($_POST["newEncounter"])) {
		$prepUser = $conn->prepare("SELECT * FROM user_table WHERE user_NAME=(?)");
		$prepUser->bind_param("s", $_SESSION['who']);
		$prepUser->execute();
		$resultUser = $prepUser->get_result();
		$rowUser = $resultUser->fetch_assoc();
		$encounter = $rowUser["user_ENCOUNTER"];

		if ($encounter == 0) {
			$stmt = $conn->prepare("INSERT INTO `encounter_table`(`monster_NAME`, `monster_HP`, `monster_HP_max`, `monster_MP`, `monster_MP_max`, `monster_ATT`, `monster_DEF`, `monster_LOC`, `monster_XP`) SELECT `monster_NAME`, `monster_HP`, `monster_HP_max`, `monster_MP`, `monster_MP_max`, `monster_ATT`, `monster_DEF`, `monster_LOC`, `monster_XP` FROM `monster_table` WHERE `monster_ID`=1");
			$stmt->execute();
		};
		
	}
	
	if(isset($_POST["useAttack"])) {
		$ATTACK = $_POST["useAttack"];
		$prepUser = $conn->prepare("SELECT * FROM user_table WHERE user_NAME=(?)");
		$prepUser->bind_param("s", $_SESSION['who']);
		$prepUser->execute();
		$resultUser = $prepUser->get_result();
		$rowUser = $resultUser->fetch_assoc();
		$encounter = $rowUser["user_ENCOUNTER"];
		$prepEncounter = $conn->prepare("SELECT * FROM encounter_table WHERE encounter_ID=(?)");
		$prepEncounter->bind_param("s", $encounter);
		$prepEncounter->execute();
		$resultEncounter = $prepEncounter->get_result();
		$rowEncounter = $resultEncounter->fetch_assoc();

		$userHealth = $rowUser["user_HP"];
		$encounterHealth = $rowEncounter["monster_HP"];
		$userMana = $rowUser["user_MP"];
		$encounterMana = $rowEncounter["monster_MP"];
		$userAttack = $rowUser["user_ATT"];
		$encounterAttack = $rowEncounter["monster_ATT"];
		$userDefense = $rowUser["user_DEF"];
		$encounterDefense = $rowEncounter["monster_DEF"];
		$userExp = $rowUser["user_XP"];
		$encounterExp = $rowEncounter["monster_XP"];

		if ($ATTACK == "punch") {
			$baseDmg = 10;
			$manaCost = 0;
		} elseif ($ATTACK == "fireball") {
			$baseDmg = 20;
			$manaCost = 2;
		} 
		

		if($_POST["fromPlayer"] == "yes") {
			$damage = ($baseDmg + $userAttack - $encounterDefense);
			$userMana -= $manaCost;
			$encounterHealth -= $damage;
			if ($encounterHealth <= 0) {
				$userExp += $encounterExp;
				$ded = $conn->prepare("DELETE FROM encounter_table WHERE encounter_ID=(?)");
				$ded->bind_param("i", $encounter);
				$ded->execute();
				$exp = $conn->prepare("UPDATE user_table SET user_MP=(?), user_XP=(?), user_ENCOUNTER=0 WHERE user_ENCOUNTER=(?)");
				$exp->bind_param("iii", $userMana, $userExp, $encounter);
				$exp->execute();
			} else {
				$dmg = $conn->prepare("UPDATE encounter_table SET monster_HP=(?) WHERE encounter_ID=(?)");
				$dmg->bind_param("ii", $encounterHealth, $encounter);
				$dmg->execute();
				$mana = $conn->prepare("UPDATE user_table SET user_MP=(?) WHERE user_ENCOUNTER=(?)");
				$mana->bind_param("ii", $userMana, $encounter);
				$mana->execute();
			}
			$stamp = date("h:i:sa");
			$newMessage = $stamp." > <u>".$_SESSION["who"]."</u> uses ".$ATTACK.", dealing ".$damage." to <u>".$rowEncounter["monster_NAME"]."</u>";
			manageLog($newMessage);

		} else {
			$damage = ($baseDmg + $encounterAttack - $userDefense);
			$encounterMana -= $manaCost;
			$userHealth -= $damage;
			if ($userHealth <= 0) {
				$ded = $conn->prepare("DELETE FROM encounter_table WHERE encounter_ID=(?)");
				$ded->bind_param("i", $encounter);
				$ded->execute();
				$ded = $conn->prepare("DELETE FROM user_table WHERE user_ENCOUNTER=(?)");
				$ded->bind_param("i", $encounter);
				$ded->execute();
			} else {
				$dmg = $conn->prepare("UPDATE user_table SET user_HP=(?) WHERE user_ENCOUNTER=(?)");
				$dmg->bind_param("ii", $userHealth, $encounter);
				$dmg->execute();
				$mana = $conn->prepare("UPDATE user_table SET user_MP=(?) WHERE user_ENCOUNTER=(?)");
				$mana->bind_param("ii", $userMana, $encounter);
				$mana->execute();
			}

			$dmg = $conn->prepare("UPDATE user_table SET user_HP=(?) WHERE user_ENCOUNTER=(?)");
			$dmg->bind_param("ii", $userHealth, $encounter);
			$dmg->execute();
		}


	}

	function manageLog($message) {
		$_SESSION["d1"] = $_SESSION["d2"];
		$_SESSION["d2"] = $_SESSION["d3"];
		$_SESSION["d3"] = $message;
	}

	function displayUser($userName) {
		global $conn;
		$stmt = $conn->prepare("SELECT * FROM user_table WHERE user_NAME=(?) ");
		$stmt->bind_param("s", $userName);
		$stmt->execute();
		$result = $stmt->get_result();
		$row = $result->fetch_assoc();
		echo 	"Name: <h3>".$row["user_NAME"]."</h3>  (Player #".$row["user_ID"].")".
			"<br>Health: ".$row["user_HP"]."/".$row["user_HP_max"].
			"<br>Mana: ".$row["user_MP"]."/".$row["user_MP_max"].
			"<br>Attack: ".$row["user_ATT"].", Defense:".$row["user_DEF"].
			"<br>Experience: ".$row["user_XP"].
			"<br>Fighting: ".$row["user_ENCOUNTER"];	
	}

	function displayCreep($creepName) {
		global $conn;
		$stmt = $conn->prepare("SELECT * FROM encounter_table WHERE monster_NAME=(?) ");
		$stmt->bind_param("s", $creepName);
		$stmt->execute();
		$result = $stmt->get_result();
		$row = $result->fetch_assoc();
		if ($row["monster_HP"] > 0) {
			echo 	"Name: <h3>".$row["monster_NAME"]."</h3>  (Mob #".$row["encounter_ID"].")".
			"<br>Health: ".$row["monster_HP"]."/".$row["monster_HP_max"].
			"<br>Mana: ".$row["monster_MP"]."/".$row["monster_MP_max"].
			"<br>Attack: ".$row["monster_ATT"].", Defense:".$row["monster_DEF"].
			"<br>Experience: ".$row["monster_XP"];
			$stmt = $conn->prepare("UPDATE user_table SET user_ENCOUNTER=? WHERE user_NAME=?");
			$stmt->bind_param("is", $row["encounter_ID"], $_SESSION["who"]);
			$stmt->execute();
		} else {
			echo 	"<h1> Victory! </h1>";
		}
		
		

		
	}


	echo "This is the functions page. Why are you here.";
?>