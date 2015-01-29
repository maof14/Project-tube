// for video player. 

$('document').ready(function(){ // document ready start. 
	'use strict';
	// global player
	var v = document.getElementById('video-player');

	// Play or pause the video
	$('#play-pause').on('click', function(){ // den börjar med class play. Så måste toggla båda.
		$(this).toggleClass('play').toggleClass('pause');
		if(v.paused || v.ended) {
			v.play();
		}
		else {
			v.pause();
		}
	});

	// Mute video
	$('#toggle-mute').on('click', function(){
		$(this).toggleClass('mute').toggleClass('no-mute');
		if(v.muted == false) {
			v.muted = true;
		} else {
			v.muted = false;
		}
	});

	// Update progress of canvas
	$('#video-player').on('timeupdate', function(){
		updateCanvasProgress();
	});

	// video has ended, alter icon
	$('#video-player').on('ended', function(){
		$('#play-pause').toggleClass('play').toggleClass('pause');
	});

	// fullscreen the video
	$('#fullscreen').on('click', function(){
		v.mozRequestFullScreen();
	});

	// Seek in video
	$('#canvas-progress').on('click', function(event) {
		var ct = document.getElementById('canvas-progress');
		var offset = $('#canvas-progress').offset();
		var target = ((event.clientX - offset.left) / ct.clientWidth * v.duration);
		v.currentTime = target;
	});

	// Get progresses with canvas 
	function updateCanvasProgress(){
		var ct = document.getElementById('canvas-progress');
		var ctx = ct.getContext('2d');
		var width = ct.width, height = ct.height,
		bs = v.buffered.start(0), be = v.buffered.end(0),
		// calculate bufferprogress
		bufferPercentage = Math.floor((100 / v.duration) * be),
		bufferProgress = width * bufferPercentage / 100;
		// draw bufferprogress
		ctx.fillStyle = 'rgb(230, 230, 230)';
		ctx.fillRect(0, 0, bufferProgress, height);
		// calculate playback progress
		var percentage = Math.floor((100 / v.duration) * v.currentTime);
		var progress = width * percentage / 100;
		// draw playback progress
		ctx.fillStyle = 'rgb(230, 0, 0)';
		ctx.fillRect(0, 0, progress, height);
	}

	/*
	* Attempt to show controls upon hovering video player.
	*
	*/

	$('#video-player').mouseover(function(event){
		$('#media-controls-container').css({'visibility': 'visible', 'opacity': 0}).animate({'opacity': 1}, 400);
			$(this).mouseout(function(){
				setTimeout(function(){
				$('#media-controls-container').css({'opacity': 1}).animate({'opacity': 0, 'visibility': 'hidden'}, 400);
			}, 2000);
		});
	});
}); // document ready end.