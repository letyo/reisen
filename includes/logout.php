<?php

	session_start();


	//kitörli a cookie-t, ami bejelentkezve tart
	setcookie("hetyey_weblap_haha", "", time() - 1, "/");

	//kitörli a session változóba lementett adatokat
	session_unset();
	//törli a session-t
	session_destroy();

	
	header('LOCATION: ../index.php');

?>