<?php

	include_once "security.php";
	include_once "db_connect.php";
	include_once "functions_login.php";

	session_start();
	

	if (!empty($_POST['username']) && !empty($_POST['password'])) {
		//ha megvan adva egy felhasználónév és egy jelszó, akkor megnézi h sikeres-e a bejelentkezés vele
		if (login($_POST['username'], $_POST['password'], $conn) == true) {
			//ha igen, akkor megad egy success-t és átirányít az index page-re
			$_SESSION['login_success'] = "Willkommen " . $_SESSION['username'] . "! Schönen Tag noch!";
			header('LOCATION: ../index.php');
		} else {
			//ha nem, akkor kiír egy hibaüzenetet, lementi a felhasználónevet a session-be és elmenti a próbálkozást a brute táblázatba és átirányít az index page-re
			faild_login_attempts($_SESSION['user_id'], $conn);
			if (empty($_SESSION['login_brute'])) {
				$_SESSION['login_error'] = "Bitte das richtige Benutzername und Passwort eintippen!";
			}
			if (isset($_POST['username'])) {
				$_SESSION['failed_login_username'] = $_POST['username'];
			}
			header('LOCATION: ../index.php?q=login_error');
		} 
	} else {
		//ha nincs megadva vmelyik/mindkettő adat...
		$_SESSION['login_error'] = "Bitte das richtige Benutzername und Passwort eintippen!";
		if (isset($_POST['username'])) {
			$_SESSION['failed_login_username'] = $_POST['username'];
		}
		header('LOCATION: ../index.php?q=login_error');
	}

?>
