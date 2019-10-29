<?php
function titan_eq_register_cron_jobs()
{
	if( !wp_next_scheduled( 'titan_email_queue' ) ) {
		wp_schedule_event( time(), 'every_minute', 'titan_email_queue' );
	}
}

function titan_eq_unregister_cron_jobs()
{
	$timestamp = wp_next_scheduled( 'titan_email_queue' );
	if($timestamp)
		wp_unschedule_event( $timestamp, 'titan_email_queue' );
}

//

function titan_eq_add_every_minute( $schedules ) {
	$schedules['every_minute'] = array(
		'interval' => 60,
		'display' => __('Once Every Minute')
	);
	return $schedules;
}
add_filter( 'cron_schedules', 'titan_eq_add_every_minute' );

function titan_eq_process_email_batch()
{
	$emails = titan_eq_get_email_batch();
	foreach($emails as $email){
		try{
			$success = wp_mail($email->email_to, $email->title, $email->body, 'Content-Type: text/html; charset=UTF-8');
		} catch(Exception $e){
			$success = false;
		}
		titan_eq_update_email_status($email, $success);
	}
}
add_action ('titan_email_queue', 'titan_eq_process_email_batch'); 