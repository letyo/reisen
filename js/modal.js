//automatikusan és kattintásra is vált a nagy képek között a lightbox-ban, ha meg van nyitva


/*------------- a változók definiálása -------------------*/

/*---- login ----*/

// Get the login-modal
var login_modal = document.getElementById('login');

// Get the reg-modal
var reg_modal = document.getElementById('reg');

// Get success modal
var success_modal = document.getElementById('success');

// Get the login-button that opens the modal
var login_btn = document.getElementById("login_modal");

// Get the reg-button that opens the modal
var reg_btn = document.getElementById("reg_modal");

// Get the login_close element that closes the modal
var login_close = document.getElementById("login_close");

// Get the reg_close element that closes the modal
var reg_close = document.getElementById("reg_close");

//a hibaüzenet a login/reg page-ről a header-ben
var error = window.location.href.split("=")[1];


/*---- lightbox ----*/

//lementi az összes modal-t a modals-ba
var modals = document.getElementsByClassName('lightbox_modal');

//elnevezi a slideshowban lévő képeket slides-nak
var slides = document.getElementsByClassName("slideshow");
//elnevezi a slideshow alatti pöttyöket, amikkel az adott képre tudunk ugrani dots-nak
var dots = document.getElementsByClassName("demo");

//definiálja a változókat h globálisak legyenek, és az összes függvény tudja használni/elérni őket
var slideIndex = 0;
var auto;
var i;
var opened_modal;

//megadja hány lightbox van az oldalon
var modal_length = modals.length;

//definiálja az array-okat, amikbe majd szétválogatim az 1-1 lightbox-hoz tartozó képeket
var slide = new Array();
var dot = new Array()
for (m = 0; m < modal_length; m++) {
   slide[m] = new Array();
   dot[m] = new Array();
}

//szétválogatja a képeket az array-okba, amiket fentebb definiáltam (a válogatáshoz a dataSlides attribute-ot veszi alapul)
var f = 0;
while (f < slides.length) {
   for (m = 0; m < modal_length; m++) {
      if (slides[f].getAttribute('dataSlides') == m) {
         slide[m].push(slides[f]);
         dot[m].push(dots[f]);
      }
   }
   f++;
}


/*------------- a modal nyitása/zárása -------------------*/

/*---- login zárása x-szel ----*/

// When the user clicks on (x), close the login_modal
login_close.onclick = function() {
    login_modal.style.display = "none";
}

// When the user clicks on (x), close the reg_modal
reg_close.onclick = function() {
    reg_modal.style.display = "none";
}


/*---- lightbox nyitása ill. zárása x-szel ----*/

//megnyitja a modalt
function openModal(j) {
   modals[j].style.display = "block";
   //az automata vetítéshez, és a modal-ból való kilépeshez kell (oldalra kattintással, esc-kel) kell
   opened_modal = j;
 }

//bezárja a modalt
function closeModal(j) {
   modals[j].style.display = "none";
   //törli a változót az automata vetítéshez, h ne fusson tovább a háttérben
   opened_modal ="";
}


/*---- minden modal zárása mellékattal és esc-kel ----*/

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modals[opened_modal] || event.target == login_modal || event.target == reg_modal) { 
        login_modal.style.display = "none";
        reg_modal.style.display = "none";
        modals[opened_modal].style.display = "none";
        opened_modal = "";
    }
}

//when the user push the esc button, the modal closes
window.onkeydown = function(event) {
   if (event.keyCode == 27) {
        login_modal.style.display = "none";
        reg_modal.style.display = "none";
        modals[opened_modal].style.display = "none";
        opened_modal = "";
    }
}


/*---- login nyitása ----*/

// When the user clicks on the button, open the login_modal
login_btn.onclick = function() {
    login_modal.style.display = "block";
    document.getElementById("input_login_user").focus();
}

// When the user clicks on the button, open the reg_modal
reg_btn.onclick = function() {
    reg_modal.style.display = "block";
    document.getElementById("input_reg_user").focus();
}

//amikor nem sikerül a login/reg, akkor visszatölti a modal-t
if (error === "login_error") {
    window.onload = login_modal.style.display = "block";
} else if (error === "reg_error") {
    window.onload = reg_modal.style.display = "block";
} else {
    window.onload = login_modal.style.display = "none";
    window.onload = reg_modal.style.display = "none";
}


/*------------- a lightbox -------------------*/

//hívja az automatikusan a képek között lapozó függvényt
autoSlides();

//ha a jobbra/balra nyílra kattintunk, akkor arra fog lapozni a képekben
function plusSlides(wich_modal, wich_slide) {
   //kitörli a visszaszámlálást, h minden egyes kattintás után ugyanaddig maradjon az adott kép, mintha nem kattintottunk volna (ami ahhoz van beállítva h magától váltson a dia)
   clearTimeout(auto);
   //újra beállítja a visszaszámlálást a diákhoz
   auto = setTimeout(autoSlides, 10000);
   slideIndex += wich_slide;
   showSlides(wich_modal, slideIndex);
}

//ha egy képhez tartozó pontra kattintunk, akkor arra a képre fog ugrani
function currentSlide(wich_modal, wich_slide) {
   //kitörli a visszaszámlálást, h minden egyes kattintás után ugyanaddig maradjon az adott kép, mintha nem kattintottunk volna (ami ahhoz van beállítva h magától váltson a dia)
   clearTimeout(auto);
   //újra beállítja a visszaszámlálást a diákhoz   
   auto = setTimeout(autoSlides, 10000);
   slideIndex = wich_slide;
   showSlides(wich_modal, slideIndex);
}

//eltünteti az összes elrejti az összes képet, és az összes pont kijelölését törli
function hide() {
   //az összes slides-nak a display style-ját none-ra állítja -> így nem látszik egyik sem
   for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";  
   }
   //a slideshow alatti összes pötty (dots) class nevében kicseréli az active class-t a semmire (a dots-oknak két class-sza van: dot és active, az active természetesen csak az épp active-nak, és ezt törli ki)
   for (i = 0; i < dots.length; i++) {
      dots[i].className = dots[i].className.replace(" active", "");
   }
}

//az éppen aktív képet mutatja, és az ehhez a képhez tartozó pontot aktívvá teszi
function fadeIn(wich_modal) {
   //az aktív kép display style-ját block-ra változtatja, így csak ez az egy látható
   slide[wich_modal][slideIndex-1].style.display = "block";  
   //az aktív képhez tartozó dots-nak ad még egy class-t az active class-t
   dot[wich_modal][slideIndex-1].className += " active";
}

//a kattintásra való képváltást kezeli
function showSlides(wich_modal, wich_slide) {
   hide();
   //ha lapozáskor n értéke nagyobb lenne mint ahány kép van a slideshow-ban akkor visszaugrik az elsőre
   if (wich_slide > slide[wich_modal].length) {
      slideIndex = 1;
   }    
   //ha lapozáskor n értéke kisebb lenne mint 1 akkor átugrik az utolsó képre a slideshow-ban
   if (wich_slide < 1) {
      slideIndex = slide[wich_modal].length;
   }
   fadeIn(wich_modal);
}

//az automatikus képváltást kezeli
function autoSlides() {
   if (opened_modal.length !== 0) {
      hide();
      wich_modal = opened_modal;
      slideIndex++;
      //ha lapozáskor slideIndex értéke nagyobb lenne mint ahány kép van a slideshowban akkor visszaugrik az elsőre
      if (slideIndex > slide[wich_modal].length) {
         slideIndex = 1;
      }
      fadeIn(wich_modal);
      //ezzel vált magától a képek között
      auto = setTimeout(autoSlides, 10000);
   }
}