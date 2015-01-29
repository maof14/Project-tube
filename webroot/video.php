<?php 

/* ** 

This is triton pagecontroller

Detta är en sidkontroller - den ska ligga i katalogen webroot och den har som syfte att visa upp en webbsida. 
*/ 

include(__DIR__ . '/config.php');

$url = isset($_GET['v']) ? $_GET['v'] : null;
if(!isset($url)) exit('No video in URL.');
$video = new CVideo($triton['database'], $url);
$videoId = $video->getMember('id');

$triton['title'] = "{$video->getMember('title')}";
$comment = new CComment($triton['database']);

$comments = $comment->getComments($videoId);

$commentForm = isset($_SESSION['user']) ? $comment->getForm($videoId) : null;

$triton['main'] = <<<EOD
<div id='video-page'>
<h1 class='font-shadow'>{$video->getMember('title')}</h1>
<div class='video-area'>
	<video id='video-player' height='400'>
		<source src='video/{$video->getMember('src')}mp4' type='video/mp4'>
		You need to update your browser in order to view this HTML5 video. 
	</video>
</div>
	<div id='media-controls-container'>
		<div id='media-controls'>
			<button id='play-pause' class='controls-button play'></button>
			<button id='toggle-mute' class='controls-button no-mute'></button>
			<canvas id='canvas-progress'>You need to update your browser in order to view this HTML5 video.</canvas>
			<button id='fullscreen' class='controls-button fullscreen'></button>
		</div>
	</div>
	<div id='video-header-data'>
		<div id='video-desc' class='left'>
			<p class='font-shadow'><span class='label-info'>Descripton: </span>{$video->getMember('description')}</p>
			<p class='font-shadow small'><span class='label-info'>Uploaded </span>{$video->getMember('created')} <span class='label-info'>by </span> <a href='profile.php?id={$video->getMember('user')}'>{$video->getMember('acronym')}</a></p>
		</div>
		<div id='video-likes-container' class='right'>
		<p>
		<progress id='video-likes' min=0 max=100 value={$video->getLikeRatio()}></progress>
		</p>
		<form method='post' id='like-form' class='like-form'>
			<button class='like-button left' type='button' name='thumbup' id='thumbup-button'><i class="fa fa-thumbs-up"></i></button>
			<input type='hidden' name='direction' value='up' />
			<input type='hidden' name='videoid' id='videoid' value='{$video->getMember('id')}' />
		</form>
		<form method='post' id='dislike-form' class='like-form'>
			<button class='like-button right' type='button' name='thumbdown' id='thumbdown-button'><i class="fa fa-thumbs-down"></i></button>
			<input type='hidden' name='direction' value='down' />
			<input type='hidden' name='videoid' id='videoid' value='{$video->getMember('id')}' />
		</form>
		</div>
	</div>
</div>
<div class='comments-area'>
<h2>Comments</h2>
{$commentForm}
{$comments}
</div>

EOD;

// slutligen - lämna över detta till renderingen av sidan. 
include(TRITON_THEME_PATH);

