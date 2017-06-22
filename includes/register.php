<?php

	include_once "security.php";
	include_once "db_connect.php";
	include_once "functions_reg.php";

	session_start();


	//megnézi h a reg függvény által adott eredmény igaz-e
	if (reg($_POST['username'], $_POST['email'], $_POST['password'], $conn) == true) {
		//ha igen, akkor megad egy success-t és átirányít az index page-re
		$_SESSION['reg_success'] = "Du hast dich erfolgreich registriert, und jetzt bist du als " . $_SESSION['username'] . " eingeloggt!";
		$_SESSION['failed_reg_username'] = "";
		$_SESSION['failed_reg_email'] = "";
		header('LOCATION: ../index.php');
	} else {
		//ha nem, akkor kiír egy hibaüzenetet lementi a beírt adatokat a session-be és átirányít az index page-re
		if (isset($_POST['username'])) {
			$_SESSION['failed_reg_username'] = $_POST['username'];
		}
		if (isset($_POST['email'])) {
			$_SESSION['failed_reg_email'] = $_POST['email'];
		}
		header('LOCATION: ../index.php?q=reg_error');
	}
	if (empty($_POST['username']) || empty($_POST['email']) || empty($_POST['password'])) {
		//ha nincs megadva a felhasználónév, email és/vagy a jelszó, akkor kiírja h add meg, a megadottakat pedig lementi a session-be
		$_SESSION['reg_errors']['empty'] = "Bitte alle Datenfeld ausfüllen!";
		if (isset($_POST['username'])) {
			$_SESSION['failed_reg_username'] = $_POST['username'];
		}
		if (isset($_POST['email'])) {
			$_SESSION['failed_reg_email'] = $_POST['email'];
		}
		header('LOCATION: ../index.php?q=reg_error');
	}

?>