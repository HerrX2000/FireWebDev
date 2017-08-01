//Cookie
function eraseCookie(c_name) {
    document.cookie= c_name + "=;expires=Thu, 01 Jan 1970 00:00:00 UTC;";
}
//Bildershow	
	 function fade(step) {
            var imgs = document.getElementById("meinFader").getElementsByTagName("img");

            step = step || 0;

            imgs[counter].style.opacity = step/100;
            imgs[counter].style.filter = "alpha(opacity=" + step + ")"; // 

            step = step + 2;

            if (step <= 100) {
                window.setTimeout(function () { fade(step); }, 1);
            } else {
                window.setTimeout(next, 10000);
            }
        }
/*
        function next() {
            var imgs = document.getElementById("meinFader").getElementsByTagName("img");

            if (typeof(counter) != "number") {
                counter = 0;
            }

            counter++;

            if (counter < imgs.length) {
                fade();
            }
        };
		
		function prev() {
            var imgs = document.getElementById("meinFader").getElementsByTagName("img");

            if (typeof(counter) != "number") {
                counter = 0;
            }

            counter++;

            if (counter < imgs.length) {
                fade();
            }
        };
*/		
	//Menü einblenden
		var foo = document.getElementById('menu_fixed');
		window.onscroll = function() {
			if( /iphone|ipad|ipod|android|mobile|smartphone|blackberry|iemobile|kindle|opera mobi|opera mini/i.test(navigator.userAgent) ) {
			if(window.innerHeight > window.innerWidth){
			foo.style.display = ((window.pageYOffset || document.documentElement.scrollTop) > 92) ? 'block' : 'none';
			}
			else{
			foo.style.display = 'none';
			}
}
else{
			foo.style.display = ((window.pageYOffset || document.documentElement.scrollTop) > 92) ? 'block' : 'none';
	}	
	};

/*		(function Slider(){
		  
		var counter = 0, // to keep track of current slide
			$items = document.querySelectorAll('.diy-slideshow figure'),
			// a collection of all of the slides, caching for performance
			numItems = $items.length; // total number of slides

		// this function is what cycles the slides, showing the next or previous slide and hiding all the others
		var showCurrent = function(){
		  var itemToShow = Math.abs(counter%numItems);
		  // uses remainder (aka modulo) operator to get the actual index of the element to show  
		  
		  // remove .show from whichever element currently has it 
		  [].forEach.call( $items, function(el){
			el.classList.remove('show');
		  });
		  
		  // add .show to the one item that's supposed to have it
		  $items[itemToShow].classList.add('show');    
		};

		// add click events to prev & next buttons 
		document.querySelector('.next').addEventListener('click', function() {
			 counter++;
			 showCurrent();
		  }, false);

		document.querySelector('.prev').addEventListener('click', function() {
			 counter--;
			 showCurrent();
		  }, false);
		  
		})();  */	
		
		
		
//Passwortfeld unten
	function Admin () 
	{
		var Ergebnis = (document.Login.Eingabe.value == "FirePass") ? location.href = "Admin.php" : "falsch";
		document.Login.Eingabe.value = Ergebnis;
	};


//Menü einblenden
	function nolink() {
	alert("Kein Link verfügbar!");
	}
//Forum
	function noforum() {
	alert("Kein Forum Plug-in eingefügt");
	}

	function toggle(el) 
	{

	myEl = document.getElementById(el); 
	myEl.style.display = (myEl.style.display == 'none') ? 'block' : 'none'; 
	}
	function toggle_sev(name) 
	{
    x = document.getElementsByName(name).length;
	y = document.getElementsByName(name);
	for (i = 0; i < x; i++) { 
    y[i].style.display = (y[i].style.display == 'none') ? 'block' : 'none'; 	
	}
	}
	function toggle_visibility(el) 
	{ 
	myEl = document.getElementById(el); 
	myEl.style.visibility = (myEl.style.visibility == 'hidden') ? 'visible' : 'hidden'; 
	} 
	
	
//Protectoin
function protection() {
	var password;
	var pass="FirePass";
	password=prompt('Bitte Passwort eingeben:');

	if (password==pass)
	{
		document.getElementById("safe").style.display="block";
    }	 
	else
	{
		alert("Error! (Passwort falsch)");
		window.location="index.php";
    }
	
	}

	function aufloesung()
	{
	if(window.innerHeight)
	{
	height = window.innerHeight;
	width = window.innerHeight;
	}
	else if(document.body.clientHeight)
	{
	height = document.body.clientHeight;
	width = document.body.clientWidth;
	}
	document.write(width + "x" + height);
	}
	
	
	