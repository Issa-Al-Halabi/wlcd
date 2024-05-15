@section('scripts')
<script type="text/javascript">

$(window).on('unload', function() {
	// Asynchronous AJAX
	$.ajax({
        type: 'POST',
        url: 'ajax.php',
        data: { ajax_data : 22 }
    });
})
</script>
