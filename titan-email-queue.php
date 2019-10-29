<?php
/**
 * Plugin Name: Titan E-mail Queue
 * Plugin URI:  https://wordpress.org/plugins/titan-email-queue/
 * Description: Send e-mails stored in a queue.
 * Author:      Augusto Moura
 * Author URI:  https://github.com/augusto-moura40/
 * Version:     0.1
 * Text Domain: titan-email-queue
 * Domain Path: 
 * License:     MIT
 *
 * Add e-mail messages to the queue using the function titan_eq_add_email() and that's it. Every minute, the plugin will process the next 5 e-mails. 
 * The titan_eq_add_email() function accepts as parameter an array with the following keys:
 * email_to, title, body, type (optional), info (optional)
 * 
 * Repo: https://github.com/augusto-moura40/titan-email-queue 
 *
 * @package    Titan E-mail Queue
 * @author     Augusto Moura <augusto_moura40@hotmail.com>
 * @copyright  Copyright 2019 Augusto Moura
 * @license    https://choosealicense.com/licenses/mit/ MIT
 * @link       https://wordpress.org/plugins/titan-email-queue/
 * @since      0.1
 */

require_once 'cron.php';
require_once 'database.php';

function titan_eq_activation()
{
	titan_eq_create_tables();
	titan_eq_register_cron_jobs();
}
register_activation_hook( __FILE__, 'titan_eq_activation' );

function titan_eq_deactivation()
{
	titan_eq_unregister_cron_jobs();
}
register_deactivation_hook( __FILE__, 'titan_eq_deactivation' );

function titan_eq_uninstall()
{
	titan_eq_drop_tables();
	titan_eq_unregister_cron_jobs();
}
register_uninstall_hook(__FILE__, 'titan_eq_uninstall');

function titan_eq_plugin_init()
{
	titan_eq_process_email_batch();
}
add_action( 'init', 'titan_eq_plugin_init' );