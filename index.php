<?php
	$destinations = array("iceland", "portugal", "norway", "greece"); // 
	$dest_numb = count($destinations);
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Riesen Reisen</title>
	<link type="text/css" rel="stylesheet" href="css/main.css"/>
	<script type="text/javascript" src="js/jQuery.js" defer></script>
	<script type="text/javascript" src="js/main.js" defer></script>
	<script type="text/javascript" src="js/modal.js" defer></script>
</head>
<body>

	<div id="loading">
		<div id="loader"></div>
	</div>

<?php
	include_once "block/header.php";
?>

	<div class="home">
		<div class="home_content">

			<p>Unterschiedliche Menschen haben im Urlaub verschiedene Erwartungen. Wir wissen das wie kaum ein anderer und bietet Ihnen daher auch eine Fülle von Möglichkeiten, Ihren persönlichen Urlaub zu finden. Sie suchen Ruhe, Entspannung und Erholung? Sie möchten ein Land und seine Leute, andere Kulturen und neue Wege entdecken? Wir haben all dies im Programm. Ganz gleich, ob Strandurlaub oder Rundreise: Die Qualität ist immer an Ihrer Seite.</br>
			Bei unseren Preisknüllern wurde schon beim Einkauf auf ein extrem gutes Preis-Leistungsverhältnis geachtet. Gekürzt wurde nur beim Preis, nicht aber bei der Qualität. Und wenn Sie bei der Urlaubsplanung schnell und ebenso flexibel sind, profitieren Sie von unseren tagesaktuellen Extra-Knüllern.</p>
			</br>

			<img src="img/travel_quote.jpg">

		</div>
	</div>

<?php
	if (login_check($conn) == true) {
		include_once "block/parallax.php";
	}
?>

	<img class="back_to_top_button" src="img/back_to_top_button.jpg"/>

</body>
</html>