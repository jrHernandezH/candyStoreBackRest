<?php
class DB {
    private static $conn;

    public static function getConnection() {
        if (!self::$conn) {
            $servername = "localhost";
            $username = "admin_candy_2024";
            $password = "candycandy";
            $database = "candy";

            try {
                self::$conn = new PDO("mysql:host=$servername;dbname=$database;charset=utf8", $username, $password);
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            } catch (\Throwable $th) {
                error_log("Error en la conexion: " . $th->getMessage());
                throw new Exception("Error en la conexion: " . $th->getMessage());
            }
        }

        return self::$conn;
    }
}
?>
