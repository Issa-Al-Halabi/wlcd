<!DOCTYPE html>
<html lang="en">

<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">

	<link rel="stylesheet" href="https://cdn.plyr.io/3.7.3/plyr.css" />

</head>

<body id="page-top">


	@if ($courses['preview_type'] == 'video')
		<video controls crossorigin playsinline data-poster="{{ asset('images/course/' . $courses['preview_image']) }}"
			class="js-layer">

			<source src="{{ asset('video/preview/' . $courses['video']) }}" type="video/mp4" />

		</video>
	@elseif($courses['preview_type'] == 'url')
		<iframe class="js-player" src="{{ str_replace('watch?v=', 'embed/', $courses['url']) }}" frameborder="0"
			allowfullscreen></iframe>
	@endif

	<script>
		document.addEventListener('DOMContentLoaded', () => {

			const controls = [
				'play-large', // The large play button in the center
				'restart', // Restart playback
				'rewind', // Rewind by the seek time (default 10 seconds)
				'play', // Play/pause playback
				'fast-forward', // Fast forward by the seek time (default 10 seconds)
				'progress', // The progress bar and scrubber for playback and buffering
				'current-time', // The current time of playback
				'duration', // The full duration of the media
				'mute', // Toggle mute
				'volume', // Volume control
				'captions', // Toggle captions
				'settings', // Settings menu
				'pip', // Picture-in-picture (currently Safari only)
				'airplay', // Airplay (currently Safari only)
				'download', // Show a download button with a link to either the current source or a custom URL you specify in your options
				'fullscreen' // Toggle fullscreen
			];

			const player = Plyr.setup('.js-player', {
				controls
			});

		});
	</script>
	<script src="https://cdn.plyr.io/3.7.3/plyr.js"></script>

</body>

<style>
	.js-player {
		width: 50% !important;
		position: absolute;
		left: 25%;
		top: 10%;
	}

	.vjs-tech {
		width: 100% !important;
	}

	.vjs-big-play-button {
		position: absolute !important;
		top: 50% !important;
		left: 50% !important;
	}
</style>
