  <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.5/js/materialize.min.js" defer></script>
  <script src="<?php echo($baseurl); ?>src/js.cookie.js" async></script>
<script><?php ob_start(); ?>
(function($){
  $(function(){
	$(document).ready(function() {	  
		$("#filterCity").change(function() {
			var city = $(this).val();
			document.location = "<?php echo($baseurl); ?>filter/?by=city&city=" + city;
		});
		$(".material-icons").delay(800).fadeIn();		
		$(".fa").delay(800).fadeIn();		
		$('.button-collapse').sideNav();
	    $('.modal-trigger').leanModal();
		$('select').material_select();
	});

  }); // end of document ready
})(jQuery); // end of jQuery name space  

var cb1 = function() {
var l = document.createElement('link'); l.rel = 'stylesheet';
l.href = 'https://fonts.googleapis.com/icon?family=Material+Icons';
var h = document.getElementsByTagName('head')[0]; h.parentNode.insertBefore(l, h);
};
var cb2 = function() {
var l = document.createElement('link'); l.rel = 'stylesheet';
l.href = 'https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css';
var h = document.getElementsByTagName('head')[0]; h.parentNode.insertBefore(l, h);
};
var raf = requestAnimationFrame || mozRequestAnimationFrame ||
webkitRequestAnimationFrame || msRequestAnimationFrame;
if (raf) {
	 raf(cb1);
	 raf(cb2);
} else {
	window.addEventListener('load', cb1);
	window.addEventListener('load', cb2);
}

var Geo={};
		function getLocation(e, bypass) {
			e.preventDefault();
			$("#cover").show();
			bypass = typeof bypass !== 'undefined' ? bypass : false;
			var GeoCookie = Cookies.get('location');
			if(GeoCookie == "known" && bypass===false) {
				var lat = Cookies.get('lat');
				var lng = Cookies.get('lng');
				window.location = '<?php echo($baseurl); ?>map/?by=coord&lat=' + lat + '&lng=' + lng;
			} else {
				Materialize.toast('Verifying permissions.', 8000);
		
				if (navigator.geolocation) {
				   navigator.geolocation.getCurrentPosition(success, showError);
				}
			}
		}
		
        //Get the latitude and the longitude;
        function success(position) {
			Materialize.toast('Awesome. Searching...', 8000);
            Geo.lat = position.coords.latitude;
            Geo.lng = position.coords.longitude;
			var coord = [Geo.lat, Geo.lng];
			Cookies.remove('lat', { path: '/' }); // removed!
			Cookies.set('lat', Geo.lat, { expires: 0.01, path: '' });
			Cookies.remove('lng', { path: '/' }); // removed!
			Cookies.set('lng', Geo.lng, { expires: 0.01, path: '' });
			Cookies.set('location', "known", { expires: 0.01, path: '' });
			window.setTimeout("window.location = '<?php echo($baseurl); ?>map/?by=coord&lat=' + Geo.lat + '&lng=' + Geo.lng;",600);         
        }

		function showError(error) {
			$("#cover").hide();
			switch(error.code) {
				case error.PERMISSION_DENIED:
					Materialize.toast('User denied request for Geolocation.', 8000);
					break;
				case error.POSITION_UNAVAILABLE:
					Materialize.toast('Location information is unavailable.', 8000);
					break;
				case error.TIMEOUT:
					Materialize.toast('The request to get user location timed out.', 8000);
					break;
				case error.UNKNOWN_ERROR:
					Materialize.toast('An unknown error occurred.', 8000);
					break;
			}
		}

        function populateHeader(lat, lng){
            $('#Lat').html(lat);
            $('#Long').html(lng);
        }

<?php $output = ob_get_contents();
ob_end_clean();

echo(minify_js($output)); ?>
</script>
