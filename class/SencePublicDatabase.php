<?php

global $wpdb;

class SencePublicDatabase
{
    private static $db;
    private static $table_otec;
    private static $table_url;
    private static $table_course;
    private static $table_user;
    private static $table_user_course;
    private static $table_session;

    private static function init()
    {
        global $wpdb;
        self::$db = $wpdb;
        self::$table_otec = "{$wpdb->prefix}otec_data";
        self::$table_url = "{$wpdb->prefix}otec_url";
        self::$table_course = "{$wpdb->prefix}otec_course";
        self::$table_user_course = "{$wpdb->prefix}otec_user_course";
        self::$table_user = "{$wpdb->prefix}otec_user";
        self::$table_session = "{$wpdb->prefix}otec_session";
    }

    private static function get_id_session()
    {
        self::init();
        $query = "SELECT id_sesion FROM " . self::$table_session . " ORDER BY id_sesion DESC LIMIT 1";
        $result = self::$db->get_results($query, ARRAY_A);
        $id = $result ? (int) ($result[0]['id_sesion']) + 1 : 1;
        return ['id_sesion_alumno' => $id];
    }
    public static function get_form_sence_data($mail)
    {
        self::init();
        $query = "SELECT 
            uc.rut_otec,
            o.token,
            c.cod_sence,
            uc.codigo_curso,
            c.linea_capacitacion,
            u.run_alumno,
            url.url_exito,
            url.url_error
            FROM 
                " . self::$table_user . " u
            INNER JOIN 
                " . self::$table_user_course . " uc ON u.run_alumno = uc.run_alumno
            INNER JOIN 
                " . self::$table_otec . " o ON uc.rut_otec = o.rut_otec
            INNER JOIN 
                " . self::$table_course . " c ON uc.rut_otec = c.rut_otec AND uc.codigo_curso = c.codigo_curso
            INNER JOIN 
                " . self::$table_url . " url ON o.rut_otec = url.rut_otec
            WHERE 
            u.correo_alumno = '$mail'
            AND uc.status = 1;";

        $result = self::$db->get_results($query, ARRAY_A);
        // var_dump($result[0]);
        $data = [...$result[0], ...self::get_id_session()];
        // var_dump($data);
        return $data;
    }
}
