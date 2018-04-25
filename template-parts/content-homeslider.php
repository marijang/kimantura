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

   <div class="homeslider__item">
        <div class="homeslider__image" style="background-image: url(<?php echo $featured_img_url ?>)"></div>
        <div class="homeslider__content">
                <?php the_title( '<h3 class="homeslider__title">', '</h3>' ); ?>
                <?php 
                the_subtitle( '<p class="homeslider__subtitle">', '</p>' ); 
                echo '<p class="homeslider__description">';
                the_content();
                echo '</p>';
                ?>
                <a href="<?php the_permalink() ?>" class="btn btn--primary">Saznaj više</a> 
        </div>
   </div>
 



