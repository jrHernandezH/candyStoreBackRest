<?php
require_once '../models/DB.php';

class PasswordUpdater {
    private $connection;

    public function __construct() {
        $this->connection = DB::getConnection(); // Si getConnection() es estático
    }

    public function updatePasswords() {
        try {
            $sql = "SELECT cuenta, password FROM usuario";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute();
            $administradores = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($administradores as $administrador) {
                $cuenta = $administrador['cuenta'];
                $contrasena = $administrador['password'];

                if (!password_verify($contrasena, $contrasena)) {
                    $hashedPassword = password_hash($contrasena, PASSWORD_BCRYPT);

                    $updateSql = "UPDATE usuario SET password = :password WHERE cuenta = :cuenta";
                    $updateStmt = $this->connection->prepare($updateSql);
                    $updateStmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
                    $updateStmt->bindParam(':cuenta', $cuenta, PDO::PARAM_STR);
                    $updateStmt->execute();

                    echo "Contraseña de la cuenta $cuenta actualizada.\n";
                } else {
                    echo "La cuenta $cuenta ya tiene una contraseña hash.\n";
                }
            }

            echo "Actualización completada.\n";

        } catch (PDOException $e) {
            $msg = "Error en el script de actualización de contraseñas: " . $e->getMessage();
            error_log($msg);
            echo $msg;
        }
    }
}

$updater = new PasswordUpdater();
$updater->updatePasswords();
?>
