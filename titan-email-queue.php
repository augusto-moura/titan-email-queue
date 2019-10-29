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
 * LICENSE
 * MIT License
 * 
 * Copyright (c) 2019 Augusto Moura
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 *
 * @package    Titan E-mail Queue
 * @author     Augusto Moura <augusto_moura40@hotmail.com>
 * @copyright  Copyright 2019 Augusto Moura
 * @license    https://choosealicense.com/licenses/mit/ MIT
 * @link       https://wordpress.org/plugins/titan-email-queue/
 * @since      0.1
 */

require_once 'cron.php';

function titan_eq_activation()
{
	require_once 'database.php';
	titan_eq_create_tables();
	titan_eq_register_cron_jobs();
}
register_activation_hook( __FILE__, 'titan_eq_activation' );

function titan_eq_deactivation()
{
	//TODO: deactivation hook
	//Remove cron events.
}
register_deactivation_hook( __FILE__, 'titan_eq_deactivation' );

function titan_eq_uninstall()
{
	//TODO: uninstall hook
	require_once 'database.php';
	titan_eq_drop_tables();
	//Remove cron events.
}
register_uninstall_hook(__FILE__, 'titan_eq_uninstall');

function titan_eq_plugin_init()
{
	require_once 'database.php';
}