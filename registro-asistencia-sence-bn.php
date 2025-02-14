<?php

/*
 * Plugin Name:       Registro asistencia Sence BN
 * Plugin URI:        https://blacknexus.cl/
 * Description:       Allows you to integrate the SENCE session system into WordPress.
 * Version:           0.0
 * Requires at least: 
 * Requires PHP:      
 * Author:            BlackNexus
 * Author URI:        https://blacknexus.cl/
 * License:           
 * License URI:       
 * Update URI:       
 * Text Domain:       my-basics-plugin
 * Domain Path:       
 * Requires Plugins:  
*/

require_once plugin_dir_path(__FILE__) . 'functions.php';


register_activation_hook(__FILE__, 'AcrivateRASN');
register_deactivation_hook(__FILE__, 'DeactivateRASN');

add_action('admin_menu', 'RASN_crear_menu');
add_action('admin_enqueue_scripts', 'add_my_js');
add_action('wp_ajax_eliminarOtec', 'RASN_eliminar_otec');
add_action('admin_enqueue_scripts', 'add_my_css');
add_action('wp_enqueue_scripts', 'mi_plugin_enqueue_frontend_script');
add_action('wp_enqueue_scripts', 'mi_plugin_enqueue_frontend_style');

add_shortcode("SENCE_BTN", "sence_button");
add_shortcode("SENCE-EXITO", "sence_exito");
add_shortcode("SENCE-ERROR", "sence_error");


//mail

add_action('wp_mail_failed', function ($wp_error) {
    error_log('Error en wp_mail: ' . print_r($wp_error, true));
});
