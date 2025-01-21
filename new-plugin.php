<?php

/*
Plugin Name: New Plugin
Description: This is my first wordpress plugin
Version: 0.0
Author: Me
Text Domain: new-plugin

*/

require_once dirname(__FILE__) . '/class/SenceView.php';
require_once dirname(__FILE__) . '/admin/SenceAdminDatabase.php';


function Activar()
{
    SenceAdminDatabase::plugin_db_init();
}

function Desactivar()
{
    global $wpdb;
    $query = "DELETE FROM {$wpdb->prefix}otec_data;";
    $wpdb->query($query);

    flush_rewrite_rules();
}

function Borrar() {}


register_activation_hook(__FILE__, 'Activar');
register_deactivation_hook(__FILE__, 'Desactivar');

add_action('admin_menu', 'sence_crear_menu');

function sence_crear_menu()
{
    add_menu_page(
        'Sence pt',
        'Sence mt',
        'manage_options',
        plugin_dir_path(__FILE__) . 'admin/views/admin.php',
        // 'MostrarContenido',
        // plugin_dir_url(__FILE__) . 'admin/images/icon.png',
        // position: '1'
    );

    add_submenu_page(
        plugin_dir_path(__FILE__) . 'admin/views/admin.php',
        'Cursos',
        'Cursos',
        'manage_options',
        plugin_dir_path(__FILE__) . 'admin/views/courses.php',
        // 'Submenu'
    );
    add_submenu_page(
        plugin_dir_path(__FILE__) . 'admin/views/admin.php',
        'OTEC',
        'OTEC',
        'manage_options',
        plugin_dir_path(__FILE__) . 'admin/views/otec.php',
    );
    add_submenu_page(
        null,
        'Editar Otec',
        'Editar Otec',
        'manage_options',
        // 'edit-otec',
        plugin_dir_path(__FILE__) . 'admin/views/edit-otec.php',

    );
    add_submenu_page(
        plugin_dir_path(__FILE__) . 'admin/views/admin.php',
        'Ajustes',
        'Ajustes',
        'manage_options',
        'sp_menu_ajustes',
        'Submenu'
    );
}

function MostrarContenido()
{
    echo '<h1>Menu Sence</h1>';
}

function Submenu()
{
    echo '<h1>SubMenu Sence</h1>';
}


function add_my_js($hook)
{
    // echo "<script>console.log('$hook')</script>";

    // if ($hook != 'new-plugin/admin/views/admin.php') {
    //     return;
    // }
    wp_enqueue_script('personalJs', plugins_url('admin/js/script.js', __FILE__));
}
add_action('admin_enqueue_scripts', 'add_my_js');

function add_my_css($hook)
{
    // echo "<script>console.log('$hook')</script>";

    // if ($hook != 'new-plugin/admin/views/admin.php') {
    //     return;
    // }
    wp_enqueue_style('personalCss', plugins_url('admin/css/style.css', __FILE__));
}
add_action('admin_enqueue_scripts', 'add_my_css');

function print_shortcode($atts)
{
    $_short = new SenceView;
    $html = $_short->content();
    return $html;
}

add_shortcode("SENCE_BTN", "print_shortcode");
