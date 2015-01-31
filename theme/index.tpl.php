<!doctype html>
<html lang='<?=$lang?>' class='no-js'>
<head>
	<meta charset='utf-8'/>
	<title><?=get_title($title)?></title>
	<?php if(isset($favicon)): ?><link rel='shortcut icon' href='<?=$favicon?>'/><?php endif; ?>
	<link rel='stylesheet' type='text/css' href='<?=$stylesheet?>'>
	<?php if(isset($stylesheets)): ?>
	<?php foreach($stylesheets as $val): ?>
	<link rel="stylesheet" type="text/css" href='<?=$val?>'/>
	<?php endforeach; ?>
	<?php endif; ?>
	<?php if(isset($js['above'])) : ?> 
		<?php foreach($js['above'] as $val): ?> 
			<script src='<?=$val?>'></script>
		<?php endforeach; ?>
	<?php endif; ?>
</head>
<body>
	<div id='header'>
	<div class='container'><img src='img/nav.png' alt='nav' height='50' id='navmenu-button' /><?=$header?></div>
	<?=$navmenu?>
	</div>
	<div id='main'><?=$main?></div>
	<div id='footer'><?=$footer?></div>
	<?php if(isset($js['below'])) : ?> 
		<?php foreach($js['below'] as $val): ?> 
			<script src='<?=$val?>'></script>
		<?php endforeach; ?>
	<?php endif; ?>
</body>
</html>