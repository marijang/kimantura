<?php
/**
 * B4B Payment fix paypal
 *
 * @package kimnaturaV1
 */


add_action( 'wp_enqueue_scripts', 'b4b_map_enqueue_assets' );
function b4b_map_enqueue_assets() {
  /*
    wp_enqueue_script( 
        'google-maps-geo', 
        '//maps.googleapis.com/maps/api/js?libraries=geometry&key=AIzaSyCV8YEvsysGHxNf-YljgxfcLDYmH371ppE', 
        array(), 
        '1.0', 
        true 
      );
      */
	wp_enqueue_script( 
	  'google-maps', 
	  '//maps.googleapis.com/maps/api/js?key=AIzaSyCV8YEvsysGHxNf-YljgxfcLDYmH371ppE', 
	  array(), 
	  '1.0'
    );
   
    
}

//Google Maps Shortcode
add_shortcode( 'b4b-map', 'b4b_gmaps' );
function b4b_gmaps( $args ) {
	$args = shortcode_atts( array(
		'lat'    => '48.856259',
		'lng'    => '2.365043',
		'zoom'   => '8',
		'height' => '700px'
	), $args, 'map' );


	$id = substr( sha1( "Google Map" . time() ), rand( 2, 10 ), rand( 5, 8 ) );
	ob_start();
	?>
	<div class='map' id="karta" style='position: relative;height:<?php echo $args['height'] ?>;'></div> 

	<script type='text/javascript'>
jQuery(document).ready(function(){
function initMap() {
  function CustomMarker(latlng,  map) {
    this.latlng_ = latlng;
    this.setMap(map);
  }

  CustomMarker.prototype = new google.maps.OverlayView();
  CustomMarker.prototype.draw = function() {
    var me = this;
    var div = this.div_;
    if (!div) {
      div = this.div_ = document.createElement('DIV');
      div.style.border = "none";
      div.style.position = "absolute";
      div.style.paddingLeft = "0px";
      div.style.cursor = 'pointer';
      this.div = div;
      var span = document.createElement('div');
      span.classList.add('pin');
      span.classList.add('bounce');
      span.innerHTML = '';
      div.appendChild(span);

      var pulse = document.createElement('div');
      pulse.classList.add('pulse');
      div.appendChild(pulse);
        
      //you could/should do most of the above via styling the class added below
      div.classList.add('pin-ala');

      google.maps.event.addDomListener(div, "click", function(event) {
        google.maps.event.trigger(me, "click");
      });

      var panes = this.getPanes();
      panes.overlayImage.appendChild(div);
    }

    var point = this.getProjection().fromLatLngToDivPixel(this.latlng_);
    if (point) {
      div.style.left = point.x + 'px';
      div.style.top = point.y + 'px';
    }
  };

  CustomMarker.prototype.remove = function() {
    if (this.div_) {
      this.div_.parentNode.removeChild(this.div_);
      this.div_ = null;
    }
  };

  CustomMarker.prototype.getPosition = function() {
   return this.latlng_;
  };

;


	
	  map = new google.maps.Map(document.getElementById('karta'), {
	    center: {lat: <?php echo $args['lat'] ?>, lng: <?php echo $args['lng'] ?>},
        zoom: <?php echo $args['zoom'] ?>,
        styles: [{"stylers": [{ "saturation": -100 }]}]
      });
      var point= {lat:<?php echo $args['lat'] ?>, lng: <?php echo $args['lng'] ?>};
      var myLatLng = new google.maps.LatLng(point.lat, point.lng)
      var myMarker = new CustomMarker(myLatLng,map);
  }


initMap();
  });
	</script>

	<?php
	$output = ob_get_clean();
	return $output;
}



/**
 * Add a social share links.
 */
function social_sharing()
{ 
	extract(shortcode_atts(array(), $atts));	
	return'
	<label class="social-sharing-label" for="social-open-link">Share This Article</label>
<input type="checkbox" id="social-open-link">
	<div id="social-sharing-container">
		<a class="social-sharing-icon social-sharing-icon-facebook" target="_new" href="http://www.facebook.com/share.php?u=' . urlencode(get_the_permalink()) . '&title=' . urlencode(get_the_title()). '"><i class="fa fa-facebook-square"></i></a>
		<a class="social-sharing-icon social-sharing-icon-twitter" target="_new" href="http://twitter.com/home?status='. urlencode(get_the_title()). '+'. urlencode(get_the_permalink()) . '"><i class="fa fa-twitter-square"></i></a>
		<a class="social-sharing-icon social-sharing-icon-pinterest" target="_new" href="https://pinterest.com/pin/create/button/?url=' . urlencode(get_the_permalink()) . '&media=' . urlencode(get_template_directory_uri()."/img/logo.png") . '&description=' . urlencode(get_the_title()). '"><i class="fa fa-pinterest-square"></i></a>
		<a class="social-sharing-icon social-sharing-icon-google-plus" target="_new" href="https://plus.google.com/share?url=' . urlencode(get_the_permalink()) . '"><i class="fa fa-google-plus-square"></i></a>
		<a class="social-sharing-icon social-sharing-icon-linkedin" target="_new" href="http://www.linkedin.com/shareArticle?mini=true&url=' . urlencode(get_the_permalink()) . '&title=' . urlencode(get_the_title()) . '&source=' . get_bloginfo("url") . '"><i class="fa fa-linkedin-square"></i></a>
		<a class="social-sharing-icon social-sharing-icon-tumblr" target="_new" href="http://www.tumblr.com/share?v=3&u=' . urlencode(get_the_permalink()) . '&t=' . urlencode(get_the_title()). '"><i class="fa fa-tumblr-square"></i></a>
		<a class="social-sharing-icon social-sharing-icon-email" target="_new" href="mailto:?subject=' . urlencode(get_the_permalink()) . '&body=Check out this article I came across '. get_the_permalink() .'"><i class="fa fa-share"></i></a>
	</div>
';
}
add_shortcode("social_sharing", "social_sharing");




