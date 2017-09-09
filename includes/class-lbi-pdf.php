<?php
/**
 *
 * PDF generation object
 *
 * @class     LBI_PDF
 * @since   2.2.0
 * @category  Class
 * @author    Justin W Hall
 */


class LBI_PDF {

	/**
	 * kick if off
	 * @return void
	 */
	public static function init() {
		add_action( 'wp', array( __CLASS__, 'build_pdf' ), 1 );
		// Require composer autoload
		require_once LBI_PLUGIN_DIR . '/vendor/autoload.php';
	}

	/**
	 * Generates a PDF
	 * @param  object $post post query object
	 * @return void
	 */
	public static function build_pdf( $post ) {

		if ( ! isset( $_GET['pdf'] ) || 'lb_invoice' != get_query_var( 'post_type' ) ) {
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

		exit;
	}
}
