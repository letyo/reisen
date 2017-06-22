<?php


	function reg($username, $email, $password, $conn) {
		$username = check_text($username);
		$email = check_email($email);
		$password = check_text($password);

		$_SESSION['reg_errors'] = array();

		if (!empty($password)) {
			$password = password_hash($password, PASSWORD_DEFAULT);
		}

		//ellenőrzi h létezhet-e egyáltalán (formailag) az email cím
		if (valid_email($email) == false && !empty($email)) {
        	$_SESSION['reg_errors']['email_invalid'] = "Bitte eine gültige E-Mail-Addresse eingeben!";
    	}

    	//ellenőrzi h létezik-e az email cím
		$stmt = $conn->prepare("SELECT user_id FROM reisen__members WHERE email = ?");
		$stmt->bind_param("s", $email);
		$stmt->execute();
		$stmt->store_result();
		if ($stmt->num_rows > 0) {
			$_SESSION['reg_errors']['email_exists'] = "Ein/e BenutzerIn existiert schon mit dieser E-Mail-Addresse!";
		}
		$stmt->close();

		//ellenőrzi h létezik-e a felhasználónév cím
		$stmt = $conn->prepare("SELECT user_id FROM reisen__members WHERE username = ?");
		$stmt->bind_param("s", $username);
		$stmt->execute();
		$stmt->store_result();
		if ($stmt->num_rows > 0) {
			$_SESSION['reg_errors']['username_exists'] = "Ein/e BenutzerIn existiert schon mit diesem Benutzername!";
		}
		$stmt->close();

		//ha nem létezik az email cím és a felhasználónév, érvényes lehet az email cím és minden mező ki lett töltve akkor beviszi az adatokat a táblázatba
		if (empty($_SESSION['reg_errors']) && !empty($username) && !empty($email) && !empty($password)) {
			
			$next_valid_login_time_reg = ''; //regisztrációnál mindig helyes a bejelentkezés, tehát ez az oszlop üres kell hogy legyen
			$session_id = '';

			$stmt = $conn->prepare("INSERT INTO reisen__members(user_id, username, password, email, next_valid_login_time, session_id) VALUES(DEFAULT, ?, ?, ?, ?, ?)");
			$stmt->bind_param("sssis", $username, $password, $email, $next_valid_login_time_reg, $session_id);
			$stmt->execute();
			$stmt->close();

			//majd kiszedi az összes adatot a táblázatból (id-t is)
			$stmt = $conn->prepare("SELECT user_id, username, password, email FROM reisen__members WHERE username = ?");
			$stmt->bind_param("s", $username);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($db_user_id, $db_username, $db_password, $db_email);
			$stmt->fetch();
			$stmt->close();

			//majd lementi a session-be az adatokat a táblázatból
			$_SESSION['user_id'] = $db_user_id;
			$_SESSION['username'] = $db_username;
			$_SESSION['password'] = $db_password;
			$_SESSION['email'] = $db_email;
			return true;
		}
	}

?>