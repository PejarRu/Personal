<?php
    require_once('config.ini.php');
    class Conexion{
        private $host; // servidor
        private $user; // loguin bddd
        private $pass; // password bbdd
        private $database; // nombre de la bbdd   
        private static $conexion = null; // Conexión de la BBDD

        private function __construct(){
            try {
                // Inicializo los atributos
                $this->host = DB_SERVER;
                $this->user = DB_USER;
                $this->pass = DB_PASS;
                $this->database = DB_DATABASE;

                // Creo la conexiónPDO indicandole el servidor, la base de datos, el usuario y la contraseña de conexión
                self::$conexion = new PDO("mysql:host=$this->host;dbname=$this->database", $this->user, $this->pass);
                // Establezco el nivel de errores a EXCEPTION
                self::$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                // Este echo lo deberíamos comentar, ahora lo dejo para que veáis que se te ha conectado correctamente a la bbdd
                //echo "<p>Conexión establecida</p>";
            } catch (PDOException $e) {
                //echo "<p>Error en la conexión: " . $e->getMessage() . "</p>";
            }
        }

        public static function getConexion(){
            if(!self::$conexion) {
              new Conexion(); // Me creo la conexión en el caso de no tenerla inciializada
            }           
            return self::$conexion; // Devuelvo el objeto de la conexión con el que trabajaré
        }

        public static function cerrarConexion(){
            // Basta con establecer la conexión a nulo
            self::$conexion = null;
        }
    }
?>