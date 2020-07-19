<?php
date_default_timezone_set('Asia/Kolkata');
$data = $_REQUEST['image_jpeg'];
$date = Date('ymdhis');
$img_name = "image".$date;

define('UPLOAD_DIR','uploads/'); // image dir path

list($type, $data) = explode(';', $data); 

list(, $data)      = explode(',', $data);

$data = str_replace(' ', '+', $data);

$data = base64_decode($data); // base 64 decoding 

print_r($data);

file_put_contents(UPLOAD_DIR.$img_name.".jpeg", $data); // saving the image to required path

?>
