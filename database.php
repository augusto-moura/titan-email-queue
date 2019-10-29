<?php

/**
 * Create database tables if they don't already exist.
 */
function titan_eq_create_tables()
{
	global $wpdb;	
	$table_name = "{$wpdb->prefix}titan_email_queue";

	if($wpdb->get_var("SHOW TABLES LIKE '{$table_name}'") != $table_name) {
		$charset_collate = $wpdb->get_charset_collate();
		
		$sql = "CREATE TABLE {$table_name} (
			id bigint(9) NOT NULL AUTO_INCREMENT,
		 	email_to varchar(500) NOT NULL,
		 	title varchar(200) NOT NULL,
		 	body text NOT NULL,
		 	type varchar(32) NULL,
		 	info varchar(512) NULL,
		 	date_registered datetime NOT NULL,
		 	date_sent datetime NULL,
		 	error varchar(512) NULL,
			PRIMARY KEY  (id)
		) {$charset_collate};";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
	}
}

/**
 * Drop database tables.
 */
function titan_eq_drop_tables()
{
	global $wpdb;	
	$table_name = "{$wpdb->prefix}titan_email_queue";

	$sql = "DROP TABLE IF EXISTS {$table_name};";	
	$wpdb->query( $sql );
}

function titan_eq_get_email_batch()
{
	global $wpdb;
	$table_name = "{$wpdb->prefix}titan_email_queue";
	$emails = $wpdb->get_results( 
		"SELECT * FROM {$table_name}
		WHERE date_sent IS NULL
		AND error IS NULL
		ORDER BY date_registered, id ASC
		LIMIT 5;" 
	);
	return $emails;
}

/**
 * @param object $email
 * @param bool $success
 */
function titan_eq_update_email_status($email, $success)
{
	global $wpdb;
	$table_name = "{$wpdb->prefix}titan_email_queue";
	$args = [];

	if($success)
		$set = " date_sent = NOW() ";
	else{
		$errorMsg = 'Error.';
		if(!filter_var($email->email_to, FILTER_VALIDATE_EMAIL)) $errorMsg .= ' Argument \'email_to\' not valid.';
		if(!$email->title) $errorMsg .= ' Argument \'title\' not valid.';
		if(!$email->body) $errorMsg .= ' Argument \'body\' not valid.';
		$set = " error = %s ";
		$args[] = $errorMsg;
	}

	$sql = "	UPDATE {$table_name}
				SET {$set}
				WHERE id = %d;";
	$args[] = $email->id;
	$wpdb->get_results( $wpdb->prepare($sql, $args) );
}

/**
 * Add new e-mail to the Titan E-mail Queue
 * @param array $emailAsArray Array with keys: email_to, title, body, [type], [info]
 */
function titan_eq_add_email($emailAsArray)
{
	global $wpdb;
	$table_name = "{$wpdb->prefix}titan_email_queue";

	$emailAsArray = array_merge([
		'type' => null,
		'info' => null,
	], $emailAsArray);

	$wpdb->get_results( $wpdb->prepare(
		"INSERT INTO {$table_name} (email_to, title, body, type, info, date_registered)
		VALUES (%s, %s, %s, %s, %s, NOW());"
		, [$emailAsArray['email_to'], $emailAsArray['title'], $emailAsArray['body'], $emailAsArray['type'], $emailAsArray['info']]
	));
}