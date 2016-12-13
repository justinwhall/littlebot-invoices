
<label for="send_to_client">Client Email(s)</label>
<input type="text" name="send_to_client" value="<?php if( $client_meta ){ echo $client_email; } ?>">
<span class="send-to-client button">Send Now</span>
<img src="/wp-admin/images/spinner-2x.gif" id="send-doc-loader">
<div id="lb-send-doc-feedback" class="update-message notice inline notice-alt updated-message notice-success">
	<p>Success, sent! </p>
</div>