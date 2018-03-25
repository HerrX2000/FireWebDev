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

function scroll_toogle (foo, perc) 
	{
		var foo = document.getElementById(foo);
		if( /iphone|ipad|ipod|android|mobile|smartphone|blackberry|iemobile|kindle|opera mobi|opera mini/i.test(navigator.userAgent) ) {
			if(window.innerHeight > window.innerWidth){
				foo.style.display = ((window.pageYOffset || document.documentElement.scrollTop) > perc) ? 'block' : 'none';
			}
			else{
				foo.style.display = 'none';
			}
		}
		else{
			foo.style.display = ((window.pageYOffset || document.documentElement.scrollTop) > perc) ? 'block' : 'none';
		}	
	};
		

//warning
function nolink() {
alert("Kein Link verfügbar!");
}

//Toggle
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

function toggle_id_display(el) 
{

myEl = document.getElementById(el); 
myEl.style.display = (myEl.style.display == 'none') ? 'block' : 'none'; 
}
function toggle_name_display(name) 
{
x = document.getElementsByName(name).length;
y = document.getElementsByName(name);
for (i = 0; i < x; i++) { 
y[i].style.display = (y[i].style.display == 'none') ? 'block' : 'none'; 	
}
}
function toggle_id_visibility(el) 
{ 
myEl = document.getElementById(el); 
myEl.style.visibility = (myEl.style.visibility == 'hidden') ? 'visible' : 'hidden'; 
} 

//resolution
function resolution()
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
//Cookie
function delete_cookie( name ) {
  document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
}

function eraseCookie(c_name) {
    document.cookie= c_name + "=;expires=Thu, 01 Jan 1970 00:00:00 UTC;";
}