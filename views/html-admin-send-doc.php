<div class="email-client-wrap <?php if ( !$client_meta ): ?>lb-hide<?php endif; ?>">
    <label for="send_to_client">Client Email</label>
    <input type="text" name="send_to_client" value="<?php if( $client_meta ){ echo $client_email; } ?>">
    <span class="send-to-client button">Send Now</span>
    <img src="/wp-admin/images/spinner-2x.gif" id="send-doc-loader">
    <div id="lb-send-doc-feedback" class="update-message notice inline notice-alt updated-message notice-success">
    	<p>Success, sent! </p>
    </div>
</div>
<div class="lb-no-client-add <?php if ( $client_meta ): ?>lb-hide<?php endif; ?>">
    <a href="#TB_inline?width=600&height=550&inlineId=lb-add-client" class="thickbox ">Add a client</a> to send notifications.
</div>