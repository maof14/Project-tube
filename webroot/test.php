<?php 

include "config.php";

$db = new CDatabase($triton['database']);

$hejsan = exec('hostname');

echo $hejsan;



// i php exec
// hostname mac = Mattiass-MacBook-Air.local
// which ffmpeg = /usr/local/bin/ffmpeg


// hostname server = ubuntuserv1
// which ffmpeg = /usr/bin/ffmpeg
// which ffmpeg ubuntuserv1 = 
// vad skulle jag testa här då... 

// skulle testa göra ett table för att se lite saker. 
