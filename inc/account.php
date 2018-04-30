<?php
/**
 * Account Modifications
 *
 * @link https://woocommerce.com/
 *
 * @package b4b
 */




add_action( 'b4b_account_before','b4b_user_navigation' );
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

			if ( has_nav_menu( 'user-navigation' ) && 1==2) : 
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
				?>
				<nav class="account__navigation-user">
					<ul class="navigation-user__menu">
						<?php 
						$endpoints = wc_get_account_menu_items();
					    // Sort 
						ksort($endpoints);
						// Remove dashboard
						unset($endpoints['dashboard']);
						//foreach ( wc_get_account_menu_items() as $endpoint => $label ) : ?>
						<?php
							$is_current_item = '';
							//var_dump(wc_get_account_menu_item_classes( $endpoint ));
							/*if(array_search('current-menu-item', $endpoint->classes) != 0)
							{
								$is_current_item = ' is-active"';
							}*/
							if (is_wc_endpoint_url( 'view-order' )){

							}
							if (is_wc_endpoint_url( 'edit-account' )){

							}
							
							if (is_wc_endpoint_url( 'edit-address' )){

							}							
							//$endpoints = array('edit-account', 'edit-address','view-order' )
						?>
						<?php foreach ( $endpoints as $endpoint => $label ) : 
								$is_current_item = '';

								$classes = explode(' ',wc_get_account_menu_item_classes( $endpoint ));
								//var_dump(wc_get_account_menu_item_classes( $endpoint ));
								if(array_search('is-active', $classes) != 0)
								{
									$is_current_item = ' is-active"';
								}
							
							?>
							<li class=" navigation-user__menu-item">
								<a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>" class="navigation-user__menu-link <?php echo $is_current_item ?>">
									<?php echo esc_html( $label ); ?>
							    </a>
							</li>
						<?php endforeach; ?>
					</ul>
				</nav>
				<?php
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


/**
 * Redirect users to custom URL based on their role after login
 *
 * @param string $redirect
 * @param object $user
 * @return string
 */
function b4b_custom_user_redirect( $redirect, $user ) {
	// Get the first of all the roles assigned to the user
	//$role = $user->roles[0];
	$dashboard = admin_url();
    $myaccount = get_permalink( wc_get_page_id( 'myaccount' ) );


    /*
	if( $role == 'administrator' ) {
		//Redirect administrators to the dashboard
		$redirect = $dashboard;
	} elseif ( $role == 'shop-manager' ) {
		//Redirect shop managers to the dashboard
		$redirect = $dashboard;
	} elseif ( $role == 'editor' ) {
		//Redirect editors to the dashboard
		$redirect = $dashboard;
	} elseif ( $role == 'author' ) {
		//Redirect authors to the dashboard
		$redirect = $dashboard;
	} elseif ( $role == 'customer' || $role == 'subscriber' ) {
		//Redirect customers and subscribers to the "My Account" page
		$redirect = $myaccount;
	} else {
		//Redirect any other role to the previous visited page or, if not available, to the home
		$redirect = wp_get_referer() ? wp_get_referer() : home_url();
    }
    */
	return $redirect;
}
//add_filter( 'woocommerce_login_redirect', 'b4b_custom_user_redirect', 10, 2 );

function my_login_redirect( $url, $request, $user ){
    if( $user && is_object( $user ) && is_a( $user, 'WP_User' ) ) {
        if( $user->has_cap( 'administrator' ) ) {
            $url = admin_url();
            $url = home_url('/my-account/edit-account/');
        } else {
            $url = home_url('/');
            $url = home_url('/');
        }
    }
    return $url;
}
add_filter('login_redirect', 'my_login_redirect', 10, 3 );

		