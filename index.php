<?php
/*
Plugin Name: Recip.ly Plugin
Plugin URI: 
Description: The recip.ly plugin allows you to easily add the recip.ly checkout process to your recipes.
Author: The Recip.ly Integration team
Version: 1.1.6
Author URI: http://integration.recip.ly
*/

function reciply_addbuttons() 
{
add_filter('mce_external_plugins', "reciply_register");
add_filter('mce_buttons', 'reciply_add_button', 0);
add_filter( "the_content", "url_post" );
add_filter( "the_content", "url_img" );
}

function url_post($content) {
$permalink = get_permalink();

$post_url = '
			<div class="reciply-addtobasket-widget" href="'.$permalink.'">
			'; 	
return str_replace('<div class="reciply-addtobasket-widget">', $post_url, $content);
}

function url_img($content) {
$img_url = '
			<img src="./wp-content/plugins/reciply/
			'; 	
return str_replace('<img src="../wp-content/plugins/reciply/', $img_url, $content);
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
	register_setting( 'reciply-settings-group', 'fichier' );	
}

function reciply_settings_page() {
?>
<script type="text/javascript">
var pass = false;
function valider() {
// for save button
var b = false;
var picture = "<?php echo $_GET['img'] ?>";
//var fich = document.getElementById("image").value; 
var choice = document.getElementById("custom").checked;
if (choice==true){
	if (picture == ""){ 
						alert("You must Upload a selected image");
						}
	else { 
		b = true;
		}
	}
else { 
	b = true;
	}
return b;
}

//<![CDATA[
onload=function stateColor(){
var choix_option= "<?php if ($_GET['img']!="") echo "custom"; 
						else 
							echo get_option('choix'); ?>";

if (choix_option=="reciply") {
	document.getElementById("reciply").checked = true;
	document.getElementById("color").disabled = false;
	document.getElementById("custom").checked = false;
	document.optionform.image.disabled = true;
	document.optionform.upload.disabled = true;
	document.getElementById("upload").disabled = true;
	var color_option= "<?php echo get_option('color'); ?>";
	for(i = 0;i < document.getElementById("color").options.length;i++) {
    if(document.getElementById("color").options[i].value == color_option){
		document.getElementById("color").options[i].selected = "selected";
		break;
		}
	}	
}
if (choix_option=="custom") {
	document.getElementById("custom").checked = true;
	document.getElementById("reciply").checked = false;	
	document.getElementById("color").disabled = true;
	document.getElementById("upload").disabled = false;
	}
}
//]]>

function activer(i) {
if (i==0) { 
	document.getElementById("color").disabled = false;
	document.optionform.image.disabled = true;
	document.optionform.upload.disabled = true;
	document.getElementById("upload").disabled = true;
	}
if (i==1) { 
	document.optionform.image.disabled = false;
	document.optionform.upload.disabled = false;
	document.getElementById("upload").disabled = false;
	document.getElementById("color").disabled = true;
	}
}

</script>
<div class="wrap">
<h2>Recip.ly Plugin</h2>
<form name="optionform" enctype="multipart/form-data" method="post" action="options.php" />
    <?php settings_fields('reciply-settings-group'); ?>
    <table class="form-table">
        <tr valign="top">
        <th scope="row"><input type="radio" name="choix" id="reciply" value="reciply" onclick="javascript:activer(0);" /><b>Recip.ly Button :</b></th>
        </tr>	
        <tr valign="top">
        <th scope="row">Color</th>
        <td>
		<SELECT NAME="color" id="color">
		<option value="orange">Orange</option>
		<option value="red">Red</option>
		<option value="green">Green</option>
		</SELECT>
		</td>
        </tr> 
        <tr valign="top">
        <th scope="row"><input type="radio" name="choix" id="custom" value="custom" onclick="javascript:activer(1);" /><b>Custom Image Button :</b></th>
        </tr>		
        <tr valign="top">	
         <th scope="row">Image</th>
        <td>
		<label name="l"><?php echo get_option('fichier'); ?></label><br/>
		<input name="image" type="file" id="image" value="<?php echo get_option('image'); ?>" /><br>
		<input id="upload" name="upload" type="submit" value="Upload" onclick="optionform.action='../wp-content/plugins/reciply/uploadImage.php'; return true;"/>
		</td>
        </tr>
        </tr>		
    </table>    
    <p class="submit">
    <input type="submit" name="save" id="save" class="button-primary" value="<?php _e('Save Changes') ?>" onclick="javascript:valider();"/>
    </p>
</form>
</div>
<?php }
add_action('wp_print_scripts','myscript');
if(($_GET['img'])!="")
	{
	$image_selected = '../wp-content/plugins/reciply/'.$_GET['img']; 	
	update_option('image',$image_selected);		
	}
if(($_GET['f'])!="")
	{
	$fichier = $_GET['f']; 
	update_option('fichier',$fichier);
	}	
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