<?php
/*
Plugin Name: Recip.ly Plugin
Plugin URI: 
Description: The recip.ly plugin allows you to easily add the recip.ly checkout process to your recipes.
Author: The Recip.ly Integration team
Version: 1.0.2
Author URI: http://integration.recip.ly
*/

function reciply_addbuttons() 
{
add_filter('mce_external_plugins', "reciply_register");
add_filter('mce_buttons', 'reciply_add_button', 0);
}

function reciply_add_button($buttons)
{
    array_push($buttons, "separator", "reciply");
    return $buttons;
}

function reciply_register($plugin_array)
{
    $url = trim(get_bloginfo('url'), "/")."/wp-content/plugins/reciply/editor_plugin.js";

    $plugin_array['reciply'] = $url;
    return $plugin_array;
}

add_action('init', 'reciply_addbuttons');

// create custom plugin settings menu
add_action('admin_menu', 'reciply_create_menu');

function reciply_create_menu() {

	//create new top-level menu
	add_menu_page('Reciply Plugin Settings', 'Reciply Settings', 'administrator', __FILE__, 'reciply_settings_page',plugins_url('images/icon.png', __FILE__));

	//call register settings function
	add_action( 'admin_init', 'register_mysettings' );
}


function register_mysettings() {
	//register our settings
	register_setting( 'reciply-settings-group', 'color' );
	register_setting( 'reciply-settings-group', 'image' );
	//register_setting( 'reciply-settings-group', 'url' );	
}

function reciply_settings_page() {
?>
<script type="text/javascript">
function activer(i) {
//var choice_option= <?php echo json_encode(get_option('choix')); ?>;
//alert(i);
if (i==0) { 
	document.getElementById("red").disabled = false;
	document.getElementById("orange").disabled = false;
	document.optionform.image.disabled=true;
	}
if (i==1) { 
	document.optionform.image.disabled=false;
	document.getElementById("red").disabled = true;
	document.getElementById("orange").disabled = true;
	}
}
function setpath(v){
alert(v);
}
</script>
<div class="wrap">
<h2>Reciply Plugin</h2>

<form name="optionform" method="post" enctype="multipart/form-data" action="options.php">
    <?php settings_fields('reciply-settings-group'); ?>
    <table class="form-table">
        <tr valign="top">
        <th scope="row"><input type="radio" name="choix" value="reciply" onclick="javascript:activer(0);" /><b>Reciply Button :</b></th>
        </tr>	
        <tr valign="top">
        <th scope="row">Color</th>
        <td>
		<label>Orange<input type="radio" id="orange" name="color" disabled="true" value="orange" /></label>
		<label>Red<input type="radio" id="red" name="color" disabled="true" value="red" /></label>
		</td>
        </tr> 
        <tr valign="top">
        <th scope="row"><input type="radio" name="choix" value="custom" onclick="javascript:activer(1);" /><b>Custom Image Button :</b></th>
        </tr>		
        <tr valign="top">
        <th scope="row">Image</th>
        <td><input type="file" name="image" disabled="true" onchange="javascript:setpath(this.value);" value="<?php echo get_option('image'); ?>" /></td>
        </tr>
        </tr>		
        <!--<tr valign="top">
        <th scope="row">URL of your Website</th>
        <td><input type="text" name="url" value="<?php echo get_option('url'); ?>" /></td>
        </tr>	-->	
    </table>    
    <p class="submit">
    <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
    </p>
</form>
</div>
<?php }

add_action('wp_print_scripts','myscript');
function myscript() {
?>
<script type="text/javascript">
var image_option= <?php echo json_encode(get_option('image')); ?>;
var color_option= <?php echo json_encode(get_option('color')); ?>;
//var url_option= <?php echo json_encode(get_option('url')); ?>;
</script>
<?php
}
wp_enqueue_script('myscript','/wp-content/plugins/reciply/editor_plugin.js','');
?>