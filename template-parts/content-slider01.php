<?php
/**
 * Template part for displaying page content in homepage.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package kimnaturaV1
 */

?>


<?php

$featured_img_url = get_the_post_thumbnail_url(get_the_ID(),'full'); 
?>

   <div class="slider__item">
        <div class="slider__image" style="background-image: url(<?php echo $featured_img_url ?>)"></div>
        <div class="slider__content">
                <?php the_title( '<h2 class="slider__title">', '</h2>' ); ?>
                <?php 
                the_subtitle( '<p class="slider__subtitle">', '</p>' ); 
                echo '<p class="slider__description">';
                the_content();
                echo '</p>';
                ?>
        </div>
   </div>
 



