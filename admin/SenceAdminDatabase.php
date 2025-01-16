<?php

global $wpdb;

class SenceAdminDatabase
{
    public static $db;
    public static $table_otec;
    public static $table_course;
    public static function init()
    {
        global $wpdb;
        self::$db = $wpdb;
        self::$table_otec = "{$wpdb->prefix}otec_data";
        self::$table_course = "{$wpdb->prefix}otec_course";
    }
    private static function create_tables()
    {
        self::init();
        $otec = self::$table_otec;
        $course = self::$table_course;
        $table1 = "CREATE TABLE IF NOT EXISTS {$otec}(
            `rut_otec` VARCHAR(10) NOT NULL,
            `nombre_otec` VARCHAR(45),
            `token` VARCHAR(36) NOT NULL
            );";
        $table2 = "CREATE TABLE IF NOT EXISTS {$course}(
                `cod_sence` VARCHAR(10) NOT NULL,
                `codigo_curso` VARCHAR(50),
                `linea_capacitacion` INT NOT NULL,
                `nombre` VARCHAR(255) NOT NULL
                );";


        self::$db->query($table1);
        self::$db->query($table2);
    }

    public static function plugin_db_init()
    {
        $backtrace = debug_backtrace();
        $file_name = basename($backtrace[0]['file']);
        if (!($file_name === "new-plugin.php")) {
            die('Not allowed');
        }
        self::create_tables();
    }
    public static function insert_otec($data)
    {
        self::init();
        $otec_data = [
            'rut_otec' => $data['rut_otec'],
            'nombre_otec' => $data['nombre_otec'],
            'token' => $data['token']
        ];
        self::$db->insert(self::$table_otec, $otec_data);
    }

    public static function get_otec()
    {
        self::init();
        $query = "SELECT * FROM " . self::$table_otec;
        $result = self::$db->get_results($query, ARRAY_A);
        // var_dump($result);
        return $result;
    }
    public static function insert_course($data)
    {
        self::init();
        $course_data = [
            'cod_sence' => $data['cod_sence'],
            'codigo_curso' => $data['codigo_curso'],
            'linea_capacitacion' => (int)($data['linea_capacitacion']),
            'nombre' => $data['nombre_curso']
        ];
        self::$db->insert(self::$table_course, $course_data);
    }
    public static function get_courses()
    {
        self::init();
        $query = "SELECT * FROM " . self::$table_course;
        $result = self::$db->get_results($query, ARRAY_A);
        // var_dump($result);
        return $result ? $result : array();
    }
}
