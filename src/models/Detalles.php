<?php
//TODO: Este modelo es para la tabla de Detalles Pedido
require_once 'DB.php';

class Detalle {
    //! Variable privada de conexión
    private $connection;

    //* Variables de la base de datos
    private int $id;
    private int $pedido_id;
    private int $producto_id;
    private int $cantidad;
    private float $precio_unitario;
    private float $subtotal;

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

    public function setPedidoId(int $pedido_id) {
        $this->pedido_id = $pedido_id;
    }

    public function getPedidoId(): int {
        return $this->pedido_id;
    }

    public function setProductoId(int $producto_id) {
        $this->producto_id = $producto_id;
    }

    public function getProductoId(): int {
        return $this->producto_id;
    }

    public function setCantidad(int $cantidad) {
        $this->cantidad = $cantidad;
    }

    public function getCantidad(): int {
        return $this->cantidad;
    }

    public function setPrecioUnitario(float $precio_unitario) {
        $this->precio_unitario = $precio_unitario;
    }

    public function getPrecioUnitario(): float {
        return $this->precio_unitario;
    }

    public function setSubtotal(float $subtotal) {
        $this->subtotal = $subtotal;
    }

    public function getSubtotal(): float {
        return $this->subtotal;
    }


    //! Metodos importantes para la API REST

    //? Metodo para obtener los detalles del pedido
    public function obtenerDetalles() {
        try {
            $sql = "SELECT * FROM detalle_pedido WHERE pedido_id = :pedido_id";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(':pedido_id', $this->pedido_id, PDO::PARAM_INT);
            $stmt->execute();
            $detalles = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $detalles;
        } catch (\Throwable $th) {
            error_log("Error en el modelo obtenerDetallesPedidoPorPedidoId: " . $th->getMessage());
            throw new Exception("Error en el modelo obtenerDetallesPedidoPorPedidoId: " . $th->getMessage());
        }
    }

    //? Metodo para registrar los detales del pedido
    public function registrarDetallePedido() {
        try {
            $sql = "INSERT INTO detalle_pedido (pedido_id, producto_id, cantidad, precio_unitario, subtotal) 
                    VALUES (:pedido_id, :producto_id, :cantidad, :precio_unitario, :subtotal)";
    
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(':pedido_id', $this->pedido_id, PDO::PARAM_INT);
            $stmt->bindParam(':producto_id', $this->producto_id, PDO::PARAM_INT);
            $stmt->bindParam(':cantidad', $this->cantidad, PDO::PARAM_INT);
            $stmt->bindParam(':precio_unitario', $this->precio_unitario, PDO::PARAM_STR);
            $stmt->bindParam(':subtotal', $this->subtotal, PDO::PARAM_STR);
            $stmt->execute();
    
            return $stmt->rowCount() > 0;
        } catch (\Throwable $th) {
            error_log("Error en el modelo registrarDetallePedido: " . $th->getMessage());
            throw new Exception("Error en el modelo registrarDetallePedido: " . $th->getMessage());
        }
    }

    //? Metodo para actualizar el subTotal del detalle
    public function actualizarSubtotalDetallePedido() {
        try {
            $sql = "UPDATE detalle_pedido SET subtotal = :subtotal WHERE id = :id";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(':subtotal', $this->subtotal, PDO::PARAM_STR);
            $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
            $stmt->execute();
    
            return $stmt->rowCount() > 0;
        } catch (\Throwable $th) {
            error_log("Error en el modelo actualizarSubtotalDetallePedido: " . $th->getMessage());
            throw new Exception("Error en el modelo actualizarSubtotalDetallePedido: " . $th->getMessage());
        }
    }
    
    //? Metodo para eliminar el detalle del pedido
    public function eliminarDetallePedido() {
        try {
            $sql = "DELETE FROM detalle_pedido WHERE id = :id";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
            $stmt->execute();
    
            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                throw new Exception("No se encontró el detalle de pedido con ID: $this->id");
            }
        } catch (\Throwable $th) {
            error_log("Error en el modelo eliminarDetallePedido: " . $th->getMessage());
            throw new Exception("Error en el modelo eliminarDetallePedido: " . $th->getMessage());
        }
    }
    
}
?>
