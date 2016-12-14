<?php 

/**
 * LittleBot Estimates
 *
 * A class that handles replacing email tokens with proper values.
 *
 * @class     LBI_Log
 * @version   0.9
 * @category  Class
 * @author    Justin W Hall
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class LBI_Log 
{

	/**
	 * Kick it off
	 * @param
	 */
	public function __construct(){
		// Doc updated
		add_action( 'transition_post_status', array( $this, 'doc_saved' ), 10, 3 );
		// New post
		add_action( 'littlebot_doc_new', array( $this, 'doc_new' ), 10, 4 );
		// Updated post
		add_action( 'littlebot_doc_updated', array( $this, 'doc_updated' ), 10, 4 );
		// Doc status changed
		add_action( 'littlebot_changed_status', array( $this, 'doc_status_changed' ), 10, 4 );
	}

	/**
	 * Fires on all LBI post updates. Fires correct do_action depending on post change action
	 * @param  string $new_status new old post status
	 * @param  string $old_status the old post status
	 * @param  object $post       post object being updated
	 * @return void
	 */
	public function doc_saved( $new_status, $old_status, $post ){

		// return if not a LBI post
		if ( self::is_lbi_post( $post ) == false ) return;

		$user = wp_get_current_user();

		// New Post
		if ( 'auto-draft' == $old_status && 'auto-draft' != $new_status ) {
			do_action( 'littlebot_doc_new', $post, $old_status, $new_status, $user );
		}

		// Just an update
		else if ( $old_status == $new_status ) {
			do_action( 'littlebot_doc_updated', $post, $old_status, $new_status, $user );
		}

		// status change
		else if ( $old_status != $new_status && $old_status != 'new' ) {	
			do_action( 'littlebot_changed_status', $post, $old_status, $new_status, $user );
		}

	}

	/**
	 * logs a new post
	 * @param  object  $post       new post object
	 * @param  string  $old_status old post status
	 * @param  string  $new_status new post status
	 * @param  object $user       user object of the current user if available
	 * @return void              
	 */
	public function doc_new( $post, $old_status, $new_status, $user = false ){

		$message = str_replace( 'lb_', '', $post->post_type ) .  ' created';
		self::write( $post->ID, $message,  'Created', $user->data->user_nicename );
	}

	/**
	 * logs a new post
	 * @param  object  $post       new post object
	 * @param  string  $old_status old post status
	 * @param  string  $new_status new post status
	 * @param  object $user       user object of the current user if available
	 * @return void              
	 */
	public function doc_updated( $post, $old_status, $new_status, $user = false ){
		$message = str_replace( 'lb_', '', $post->post_type ) . ' updated';
		self::write( $post->ID, $message,  'Updated', $user->data->user_nicename );
	}

	/**
	 * logs a new post
	 * @param  object  $post       new post object
	 * @param  string  $old_status old post status
	 * @param  string  $new_status new post status
	 * @param  object $user       user object of the current user if available
	 * @return void              
	 */
	public function doc_status_changed( $post, $old_status, $new_status, $user = false ){

		$old_status = str_replace( 'lb-', '', $old_status );
		$new_status = str_replace( 'lb-', '', $new_status );

		$message = 'Status changed from ' . $old_status . ' to ' . $new_status;

		self::write( $post->ID, $message, 'Status Update', $user->data->user_nicename );
	}

	/**
	 * Check to see if the post is a LBI post type
	 * @param  object  $post post object
	 * @return boolean
	 */
	public function is_lbi_post( $post ){
		
		if ( null == $post ) {
			$is_lbi_post = false;
		} else if ( 'lb_invoice' == $post->post_type || 'lb_estimate' == $post->post_type ) {
			$is_lbi_post = true;
		} else{
			$is_lbi_post = false;
		}

		return $is_lbi_post;
	}

	/**
	 * updates the post meta for this post with the new log action
	 * @param  object  $post_ID    post object
	 * @param  string  $message    the message to be logged
	 * @param  string  $event_name event name
	 * @param  object $user       user object of the user who performed an action if available
	 * @return void
	 */
	public function write( $post_ID, $message, $event_name, $user = false ){

		$data = array();
		$data['message'] = $message;
		$data['event'] = $event_name;
		$data['user'] = $user;

		$log = get_post_meta( $post_ID, '_lbi_log', true );
		if ( !is_array( $log ) ){
			$log = array();
		}

		$log[current_time( 'timestamp' )] = $data;
		update_post_meta( $post_ID, '_lbi_log', $log );
	}

}

return new LBI_Log;