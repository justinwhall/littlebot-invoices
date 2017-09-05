<?php

class LBI_PDF {

	public static function init() {
		add_action( 'wp', array( __CLASS__, 'build_pdf' ), 1 );
		// Require composer autoload
		require_once LBI_PLUGIN_DIR . '/vendor/autoload.php';
	}

	public static function build_pdf( $post ) {

		if ( '1' != $_GET['pdf'] ) {
			return;
		}

		$mpdf = new mPDF();

		ob_start();
		include LBI_PLUGIN_DIR . '/views/pdf-invoice.php';
		$html = ob_get_contents();
		ob_end_clean();

		// send the captured HTML from the output buffer to the mPDF class for processing
		$footer = '<div style="color:#ccc;">' . get_bloginfo( 'name' ) . ' • ' . get_bloginfo( 'url' ) . '</div>';
		$mpdf->SetHTMLFooter( $footer );
		$mpdf->WriteHTML( $html );
		$mpdf->Output();
		//
		exit;
	}
}
