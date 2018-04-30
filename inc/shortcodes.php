<?php
/**
 * B4B Payment fix paypal
 *
 * @package kimnaturaV1
 */


//add_action( 'wp_enqueue_scripts', 'mgms_enqueue_assets' );
function mgms_enqueue_assets() {
    wp_enqueue_script( 
        'google-maps-geo', 
        '//maps.googleapis.com/maps/api/js?libraries=geometry', 
        array(), 
        '1.0', 
        true 
      );
	wp_enqueue_script( 
	  'google-maps', 
	  '//maps.googleapis.com/maps/api/js?key=AIzaSyAzXoaC9OV09c-sTdIWWR1hWzUcJppx_g8&callback=initMap', 
	  array(), 
	  '1.0', 
	  true 
    );
   
    
}

//Google Maps Shortcode
//add_shortcode( 'b4b-map', 'b4b_gmaps' );
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
	<div class='map' style='position: relative;height:<?php echo $args['height'] ?>; margin-bottom: 1.6842em' id='map-<?php echo $id ?>'></div> 

	<script type='text/javascript'>

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


	
	  map = new google.maps.Map(document.getElementById('map-<?php echo $id ?>'), {
	    center: {lat: <?php echo $args['lat'] ?>, lng: <?php echo $args['lng'] ?>},
        zoom: <?php echo $args['zoom'] ?>,
        styles: [{"stylers": [{ "saturation": -100 }]}]
      });
      var point= {lat:<?php echo $args['lat'] ?>, lng: <?php echo $args['lng'] ?>};
      var myLatLng = new google.maps.LatLng(point.lat, point.lng)
      var myMarker = new CustomMarker(myLatLng,map);
	}
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