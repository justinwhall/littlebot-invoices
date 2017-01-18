<span class="lb-pay-button">
  <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
    <input type="hidden" name="cmd" value="_xclick">
    <input type="hidden" name="business" value="justin-buyer@windsorup.com">
    <input type="hidden" name="item_name" value="Item-name">
    <input type="hidden" name="currency_code" value="USD">
    <input type="hidden" name="amount" value="<?php echo get_post_meta( get_the_ID(), '_total', true );?>">
    <!-- <input type="hidden" name="notify_url" value="<?php echo get_site_url(); ?>/littlebot-paypal-endpoint"> -->
    <input type="hidden" name="notify_url" value="<?php echo wp_nonce_url(  get_site_url() . '/littlebot-paypal-endpoint', 'ipn_val', 'paypal_checkout' ); ?>">
    <input type="hidden" name="invoice" value="<?php echo get_the_ID(); ?>">
    <input type="hidden" name="lc" value="EN_US">
    <input type="hidden" name="no_note" value="">
    <input type="hidden" name="paymentaction" value="sale">
    <input type="hidden" name="return" value="<?php echo get_permalink( get_the_ID() ); ?>">
    <input type="hidden" name="bn" value="WPPlugin_SP">
    <input type="hidden" name="cancel_return" value="<?php echo get_permalink( get_the_ID() ); ?>">
    <input style="border: none;margin-bottom: -8px; margin-right: -15px;" class="paypalbuttonimage" type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_paynow_LG.gif" border="0" name="submit" alt="Make your payments with PayPal. It is free, secure, effective.">
    <img alt="" border="0" style="border:none;display:none;" src="https://www.paypal.com/EN_US/i/scr/pixel.gif" width="1" height="1">
  </form>
</span>