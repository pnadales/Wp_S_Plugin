<?php

global $wpdb;

class SenceAdminDatabase
{
    private static $db;
    private static $table_otec;
    private static $table_url;
    private static $table_course;
    private static $table_user;
    private static $table_user_course;
    private static $table_session;


    public static function init()
    {
        global $wpdb;
        self::$db = $wpdb;
        self::$table_otec = "{$wpdb->prefix}otec_data";
        self::$table_url = "{$wpdb->prefix}otec_url";
        self::$table_course = "{$wpdb->prefix}otec_course";
        self::$table_user = "{$wpdb->prefix}otec_user";
        self::$table_user_course = "{$wpdb->prefix}otec_user_course";
        self::$table_session = "{$wpdb->prefix}otec_session";
    }
    private static function create_tables()
    {
        self::init();
        $otec = self::$table_otec;
        $url = self::$table_url;
        $course = self::$table_course;
        $user = self::$table_user;
        $user_course = self::$table_user_course;
        $session = self::$table_session;

        $table_otec_query = "CREATE TABLE IF NOT EXISTS {$otec}(
                            `rut_otec` VARCHAR(10),
                            `nombre_otec` VARCHAR(255),
                            `token` VARCHAR(36) NOT NULL,
                            PRIMARY KEY (`rut_otec`)
                            );";
        $table_url_query = "CREATE TABLE IF NOT EXISTS {$url}(
                            `rut_otec` VARCHAR(10),
                            `url_exito` VARCHAR(100) NOT NULL,
                            `url_error` VARCHAR(100) NOT NULL,
                            FOREIGN KEY (`rut_otec`) REFERENCES {$otec}(`rut_otec`) ON DELETE CASCADE
                            );";
        $table_course_query = "CREATE TABLE IF NOT EXISTS {$course}(
                            `rut_otec` VARCHAR(10),
                            `codigo_curso` VARCHAR(50),
                            `cod_sence` VARCHAR(10) NOT NULL,
                            `linea_capacitacion` INT NOT NULL,
                            `nombre` VARCHAR(255),
                            PRIMARY KEY (`rut_otec`, `codigo_curso`),
                            FOREIGN KEY (`rut_otec`) REFERENCES {$otec}(`rut_otec`) ON DELETE CASCADE,
                            CHECK (`linea_capacitacion` IN (1, 3, 6))
                            );";
        $table_user_query = "CREATE TABLE IF NOT EXISTS {$user}(
                            `run_alumno` VARCHAR(10),
                            `correo_alumno` VARCHAR(150) NOT NULL,
                            `nombres` VARCHAR(30),
                            `apellidos` VARCHAR(30),
                            PRIMARY KEY (`run_alumno`)
                            );";
        $table_user_course_query = "CREATE TABLE IF NOT EXISTS {$user_course}(
                            `run_alumno` VARCHAR(10),
                            `rut_otec` VARCHAR(10),
                            `codigo_curso` VARCHAR(50),
                            `status` BOOLEAN NOT NULL,
                            FOREIGN KEY (`rut_otec`, `codigo_curso`) REFERENCES {$course}(`rut_otec`, `codigo_curso`) ON DELETE CASCADE,
                            FOREIGN KEY (`run_alumno`) REFERENCES {$user}(`run_alumno`) ON DELETE CASCADE
                            );";
        $table_session_query = "CREATE TABLE IF NOT EXISTS {$session}(
                            `id_sesion` INT,
                            `run_alumno` VARCHAR(10) NOT NULL,
                            `rut_otec` VARCHAR(10) NOT NULL,
                            `codigo_curso` VARCHAR(50) NOT NULL,
                            `fecha` TIMESTAMP NOT NULL,
                            `duracion` TIME NOT NULL,
                            PRIMARY KEY (`id_sesion`),
                            FOREIGN KEY (`run_alumno`) REFERENCES {$user}(`run_alumno`) ON DELETE CASCADE,
                            FOREIGN KEY (`rut_otec`, `codigo_curso`) REFERENCES {$course}(`rut_otec`, `codigo_curso`)
                            );";

        $create_queries = [$table_otec_query, $table_url_query, $table_course_query, $table_user_query, $table_user_course_query, $table_session_query];

        foreach ($create_queries as $table) {
            self::$db->query($table);
        }
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
            'rut_otec' => $data['rut_otec'],
            'codigo_curso' => $data['codigo_curso'],
            'cod_sence' => $data['cod_sence'],
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
    public static function insert_user($data)
    {
        self::init();
        $user_data = [
            'run_alumno' => $data['run_alumno'],
            'correo_alumno' => $data['correo_alumno'],
            'nombres' => $data['nombres'],
            'apellidos' => $data['apellidos']
        ];
        self::$db->insert(self::$table_user, $user_data);
    }
    public static function get_users()
    {
        self::init();
        $query = "SELECT * FROM " . self::$table_user;
        $result = self::$db->get_results($query, ARRAY_A);
        // var_dump($result);
        return $result ? $result : array();
    }
    public static function insert_user_course($data)
    {
        self::init();
        $user_course_data = [
            'run_alumno' => $data['run_alumno'],
            'rut_otec' => $data['rut_otec'],
            'codigo_curso' => $data['codigo_curso'],
            'status' => $data['status']
        ];
        self::$db->insert(self::$table_user_course, $user_course_data);
    }
    public static function get_user_courses()
    {
        self::init();
        $query = "SELECT * FROM " . self::$table_user_course;
        $result = self::$db->get_results($query, ARRAY_A);
        // var_dump($result);
        return $result ? $result : array();
    }

    public static function insert_url($data)
    {
        self::init();
        $user_data = [
            'rut_otec' => $data['otec'],
            'url_exito' => $data['url_exito'],
            'url_error' => $data['url_error']
        ];
        self::$db->insert(self::$table_user, $user_data);
    }
    public static function get_urls($otec, $course)
    {
        self::init();
        $query = "SELECT * FROM " . self::$table_url . " WHERE otec='$otec' AND codigo_curso='$course'";
        $result = self::$db->get_results($query, ARRAY_A);
        // var_dump($result);
        return $result ? $result : array();
    }
}
