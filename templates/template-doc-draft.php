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
                <h1><?php esc_html_e( 'Oops.', 'littlebot-invoices'); ?></h1>
                <div class="lb-is-draft"><?php esc_html_e( 'This document is currently a draft.', 'littlebot-invoices' ); ?></div>
            </div>
        </div>
        <?php wp_footer(); ?>
    </body>
</html>
