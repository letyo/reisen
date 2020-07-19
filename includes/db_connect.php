<?php

	if (file_exists("../../configuration.php")) {
		require_once "../../configuration.php";
	} elseif (file_exists("../../../configuration.php")) {
		require_once "../../../configuration.php";
	}

	$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME_REISEN) or die("Error connecting to the database!");

	//átállítja az adatbázis karakterkészletét (nem elég a meta tag-ben beállítani, ez vonatkozik az adatbázisra, nem a meta tag charset)
	$conn->set_charset("utf8");

?>