/* eyespeak share */
function eyespeak_share() { ?>
  <script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#domready=1"></script>
	<div class="sharing sharing__inline">

		<div class="addthis_toolbox" addthis:url="http://example.com" addthis:title="An excellent website">
			<div class="custom_images">
				<a class="addthis_button_twitter"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32" version="1.1" role="img" aria-labelledby="at-svg-twitter-2" class="at-icon at-icon-twitter" style="fill: rgb(34, 34, 34); width: 32px; height: 32px;"><title id="at-svg-twitter-2">Twitter</title><g><path d="M27.996 10.116c-.81.36-1.68.602-2.592.71a4.526 4.526 0 0 0 1.984-2.496 9.037 9.037 0 0 1-2.866 1.095 4.513 4.513 0 0 0-7.69 4.116 12.81 12.81 0 0 1-9.3-4.715 4.49 4.49 0 0 0-.612 2.27 4.51 4.51 0 0 0 2.008 3.755 4.495 4.495 0 0 1-2.044-.564v.057a4.515 4.515 0 0 0 3.62 4.425 4.52 4.52 0 0 1-2.04.077 4.517 4.517 0 0 0 4.217 3.134 9.055 9.055 0 0 1-5.604 1.93A9.18 9.18 0 0 1 6 23.85a12.773 12.773 0 0 0 6.918 2.027c8.3 0 12.84-6.876 12.84-12.84 0-.195-.005-.39-.014-.583a9.172 9.172 0 0 0 2.252-2.336" fill-rule="evenodd"></path></g></svg></a>
				<a class="addthis_button_facebook">
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32" version="1.1" role="img" aria-labelledby="at-svg-facebook-1" class="at-icon at-icon-facebook" style="fill: rgb(34, 34, 34); width: 32px; height: 32px;"><title id="at-svg-facebook-1">Facebook</title><g><path d="M22 5.16c-.406-.054-1.806-.16-3.43-.16-3.4 0-5.733 1.825-5.733 5.17v2.882H9v3.913h3.837V27h4.604V16.965h3.823l.587-3.913h-4.41v-2.5c0-1.123.347-1.903 2.198-1.903H22V5.16z" fill-rule="evenodd"></path></g></svg>
        </a>
				<a class="addthis_button_pinterest"></a>
        <a class="addthis_button_email"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32" version="1.1" role="img" aria-labelledby="at-svg-email-5" class="at-icon at-icon-email" style="fill: rgb(34, 34, 34); width: 32px; height: 32px;"><title id="at-svg-email-5">Email</title><g><g fill-rule="evenodd"></g><path d="M27 22.757c0 1.24-.988 2.243-2.19 2.243H7.19C5.98 25 5 23.994 5 22.757V13.67c0-.556.39-.773.855-.496l8.78 5.238c.782.467 1.95.467 2.73 0l8.78-5.238c.472-.28.855-.063.855.495v9.087z"></path><path d="M27 9.243C27 8.006 26.02 7 24.81 7H7.19C5.988 7 5 8.004 5 9.243v.465c0 .554.385 1.232.857 1.514l9.61 5.733c.267.16.8.16 1.067 0l9.61-5.733c.473-.283.856-.96.856-1.514v-.465z"></path></g></svg></a>
        <a id="atcounter"></a>
			</div>
		</div>
	</div>
	<script>
		var addthis_share = {
			// ... other options
			url_transforms : {
				shorten: {
					twitter: 'bitly'
				}
			}, 
			shorteners : {
				bitly : {}
			}
    }
   // addthis.counter("#atcounter");
		jQuery(document).ready(function($) {
			jQuery('.sharing-button').click(function(){
				$(this).parent('.sharing').toggleClass('active');
			});
		});
	</script>
<?php
} 