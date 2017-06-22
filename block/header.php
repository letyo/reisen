<?php

	//a regisztrációnál ha üres egy mező, akkor arra a többi hiba mellett kiír egy hibaüzenetet, míg a loginnál csak azt írja k mindig úgy írd be helyesen a felhasználónevet és a jelszót
	//vhogy meg lehetne oldani azt is h az üzeneteket egy külön fájlba beleírni és onnét ezekbe linkelni (include-olni) (már próbáltam, a fájlt sem töröltem ki, és ott összefoglaltam a hibákat is, h mi nem sikerült - file_name: texts_and_options.php)

	include_once "includes/functions.php";
	include_once "includes/db_connect.php";
	include_once "includes/destinations.php";

	session_start();

?>

	<div id="header">
		<div id="menu_header">

<?php
			if (login_check($conn) == true) {
				for ($n = 0; $n < $dest_numb; $n++) {
?>
					<p class="menu_buttons" data-link="<?php echo $destinations[$n]; ?>"><?php echo $menu_buttons[$destinations[$n]]; ?></p>
<?php
				}
			} else {
?>
				<p class="menu_header">Die Reiseziele zu sehen, bitte einloggen!</p>
<?php
			}
?>

		</div>

		<div id="login_header">

<?php
			if (login_check($conn) == true) {			
				//kiírja az aktuális állapotot, h bevagyunk-e jelentkezve, és ettől függően a megfelelő gombokat is elhelyezi (login / logout & reg)
?>			
				<p class="login_header">Du bist eingeloggt als <?php echo $_SESSION['username']; ?>!</p>
				<button class='login_header login_buttons' onClick="document.location.href='includes/logout.php'">Log out!</button>
<?php			
			} else {
?>			
				<p class="login_header">Du bist nicht eingeloggt! Bitte logg ein, oder registrier dich!</p>
				<button class='login_header login_buttons' id='login_modal'>Einloggen!</button>
				<button class='login_header login_buttons' id='reg_modal'>Registrieren!</button>
<?php			
			}
?>

		</div>
	</div>


	<!-- The Login-Modal -->
	<div id="login" class="modal">

		<!-- a Modal Box tartalma -->
		<div class="modal_content">

			<div class="modal_header">
				<!-- The Close Button -->
		  		<span id="login_close" class="close">&times;</span>
		  		<!-- a modal cím szövege -->
				<p class="modal_header_text">Einloggen</p>
		  	</div>

	  		<!-- a modal box interaktív tartalma -->
	  		<div class="modal_body">

	  			<div class="errors">
<?php
					//kiírja a bejelentkezéssel kapcsolatos hibákat/sikert majd törli az összeset
					if (!empty($_SESSION['login_brute'])) {
						echo $_SESSION['login_brute'];
					}
					if (!empty($_SESSION['login_error'])) {
						echo $_SESSION['login_error'];
					}
					if (!empty($_SESSION['login_success'])) {
						echo $_SESSION['login_success'];
					}
					$_SESSION['login_brute'] = "";
					$_SESSION['login_error'] = "";
					$_SESSION['login_success'] = "";
?>
				</div>

				</br>
				<form method="post" action="includes/login.php">
					<input id="input_login_user" type="text" name="username" placeholder="Benutzername" value="<?php if (!empty($_SESSION['failed_login_username'])) {echo $_SESSION['failed_login_username'];} ?>">
					</br>
					<input type="password" name="password" placeholder="Passwort">
					</br>
					<input type="checkbox" name="stay_logged_in" value="stay_logged_in"><em>Eingeloggt bleiben!</em>
					</br>
					<input type="submit" name="login" value="Log in!">
				</form>
			</div>
		</div>
	</div>

	<!-- The _Reg-Modal -->
	<div id="reg" class="modal">

		<!-- a Modal Box tartalma -->
		<div class="modal_content">

			<div class="modal_header">
				<!-- The Close Button -->
		  		<span id="reg_close" class="close">&times;</span>
				<!-- a modal cím szövege -->
				<p class="modal_header_text">Registrieren</p>
		  	</div>

	  		<!-- a modal box interaktív tartalma -->
	  		<div class="modal_body">

	  			<div class="errors">
<?php
					//kiírja a regisztrációval kapcsolatos hibákat/sikert majd törli az összeset
					if (!empty($_SESSION['reg_errors'])) {
						foreach ($_SESSION['reg_errors'] as $error) {
							echo $error . "</br>";
						}
					}
					if (!empty($_SESSION['reg_success'])) {
						echo $_SESSION['reg_success'];
					}
					$_SESSION['reg_success'] = "";
?>
				</div>

				</br>
				<form method="post" action="includes/register.php">
					<input id="input_reg_user" type="text" name="username" placeholder="Benutzername" value="<?php if (!empty($_SESSION['failed_reg_username'])) {echo $_SESSION['failed_reg_username'];} ?>">
					</br>
					<input type="text" name="email" placeholder="E-Mail-Adresse" value="<?php if (!empty($_SESSION['failed_reg_email'])) {echo $_SESSION['failed_reg_email'];} ?>">
					</br>
					<input type="password" name="password" placeholder="Passwort">
					</br>
					<input type="submit" name="reg" value="Register!">
				</form>
			</div>
		</div>
	</div>