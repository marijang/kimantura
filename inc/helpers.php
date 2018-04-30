<?php
/**
 * B4B Site Theme Helpers
 *
 * @package kimnaturaV1
 */

/**
 * Helper Functions.
*/
// Function to get an image's ID by it's full sized URL
function get_image_id_by_url( $image_url ) {
    global $wpdb;
    $attachment = $wpdb->get_col( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url ) ); 
    return $attachment[0]; 
}


/**
 * Add a social share links.
 */
function b4b_social_icons() {
    $icons_dir = get_template_directory_uri().'/img/social-share/';
    $array = array(
        array(
            "value" => 'Facebook',
            "link"  => '#facebook',
            "image" => 'facebook.svg'
        ),
        array(
            "value" => 'Instagram',
            "link"  => '#instagram',
            "image" => 'instagram.svg'
        ),
        array(
            "value" => 'Twitter',
            "link"  => '#twitter',
            "image" => 'twitter.svg'
        )
    );
    ?>
    <div class="social-followus">
        <h5 class="social-followus__title"> <?php echo  __('Pratite nas','b4b');?></h5>
    <ul class="social-followus__menu">
    <?php
    foreach($array as $item){
   ?>
        <li class="social-followus__item">
            <a href="<?php echo $item['link']?>" class="social-followus__link">
            <?php get_template_part('img/inline/inline',$item['image']) ?>
            </a>
        </li>
    </li>

    <?php
    }
    ?>
    </ul>
    </div>
    <?php

    
}
add_action( 'b4b_social_icons', 'b4b_social_icons' );





/**
 * Add a social share links.
 */
function b4b_cookie_notice() {
    $site_url = get_site_url();
    $policy_url = '/cookie-policy';
    $array = array(
        "link"  => 'Slažem se',
        "text"  => '
        koristi <a href="'.$policy_url.'" target="_blank">kolačiće</a> za pružanje boljeg korisničkog iskustva, funkcionalnosti i prikaza sustava oglašavanja. Za nastavak pregleda i korištenje '.$site_url.' klikni na gumb "Slažem se". Želimo ti ugodno jutro i uspješan dan. Tvoj BLA
        '
    );

    /* This sets the $time variable to the current hour in the 24 hour clock format */
    $time = date("H");
    /* Set the $timezone variable to become the current timezone */
    $timezone = date("e");
    /* If the time is less than 1200 hours, show good morning */
    if ($time < "12") {
        $pozdrav = "Dobro jutro!";
    } else
    /* If the time is grater than or equal to 1200 hours, but less than 1700 hours, so good afternoon */
    if ($time >= "12" && $time < "17") {
        $pozdrav = "Dobar Dan";
    } else
    /* Should the time be between or equal to 1700 and 1900 hours, show good evening */
    if ($time >= "17" && $time < "19") {
        $pozdrav = "Dobro večer";
    } else
    /* Finally, show good night if the time is greater than or equal to 1900 hours */
    if ($time >= "19") {
        $pozdrav = "Laku noć";
    }
    ?>
  <div id="cookie-notice" class="cookie-notice__container">
    <div class="cookie-notice__content cookie_notice">
        <div class="cookie-notice__inner">
            <p class="cookie-notice__description"><?php echo $pozdrav.' '.$array['text']?></p>
            <span class="cookie-notice__close"><?php echo $array['link']?></span>
        </div>
    </div>
    </div>    
    <?php
    wp_enqueue_script( 'b4b-cookie-notice');
}
add_action( 'b4b_cookie_notice', 'b4b_cookie_notice' );
 

// Copyright date
add_action( 'b4b_copyright', 'b4b_copyright' );
function b4b_copyright() {
	global $wpdb;
	$copyright_dates = $wpdb->get_results("
	SELECT
	YEAR(min(post_date_gmt)) AS firstdate,
	YEAR(max(post_date_gmt)) AS lastdate
	FROM
	$wpdb->posts
	WHERE
	post_status = 'publish'
	");
	$output = '';
	if($copyright_dates) {
	$copyright = "© " . $copyright_dates[0]->firstdate;
	if($copyright_dates[0]->firstdate != $copyright_dates[0]->lastdate) {
	$copyright .= '-' . $copyright_dates[0]->lastdate;
	}
	$output = $copyright;
    }
    if (get_theme_mod('copyright_text')){
        $output = get_theme_mod('copyright_text').' '.$output;
    }else{
        $output = ' No Copyright '.$output;
    }
    
	echo  $output;
}
