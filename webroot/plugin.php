<?php 

/* ** 

This is triton pagecontroller

Detta är en sidkontroller - den ska ligga i katalogen webroot och den har som syfte att visa upp en webbsida. 
*/ 

// config - skall alltid inkluderas (som förut)
include(__DIR__ . '/config.php');

$triton['title'] = "Plugin";
$triton['main'] = <<<EOD
<h1 class='font-shadow'>The plugins</h1>
<p>Vad skriva här då.. :S</p>
EOD;

// slutligen - lämna över detta till renderingen av sidan. 
include(TRITON_THEME_PATH);

