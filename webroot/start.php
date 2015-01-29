<?php 

/* ** 

This is triton pagecontroller

Detta är en sidkontroller - den ska ligga i katalogen webroot och den har som syfte att visa upp en webbsida. 
*/ 

// config - skall alltid inkluderas (som förut)
include(__DIR__ . '/config.php');

$startpage = new CStartpage($triton['database']);

$rolling = $startpage->getLatestVideos();

$triton['title'] = "Start";
$triton['main'] = <<<EOD
<h1 class='welcome font-shadow'>Your files. On your conditions.</h1>
$rolling
<h2 class='font-shadow'>How does it work?</h2>
<p class='font-shadow'>This is the page of Project &lt; tube &gt; </p>
<p>New videos, blabla</p>
<img src='img.php?src=vid498219.png&width=100' />
EOD;

// slutligen - lämna över detta till renderingen av sidan. 
include(TRITON_THEME_PATH);

