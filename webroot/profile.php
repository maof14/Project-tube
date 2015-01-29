<?php 

/* ** 

This is triton pagecontroller

Detta är en sidkontroller - den ska ligga i katalogen webroot och den har som syfte att visa upp en webbsida. 
*/ 

// config - skall alltid inkluderas (som förut)
include(__DIR__ . '/config.php');

$id = isset($_GET['id']) ? $_GET['id'] : null; // if another user in get. id by link. 
$user = new CUser($triton['database'], $id);

$videoTable = $user->getVideoList();

$triton['title'] = "Welcome";
$triton['main'] = <<<EOD

<h1 class='font-shadow'>{$user->getMember('acronym')}'s profile</h1>
<div class='profile'>
	<div class='left info-column'>
		<div class='profile-pic left'>
			<figure><img src='{$user->getGravatar(160)}' alt='Profile picture'></figure>
		</div>
		<div class='user-info small'>
			<p>Username: <span class='grey'>{$user->getMember('acronym')}</span></p>
			<p>Full name: <span class='grey'>{$user->getMember('name')}</span></p>
			<p>E-mail: <span class='grey'>{$user->getMember('email')}</span></p>
			<p>Profile created: <span class='grey'>{$user->getMember('created')}</span></p>
		</div>
	</div>
	<div class='user-presentation-text left'>
		<h3><span class='label-info'>Presentation</span></h3>
		<p>{$user->getMember('text')}</p>
	</div>
	<div id='videos-by-user' class='left'>
		<p><span class='label-info small'>Videos by this user</span></p>
		$videoTable
	</div>
</div>
EOD;

// slutligen - lämna över detta till renderingen av sidan. 
include(TRITON_THEME_PATH);

