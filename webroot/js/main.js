// main.js
// http://ffmpeg.org, video editor open source lib
$(document).ready(function(){ // document ready start. 
	'use strict';

	/*
	* Navmenu button click - show nav menu. 
	*/

	$('#navmenu-button').click(function(){
		$('.navmenu').animate({width:'toggle'}, 350);
		$('.navmenu').toggleClass('inactive');
	});
	// get file information and display it. 
	function readFile(file) {
		$('#file-information').empty();
		var reader = new FileReader();
			var f = file;
			reader.onload = function(e){
				$('#submit').attr('disabled', false);
				$('#upload-output').removeClass('error').empty();
				$('#file-information').append('<li>Filename: ' + e.name + '</li>');
				$('#file-information').append('<li>Last modified: ' + e.lastModifiedDate + '</li>');
				$('#file-information').append('<li>Size: ' + Math.round((e.size/1048576) * 100) / 100 + ' MB</li>');
				$('#file-information').append('<li>Type: ' + e.type + '</li>');
				$('.upload-details').css({'display': 'block'});
				$('#title').val(e.name);
				$('#filename').val(e.name);
				if(e.type !== 'video/quicktime') {
					console.log('Cannot upload this file. Wrong type.');
    				$('#upload-output').toggleClass('error');
    				$('#submit').attr('disabled', 'disabled');
    				$('#upload-output').html('<p>This file cannot be uploaded. We only accept video/quicktime videos for now. Try a video recorded from an iPhone.</p>');
    			}
			}(f);
    	reader.readAsDataURL(f);
	}

	$('#file').on('change', function(){
		if(this.files.length === 1) {
			readFile(this.files[0]);
		} else {
			console.log('Do many files, do not proceed.');
		}
	});

	$('#file-upload').submit(function(event){
		event.preventDefault();
		var data = $('#file')[0].files[0];
		var formData = new FormData();
		formData.append('data', data); // detta blir namnet på det som skickas med formen. 
		formData.append('filename', $('#filename').val());
		formData.append('title', $('#title').val());
		formData.append('description', $('#description').val());
		$.ajax({
			url: 'ajax/process_upload.php',
			type: 'post',
			data: formData,
			xhr: function() {
				var request = $.ajaxSettings.xhr();
				if(request.upload){
					request.upload.addEventListener('progress', handleProgress, false);
				}
				return request;
			},
			success: successMessage,
			error: errorMessage,
			cache: false,
			contentType: false,
			processData: false
		});
	});

	var handleProgress = function(e) {
		$('#progress-upload').css({display:'block'});
		$('#progress-upload').attr({value:e.loaded, max:e.total});
	}
	var successMessage = function(data) {
		console.log('Output: ' + data.output + ', url: ' + data.url);
		var str1 = 'The video is uploaded. <a href="video.php?v=' + data.url + '">Check it out!</a>.<br />';
		var str2 = '<p><label>Or copy the URL: </label><br /><input type="text" id="video-url" value="'+data.link+'" /></p>';
		$('#upload-output').toggleClass('success');
		$('#upload-output').html(str1);
		$('#upload-output').append(str2);
	}
	var errorMessage = function(data) {
		console.log(data.output);
		$('#upload-output').toggleClass('error');
		$('#upload-output').html('<p>Some error appeared.</p>');
	}

	$('#video-url').focus(function(){
		this.select();
	});

	/*
	*
	* Functions to handle commenting. Post comment with ajax and when new comment is posted, load it to the page without reloading the entire page.
	*
	*/

	$('#comment-add').on('click', function(event){
		var data = $('#comment-add').parents('form').serialize();
		$.ajax({
			type: 'post',
			url: 'ajax/process_comments.php',
			data: data,
			dataType: 'json',
			success: commentSuccess
		});
		
	});

	var commentSuccess = function(data) {
		$('#commenttext').val('');
		reloadComments(data.comment);
	}

	function reloadComments(id) {
		$.ajax({
			type: 'get',
			url: 'ajax/process_comments.php?id=' + id,
			dataType: 'json',
			success: function(data) {
				$('#new-comment').after("<div id='comment-" + data.comment.id + "' class='comment'><span class='comment-header'>Posted by <span class='data'><a href='profile.php?id=" + data.comment.userid + "'>" + data.comment.acronym + "</a></span> on <span class='data'>" + data.comment.created + "</span></span><br />" + data.comment.text + "</div>").fadeIn();
				// Man skulle kunna ha lite animate här ocskå, så man ser att den kom dit liksom. Riktigt nice. Nu blire HOW. HEj da. 
			}
		});
	}
	/*
	* Handle likes with ajax
	*
	*/

	// thumbs up
	$('.like-button').on('click', function(){
		$.ajax({
			type: 'post',
			url: 'ajax/process_comments.php',
			data: $(this).parents('form').serialize(),
			dataType: 'json',
			success: function(data) {
				var likes = parseInt(data.result.likes), dislikes = parseInt(data.result.dislikes);
				var total = likes + dislikes;
				var ratio = Math.floor((likes / total) * 100);
				$('#video-likes').val(ratio);
			}
		});
	});

	var likeSuccess = function(data) {
		console.log(data.result);
	}

}); // document ready end.