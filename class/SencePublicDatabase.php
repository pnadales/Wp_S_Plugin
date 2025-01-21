<?php

global $wpdb;

class SencePublicDatabase
{
    private static $db;
    private static $table_otec;
    private static $table_course;
    private static $table_user_course;
    private static $table_user;

    private static function init()
    {
        global $wpdb;
        self::$db = $wpdb;
        self::$table_otec = "{$wpdb->prefix}otec_data";
        self::$table_course = "{$wpdb->prefix}otec_course";
        self::$table_user_course = "{$wpdb->prefix}otec_user_course";
        self::$table_user = "{$wpdb->prefix}otec_user";
    }



    private static function get_otec()
    {
        self::init();
        $query = "SELECT * FROM " . self::$table_otec;
        $result = self::$db->get_results($query, ARRAY_A);
        return $result[0];
    }

    private static function get_course($course)
    {
        self::init();
        $query = "SELECT * FROM " . self::$table_course . " WHERE codigo_curso=$course";
        $result = self::$db->get_results($query, ARRAY_A);
        // var_dump($result);
        return $result ? $result[0] : array();
    }

    private static function get_user_course($user)
    {
        self::init();
        $query = "SELECT * FROM " . self::$table_user_course . " WHERE correo_alumno='$user'";
        $result = self::$db->get_results($query, ARRAY_A);
        return $result ? $result[0] : array();
    }
    private static function get_user($user)
    {
        self::init();
        $query = "SELECT * FROM " . self::$table_user . " WHERE correo_alumno='$user'";
        $result = self::$db->get_results($query, ARRAY_A);
        return $result ? $result[0] : array();
    }

    public static function get_form_sence_data($mail)
    {
        $data = array();
        $otec = self::get_otec();
        // var_dump($otec);
        // echo "</br>";
        $cod_course = self::get_user_course($mail)['codigo_curso'];
        // var_dump($cod_course);
        $course = self::get_course($cod_course);
        // echo "</br>";
        // var_dump($course);
        $user = self::get_user($mail);
        // echo "</br>";
        // var_dump($user);
        $data = [...$otec, ...$course, ...$user];
        return $data;
    }
}
