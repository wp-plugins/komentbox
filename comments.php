<div id="NLPkomentBox">

        <div id="NLPkomentBoxContent">
		<?php
		$komentbox_options = get_option('komentbox_options');
		$publisherkey = $komentbox_options['publisherkey'];
		?>
		
		<!--Start NLPCaptcha Embed Code -->
		 <script type="text/javascript">
		 var NLPOptions = {
						key:'<?php echo $publisherkey;?>' // PUBLISHER_KEY 
			
			};
		  </script>
		<script type="text/javascript" src="http://komentbox.nlpcaptcha.in/js/comments.js"></script>
		<!--End NLPCaptcha Embed Code -->

        </div>
</div>

