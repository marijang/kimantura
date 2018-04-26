<?php
/**
 * kimnaturaV1 Theme Customizer
 *
 * @package kimnaturaV1
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function b4b_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';


	$wp_customize->add_section( 'mytheme_options', 
         array(
            'title'       => __( 'Bit4Bytes Options', 'b4b' ), //Visible title of section
            'priority'    => 35, //Determines what order this appears in
            'capability'  => 'edit_theme_options', //Capability needed to tweak
            'description' => __('Allows you to customize some example settings for MyTheme.', 'b4b'), //Descriptive tooltip
         ) 
	);
	  //2. Register new settings to the WP database...
      $wp_customize->add_setting( 'footer_text', //No need to use a SERIALIZED name, as `theme_mod` settings already live under one db record
         array(
            'default'    => 'Test', //Default setting/value to save
            'type'       => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport'  => 'postMessage', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
	  );  
	  $wp_customize->add_setting( 'copyright_text', //No need to use a SERIALIZED name, as `theme_mod` settings already live under one db record
	  array(
		 'default'    => 'Test', //Default setting/value to save
		 'type'       => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
		 'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
		 'transport'  => 'postMessage', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
	  ) 
   ); 
	  /*
	  $wp_customize->add_control(
		'footer_control', 
		array(
			'label'    => __( 'Footer Text', 'b4b' ),
			'section'  => 'mytheme_options',
			'settings' => 'footer_text',
			'type'     => 'textarea',
			'choices'  => array(
				'left'  => 'left',
				'right' => 'right',
			),
		)
	);
	*/
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'footer_control',
			array(
				'label'    => __( 'Footer Text', 'b4b' ),
				'section'  => 'mytheme_options',
				'settings' => 'footer_text',
				'type'     => 'textarea',
				'choices'  => array(
					'left'  => 'left',
					'right' => 'right',
				),
			)
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'copyright_text',
			array(
				'label'    => __( 'Copyright Text', 'b4b' ),
				'section'  => 'mytheme_options',
				'settings' => 'copyright_text',
				'type'     => 'text',
				'choices'  => array(
					'left'  => 'left',
					'right' => 'right',
				),
			)
		)
	);

	//$wp_customize->get_setting( 'footer_control' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => 'kimnaturav1_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => 'kimnaturav1_customize_partial_blogdescription',
		) );
	}
}
add_action( 'customize_register', 'b4b_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function kimnaturav1_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function kimnaturav1_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function kimnaturav1_customize_preview_js() {
	wp_enqueue_script( 'kimnaturav1-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'kimnaturav1_customize_preview_js' );
