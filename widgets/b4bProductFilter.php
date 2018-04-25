<?php
/*
Plugin Name: B4B Products by category
Description: This plugin displays a list of products of a certain category on your website.
*/


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class B4B_Widget_Product extends WP_Widget
{

    function __construct()
    {
        parent::__construct(
                'woocommerce_ndbProducts',
                __( 'Products by category', 'ndb' ),
                array('description' => __( 'This plugin displays a list of products of a certain category on your website.', 'ndb' )) 
                );
    }

    public function widget( $args, $instance ) {

        extract( $args );
        $title = apply_filters( 'widget_title', $instance['title']);
        $ids   = $instance['ids'];
        $arr_id = explode(',',$ids);
        $query_args = array(
            'post_status'    => 'publish',
            'post_type'      => 'product',
            'no_found_rows'  => 1,
            'posts_per_page' => -1, //-1 needed for displaying all posts of the category
            'tax_query' => array(
                array(
                    'taxonomy' => 'product_cat', //the taxonomy we want to query
                    'field' => 'term_id', //we use the term_id tp find our terms
                    'terms' => $arr_id //our comma seperated list of ID´s
                )
            )
        );

        $r = new WP_Query( $query_args );
        if ( $r->have_posts() ) {

            echo $before_widget;

            if ( $title )
                echo $before_title . $title . $after_title;

            echo '<ul class="product_categories">';

            while ( $r->have_posts()) {
                $r->the_post();
                global $product;
                 ?>
                    <li>
                        <a href="<?php echo esc_url( get_permalink( $product->id ) ); ?>" title="<?php echo esc_attr( $product->get_title() ); ?>">
                            <?php echo $product->get_image(); ?>
                            <?php echo $product->get_title(); ?>
                        </a>
                        <?php if ( ! empty( $show_rating ) ) echo $product->get_rating_html(); ?>
                        <?php echo $product->get_price_html(); ?>
                        <i class="mi">keyboard_arrow_up</i>
                    </li>
                <?php
            }

            echo '</ul>';

            echo $after_widget;
        }

        wp_reset_postdata();

        echo $content;

    }
    // Widget Backend

    public function form($instance){
        $title = (isset($instance['title'])) ? $instance['title'] : __( 'Products', 'ndb' );
        $ids = $instance['ids'];
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"  name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('ids'); ?>"><?php _e('Category:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('ids'); ?>"  name="<?php echo $this->get_field_name( 'ids' ); ?>" type="text" value="<?php echo esc_attr( $ids ); ?>" />
        </p>
        <?php

    }

    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['ids'] = ( ! empty( $new_instance['ids'] ) ) ? strip_tags( $new_instance['ids'] ) : '';
        return $instance;
    }


}



add_action( 'widgets_init', function(){
    register_widget( 'B4B_Widget_Product' );
} );
