<?php
/*
Plugin Name: Recip.ly Plugin
Plugin URI: 
Description: The recip.ly plugin allows you to easily add the recip.ly checkout process to your recipes.
Author: The Recip.ly Integration team
Version: 1.0.7
Author URI: http://integration.recip.ly
*/

function reciply_addbuttons() 
{
add_filter('mce_external_plugins', "reciply_register");
add_filter('mce_buttons', 'reciply_add_button', 0);
add_filter( "the_content", "url_post" );
}

function url_post($content) {
$permalink = get_permalink();

$post_url = '
			<div class="reciply-addtobasket-widget" href="'.$permalink.'">
			'; 	

return str_replace('<div class="reciply-addtobasket-widget">', $post_url, $content);
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
	add_menu_page('Recip.ly Plugin Settings', 'Recip.ly Settings', 'administrator', __FILE__, 'reciply_settings_page',plugins_url('images/icon.png', __FILE__));

	//call register settings function
	add_action( 'admin_init', 'register_mysettings' );
}

function register_mysettings() {
	//register our settings
	register_setting( 'reciply-settings-group', 'color' );
	register_setting( 'reciply-settings-group', 'image' );
	register_setting( 'reciply-settings-group', 'choix' );		
}

function reciply_settings_page() {
?>
<script type="text/javascript">
//<![CDATA[
onload=function stateColor(){
var color_option= "<?php echo get_option('color'); ?>";
var choix_option= "<?php echo get_option('choix'); ?>";
if (color_option=="orange") {
	document.getElementById("orange").checked = true;
	document.getElementById("red").checked = false;
	}
if (color_option=="red") {
	document.getElementById("red").checked = true;
	document.getElementById("orange").checked = false;
	}
if (choix_option=="reciply") {
	document.getElementById("reciply").checked = true;
	document.getElementById("custom").checked = false;
	}
if (choix_option=="custom") {
	document.getElementById("custom").checked = true;
	document.getElementById("reciply").checked = false;
	}
}
//]]>
function activer(i) {
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
<h2>Recip.ly Plugin</h2>
<form name="optionform" method="post" action="options.php">
    <?php settings_fields('reciply-settings-group'); ?>
    <table class="form-table">
        <tr valign="top">
        <th scope="row"><input type="radio" name="choix" id="reciply" value="reciply" onclick="javascript:activer(0);" /><b>Recip.ly Button :</b></th>
        </tr>	
        <tr valign="top">
        <th scope="row">Color</th>
        <td>
		<label>Orange<input type="radio" id="orange" name="color" disabled="true" value="orange" /></label>
		<label>Red<input type="radio" id="red" name="color" disabled="true" value="red" /></label>
		</td>
        </tr> 
        <tr valign="top">
        <th scope="row"><input type="radio" name="choix" id="custom" value="custom" onclick="javascript:activer(1);" /><b>Custom Image Button :</b></th>
        </tr>		
        <tr valign="top">
        <th scope="row">Image</th>
        <td><input type="file" name="image" disabled="true" onchange="javascript:setpath(this.value);" value="<?php echo get_option('image'); ?>" /></td>
        </tr>
        </tr>		
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
var choix_option= <?php echo json_encode(get_option('choix')); ?>;
</script>
<?php
}
wp_enqueue_script('myscript','/wp-content/plugins/reciply/editor_plugin.js','');
?>