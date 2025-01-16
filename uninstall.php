<?php
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    die;
}
/*
Documentation example
$option_name = 'wporg_option';

delete_option( $option_name );

// for site options in Multisite
delete_site_option( $option_name );

// drop a custom database table
global $wpdb;
$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}mytable" );
*/

if(!defined('ABSPATH')) exit;
