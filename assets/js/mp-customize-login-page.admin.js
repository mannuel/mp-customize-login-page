jQuery(document).ready( function($) {
	var mediaUploader;

	$('#upload-login-image-button').on('click',function(e){
		e.preventDefault();
		if (mediaUploader) {
			mediaUploader.open();
			return;
		}

		mediaUploader = wp.media.frames.file_frame = wp.media({
			title: 'Choose a image for login page',
			button: {
				text: 'Choose a picture'
			},
			multiple: false
		});

		mediaUploader.on('select', function(){
			attachment = mediaUploader.state().get('selection').first().toJSON();
			$('#mpclp-login-image').val(attachment.url);
			$('#login-image-current').css('background-image','url(' + attachment.url + ')');
		});

		mediaUploader.open();
	});

	$('#upload-background-image-button').on('click',function(e){
		e.preventDefault();
		if (mediaUploader) {
			mediaUploader.open();
			return;
		}

		mediaUploader = wp.media.frames.file_frame = wp.media({
			title: 'Choose a background image',
			button: {
				text: 'Choose a background'
			},
			multiple: false
		});

		mediaUploader.on('select', function(){
			attachment = mediaUploader.state().get('selection').first().toJSON();
			$('#mpclp-background').val(attachment.url);
			$('#background-image-current').css('background-image','url(' + attachment.url + ')');
		});

		mediaUploader.open();
	});

	$('.wpColorPicker').wpColorPicker();

	$('#reset-options').on('click',function(e){
		$('#mpclp-login-image-height').val('');
		$('#mpclp-login-background').val('');
		$('#mpclp-login-form-background').val('');
		$('#mpclp-login-form-label').val('');
		$('#mpclp-login-message').val('');
		$('#mpclp-login-image-link').val('');
		$('.wp-color-result').removeAttr( 'style' );
	});
});