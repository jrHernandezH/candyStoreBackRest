<?php
//TODO: Este modelo es para la tabla de Pedidos
require_once 'DB.php';

class Pedido {
    //! Variable privada de conexión
    private $connection;

    //* Variables de la base de datos
    private int $id;
    private String $usuario_id;
    private string $direccion_envio;
    private string $metodo_pago;
    private string $estado;

    //? Constructor
    public function __construct() {
        $this->connection = DB::getConnection();
    }

    //? Metodos Setters y Getters

    public function setId(int $id) {
        $this->id = $id;
    }

    public function getId(): int {
        return $this->id;
    }

    public function setUsuarioId(String $usuario_id) {
        $this->usuario_id = $usuario_id;
    }

    public function getUsuarioId(): String {
        return $this->usuario_id;
    }

    public function setDireccionEnvio(string $direccion_envio) {
        $this->direccion_envio = $direccion_envio;
    }

    public function getDireccionEnvio(): string {
        return $this->direccion_envio;
    }

    public function setMetodoPago(string $metodo_pago) {
        $this->metodo_pago = $metodo_pago;
    }

    public function getMetodoPago(): string {
        return $this->metodo_pago;
    }

    public function setEstado(string $estado) {
        $this->estado = $estado;
    }

    public function getEstado(): string {
        return $this->estado;
    }


    //! Metodos importantes para la API REST

    //? Metodo para registrar pedido
    public function registerOrder() {
        try {
            $sql = "INSERT INTO pedido (usuario_id, direccion_envio, metodo_pago, estado) 
                    VALUES (:usuario_id, :direccion_envio, :metodo_pago, :estado)";

            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(':usuario_id', $this->usuario_id, PDO::PARAM_INT);
            $stmt->bindParam(':direccion_envio', $this->direccion_envio, PDO::PARAM_STR);
            $stmt->bindParam(':metodo_pago', $this->metodo_pago, PDO::PARAM_STR);
            $stmt->bindParam(':estado', $this->estado, PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return $this->connection->lastInsertId();
            } else {
                return false;
            }
        } catch (\Throwable $th) {
            error_log("Error en el modelo registrarPedido: " . $th->getMessage());
            throw new Exception("Error en el modelo registrarPedido: " . $th->getMessage());
        }
    }

    //? Metodo para obtener los pedidos que ha realizado el cliente
    public function getAllOrderCustomer() {
        try {
            $sql = "SELECT * FROM pedido WHERE usuario_id = :usuario_id";

            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(':usuario_id', $this->usuario_id, PDO::PARAM_INT);
            $stmt->execute();
            $pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $pedidos;
        } catch (\Throwable $th) {
            error_log("Error en el modelo obtenerPedidosCliente: " . $th->getMessage());
            throw new Exception("Error en el modelo obtenerPedidosCliente: " . $th->getMessage());
        }
    }

    //? Metodo para obtener todos los pedidos
    public function getAllOrders() {
        try {
            $sql = "SELECT * FROM pedido";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute();
            $pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $pedidos;
        } catch (\Throwable $th) {
            error_log("Error en el modelo obtenerTodosPedidos: " . $th->getMessage());
            throw new Exception("Error en el modelo obtenerTodosPedidos: " . $th->getMessage());
        }
    }

    //? Metodo para actualizar el estado del pedido
    public function updateStateOrder() {
        try {
            $sql = "UPDATE pedido SET estado = :nuevo_estado WHERE id = :id";

            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(':nuevo_estado', $this->estado, PDO::PARAM_STR);
            $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->rowCount() > 0;
        } catch (\Throwable $th) {
            error_log("Error en el modelo actualizarEstadoPedido: " . $th->getMessage());
            throw new Exception("Error en el modelo actualizarEstadoPedido: " . $th->getMessage());
        }
    }

    //? Metodo para actualizar la direccion del envio
    public function updateDirectionOrder() {
        try {
            $sql = "UPDATE pedido SET direccion_envio = :nueva_direccion WHERE id = :id";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(':nueva_direccion', $this->direccion_envio, PDO::PARAM_STR);
            $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->rowCount() > 0;
        } catch (\Throwable $th) {
            error_log("Error en el modelo actualizarDireccionEnvio: " . $th->getMessage());
            throw new Exception("Error en el modelo actualizarDireccionEnvio: " . $th->getMessage());
        }
    }

    //? Metodo para eliminar el pedido
    public function deleteOrder() {
        try {
            $sql = "DELETE FROM pedido WHERE id = :id";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                throw new Exception("No se encontró el pedido con ID: $this->id");
            }
        } catch (\Throwable $th) {
            error_log("Error en el modelo eliminarPedido: " . $th->getMessage());
            throw new Exception("Error en el modelo eliminarPedido: " . $th->getMessage());
        }
    }
}
?>
