<?php

	function check_text($sec) {
		//kitörli a felesleges üres helyeket, a "\" jeleket és kicseréli a speciális karaktereket 
		$sec = trim($sec);
		$sec = stripslashes($sec);
		$sec = htmlspecialchars($sec);
		return $sec;
	}

	function check_number($sec) {
		//csak a számokat, a plusz és a minusz jeleket hagyja benn
		$sec = filter_var($sec, FILTER_SANITIZE_NUMBER_INT);
		return $sec;
	}

	function check_number_full($sec) {
		//csak a számokat hagyja benn
		$sec = filter_var($sec, FILTER_SANITIZE_NUMBER_INT);
		$sec = str_replace("-", "", $sec);
		$sec = str_replace("+", "", $sec);
		return $sec;
	}

	function check_email($sec) {
		//a betűket, számokat és ezeket: !#$%&'*+-=?^_`{|}~@.[] hagyja benn, a többit törli
		$sec = filter_var($sec, FILTER_SANITIZE_EMAIL);
		return $sec;
	}

	function valid_email($sec) {
		//ellenőrzi h létezhet-e az email cím, ha igen akkor true-t, ha nem akkor false-t ad vissza
		if (filter_var($sec, FILTER_VALIDATE_EMAIL) == true) {
			return true;
		} else {
			return false;
		}
	}

	function valid_tel($sec) {
		//ellenőrzi h csak számok, space, "+", "-" és "/" van-e benne "/^[\d +-\/]*$/"
		if (preg_match("/^[\d +-\/]*$/", $sec)) {
			return true;
		} else {
			return false;
		}
	}

?>