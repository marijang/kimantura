<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package kimnaturaV1
 */

?>



</div><!-- #page container -->


   <footer>
        <div class="footer__content">
           <div>
             <figure class="footer__logo">
             <img src="<?php echo get_template_directory_uri(); ?>/img/logo.png" alt="Logo" width="HERE" height="HERE" />
            </figure>
             <p>
             <?php
                echo get_bloginfo( 'description', 'display' );
             ?>
               
             </p>
           </div>
           <div class="footer__links">
            <?php
               wp_nav_menu(array(
                    'theme_location' => 'footer-1',
                    'container' => false,
                    'menu_id' => 'primary-menu',
                    'menu_class'		=> 'footer-nav',
                    'depth' => 1,
                    // This one is the important part:
                    'walker' => new Footer_Walker_Nav_Menu
                ));
            ?>
           </div>
           <div class="footer__links">
                <?php
                wp_nav_menu(array(
                        'theme_location' => 'footer-2',
                        'container' => false,
                        'menu_id' => 'primary-menu',
                        'menu_class'		=> 'footer-nav',
                        'depth' => 1,
                        // This one is the important part:
                        'walker' => new Footer_Walker_Nav_Menu
                    ));
                ?>
              
           </div>
       

        </div>
        <div class="footer__info">
             <small>
			 <?php
				/* translators: 1: Theme name, 2: Theme author. */
				printf( esc_html__( 'Theme: %1$s by %2$s.', 'kimnaturav1' ), 'kimnaturav1', '<a href="http://underscores.me/">Underscores.me</a>' );
				?>
			 </small>
        </div>
       
     </footer>






<?php wp_footer(); ?>

</body>
</html>
