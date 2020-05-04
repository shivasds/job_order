 
	<!-- Dropzone CSS & JS -->
    <link href='<?= base_url() ?>resources/dropzone.css' type='text/css' rel='stylesheet'>
    <script src='<?= base_url() ?>resources/dropzone.js' type='text/javascript'></script>
    
    <!-- Dropzone CDN -->
    <!-- 
    <link href='https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/dropzone.css' type='text/css' rel='stylesheet'>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/dropzone.js' type='text/javascript'></script>
    -->
	<style>
	.content{
		width: 50%;
	 	padding: 5px;
	 	margin: 0 auto;
	}
	.content span{
		width: 250px;
	}
	.dz-message{
		text-align: center;
		font-size: 28px;
	}
	</style>
	<script>
		// Add restrictions
		Dropzone.options.fileupload = {
		    acceptedFiles: 'image/*',
		    maxFilesize: 1 // MB
		};
	</script>

	<div class='content'>
		<!-- Dropzone -->
	   	<form action="<?= base_url('index.php/User/fileupload') ?>" class="dropzone" id='fileupload'>
	   	</form> 
	</div> 
	

