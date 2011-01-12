<?php
/*
Plugin Name: Purchase Ingredients
Plugin URI: 
Description: Purchase Ingredients
Author: Karim Ntic
Version: 1.0.0
Author URI: 
*/

function purchase_addbuttons() 
{
add_filter('mce_external_plugins', "purchase_register");
add_filter('mce_buttons', 'purchase_add_button', 0);
}

function purchase_add_button($buttons)
{
    array_push($buttons, "separator", "purchase");
    return $buttons;
}

function purchase_register($plugin_array)
{
    $url = trim(get_bloginfo('url'), "/")."/wp-content/plugins/purchase/editor_plugin.js";

    $plugin_array['purchase'] = $url;
    return $plugin_array;
}

add_action('init', 'purchase_addbuttons');

?>