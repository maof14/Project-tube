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
<p class='font-shadow'>Using PHP and JavaScript, this site utilizes the PHP class CVideoProcess in order to allow video uploads. The videos are converted to the html-friendly format mp4 and a snapshot is made of the video. Using JavaScript and jQuery, video uploads have never been easier.</p>
<p class='font-shadow'>This page acts as a showcase for a bunch of tools I have created for these purposes in PHP, JavaScript with the help of jQuery and ffmpeg.</p>
<p class='font-shadow'>Try uploading a video and share it with your friends!</p>
<p class='font-shadow'>You can find more details on the tools <a href='plugin.php'>here</a>.</p>
<p class='font-shadow'>You are also welcome to visit my <a href='https://github.com/maof14'>Github page</a>.</p>
EOD;

// slutligen - lämna över detta till renderingen av sidan. 
include(TRITON_THEME_PATH);

