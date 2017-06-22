$('.title').hide();
$('.lightbox_button').hide();
$('.price').hide();
$('.info_container').hide();

//kitörli a loading elemet
$(window).on("load", function() {
	$('#loading').fadeOut(800);
});

$(document).ready(function() {
	//parallax-on lévő adatok elő- és eltűnésének időzítése
	var window_height = $(window).height();
	var $parallax = $('.parallax');
	$parallax.each(function(i) {
		var $p = $(this); //csak egy parallax a sok közül
		$(document).scroll(function() { 
			var y = $(this).scrollTop(); //ha azt akarom h a háttér is mozogjon: transform: translateY(-20px); és a 20px-et számolom y-ból százalékra -> a background attachment:fixed-et ki kell szedni, de akkor nem úgy fog kinézni mintha a két háttér egymáson gördülne, hanem simán egymás után feljönnek a képbe, mintha két kép lenne egymás alatt
			if (y > (i + 0.25) * window_height) {
				$p.find('.title').fadeIn(800); //a $p-n belül keresi a title-t
			} else {
				$p.find('.title').fadeOut(800);
			}
			if (y > (i + 0.75) * window_height) {
				$p.find('.lightbox_button').fadeIn(800);
			} else {
				$p.find('.lightbox_button').fadeOut(800);
			}
			if (y > (i + 0.35) * window_height) {
				$p.find('.price').fadeIn(800);
			} else {
				$p.find('.price').fadeOut(800);
			}
			if (y > (i + 0.75) * window_height) { //vhogy meg lehetne oldani, h az infók egymás után jöjjenek be, ne egyszerre
				$p.find('.info_container').fadeIn(800);
			} else {
				$p.find('.info_container').fadeOut(800);
			}
		});
	});

	//a destination-ben lévő hivatkozások linkelése a hozzájuk tartozó parallax-hoz (document részhez)
	var $links = $('[data-link]');
	var document_height = $(document).height();
	console.log(window_height); 
	console.log(document_height);
	$links.click(function() {
		var $link = $(this);
		var target = $link.data('link') //mintha attr('data-link') lenne
		var target_place = $('[data-target="' + target + '"]').offset().top;
		var scroll_down_speed = target_place / document_height * 2000;
		$('html, body').animate({
			scrollTop: target_place //('#' + target) === ('[data-target="' + target + '"]'), csak az elsőnél az id-ra a 2.-nál a data-target-re hivatkozik (a target mindkettőben a változó, amit itt, kicsit följebb definiáltam)
		}, scroll_down_speed);
	});

	//a back_to_top_button
	var $back_to_top_button = $('.back_to_top_button');
	$(window).scroll(function() {
		if ($(window).scrollTop() > 100) {
		//előtűnése és eltűnése
			$('.back_to_top_button').fadeIn('slow');
		} else {
			$('.back_to_top_button').fadeOut('slow');
		}
	});

	$('.back_to_top_button').click(function() {
		var button_place = $back_to_top_button.offset().top;
		var scroll_top_speed = button_place / document_height * 1000;
		//az oldal tetejére görgetés a gombra való kattintással
		$('html, body').animate({
			scrollTop: 0}, scroll_top_speed);
	});
	
});