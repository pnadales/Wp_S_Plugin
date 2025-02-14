<?php

// require_once dirname(__FILE__) . '/class/SenceView.php';
// require_once dirname(__FILE__) . '/class/SenceExito.php';
// require_once dirname(__FILE__) . '/class/SenceError.php';
// require_once dirname(__FILE__) . '/admin/SenceAdminDatabase.php';

require_once plugin_dir_path(__FILE__) . 'class/SenceView.php';
require_once plugin_dir_path(__FILE__) . 'class/SenceExito.php';
require_once plugin_dir_path(__FILE__) . 'class/SenceError.php';
require_once plugin_dir_path(__FILE__) . 'admin/SenceAdminDatabase.php';


function AcrivateRASN()
{
    SenceAdminDatabase::plugin_db_init();
}

function DeactivateRASN()
{


    flush_rewrite_rules();
}



function RASN_crear_menu()
{
    add_menu_page(
        'Registro Asistencia Sence',
        'Registro Asistencia Sence',
        '',
        'RASN'
    );
    add_submenu_page(
        'RASN',
        'Home',
        'Home',
        'manage_options',
        plugin_dir_path(__FILE__) . 'admin/views/home-admin.php',
    );

    add_submenu_page(
        'RASN',
        'OTEC',
        'OTEC',
        'manage_options',
        plugin_dir_path(__FILE__) . 'admin/views/otec.php',
    );
    add_submenu_page(
        'RASN',
        'Cursos',
        'Cursos',
        'manage_options',
        plugin_dir_path(__FILE__) . 'admin/views/courses.php',
    );
    add_submenu_page(
        'RASN',
        'URLs',
        'URLs',
        'manage_options',
        plugin_dir_path(__FILE__) . 'admin/views/urls.php'
    );
    add_submenu_page(
        'RASN',
        'Ajustes',
        'Ajustes',
        'manage_options',
        plugin_dir_path(__FILE__) . 'admin/views/settings.php'

    );
    add_submenu_page(
        'm',
        'Alumnos',
        'Alumnos',
        'manage_options',
        plugin_dir_path(__FILE__) . 'admin/views/students.php',

    );
}


function add_my_js($hook)
{
    // echo "<script>console.log('$hook')</script>";
    $allows_pages = [
        'registro-asistencia-sence-bn/admin/views/home-admin.php',
        'registro-asistencia-sence-bn/admin/views/courses.php',
        'registro-asistencia-sence-bn/admin/views/urls.php',
        'registro-asistencia-sence-bn/admin/views/otec.php',
        'registro-asistencia-sence-bn/admin/views/students.php'
    ];

    if (!in_array($hook, $allows_pages)) {
        return;
    }

    wp_enqueue_script('personalJs', plugins_url('admin/js/script.js', __FILE__));
    wp_localize_script('personalJs', 'SolicitudesAjax', [
        'url' => admin_url('admin-ajax.php'),
        'seguridad' => wp_create_nonce('seg')
    ]);
}

function RASN_eliminar_otec()
{
    $nonce = $_POST['nonce'];
    if (!wp_verify_nonce($nonce, 'seg')) {
        die('no tiene permisos');
    }
    $id = $_POST['id'];
    global $wpdb;
    $table_otec = "{$wpdb->prefix}otec_data";
    $wpdb->delete($table_otec, array('rut_otec' => $id));
    return true;
}

function add_my_css($hook)
{
    $allows_pages = [
        'registro-asistencia-sence-bn/admin/views/home-admin.php',
        'registro-asistencia-sence-bn/admin/views/courses.php',
        'registro-asistencia-sence-bn/admin/views/urls.php',
        'registro-asistencia-sence-bn/admin/views/otec.php',
        'registro-asistencia-sence-bn/admin/views/students.php'
    ];

    if (!in_array($hook, $allows_pages)) {
        return;
    }
    wp_enqueue_style('personalCss', plugins_url('admin/css/style.css', __FILE__));
}

function sence_button($atts)
{
    // $_short = new SenceView;
    // $html = $_short->content();
    // return $html;
    $html = SenceExito::content();
    return $html;
}


function sence_exito($atts)
{
    $html = SenceExito::content();
    return $html;
}

function sence_error($atts)
{
    $html = SenceError::content();
    return $html;
}


function mi_plugin_enqueue_frontend_script()
{

    if (!is_admin()) {
        wp_enqueue_script(
            'mi-plugin-frontend-script-modal',
            plugin_dir_url(__FILE__) . 'public/js/modal.js',
            array('jquery'),
            '1.0.0',
            true
        );
        wp_enqueue_script(
            'mi-plugin-frontend-script',
            plugin_dir_url(__FILE__) . 'public/js/script.js',
            array('jquery'),
            '1.0.0',
            true
        );
    }
}

function mi_plugin_enqueue_frontend_style()
{
    if (!is_admin()) {
        wp_enqueue_style(
            'mi-plugin-frontend-style',
            plugin_dir_url(__FILE__) . 'public/css/style.css',
            array(),
            '1.0.0',
            'all'
        );
    }
}
