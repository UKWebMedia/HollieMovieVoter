<?php
$cover = $_GET['file'];

$type = pathinfo($cover, PATHINFO_EXTENSION);
$data = file_get_contents($cover);
$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

echo $base64;

