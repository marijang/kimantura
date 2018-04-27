<?php
/**
 * Account Modifications
 *
 * @link https://woocommerce.com/
 *
 * @package b4b
 */


add_action( 'b4b_woocommerce_account_navigation1','b4b_user_navigation' );
if ( ! function_exists( 'b4b_user_navigation' ) ) {
	/**
	 * Before Check out.
	 *
	 * Wraps all WooCommerce content in wrappers which match the theme markup.
	 *
	 * @return void
	 */
	function b4b_user_navigation() {
    ?>
<div class="navigation-user">
        <div class="navigation-user__wrap">
	    <?php
		if ( is_user_logged_in() ) {
			$current_user = wp_get_current_user();
			if ( has_nav_menu( 'user-navigation' ) ) : 
			wp_nav_menu(array(
				'theme_location' => 'user-navigation',
				'container'      => false,
				'menu_id'        => 'navigation-user',
				'menu_class'     => 'navigation-user__menu',
				'depth' => 1,
				// This one is the important part:
				'walker' => new user_Walker_Nav_Menu
			  ));
			else: 
				'Nedostaje menu user-navigation';
			endif;
	    ?>
		<div class="navigation-user__info">
		   <span class="navigation-user__info-name"> <?php echo $current_user->user_email?></span>
		   <a href="<?php echo wp_logout_url()?>" class="navigation-user__info-link" ><?php echo __('Odjavite se','b4b') ?></a>
		</div>
		
		<?php
		} else {
		?>
			<div class="page__user-profile">
				Niste logirani
			</div>
		<?php
		}
		?>
		</div>
        </div>
    <?php
    }
}

		