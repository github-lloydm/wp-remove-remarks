<?php

/**
 * It will remove wordpress traces like logo, link, and etc..
 */

class removeWPtraces
{

    var $sitelogo;

    public function __construct()
    {

        //initialize all function defined    
        $this->init();
    }

    public function init()
    {
        // Custom WP ADMIN LOGO
        add_filter('login_headerurl', array($this, 'set_login_url'));

        // Set site login logo
        add_action('login_enqueue_scripts', array($this, 'set_site_login'));

        // will remove wp traces in admin dashboad
        add_action('wp_before_admin_bar_render', array($this, 'remove_wp_logo_admin_panel'));

        //add aditional text/message below logo
        add_filter('login_message', array($this, 'additional_message_below_logo'));
    }



    public function remove_wp_logo_admin_panel()
    {
?>
        <style type="text/css">
            #wp-admin-bar-wp-logo,
            #dashboard_primary,
            #footer-thankyou {
                display: none;
            }
        </style>

<?php
    }

    /**
     * Will remove wordpress logo and change automatically using the divi theme et_get_option 'divi_logo'
     */
    public function set_login_url()
    {
        return home_url();
    }

    /**
     * will change wordpress logo using divi_logo
     */
    public function set_site_login()
    {
        $logo = ($user_logo = et_get_option('divi_logo')) && !empty($user_logo) ? $user_logo : get_stylesheet_directory_uri() . '/images/logo.png';
		
		$bgimg = esc_attr( get_option( 'profile_picture' ) );

        $style = ' <style>
                       
						#login h1 a, .login h1 a {
                            background-image: url(' . $logo . ');
                            background-color: transparent;
							width: 100%;
							height: 112px;
							background-size: contain;
							background-repeat: no-repeat;
							padding-bottom: 0;
                        }

                        body.login {
                            background-image: url("' . $bgimg . '") !important;
                            background-position: center !important;
                            background-size: cover !important;
                            background-repeat: no-repeat !important;
                            background-color: #fff !important;
                        }

                        .login #backtoblog a, .login #nav a {
                            font-family: "Raleway Bold",Helvetica,Arial,Lucida,sans-serif;
                            text-transform: uppercase;
                            text-decoration: none;
                            font-size: 10px;
                            color: #707070!important;
                            letter-spacing: 3.24px;
                            line-height: 1.2em;
                            display: block;
                            text-align: center;
                        }

                        #backtoblog{
                            display: none;
                        }

                        .login form {
                            margin-top: 20px;
                            margin-left: 0;
                            padding: 26px 24px 46px;
                            font-weight: 400;
                            overflow: hidden;
                            background: rgba(255,255,255,0.8) !important;
                            border: 10px solid rgba(0,0,0,0.1) !important;
                            box-shadow: 0 1px 3px rgba(0,0,0, 0.4) !important;
                            border-radius: 5px !important;
                        }

                        .login .below-logo-msg{
                            font-family: "Raleway Bold",Helvetica,Arial,Lucida,sans-serif;
                            text-transform: uppercase;
                            font-size: 12px;
                            color: #fff!important;
                            letter-spacing: 2px;
                            line-height: 1.2em;
                            background-color: #0D173D;
                            border-radius: 10px;
                            text-align: center;
                            padding: 15px 0;
                        }

                        #wp-submit {
                            width: 100%;
                            margin-top: 20px;
                            color: #ffffff!important;
                            border-width: 1px!important;
                            border-color: #2C6936;
                            border-radius: 30px;
                            font-size: 16px;
                            font-family: "Raleway Bold",Helvetica,Arial,Lucida,sans-serif;
                            text-transform: uppercase!important;
                            background-color: #2C6936;
                            letter-spacing: 2px;
                        }
                    </style>';

        echo (!function_exists('et_divi_100_is_active')) ? $style : '';
    }

    /**
     * Add custom message to wordpress login page
     */
    public function additional_message_below_logo($message)
    {
        if (empty($message)) {
            return "<h3 class='below-logo-msg'>" . get_option('blogdescription') . "</h3>";
        } else {
            return $message;
        }
    }

    /**
     * get the first letter of the site blogname ang set as SVG logo 
     */
    public function create_logo_ifempty()
    {
        $sitename = explode(' ', get_option('blogname'));

        foreach ($sitename as $snames) {
            $firstletter[] = substr($snames, 0, 1);
        }

        return implode('', $firstletter);
    }
}

$site = new removeWPtraces();
