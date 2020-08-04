<?php

/*
	
@package sunsettheme
	
	========================
		ADMIN PAGE
	========================
*/

function wplogin_load_admin_scripts( $hook ){
	
	if( 'toplevel_page_wplogin_settings' != $hook ){ return; }
	
	wp_register_style( 'sunset_admin', get_stylesheet_directory_uri() . '/wp-login/css/wplogin.admin.css', array(), '1.0.0', 'all' );
	wp_enqueue_style( 'sunset_admin' );
	
	wp_enqueue_media();
	
	wp_register_script( 'wplogin-admin-script', get_stylesheet_directory_uri() . '/wp-login/js/wplogin.admin.js', array('jquery'), '1.0.0', true );
	wp_enqueue_script( 'wplogin-admin-script' );
	
}
add_action( 'admin_enqueue_scripts', 'wplogin_load_admin_scripts' );




function sunset_add_admin_page() {
	
	//Generate Sunset Admin Page
	add_menu_page( 'Login Settings', 'Login Settings', 'manage_options', 'wplogin_settings', 'wplogin_theme_create_page', 'dashicons-admin-plugins', 110 );
	
	//Generate Sunset Admin Sub Pages
	add_submenu_page( 'wplogin_settings', 'Login Theme Options', 'General', 'manage_options', 'wplogin_settings', 'wplogin_theme_create_page' );
}
add_action( 'admin_menu', 'sunset_add_admin_page' );

//Activate custom settings
add_action( 'admin_init', 'wplogin_custom_settings' );

function wplogin_custom_settings() {
	register_setting( 'wplogin-settings-group', 'profile_picture' );
	add_settings_section( 'wplogin-sidebar-options', 'Login Background', 'wplogin_sidebar_options', 'wplogin_settings');	
	add_settings_field( 'sidebar-profile-picture', 'Profile Picture', 'wplogin_sidebar_profile', 'wplogin_settings', 'wplogin-sidebar-options');
}

function wplogin_sidebar_options() {
	echo 'If you wish to change the login background, you can change by uploading the image..';
}

function wplogin_sidebar_profile() {
	$picture = esc_attr( get_option( 'profile_picture' ) );
	echo '<input type="button" class="button button-secondary" value="Upload Profile Picture" id="upload-button">';
	echo '<input type="hidden" id="profile-picture" name="profile_picture" value="'.$picture.'" />';
	
	echo '<input disabled class="background-picture-directory" type="input" value="'.$picture.'">';
}


function wplogin_theme_create_page() {
	?>
		<h1>Login Theme Options</h1>
		<?php settings_errors(); ?>
		<?php 
			
			$picture = esc_attr( get_option( 'profile_picture' ) );
			
		?>
		<div class="wplogin-sidebar-preview">
			<div class="wplogin-sidebar">
				<div class="image-container">
					<div id="profile-picture-preview" class="profile-picture" style="background-image: url(<?php print $picture; ?>);"></div>
				</div>
			</div>
		</div>

		<form method="post" action="options.php" class="wplogin-general-form">
			<?php settings_fields( 'wplogin-settings-group' ); ?>
			<?php do_settings_sections( 'wplogin_settings' ); ?>
			<?php submit_button(); ?>
		</form>
	<?php
}
