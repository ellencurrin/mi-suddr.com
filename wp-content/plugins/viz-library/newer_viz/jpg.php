<?php

$svg = '<?xml version="1.0" encoding="UTF-8" standalone="no"?><svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="959" height="593"><circle cx="50" cy="50" r="40" stroke="green" stroke-width="4" fill="yellow" /></svg>';

$svg = '<?xml version="1.0" encoding="UTF-8" standalone="no"?>';
$svg.= $_POST['img_content'];

$image = new Imagick();

$image->readImageBlob($svg);
$image->setImageFormat("jpg");
header("Content-Type: image/jpg");
header("Content-Disposition: attachment; filename={$_POST['img_title']}.jpg");
echo $image;

// header("Content-Type:text/plain");;
// header("Content-Disposition: attachment; filename={$_POST['img_title']}.txt");
// echo $svg;

?>