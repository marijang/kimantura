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


<!-- #page container -->


   <footer>
        <div class="footer__content">
           <div>
             <figure class="footer__logo">
             <img src="<?php echo get_template_directory_uri(); ?>/img/kimnatura-white.png" alt="Logo" width="HERE" height="HERE" />
            </figure>
             <p>
             <?php
                //echo get_bloginfo( 'description', 'display' );
                echo get_theme_mod('footer_text');
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
                if ( has_nav_menu( 'footer-2' ) ) : 
                wp_nav_menu(array(
                        'theme_location' => 'footer-2',
                        'container' => false,
                        'menu_id' => 'footer-2',
                        'menu_class'		=> 'footer-nav',
                        'depth' => 1,
                        // This one is the important part:
                        'walker' => new Footer_Walker_Nav_Menu
                    ));
                endif;
                do_action('b4b_social_icons');
                ?>
                
              
           </div>
       

        </div>
        <div class="footer__info">
             <small>
			 <?php
                /* translators: 1: Theme name, 2: Theme author. */
                
				
                ?>

                <?php  do_action('b4b_copyright'); ?>
			 </small>
        </div>
       
     </footer>
     <?php do_action('b4b_cookie_notice')?>





<?php do_action('b4b_after_footer');?>
<?php wp_footer(); ?>

</body>
</html>
