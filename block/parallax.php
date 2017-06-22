<?php
	for ($n = 0; $n < $dest_numb; $n++) {
?>

	<div class="parallax" data-target="<?php echo $destinations[$n]; ?>" style="background-image: url(<?php echo 'img/' . $destinations[$n] . '/parallax.jpg'; ?>)">
		<div class="parallax_content">
			<div class="left">
				<p class="title"><?php echo $title[$destinations[$n]]; ?></p>
				</br>

				<!-- the modal button -->
				<img class="lightbox_button" onclick="openModal(<?php echo $n; ?>);currentSlide(<?php echo $n . ', 1'; ?>)" src="<?php echo 'img/' . $destinations[$n] . '/lightbox_button.jpg'; ?>">

				<!--a modal tartalma-->
				<div class="lightbox_modal">

					<!--a bezáró gomb-->
					<span class="lightbox_close" onclick="closeModal(<?php echo $n; ?>)">&times;</span>

					<!--a slideshow-->
					<div class="lightbox_content">
<?php
						//megszámolja hány kép van összesen
						$file_exists = true;
						$i = 1; //az aktuális kép
						$j = 0; //az össes kép
						while ($file_exists == true) {
							$j++;
							$i++;
							if (!file_exists('img/' . $destinations[$n] . '/img' . $i . '.jpg')) {
								$file_exists = false;
							}
						}
						//a nagy képek a slideshow-ban
?>
						<div class="slideshow_container">
<?php
							for ($i = 1; $i <= $j; $i++) {
?>
							<div class="slideshow fade" dataSlides="<?php echo $n; ?>">
								<div class="img_number"><?php echo $i . " / " . $j; ?></div>
								<img src="<?php echo 'img/' . $destinations[$n] . '/img' . $i . '.jpg'; ?>">
							</div>
<?php
							}
?>
						</div>
				    
				    	<!--a következő és az előző nyíl-->
						<a class="prev" onclick="plusSlides(<?php echo $n . ', -1'; ?>)">&#10094;</a>
						<a class="next" onclick="plusSlides(<?php echo $n . ', 1'; ?>)">&#10095;</a>

						

						<!--a kis képek a slideshow-ban-->
						<div class="row">
<?php
							for ($i = 1; $i <= $j; $i++) {
?>
								<div class="column">
									<img class="demo" dataSlides="<?php echo $n; ?>" src="<?php echo 'img/' . $destinations[$n] . '/img' . $i . '.jpg'; ?>" onclick="currentSlide(<?php echo $n . ', ' . $i; ?>)">
								</div>
<?php
							}
?>							
						</div>
					</div>
				</div>


			</div>
			<div class="right">
				<p class="price">Price: <span><?php echo $price[$destinations[$n]]; ?></span> p.P.</p>
				</br>
				<div class="info_container">
					<p class="info">Informationen:</p>
					<ul>
<?php
						foreach ($info[$destinations[$n]] as $inf) {
?>
							<li class="info"><?php echo $inf; ?></li>
<?php
						}
?>
					</ul>
				</div>
			</div>
		</div>
	</div>

<?php
	}
?>