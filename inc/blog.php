<?php
/**
 * B4B Blog functions
 *
 * @package kimnaturaV1
 */



/* Exclude some categories */
function exclude_category( $query ) {
    $slugs = array('slider','homepage','sastojci');
    foreach($slugs as $slug){
        $cat = get_category_by_slug($slug); 
        if ($cat instanceof WP_TERM){
            $catIDs[] = $cat->term_id;
        }
        
    }  
    if ( $query->is_home() && $query->is_main_query() ) {
        foreach($catIDs as $cat){
            $query->set( 'cat', '-'.$cat );
        }
        
    }
}
add_action( 'pre_get_posts', 'exclude_category' );