<?php
	
	function login($username, $password, $conn) {
		//összehasonlítja a felhasználó adatait az adatbázisban lévőkkel, ha egyezést talál, akkor lementi $_SESSION változóknak őket és a login-ra true-t ad ki
		$username = check_text($username);
		$password = check_text($password);
		
		//kikeresi a beírt felhasználónevet a táblázatból és kigyűjti a hozzátartozó adatokat
		$stmt = $conn->prepare("SELECT user_id, username, password, email, next_valid_login_time FROM reisen__members WHERE username = ?");
		$stmt->bind_param("s", $username);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($db_user_id, $db_username, $db_password, $db_email, $db_next_valid_login_time);
		$stmt->fetch();
		$stmt->close();

		//azért kell ide a user_id a session-be h a faild_login_attempts függvény tudjon futni
		$_SESSION['user_id'] = $db_user_id;

		//ellenőrzi h le van-e tiltva az acc
		if (bruteforce($db_user_id, $conn) == true) {
			//ha igen akkor nem enged bejelentkezni és kiír egy hibát és küld egy email a felhasználó email címére h vki megpróbálta feltörni a fiókját
			$_SESSION['login_brute'] = "Dein Account ist gesperrt, wegen des Passworts zu viel mals falsch eingetippt wurde. Bitte eine Stunde warten auf das Aufsperren!";
			$subject = "Account locked!";
			$email = "email@email.com"; //a webhely üzemeltető email címe
			$next_login = date("j.n.Y. H:i:s", $db_next_valid_login_time); //az időt a server időzónájában írja ki!!!!!!!!!!!!!!!!!!!!!!!!!!
			$locked_time = date("j.n.Y. H:i:s", time()); //az időt a server időzónájában írja ki!!!!!!!!!!!!!!!!!!!!!!!!!!
			$message = "Your account with the username: " . $db_username . " is locked due to enter the wrong password too many times. Now it is locked for 1 hour. \nIf it was not you, then sombody probably tried to hack your account. Please be sure, that your password is enough hard to crack. \nIf it was you, and you do not know your password, please contact us. \nYou can log in at: (" . $next_login . "). The time of block your account: (" . $locked_time . ").";
			mail($db_email, $subject, $message, "From: " . $email);
        
			return false;
		} else {
			//ellenőrzi ha a beírt jelszó megegyezik-e a felhasználónévhez tartozóval
			if (password_verify($password, $db_password)) {
				//ha igen akkor lementi a session-be az adatokat a táblázatból
				$_SESSION['username'] = $db_username;
				$_SESSION['password'] = $db_password;
				$_SESSION['email'] = $db_email;

				//és létrehoz egy egyedi azonosítót, amit lement a táblázatba a user-hez és létrehoz egy cookie-t is, a user gépén
				if ($_POST['stay_logged_in'] == "stay_logged_in") {
					stay_logged_in($_SESSION['user_id'], $conn);
				}
				return true;
			} else {
				return false;
			}
		}		
	}

	function bruteforce($user_id, $conn) {
		//megnézi h hányszor próbáltak belépni az adott user_id-hoz a felhasználónévvel, és ha ez az elmúlt tíz percben több mint 5 akkor letiltja az acc-ot ideiglenesen
		$now = time();
		$attempts = $now - (10 * 60);

		$stmt = $conn->prepare("SELECT time FROM reisen__brute WHERE user_id = ? AND time > ?");
		$stmt->bind_param("ii", $user_id, $attempts);
		$stmt->execute();
		$stmt->store_result();
		$num_rows_brute = $stmt->num_rows; //lementi a sorok számát a változóba
		$stmt->close();

		//lekéri a next_valid_login_time cellában lévő adatot az adott user-nél, de csak azokat, amiknek az adott (jelenlegi) idő után van (a jövőben)
		$stmt = $conn->prepare("SELECT next_valid_login_time FROM reisen__members WHERE user_id = ? AND next_valid_login_time > ?");
		$stmt->bind_param("ii", $user_id, time());
		$stmt->execute();
		$stmt->store_result();
		$num_rows_members = $stmt->num_rows; //lementi a sorok számát a változóba
		$stmt->close();

		//ellenőrzi h megvolt-e már a több mmint 5 hibás jelszó beírás
		if ($num_rows_brute > 5) {
			
			//megnézi h üres-e a next_valid_login_time oszlop az adott user_id-nál (üres - ha az ott megadott idő a múltban van) - tehát nincs letiltva az acc
			if ($num_rows_members == 0) {
				//létrehoz egy timestampt-et h mikor lehet legközelebb bejelentkezni
				$next_valid_login_time = $now + (1 * 60 * 60);
				//beszúrja a timestamp-et a next_valid_login_time mezőbe a members táblázatba h mikor lehet legközelebb bejelentkezni (kapásból azt amikor be lehet, h ott már ne kelljen számolni)
				$stmt = $conn->prepare("UPDATE reisen__members SET next_valid_login_time = ? WHERE user_id = ?");
				$stmt->bind_param("ii", $next_valid_login_time, $user_id);
				$stmt->execute();
				$stmt->close();
			}
			return true;
		} elseif ($num_rows_members > 0) {
			//ha már le van tiltva az acc...
			return true;
		} else {
			return false;
		}
	}

	function faild_login_attempts($user_id, $conn) {
		//ha nem a megfelelő jelszóval próbáltak belépni vagy már túl sokszor próbáltak rosszal belépni és már letiltott a rendszer, és a next_valid_login_time cella az adott felhasználói id-nál üres a members táblázatban, akkor elmenti a próbálkozást a brute táblázatba (természetesen a függvény csak elmenti a próbálkozást, mást nem tud önmagában)
		
		//lekéri a next_valid_login_time cellában lévő adatot az adott user-nél, de csak akkor, ha az adott (jelenlegi) idő után van (a jövőben)
		$stmt = $conn->prepare("SELECT next_valid_login_time FROM reisen__members WHERE user_id = ? AND next_valid_login_time > ?");
		$stmt->bind_param("ii", $user_id, time());
		$stmt->execute();
		$stmt->store_result();
		
		//megnézi h üres-e a next_valid_login_time oszlop az adott user_id-nál (üres - ha az ott megadott idő a múltban van) - tehát nincs letiltva az acc
		if ($stmt->num_rows == 0) {
			//ha üres, akkor elmenti a próbálkozást a brute táblázatba
			$stmt = $conn->prepare("INSERT INTO reisen__brute(user_id, time) VALUES(?, ?)");
			$stmt->bind_param("ii", $user_id, time());
			$stmt->execute();
			$stmt->close();
		}
		$stmt->close();
	}

	function stay_logged_in($user_id, $conn) {
		//létrehoz egy egyedi azonosítót, amit lement a táblázatba a user-hez és létrehoz egy cookie-t is, a user gépén

		//létrehoz egy egyedi azonosítót
		$session_id = uniqid($user_id, true);
		
		//és lementi a táblázatba a user-hez
		$stmt = $conn->prepare("UPDATE reisen__members SET session_id = ? WHERE user_id = ?");
		$stmt->bind_param("si", $session_id, $user_id);
		$stmt->execute();
		$stmt->close();

		//ill. létrehoz egy cookie-t, aminek az érvényességét 1 hónapra változtatja
		$cookie_name = "hetyey_weblap_haha"; //a cookie neve, ahogy lementődik majd a gépre!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
		$cookie_value = $session_id;
		$cookie_expiration_time = time() + (60 * 60 * 24 * 30 * 2);
		setcookie($cookie_name, $cookie_value, $cookie_expiration_time, "/");
	}

?>