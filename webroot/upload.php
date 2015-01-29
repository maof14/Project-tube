<?php 

/* ** 

This is triton pagecontroller

Detta är en sidkontroller - den ska ligga i katalogen webroot och den har som syfte att visa upp en webbsida. 
*/ 

// upload.php - sidkontroller som ska använda ajax. 

include(__DIR__ . '/config.php');

if(!isset($_SESSION['user'])) exit('You are not authorized to upload!');
$hostname = gethostname();
if(strcmp($hostname, 'Mattiass-MacBook-Air.local') == 0 || strcmp($hostname, 'ubuntuserv1') == 0) {
	$notice = null;
} else {
	$notice = '<output class="error">It seems ffmpeg is not installed on this server. You cant upload videos here :(</output>';
}

$triton['title'] = "Upload";

$triton['main'] = <<<EOD
<h1>Upload</h1>
$notice
<p>Here you can upload videos. Maximum file size for now is 32 MB.</p>
<form id='file-upload' enctype="multipart/form-data" method='post'>
<div class='upload-details hidden'>
<p><label>Title</label><br />
<input type='text' name='title' id='title'></p>
<p><label>Description</label><br />
<textarea name='description' id='description'></textarea></p>
</div>
<span class='btn fileinput-button'>
<span><i class="fa fa-plus"></i> Pick a file</span>
<input class='fileinput' type='file' name='file' id='file' />
</span>
<input class='btn' type='submit' id='submit' name='submit' value='Upload' />
<input type='hidden' id='filename' name='filename' />
</form>
<ul id='file-information'></ul>
<progress id='progress-upload' value='0'></progress>
<output id='upload-output'></output>
EOD;

// slutligen - lämna över detta till renderingen av sidan. 
include(TRITON_THEME_PATH);

