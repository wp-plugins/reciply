<?php

/*
Plugin Name: Recip.ly Plugin
Plugin URI: 
Description: The recip.ly plugin allows you to easily add the recip.ly checkout process to your recipes.
Author: The Recip.ly Integration team
Version: 1.0.8
Author URI: http://integration.recip.ly
*/

$ref = $_SERVER['HTTP_REFERER'];

// Taille maximum
$MAX_FILE_SIZE = 150000;

// Dossier de destination du fichier
$serverpath = "../wp-content/plugins/reciply/images/";// Path to where images should be uploaded to on the server.
$urltoimages = "../images"; // Web address to where the images are accessible from.

// Tableau array des diff�rents types
$allowed_types = array("image/bmp", "image/gif", "image/pjpeg", "image/jpeg", "image/jpg", "image/png");

// Variables r�cup�r�e par methode POST du formulaires
$fname = $HTTP_POST_FILES['image']['name'];
$ftype = $HTTP_POST_FILES['image']['type'];
$fsize = $HTTP_POST_FILES['image']['size'];
$ftmp = $HTTP_POST_FILES['image']['tmp_name'];
$path = "$serverpath$fname";

// Diverses test afin de savoir si :
// Le format de fichier correspond � notre tableau array
if(!in_array($ftype, $allowed_types)){$error = 1;}

// La taille du fichier n'est pas d�pass�e
if($fize > $MAX_FILE_SIZE){$error = 2;}

// Le fichier n'existe pas d�j�
if(file_exists($serverpath."m_".$fname)){$error = 3;}

// Si tout va bien, c'est bien d�roul�
if(copy($ftmp,''.$serverpath.''.$fname.'')) {$error = 0;}

header( 'refresh: 0; url='.$ref.'&img='.$path.'&target="_blank"');
?>