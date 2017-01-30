<html <?php language_attributes(); ?> class="no-js">
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>">
        <meta name="robots" content="noindex, nofollow">
        <link rel="profile" href="http://gmpg.org/xfn/11">
        <?php wp_head(); ?>
    </head>

    <body <?php body_class(); ?>>
        <div class="lb-container">
            <div class="lb-wrap lb-center">
                <h1><?php _e( 'Oops.', 'littlebot-invoices'); ?></h1>
                <div class="lb-is-draft">This document is currently a draft.</div>
            </div>
        </div>
        <?php wp_footer(); ?>
    </body>
</html>