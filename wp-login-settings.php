<?php

function demo_settings_page()
{
    add_settings_section("section", "Section", null, "demo");
    add_settings_field("wplogin-bg", "WP Login background", "demo_file_display", "demo", "section");  
    register_setting("section", "wplogin-bg", "handle_file_upload");
}

function handle_file_upload($option)
{
    if(!empty($_FILES["wplogin-bg"]["tmp_name"]))
    {
        $urls = wp_handle_upload($_FILES["wplogin-bg"], array('test_form' => FALSE));
        $temp = $urls["url"];
        return $temp;   
    }

    return $option;
}

function demo_file_display()
{
   ?>
        <input type="file" name="wplogin-bg" /> 
        <?php echo get_option('wplogin-bg'); ?>
   <?php
}

add_action("admin_init", "demo_settings_page");

function demo_page()
{
  ?>
      <div class="wrap">
         <h1>WP Login</h1>
		 <p>Please upload an image for the login background if you wish to change the login background.</p>

         <form method="post" action="options.php">
            <?php
               settings_fields("section");

               do_settings_sections("demo");

               submit_button(); 
            ?>
         </form>
      </div>
   <?php
}

function menu_item()
{
  add_submenu_page("options-general.php", "Demo", "Demo", "manage_options", "demo", "demo_page"); 
}

add_action("admin_menu", "menu_item");