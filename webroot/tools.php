<?php 

/* ** 

This is triton pagecontroller

Detta är en sidkontroller - den ska ligga i katalogen webroot och den har som syfte att visa upp en webbsida. 
*/ 

// config - skall alltid inkluderas (som förut)
include(__DIR__ . '/config.php');

$htmlpart = nl2br(htmlentities('<div id="sliding-videos">
    <div class="sliding-video"></div>
    <div class="sliding-video"></div>
    <div class="sliding-video"></div>
</div>'));

$topics = "
	<ul id='topics-documentation'>
	<li><h2 class='font-shadow'>Topics</h2></li>
	<li><h3 class='font-shadow'><a href='#jquery-tool'>jQuery slider plugin</a></h3></li>
	<li><h5 class='font-shadow'><a href='#tools-css'>CSS</a></h5></li>
	<li><h5 class='font-shadow'><a href='#tools-html'>HTML / PHP</a></h5></li>
	<li><h5 class='font-shadow'><a href='#tools-jquery'>jQuery</a></h5></li>
	<li><h3 class='font-shadow'><a href='#process-tool'>Video upload and processing</a></h3></li>
	<li><h5 class='font-shadow'><a href='#upload-ajax'>Uploading with Ajax</a></h5></li>
	<li><h5 class='font-shadow'><a href='#upload-server'>Server side processing</a></h5></li>
	<li><h5 class='font-shadow'><a href='#upload-convert'>Converting the video file</a></h5></li>
	</ul>
";

$jQueryCode = nl2br(file_get_contents(TRITON_INSTALL_PATH.'/webroot/js/videosliderplugin.js'));

$triton['title'] = "Tools";
$triton['main'] = <<<EOD
<h1 class='font-shadow'>Tools</h1>
$topics
<h2 class='font-shadow' id='jquery-tool'>jQuery slider plugin</h2>
<p>First impressions on things are important. Website frontpages are no exception to this statement. That is why i have created this plugin, that slides the children of a div over the page. As the plugin is tied closely to this project, I have chosen to let in stay in <a href='https://github.com/maof14/Project-tube'>this repository</a> instead of one of its own. Find it under webroot/js/videosliderplugin.js.</p>
<p>However, renaming your divs to match will surely make it work on your own website.</p>
<h3 id='tools-css'>CSS</h3>
<p>Pretty straigt forward. Using relative position and setting height, width to center the images on screen.</p>
<code>
<p>div#sliding-videos {<br />
  position: relative;<br />
  width: 450px;<br />
  height: 300px;<br />
  margin: 0px auto;<br />
}<br /></p>
<p>div.sliding-video {<br />
  position: absolute;<br />
  height: 100%;<br />
  width: 100%;<br />
  display: none;<br />
  text-align: center;<br />
}<br /></p>
</code>

<h3 id='tools-html'>HTML / PHP generated</h3>
<p>These are the divs that will get slided. In my case, I have an image, embedded in a figure, in a link. You can put anything here, as long as you keep track of the CSS classes and the ID.</p>
<code>
<p>
$htmlpart
</p>
</code>
<h3 id='tools-jquery'>jQuery</h3>
<p>Enough with it, lets get to the actual jQuery code. Found in the, as mentioned file. </p>
<p>First, the page is checked if the video container is present. We don't want the timer to run on all pages. Next, the first target to slide is selected. </p>
<p>Target is slided out, followed by a timer that runs forever (or until another page is requested). This repeats the processed mentioned above, target is aquired, slided out and in with the next using jQuery css and animation functions. Then next target is aquired. Simple as cake!</p>
<code>
<p>
$jQueryCode;
</p>
</code>
<h2 id='process-tool'>Video upload and processing</h2>
<p>This part explains how the video upload and processing works.</p>
<h3 id='upload-ajax'>Uploading with Ajax</h3>
<p>I have chosen to use Ajax through jQuery for the video uploading on this site. I wanted to have direct response without reloading the page during the upload process.</p>
<p>
<code>
$('#file-upload').submit(function(event){<br />
		event.preventDefault();<br />
		var data = $('#file')[0].files[0];<br />
		var formData = new FormData();<br />
		formData.append('data', data);<br />
		formData.append('filename', $('#filename').val());<br />
		formData.append('title', $('#title').val());<br />
		formData.append('description', $('#description').val());<br />
		$.ajax({<br />
			url: 'ajax/process_upload.php',<br />
			type: 'post',<br />
			data: formData,<br />
			xhr: function() {<br />
				var request = $.ajaxSettings.xhr();<br />
				if(request.upload){<br />
					request.upload.addEventListener('progress', handleProgress, false);<br />
				}<br />
				return request;<br />
			},<br />
			success: successMessage,<br />
			error: errorMessage,<br />
			cache: false,<br />
			contentType: false,<br />
			processData: false<br />
		});<br />
	});<br />
</code>
</p>
<p>What happends in the above code is easier than it looks. I have a form called file-upload, who's input is a file.</p>
<p>When this form is submitted, it takes this file and sends it as a FormData object to a script on the server handling the Ajax request.</p>
<h3 id='server-side-upload' id='upload-server'>Server side processing</h3>
<p>The server side must be able to recieve the data from Ajax. When the file is uploaded, it is stored at runtime in the php global &#36;_FILE variable. This is handled in webroot/ajax/process_upload.php file, as stated in the above script.</p>
<p>From the webroot/ajax/process_upload.php script, a new object is created, CProcessVideo. This is where everything to the video happen.</p>
<p>Some code from it: </p>
<p>
<code>
public function __construct(&#36;db){<br />
	&#36;hostname = gethostname();<br />
	switch (&#36;hostname) {<br />
		case 'servername':<br />
			&#36;this->pathToFfmpeg = 'path/to/exec/lib/here'; // A server<br />
			break;<br />
		case 'servername2':<br />
			&#36;this->pathToFfmpeg = 'another/exec/path/here'; // Another server<br />
		default:<br />
		// ... <br />
	}<br />
</code>
</p>
<p>To run the program ffmpeg, one must be able to and use the PHP function exec. This could be a security risk, so be careful here.</p>
<p>This class also moves, assigns a name and uploads path and other into to the db, relavant to the video file.</p>
<h3 class='font-shadow' id='upload-convert'>Converting the video file</h3>
<p>Converting the file with exec:</p>
<p>
<code>
public function processFile() {<br /> 
	if(&#36;this->status) {<br />
		&#36;file = &#36;this->getFileNameWithoutExtension(&#36;this->storePath);<br />
		exec("{&#36;this->pathToFfmpeg} -i {&#36;this->filePath} -vcodec copy -acodec copy {&#36;file}mp4");<br />
		exec("rm {&#36;this->filePath}");<br />
	}<br />
}<br />
</code>
</p>
<p>This code safely converts the file into mp4 format, keeping the original quality. You can see more information on ffmpeg flags <a href='https://ffmpeg.org/ffmpeg.html'>here</a>. Among many other options ffmpeg allows to lower the quality to preserve space on the hard drive. That could be a good idea. However, my class here does not implement that.</p>
<p>When all is done, the file is placed on the server, database updated and now ready to pick up and view with the new HTML5 video element!</p>
EOD;

// slutligen - lämna över detta till renderingen av sidan. 
include(TRITON_THEME_PATH);

