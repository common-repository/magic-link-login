<?php
/**
 * Enables the user to login without password but with an email
 *
 * @author    Tim Sippel <sippel@amicaldo.de>
 * @license   GPLv2
 * @copyright 2018 amicaldo. All rights reserved.
 *
 * @wordpress-plugin
 * Plugin Name:       Magic Link Login
 * Description:       Enables the user to login without entering a password. Instead, a mail with a magic link is sent to the user and he can login by just click the link in the mail.
 * Version:           1.1.0
 * Author:            amicaldo GmbH
 * Author URI:        https://amicaldo.de
 * Text Domain:       amc-spark
 * Domain Path:       /lang
 * License:           GPLv2
 * License URI:       https://www.gnu.org/licenses/old-licenses/gpl-2.0.txt
 */

// Bootstrap plugin
require 'classes/AMC_Main.php';

function amc_spark_load_text_domain() {
    load_plugin_textdomain( 'amc-spark', false, basename( dirname( __FILE__ ) ) . '/lang/' );
}

add_action( 'plugins_loaded', 'amc_spark_load_text_domain' );

$main = new amc_spark\AMC_Main( plugin_dir_path( __FILE__ ), plugin_dir_url( __FILE__ ) );