<?php
/**
 * LittleBot Estimates
 *
 * A class to handle LittleBot Reports.
 *
 * @class     LBI_Estimate
 * @version   0.9
 * @category  Class
 * @author    Justin W HAll
 * @package   Reports
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * LittleBot Reports Class
 */
class LBI_REPORTS {

	/**
	 * Gets a _total over a period of time
	 *
	 * @param array  $statuses  An array of statuses.
	 * @param int    $client_id The client ID.
	 * @param string $post_type Post type to query.
	 * @return object
	 */
	public function get_total_for_period( $statuses, $client_id, $post_type, $after, $before ) {
		global $wpdb;
		$status_sql = '';

		/**
		 * Format statuses for SQL
		 */
		foreach ( $statuses as $index => $status ) {
			$status_sql .= "'{$status}'";

			if ( $index !== count( $statuses ) - 1 ) {
				$status_sql .= ',';
			}
		}

		$sql = "SELECT DISTINCT SUM(pm.meta_value) FROM wp_posts AS p 
                INNER JOIN wp_postmeta ON p . ID = wp_postmeta . post_id
                INNER JOIN wp_postmeta AS pm ON p.ID = pm.post_id 
                WHERE p.post_type LIKE %s 
                AND p.post_status IN ({$status_sql}) 
                AND p.post_date > '{$after}'
                AND p.post_date < '{$before}'
                AND pm.meta_key = '_total'
                AND wp_postmeta.meta_key = '_client'";

		if ( $client_id ) {
			$sql .= "AND wp_postmeta.meta_value = {$client_id}";
		}

		$req = $wpdb->get_var( // phpcs:ignore
			$wpdb->prepare(
				$sql, // phpcs:ignore
				$post_type,
			)
		);

		return $req;

	}

}
