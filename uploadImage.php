<?php

// File version 1.1.7
$ref = $_SERVER['HTTP_REFERER'];

// Taille maximum 
$MAX_FILE_SIZE = 400000;

// Dossier de destination du fichier
$serverpath = "images/";// Path to where images should be uploaded to on the server.

foreach ($_FILES as $file) {
$allowed_types = array("image/bmp", "image/gif", "image/pjpeg", "image/jpeg", "image/jpg", "image/png");
$fname = $file['name'];
$ftype = $file['type'];
$fsize = $file['size'];
$ftmp =$file['tmp_name'];
$path = "$serverpath$fname";
}

// Diverses test afin de savoir si :
// Le format de fichier correspond � notre tableau array
if(!in_array($ftype, $allowed_types)){$error = 1;}

// La taille du fichier n'est pas d�pass�e
if($fize > $MAX_FILE_SIZE){$error = 2;}

// Le fichier n'existe pas d�j�
if(file_exists($serverpath."m_".$fname)){$error = 3;}

// Si tout va bien, c'est bien d�roul�
if(move_uploaded_file($ftmp,''.$serverpath.''.$fname.'')) {$error = 0;}

if($fname!="") {
				header('refresh: 0; url='.$ref.'&img='.$path.'&f='.$fname.'&target="_blank"');
				}
else {
		header('refresh: 0; url='.$ref);
	}

?>