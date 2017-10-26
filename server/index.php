<?php
$request = explode('/', $_GET['url']);

$word = $request[0];
$language = $request[1];

echo $word . ' - ' . $language;