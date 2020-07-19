<?php

	function login_check($conn) {
		//ez ellenőrzi le h be van-e jelentkezve az illető

		//megnézi h van-e lementve cookie
		if (isset($_COOKIE["hetyey_weblap_haha"])) { //a cookie neve, ahogy lementődik majd a gépre!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
			//ha igen, akkor megkeresi a táblázatban a hozzátartozó felhasználót
			$stmt = $conn->prepare("SELECT user_id FROM " . TABLE_NAME_REISEN__MEMBERS . " WHERE session_id = ?");
			$stmt->bind_param("s", $_COOKIE["hetyey_weblap_haha"]); //a cookie neve, ahogy lementődik majd a gépre!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
			$stmt->execute();
			$stmt->store_result();
			$num_rows_cookies = $stmt->num_rows;
			$stmt->close();

			//ha talál felhasználót, pontosan egyet, kimenti az adatait
			if ($num_rows_cookies == 1) {
				$stmt = $conn->prepare("SELECT user_id, username, password, email FROM " . TABLE_NAME_REISEN__MEMBERS . " WHERE session_id = ?");
				$stmt->bind_param("s", $_COOKIE["hetyey_weblap_haha"]); //a cookie neve, ahogy lementődik majd a gépre!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
				$stmt->execute();
				$stmt->store_result();
				$stmt->bind_result($db_user_id, $db_username, $db_password, $db_email);
				$stmt->fetch();
				$stmt->close();

				$_SESSION['user_id'] = $db_user_id;
				$_SESSION['username'] = $db_username;
				$_SESSION['password'] = $db_password;
				$_SESSION['email'] = $db_email;
			}
		}

		if (!empty($_SESSION['user_id']) && !empty($_SESSION['username']) && !empty($_SESSION['password']) && !empty($_SESSION['email'])) {
			return true;
		} else {
			return false;
		}
	}

?>

			